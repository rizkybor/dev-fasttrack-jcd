import { jsPDF } from "jspdf";

const angkaTerbilang = (n) => {
    if (!n || isNaN(n)) return "nol";
    n = Math.abs(Math.floor(n));
    const s = [
        "",
        "satu",
        "dua",
        "tiga",
        "empat",
        "lima",
        "enam",
        "tujuh",
        "delapan",
        "sembilan",
        "sepuluh",
        "sebelas",
    ];
    if (n < 12) return s[n];
    if (n < 20) return s[n - 10] + " belas";
    if (n < 100)
        return (
            s[Math.floor(n / 10)] + " puluh" + (n % 10 ? " " + s[n % 10] : "")
        );
    if (n < 200)
        return "seratus" + (n % 100 ? " " + angkaTerbilang(n % 100) : "");
    if (n < 1000)
        return (
            s[Math.floor(n / 100)] +
            " ratus" +
            (n % 100 ? " " + angkaTerbilang(n % 100) : "")
        );
    if (n < 2000)
        return "seribu" + (n % 1000 ? " " + angkaTerbilang(n % 1000) : "");
    if (n < 1e6)
        return (
            angkaTerbilang(Math.floor(n / 1000)) +
            " ribu" +
            (n % 1000 ? " " + angkaTerbilang(n % 1000) : "")
        );
    if (n < 1e9)
        return (
            angkaTerbilang(Math.floor(n / 1e6)) +
            " juta" +
            (n % 1e6 ? " " + angkaTerbilang(n % 1e6) : "")
        );
    if (n < 1e12)
        return (
            angkaTerbilang(Math.floor(n / 1e9)) +
            " miliar" +
            (n % 1e9 ? " " + angkaTerbilang(n % 1e9) : "")
        );
    return (
        angkaTerbilang(Math.floor(n / 1e12)) +
        " triliun" +
        (n % 1e12 ? " " + angkaTerbilang(n % 1e12) : "")
    );
};

const fmtRupiah = (v) =>
    `Rp ${(parseInt(String(v).replace(/\D/g, "")) || 0).toLocaleString("id-ID")},-`;
const parseNum = (v) => parseInt(String(v).replace(/\D/g, "")) || 0;
const spacedTitle = (t) => t.split("").join(" ");

export const useAktaPDF = () => {
    const generateAktaPDF = ({
        namaPerseroan,
        kotaKedudukan,
        provinsi,
        alamatLengkap,
        selectedKBLI,
        modalDasar,
        modalDitempatkan,
        modalDisetor,
        nominalPerSaham,
        sahamPerPendiri,
        pemegangSaham,
        direksi,
        komisaris,
    }) => {
        const doc = new jsPDF({
            orientation: "portrait",
            unit: "mm",
            format: "a4",
        });
        const pW = 210,
            pH = 297;
        const mL = 30,
            mR = 20,
            mT = 25;
        const cW = pW - mL - mR;
        let y = mT;

        const np = () => {
            doc.addPage();
            y = mT;
        };
        const cy = (n = 10) => {
            if (y + n > pH - 22) np();
        };
        const sf = (sz = 11, st = "normal") => {
            doc.setFontSize(sz);
            doc.setFont("courier", st);
        };

        const LH = 4.8;
        const PS = 2.0;
        const TAB = { 0: 10, 1: 8, 2: 14 };
        const INDENT_LANJUTAN = 15; // ← BARU: untuk paragraf kelanjutan (DOCX tab besar)

        const wA = (nomor, text, lvl = 0) => {
            sf(11, "normal");
            const tabX = TAB[lvl] || 0;
            const txX = mL + tabX;
            const txW = cW - tabX;
            const lines = doc.splitTextToSize(text, txW);
            cy(lines.length * LH + 2);
            doc.text(nomor, mL, y);
            lines.forEach((ln) => {
                doc.text(ln, txX, y);
                y += LH;
            });
            y += PS;
        };

        const wP = (text, indent = 0) => {
            sf(11, "normal");
            const w = cW - indent;
            const lines = doc.splitTextToSize(text, w);
            cy(lines.length * LH + 2);
            lines.forEach((ln) => {
                doc.text(ln, mL + indent, y);
                y += LH;
            });
            y += PS;
        };

        const wC = (text, sz = 11, st = "bold") => {
            sf(sz, st);
            const lines = doc.splitTextToSize(text, cW);
            cy(lines.length * (sz * 0.38 + 1.0) + 2);
            lines.forEach((ln) => {
                doc.text(ln, pW / 2, y, { align: "center" });
                y += sz * 0.38 + 1.4;
            });
        };

        const sp = (h = 3) => {
            y += h;
        };
        const dv = (thick = false) => {
            cy(3);
            doc.setLineWidth(thick ? 0.5 : 0.2);
            doc.line(mL, y, pW - mR, y);
            y += 4;
        };

        const pasal = (no, judul, isSpaced = false) => {
            cy(12);
            sp(3);
            sf(11, "normal");
            doc.text(
                `----------------------- Pasal ${no} -----------------------`,
                pW / 2,
                y,
                { align: "center" },
            );
            y += 4;
            const jTxt = isSpaced
                ? spacedTitle(judul.toUpperCase())
                : judul.toUpperCase();
            doc.text(`-------------- ${jTxt} --------------`, pW / 2, y, {
                align: "center",
            });
            y += 4;
            sp(3);
        };

        const today = new Date();
        const hari = today.toLocaleDateString("id-ID", { weekday: "long" });
        const tgl = today.toLocaleDateString("id-ID", {
            day: "numeric",
            month: "long",
            year: "numeric",
        });
        const nUp = (namaPerseroan || "[NAMA PERSEROAN]").toUpperCase();
        const mD = parseNum(modalDasar);
        const mDt = parseNum(modalDitempatkan);
        const mDs = parseNum(modalDisetor);
        const nS =
            parseNum(nominalPerSaham) ||
            (mD > 0 ? Math.round(mD / 400) : 100000);
        const jSD = nS > 0 ? Math.round(mD / nS) : 0;
        const jST = nS > 0 ? Math.round(mDt / nS) : 0;
        const pDt = mD > 0 ? Math.round((mDt / mD) * 100) : 0;
        const thD = today.getFullYear() + 1;

        // ══════════════════════════════════════
        //  HALAMAN JUDUL & KOMPARISI
        // ══════════════════════════════════════
        sp(10);
        wC("AKTA PENDIRIAN", 14, "bold");
        wC("PERSEROAN TERBATAS", 14, "bold");
        sp(3);
        wC(`"${nUp}"`, 12, "bold");
        sp(5);
        dv(true);
        dv(true);
        sp(5);
        wC("Nomor : ___________", 11, "normal");
        sp(2);
        wC(`Hari ${hari}, tanggal ${tgl}`, 11, "normal");
        sp(6);
        dv();
        sp(3);

        sf(11, "bold");
        doc.text("KOMPARISI", mL, y);
        y += LH + 1;
        sp(2);
        wP(
            "Berhadapan dengan saya, _________________________, Sarjana Hukum, Notaris di _________________________, dengan dihadiri oleh saksi-saksi yang saya, Notaris, kenal dan akan disebutkan pada bagian akhir akta ini:",
        );

        pemegangSaham.forEach((ps, i) => {
            wA(
                `${i + 1}.`,
                `Tuan/Nyonya ${ps.nama || "_______________"}, Warga Negara ${ps.domisili === "WNA" ? "Asing" : "Indonesia"}, Nomor Identitas : _______________, bertempat tinggal di _______________, untuk selanjutnya disebut sebagai "PENDIRI ${i + 1}" atau "PEMEGANG SAHAM ${i + 1}";`,
            );
        });

        sp(2);
        wP(
            'Para penghadap tersebut di atas menerangkan bahwa dengan tidak mengurangi izin dari pihak yang berwenang, mereka dengan ini bersepakat dan setuju untuk mendirikan suatu Perseroan Terbatas, dengan Anggaran Dasar sebagaimana yang termuat dalam akta ini (selanjutnya disebut "Anggaran Dasar").',
        );

        // ══════════════════════════════════════
        //  ANGGARAN DASAR
        // ══════════════════════════════════════
        sp(6);
        dv(true);
        sp(3);
        wC("---------- ANGGARAN DASAR ----------", 11, "bold");
        wC(`PERSEROAN TERBATAS "${nUp}"`, 11, "bold");
        sp(3);
        dv();

        // ── PASAL 1 ───────────────────────────────
        pasal(1, "Nama dan Tempat Kedudukan");
        // ✔️ PERBAIKAN: Pemisahan baris dan penyesuaian redaksi "di-Kota" sesuai dokumen
        wA(
            "1.1",
            `Perseroan Terbatas ini bernama:\n-------------PT "${nUp}"\n(selanjutnya dalam Anggaran Dasar ini cukup\ndisingkat dengan "Perseroan"), dan berkedudukan di-Kota ${kotaKedudukan || "_______________"}, beralamat lengkap di ${alamatLengkap || "_______________"}.`,
        );
        wA(
            "1.2",
            "Perseroan dapat membuka kantor, kantor cabang atau-\nkantor perwakilan di tempat lain di dalam\nmaupun di luar wilayah Republik Indonesia sebagaimana\nditetapkan oleh Direksi, dengan persetujuan dari\nDewan Komisaris.",
        );

        // ── PASAL 2 ───────────────────────
        pasal(2, "Jangka Waktu Berdirinya Perseroan");
        wP(
            "-Perseroan ini didirikan untuk jangka waktu yang tidak ditentukan lamanya dan dimulai sejak Anggaran Dasar ini mendapat pengesahan dari pihak yang berwenang, dengan memperhatikan Undang-Undang Nomor 25 Tahun 2007 (dua ribu tujuh) tentang Penanaman Modal Sebagaimana diubah dengan Undang-Undang Nomor 11 Tahun 2020 (dua ribu dua puluh) tentang Cipta Kerja (“UU Cipta Kerja”) berlaku terhadap Perseroan.",
        );

        // ── PASAL 3 ───────────────────────
        pasal(3, "Maksud dan Tujuan serta Kegiatan Usaha");

        const kTxt = selectedKBLI?.length
            ? selectedKBLI
                  .slice(0, 10)
                  .map((k) => k.kegiatan)
                  .join(", ")
            : "_______________";

        // ✔️ PERBAIKAN 1: Kosongkan string nomor ("") karena di dokumen tidak ada angka 3.1
        wA(
            "",
            `Maksud dan tujuan Perseroan adalah melakukan kegiatan usaha di bidang ${kTxt}.`,
        );

        // ✔️ PERBAIKAN 2: Tambahkan titik setelah angka 3.2 sesuai dokumen ("3.2.")
        wA(
            "3.2.",
            "Untuk mencapai maksud dan tujuan sebagaimana dimaksud dalam Pasal 3.1 di atas, Perseroan dapat melaksanakan kegiatan usaha sebagai berikut:",
        );

        if (selectedKBLI?.length) {
            // Membatasi maksimal 10 pilihan sesuai instruksi dokumen
            selectedKBLI.slice(0, 10).forEach((kb, i) => {
                const d = kb.deskripsi
                    ? kb.deskripsi.length > 300
                        ? kb.deskripsi.substring(0, 300) + "..."
                        : kb.deskripsi
                    : `${kb.kegiatan} (KBLI ${kb.kode})`;
                wA(`${String.fromCharCode(97 + i)}.`, d, 1);
            });

            // ✔️ PERBAIKAN 3: Menghapus teks "dan seterusnya hingga..."
            // karena kalimat tersebut di dokumen hanya berupa instruksi/keterangan template, bukan untuk dicetak di akta.
        } else {
            wA("a.", "[Uraian kegiatan usaha belum dipilih]", 1);
        }

        // ── PASAL 4 ───────────────────────
        pasal(4, "MODAL", true);

        // ✔️ PERBAIKAN 1: Kosongkan nomor ("") karena di dokumen tidak pakai angka 1.
        // ✔️ PERBAIKAN 2: Pastikan format Rupiah menggunakan akhiran ,- sesuai dokumen
        wA(
            "",
            `Modal dasar Perseroan berjumlah ${fmtRupiah(mD)} (${angkaTerbilang(mD)} Rupiah) terbagi atas ${jSD.toLocaleString("id-ID")} saham, masing-masing saham bernilai nominal ${fmtRupiah(nS)}.`,
        );

        // ✔️ PERBAIKAN 3: Kosongkan nomor ("") karena di dokumen tidak pakai angka 2.
        // ✔️ PERBAIKAN 4: Hapus teks terbilang persen agar langsung memunculkan % saja
        wA(
            "",
            `Dari modal dasar sebagaimana tersebut di atas, telah ditempatkan dan disetor sebanyak ${pDt}% atau ${jST.toLocaleString("id-ID")} saham dengan nilai nominal seluruhnya sebesar ${fmtRupiah(mDt)} oleh para pendiri yang telah mengambil bagian terhadap saham-saham tersebut dengan nilai nominal saham sebagaimana disebutkan pada bagian akhir akta ini.`,
        );

        // ── PASAL 5 ───────────────────────
        pasal(5, "SAHAM", true);
        wA(
            "5.1",
            "Seluruh saham yang dikeluarkan oleh Perseroan adalah saham atas nama.",
        );
        wA(
            "5.2",
            "Perseroan hanya mengakui 1 (satu) orang atau 1 (satu) badan hukum sebagai pemilik dari setiap saham.",
        );
        wA(
            "5.3",
            "Apabila suatu saham karena sebab apapun menjadi milik beberapa orang, maka mereka yang memiliki kepemilikan bersama tersebut diwajibkan untuk menunjuk 1 (satu) orang di antara mereka atau seorang lain sebagai kuasa bersama mereka, dan hanya orang yang ditunjuk atau diberi kuasa itulah sajalah yang berhak mempergunakan hak yang diberikan oleh hukum atas saham tersebut.",
        );
        wA(
            "5.4",
            "Sepanjang ketentuan dalam Pasal 5.3 belum dilaksanakan, maka para pemegang saham tersebut tidak berhak mengeluarkan suara dalam rapat umum pemegang saham, dan pembayaran dividen untuk saham tersebut harus ditangguhkan.",
        );
        // ✔️ SUDAH TEPAT: Menggunakan wP dengan indentasi lanjutan
        wP(
            "Pemegang saham menurut hukum harus mematuhi Anggaran Dasar ini, seluruh keputusan yang diambil secara sah dalam rapat umum pemegang saham serta peraturan perundang-undangan yang berlaku.",
            INDENT_LANJUTAN,
        );
        wA(
            "5.5",
            "Perseroan harus mempunyai sekurang-kurangnya 2 (dua) pemegang saham.",
        );
        wA(
            "5.6",
            "Perseroan dapat mengeluarkan surat saham sebagai bukti kepemilikan saham.",
        );
        wA(
            "5.7",
            "Jika surat saham dikeluarkan, maka satu surat saham akan dikeluarkan untuk setiap saham.",
        );
        wA(
            "5.8",
            "Surat kolektif saham dapat dikeluarkan sebagai bukti kepemilikan 2 (dua) atau lebih saham yang dimiliki oleh seorang pemegang saham.",
        );
        // ✔️ PERBAIKAN 1: Mengubah "sekurang-kurangnya" menjadi "sekurangnya"
        wA(
            "5.9",
            "Pada surat saham harus dicantumkan sekurangnya informasi berikut:",
        );
        wA("a.", "Nama dan alamat pemegang saham;", 1);
        // ✔️ PERBAIKAN 2: Mengubah "Nomor serie" menjadi "Nomor seri"
        wA("b.", "Nomor seri surat saham;", 1);
        wA("c.", "Tanggal pengeluaran surat saham; dan", 1);
        wA("d.", "Nilai nominal saham.", 1);

        // ✔️ PERBAIKAN 3: Mengubah "sekurang-kurangnya" menjadi "sekurangnya"
        wA(
            "5.10",
            "Pada surat kolektif saham harus dicantumkan sekurangnya informasi berikut:",
        );
        wA("a.", "Nama dan alamat pemegang saham;", 1);
        wA("b.", "Nomor seri surat kolektif saham;", 1);
        wA("c.", "Tanggal pengeluaran surat kolektif saham;", 1);
        wA(
            "d.",
            "Nilai nominal saham yang diwakili oleh surat kolektif saham; dan",
            1,
        );
        wA(
            "e.",
            "Jumlah total saham yang diwakili oleh surat kolektif saham tersebut.",
            1,
        );
        wA(
            "5.11",
            "Surat saham dan surat kolektif saham harus ditandatangani oleh seorang Direktur.",
        );

        // ── PASAL 6 ───────────────────────
        pasal(6, "Penggantian Surat Saham");
        wA(
            "6.1",
            "Apabila surat saham rusak atau tidak dapat dipergunakan lagi, maka atas permintaan pihak yang berkepentingan, Direksi akan mengeluarkan surat saham pengganti, setelah surat saham yang rusak atau tidak dapat digunakan tersebut telah dikembalikan kepada Direksi.",
        );
        wA(
            "6.2",
            "Surat saham sebagaimana dimaksud dalam Pasal 6.1 kemudian akan dimusnahkan oleh Direksi, dan Direksi akan membuat suatu berita acara untuk dilaporkan dalam rapat umum pemegang saham berikutnya.",
        );
        wA(
            "6.3",
            "Apabila surat saham hilang, maka atas permintaan pihak yang berkepentingan, Direksi akan mengeluarkan surat saham pengganti, dengan ketentuan bahwa kehilangan tersebut telah cukup dapat dibuktikan menurut pendapat Direksi.",
        );
        wA(
            "6.4",
            "Setelah surat saham pengganti tersebut dikeluarkan, maka surat saham semula tidak berlaku lagi terhadap Perseroan.",
        );
        wA(
            "6.5",
            "Seluruh biaya yang dikeluarkan untuk penerbitan surat saham pengganti harus ditanggung oleh pemegang saham yang berkepentingan.",
        );
        wA(
            "6.6",
            "Ketentuan sebagaimana diatur dalam Pasal 6 ini berlaku, mutatis mutandis, bagi penerbitan surat kolektif saham pengganti.",
        );

        // ── PASAL 7 ───────────────────────
        pasal(7, "Daftar Pemegang Saham dan Daftar Khusus");
        wA(
            "7.1",
            "Direksi wajib mengadakan dan menyimpan daftar pemegang saham dan daftar khusus di tempat kedudukan Perseroan.",
        );
        wA(
            "7.2",
            "Berikut ini hal-hal yang harus dicantumkan dalam daftar pemegang saham:",
        );
        wA("(a)", "Nama dan alamat para pemegang saham;", 1);
        wA(
            "(b)",
            "Jumlah, nomor seri, tanggal perolehan dan kelas saham (jika terdapat lebih dari 1 (satu) kelas saham) atas saham yang dimiliki oleh para pemegang saham;",
            1,
        );
        wA("(c)", "Jumlah yang dibayar untuk setiap saham;", 1);
        wA(
            "(d)",
            "Nama dan alamat dari orang atau badan hukum yang mempunyai hak gadai atau jaminan fidusia atas saham dan tanggal perolehan hak gadai atau tanggal pendaftaran jaminan fidusia tersebut;",
            1,
        );
        wA(
            "(e)",
            "Keterangan mengenai pengambilan bagian atas saham apabila pembayaran dilakukan dalam bentuk lain selain uang tunai;",
            1,
        );
        wA(
            "(f)",
            "Keterangan mengenai pengalihan saham, gadai, jaminan fidusia, atau pembebanan atas saham Perseroan; dan",
            1,
        );
        wA("(g)", "Keterangan lain yang dianggap perlu oleh Direksi.", 1);

        // ✔️ SUDAH BENAR: Paragraf lanjutan tanpa nomor dengan indentasi khusus
        wP(
            "Setiap pendaftaran atau pencatatan dalam daftar pemegang saham harus ditandatangani oleh seorang Direktur.",
            INDENT_LANJUTAN,
        );

        wA(
            "7.3",
            "Bersama dengan daftar pemegang saham sebagaimana dimaksud dalam Pasal 7.2 di atas, Direksi wajib mengadakan dan menyimpan daftar khusus yang mencatat keterangan mengenai kepemilikan saham anggota Direksi dan Dewan Komisaris beserta keluarganya dalam Perseroan dan/atau pada perseroan lain serta tanggal saham itu diperoleh.",
        );
        wA(
            "7.4",
            "Setiap perubahan kepemilikan saham harus dicatatkan dalam daftar pemegang saham dan daftar khusus, sebagaimana berlaku, berdasarkan Pasal 7.2 dan Pasal 7.3 di atas.",
        );
        wA(
            "7.5",
            "Pemegang saham harus memberitahukan secara tertulis setiap perubahan alamat kepada Direksi Perseroan. Selama pemberitahuan itu belum diberikan, maka segala panggilan dan pemberitahuan kepada pemegang saham adalah sah jika dialamatkan pada alamat pemegang saham sebagaimana tercatat dalam daftar pemegang saham.",
        );
        wA(
            "7.6",
            "Setiap pemegang saham berhak untuk melihat daftar pemegang saham dan daftar khusus selama jam kerja kantor Perseroan.",
        );

        // ── PASAL 8 ───────────────────────
        pasal(8, "Pemindahan Hak Atas Saham");
        wA(
            "8.1",
            "Pemindahan hak atas saham terjadi berdasarkan akta pemindahan hak yang ditandatangani oleh yang memindahkan dan yang menerima pemindahan atau kuasanya yang sah.",
        );
        wA(
            "8.2",
            "Akta pemindahan hak sebagaimana dimaksud dalam Pasal 8.1 atau salinannya harus diserahkan kepada Perseroan.",
        );
        wA(
            "8.3",
            "Pemindahan hak atas saham hanya dapat dilakukan dengan persetujuan dari rapat umum pemegang saham.",
        );
        wA(
            "8.4",
            "Pemegang saham yang bermaksud untuk memindahkan sahamnya harus terlebih dahulu menawarkan secara tertulis kepada pemegang saham lainnya dengan menyebutkan harga dan ketentuan penjualan dan harus memberitahukan Direksi secara tertulis mengenai penawaran tersebut.",
        );
        wA(
            "8.5",
            "Para pemegang saham lainnya berhak untuk membeli saham yang ditawarkan dalam jangka waktu 30 (tiga puluh) hari setelah tanggal penawaran, secara proporsional sesuai dengan jumlah saham yang dimiliki oleh masing-masing pemegang saham tersebut.",
        );
        wA(
            "8.6",
            "Pemegang saham yang menawarkan sahamnya sebagaimana disebutkan dalam Pasal 8.4 berhak untuk menarik kembali penawarannya setelah berakhirnya jangka waktu sebagaimana disebutkan pada Pasal 8.5.",
        );
        wA(
            "8.7",
            "Persyaratan untuk menawarkan saham kepada pemegang saham hanya dapat dilakukan satu kali.",
        );
        wA(
            "8.8",
            "Pemindahan hak atas saham hanya diperbolehkan apabila semua ketentuan dalam Anggaran Dasar ini telah terpenuhi.",
        );
        wA(
            "8.9",
            "Sejak tanggal panggilan rapat umum pemegang saham hingga tanggal rapat, pemindahan hak atas saham tidak diperbolehkan.",
        );

        // ── PASAL 9 ───────────────────────
        pasal(9, "Rapat Umum Pemegang Saham");
        wA("9.1", "Rapat umum pemegang saham Perseroan adalah:");
        wA(
            "(a)",
            "Rapat umum pemegang saham tahunan sebagaimana disebutkan dalam Pasal 9 Anggaran Dasar ini; dan",
            1,
        );
        wA(
            "(b)",
            "Rapat umum pemegang saham luar biasa, yang merupakan rapat umum pemegang saham yang dapat diselenggarakan setiap saat jika diperlukan.",
            1,
        );
        // ✔️ PERBAIKAN 1: Mengubah jenis tanda kutip menjadi curly quotes sesuai dokumen
        wA(
            "9.2",
            "Kecuali dengan tegas ditentukan lain, istilah “Rapat Umum Pemegang Saham” dalam Anggaran Dasar ini berarti keduanya yaitu rapat umum pemegang saham tahunan dan rapat umum pemegang saham luar biasa.",
        );
        wA(
            "9.3",
            "Rapat umum pemegang saham tahunan diselenggarakan setiap tahun paling lambat 6 (enam) bulan setelah tahun buku Perseroan berakhir.",
        );
        wA("9.4", "Dalam rapat umum pemegang saham tahunan:");
        wA(
            "(a)",
            "Direksi mengajukan laporan tahunan untuk persetujuan pemegang saham, yang setidaknya memuat:",
            1,
        );
        wA(
            "(i)",
            "laporan keuangan yang terdiri dari sekurang-kurangnya neraca keuangan dari tahun buku yang sedang diperiksa dibandingkan dengan tahun buku yang sebelumnya, laporan laba dan rugi atas tahun buku yang sedang diperiksa, laporan pergerakan arus kas, laporan pergerakan aset dan catatan-catatan yang mendampingi laporan keuangan;",
            2,
        );
        wA("(ii)", "laporan kegiatan usaha Perseroan;", 2);
        wA(
            "(iii)",
            "laporan mengenai pelaksanaan kegiatan tanggung jawab sosial Perseroan;",
            2,
        );
        wA(
            "(iv)",
            "penjelasan mengenai permasalahan yang dihadapi oleh Perseroan selama tahun buku yang sedang diperiksa yang mempengaruhi performa Perseroan;",
            2,
        );
        // ✔️ PERBAIKAN 2: Mengubah kata "pelaksana" menjadi "pelaksanaan"
        wA(
            "(v)",
            "laporan mengenai pelaksanaan pengawasan oleh Dewan Komisaris selama tahun buku yang sedang diperiksa;",
            2,
        );
        wA("(vi)", "nama-nama anggota Direksi dan Dewan Komisaris; dan", 2);
        wA(
            "(vii)",
            "gaji dan upah yang diterima oleh anggota Direksi dan Dewan Komisaris selama tahun buku yang diperiksa.",
            2,
        );
        wA(
            "(b)",
            "Pembagian keuntungan sebagai dividen diputuskan dan disetujui, jika Perseroan memiliki pendapatan bersih positif;",
            1,
        );
        wA(
            "(c)",
            "Anggota baru Direksi dan Dewan Komisaris diangkat, jika diperlukan;",
            1,
        );
        wA("(d)", "Auditor ditunjuk; dan", 1);
        wA(
            "(e)",
            "Hal-hal lain yang telah diajukan secara benar berdasarkan anggaran dasar ditelaah.",
            1,
        );
        wA(
            "9.5",
            "Persetujuan atas laporan tahunan, termasuk pengesahan laporan keuangan dan laporan pengawasan Dewan Komisaris, oleh rapat umum pemegang saham berarti memberikan pelunasan dan pembebasan tanggung jawab sepenuhnya kepada anggota Direksi dan Dewan Komisaris atas pengurusan dan pengawasan yang telah dijalankan selama tahun buku yang sebelumnya, sepanjang tindakan tersebut tercermin dalam laporan tahunan.",
        );
        wA(
            "9.6",
            "Rapat umum pemegang saham luar biasa dapat diselenggarakan sewaktu-waktu bilamana dianggap perlu berdasarkan kebutuhan untuk membicarakan dan memutuskan agenda Perseroan tertentu.",
        );
        // ✔️ PERBAIKAN 3: Mengubah "sekurang-kurangnya" menjadi "sekurangnya"
        wA(
            "9.7",
            "Direksi wajib memanggil dan menyelenggarakan rapat umum pemegang saham luar biasa atas permintaan tertulis dari Dewan Komisaris, atau 1 (satu) pemegang saham atau lebih yang bersama-sama mewakili sekurangnya 1/10 (satu persepuluh) bagian dari seluruh saham dengan hak suara yang sah. Permintaan tertulis tersebut harus dikirim melalui surat tercatat, yang menyatakan persoalan yang akan didiskusikan bersama beserta dengan alasannya, dengan salinannya disampaikan kepada Dewan Komisaris.",
        );
        wA(
            "9.8",
            "Apabila Direksi gagal untuk menyelenggarakan rapat umum pemegang saham luar biasa sebagaimana dimaksud dalam Pasal 9.7 dalam 15 (lima belas) hari setelah permintaan diterima, para pemegang saham yang berkepentingan berhak untuk meminta kembali kepada Dewan Komisaris untuk menyelenggarakan rapat umum pemegang saham atau Dewan Komisaris berhak untuk memanggil sendiri rapat umum pemegang saham. Apabila pemegang saham meminta kepada Dewan Komisaris, Dewan Komisaris wajib melakukan pemanggilan rapat umum pemegang saham dalam waktu 15 (lima belas) hari setelah permintaan untuk menyelenggarakan rapat umum pemegang saham tersebut diterima.",
        );
        wA(
            "9.9",
            "Jika Direksi atau Dewan Komisaris gagal untuk melakukan pemanggilan rapat umum pemegang saham dalam jangka waktu yang terdapat pada Pasal 9.8, pemegang saham yang bersangkutan berhak untuk memanggil sendiri rapat umum pemegang saham setelah mendapatkan izin dari Ketua Pengadilan Negeri yang daerah hukumnya meliputi tempat kedudukan Perseroan.",
        );
        wA(
            "9.10",
            "Penyelenggaraan rapat sebagaimana yang dimaksud dalam Pasal 9.9 harus memperhatikan penetapan Ketua Pengadilan Negeri yang memberi izin tersebut.",
        );

        // ── PASAL 10 ──────────────────────
        pasal(10, "Tempat, Panggilan dan Pimpinan Rapat Umum Pemegang Saham");
        wA(
            "10.1",
            "Rapat umum pemegang saham diselenggarakan di tempat kedudukan Perseroan atau tempat kegiatan usaha utama Perseroan.",
        );
        wA(
            "10.2",
            "Rapat umum pemegang saham diselenggarakan setelah melakukan pemanggilan terlebih dahulu kepada para pemegang saham melalui surat tercatat atau pengumuman koran.",
        );
        wA(
            "10.3",
            "Panggilan rapat umum pemegang saham harus dikirimkan paling lambat 14 (empat belas) hari sebelum tanggal rapat diadakan, dengan tidak memperhitungkan tanggal panggilan dan tanggal rapat.",
        );
        wA(
            "10.4",
            "Pemberitahuan mengenai rapat umum pemegang saham harus mencantumkan hari, tanggal, jam, tempat dan agenda rapat, serta dengan disertai pemberitahuan bahwa bahan yang akan dibicarakan dalam rapat tersedia di kantor Perseroan mulai dari hari dilakukan pemanggilan sampai dengan tanggal rapat diadakan.",
        );
        wA(
            "10.5",
            "Apabila semua pemegang saham dengan hak suara yang sah hadir atau diwakilkan dalam rapat, pemberitahuan sebelumnya sebagaimana disebutkan dalam Pasal 10.2 tidak lagi diperlukan dan rapat tersebut dapat diselenggarakan dimanapun dalam wilayah Republik Indonesia. Dalam rapat, keputusan yang sah dan mengikat dapat diambil berdasarkan suara setuju dari semua pemegang saham yang hadir atau diwakili dalam rapat.",
        );
        wA(
            "10.6",
            "Rapat umum pemegang saham dipimpin oleh Direktur Utama atau, dalam hal Direktur Utama tidak dapat hadir atau berhalangan karena sebab apapun, yang mana tidak perlu dibuktikan kepada pihak ketiga, maka rapat dipimpin oleh salah satu anggota Direksi yang tercantum dalam Pasal 12. Jika Direktur Utama dan semua anggota Direksi tidak dapat hadir atau berhalangan hadir karena sebab apapun, yang mana tidak perlu dibuktikan kepada pihak ketiga, maka rapat dipimpin oleh salah seorang anggota Dewan Komisaris. Jika tidak ada seorangpun dari Dewan Komisaris hadir atau mereka berhalangan hadir karena sebab apapun, yang tidak perlu dibuktikan kepada pihak ketiga, maka rapat akan dipimpin oleh seorang yang ditunjuk oleh dan dari antara mereka yang hadir di dalam rapat.",
        );

        // ✔️ PERBAIKAN: Memecah Poin 10.7 menjadi Dua Bagian agar Terbentuk Alinea Baru
        wA(
            "10.7",
            "Para pemegang saham dapat berpartisipasi dalam rapat umum pemegang saham melalui konferensi video, konferensi telepon atau sistem komunikasi yang sejenis jika sistem tersebut memungkinkan seluruh pihak yang berpartisipasi dapat melihat dan mendengar satu sama lain. Partisipasi tersebut dianggap sebagai kehadiran dalam rapat umum pemegang saham.",
        );
        wP(
            "-Berita acara rapat umum pemegang saham yang diadakan dengan memakai konferensi video, konferensi telepon maupun sistem komunikasi yang sejenis harus dibuat secara tertulis dan diedarkan kepada seluruh pemegang saham yang berpartisipasi untuk ditinjau kembali dan mendapatkan persetujuan.",
            INDENT_LANJUTAN,
        );

        wA(
            "10.8",
            "Berita acara rapat dibuat sehubungan dengan setiap dan seluruh hal yang dibicarakan dan diputuskan dalam rapat umum pemegang saham. Berita acara rapat disahkan dengan ditandatangani oleh ketua rapat dan 1 (satu) pemegang saham atau kuasa dari seorang pemegang saham yang ditunjuk oleh dan dari antara mereka yang hadir dalam rapat. Berita acara rapat tersebut merupakan bukti yang sah untuk semua pemegang saham dan pihak ketiga atas semua peristiwa dan keputusan yang terjadi dalam rapat yang bersangkutan.",
        );
        wA(
            "10.9",
            "Penandatanganan sebagaimana dimaksud dalam Pasal 10.8 Anggaran Dasar ini tidak disyaratkan apabila berita acara rapat dibuat dalam bentuk akta Notaris.",
        );

        // ── PASAL 11 ────────────────────
        pasal(11, "Kuorum, Hak Suara dan Keputusan");
        wA(
            "11.1",
            "(a) Kecuali apabila dalam Anggaran Dasar ini atau hukum dan peraturan perundang-undangan yang terkait lainnya mengatur kuorum yang lebih tinggi, rapat umum pemegang saham dapat dilangsungkan dan berhak mengambil keputusan-keputusan yang sah dan mengikat apabila dihadiri oleh pemegang saham yang mewakili lebih dari 1/2 (satu perdua) bagian dari jumlah seluruh saham dengan hak suara yang sah yang dikeluarkan oleh Perseroan.",
        );
        wA(
            "(b)",
            "Dalam hal kuorum sebagaimana dimaksud dalam ketentuan Pasal 11.1 (a) tidak tercapai, maka dapat diadakan panggilan rapat kedua.",
            1,
        );
        wA(
            "(c)",
            "Panggilan sebagaimana yang dimaksud dalam ketentuan Pasal 11.1 (b) harus dilakukan paling lambat 7 (tujuh) hari sebelum rapat diselenggarakan, tidak termasuk tanggal panggilan dan tanggal rapat.",
            1,
        );
        wA(
            "(d)",
            "Rapat kedua diselenggarakan paling cepat 10 (sepuluh) hari dan paling lambat 21 (dua puluh satu) hari terhitung sejak tanggal rapat pertama.",
            1,
        );
        wA(
            "(e)",
            "Rapat kedua dapat dilangsungkan dan dapat mengambil keputusan-keputusan yang sah dan mengikat apabila dihadiri oleh pemegang saham yang mewakili sedikitnya 1/3 (satu pertiga) bagian dari jumlah seluruh saham dengan hak suara yang sah.",
            1,
        );
        wA(
            "(f)",
            "Dalam hal kuorum rapat kedua tidak tercapai, maka atas permohonan Perseroan, kuorum ditetapkan oleh Ketua Pengadilan Negeri yang wilayahnya meliputi tempat kedudukan Perseroan.",
            1,
        );
        wA(
            "11.2",
            "Pemegang saham dapat diwakili oleh pemegang saham lain atau orang lain dengan surat kuasa.",
        );
        wA(
            "11.3",
            "Ketua rapat berhak untuk meminta agar surat kuasa untuk mewakili pemegang saham diperlihatkan kepadanya pada waktu rapat diadakan.",
        );

        // Catatan: Pastikan output 11.4 & 11.5 tercetak rapat dengan teks setelahnya sesuai dokumen
        wA(
            "11.4",
            "Dalam rapat, tiap saham memberikan hak kepada pemiliknya untuk mengeluarkan 1 (satu) suara.",
        );
        wA(
            "11.5",
            "Anggota Direksi dan anggota Dewan Komisaris dan karyawan Perseroan boleh bertindak selaku kuasa dalam rapat, namun suara yang mereka keluarkan selaku kuasa dalam rapat tidak dihitung dalam pemungutan suara.",
        );
        wA(
            "11.6",
            "Pemungutan suara mengenai diri orang dilakukan dengan surat tertutup yang tidak ditandatangani. Pemungutan suara mengenai hal lain dilakukan secara lisan, kecuali jika ketua rapat menentukan lain, dan tanpa ada keberatan dari pemegang saham yang hadir dalam rapat.",
        );
        wA(
            "11.7",
            "Suara blanko atau suara yang tidak sah dianggap tidak ada dan tidak dihitung dalam menentukan jumlah suara yang dikeluarkan dalam rapat.",
        );

        // ✔️ PERBAIKAN: Memecah Poin 11.8 menjadi dua bagian paragraf dengan tanda hubung
        wA(
            "11.8",
            "-Semua keputusan harus dilakukan berdasarkan musyawarah untuk mufakat untuk mencapai kesepakatan. Dalam hal keputusan yang dilakukan berdasarkan musyawarah untuk mufakat tidak tercapai, maka keputusan adalah sah jika disetujui lebih dari 1/2 (satu perdua) bagian dari jumlah seluruh suara yang dikeluarkan dengan sah dalam rapat, kecuali apabila dalam Anggaran Dasar ini ditentukan lain.",
        );
        wP(
            "-Apabila jumlah suara yang setuju dan tidak setuju sama banyaknya maka usul dianggap ditolak, dengan ketentuan bahwa untuk pengangkatan anggota Direksi dan Dewan Komisaris, pemungutan suara akan dilanjutkan sampai 1 (satu) orang calon telah memperoleh suara mayoritas yang dikeluarkan secara sah sebagaimana disyaratkan.",
            INDENT_LANJUTAN,
        );

        wA(
            "11.9",
            "Pemegang saham juga dapat mengambil keputusan yang sah tanpa mengadakan rapat umum pemegang saham, dengan ketentuan semua pemegang saham telah diberitahu secara tertulis dan semua pemegang saham memberikan persetujuan mengenai usul yang diajukan secara tertulis yang dibuktikan dengan tanda tangan persetujuan mereka. Keputusan yang diambil dengan cara demikian mempunyai kekuatan yang sama dengan keputusan yang diambil dengan sah dalam rapat umum pemegang saham. Semua keputusan tersebut dapat memuat beberapa dokumen serupa, yang masing-masing ditandatangani oleh 1 (satu) atau lebih pemegang saham.",
        );

        // ── PASAL 12 ───────────────────────
        pasal(12, "DIREKSI", true);
        wA(
            "12.1",
            "Perseroan diurus oleh suatu Direksi yang terdiri dari sekurang-kurangnya 1 (satu) orang Direktur. Jika terdapat lebih dari 1 (satu) Direktur yang diangkat, maka salah satu dari mereka akan menjabat sebagai Direktur Utama.",
        );
        // ✔️ PERBAIKAN 1: Memperbaiki typo kata "perundang-undangan"
        wA(
            "12.2",
            "Anggota Direksi ditunjuk dari orang yang memenuhi persyaratan sebagaimana diatur dalam peraturan perundang-undangan yang berlaku.",
        );
        wA(
            "12.3",
            "Para anggota Direksi diangkat oleh rapat umum pemegang saham, untuk jangka waktu 5 (lima) tahun sejak tanggal rapat umum pemegang saham dimana mereka diangkat, tanpa mengesampingkan hak dari rapat umum pemegang saham untuk memberhentikan setiap anggota Direksi sewaktu-waktu dengan menyebutkan alasan pemberhentian.",
        );
        wA(
            "12.4",
            "Masa jabatan seseorang yang diangkat menjadi anggota Direksi untuk mengisi jabatan yang lowong karena sebab apapun adalah sisa masa jabatan dari anggota Direksi yang digantikannya, kecuali ditentukan lain oleh rapat umum pemegang saham.",
        );
        wA(
            "12.5",
            "Para anggota Direksi dapat diangkat kembali untuk menjabat setelah habisnya masa jabatan mereka.",
        );
        wA(
            "12.6",
            "Para anggota Direksi dapat diberi gaji dan/atau tunjangan yang jumlahnya ditentukan oleh rapat umum pemegang saham. Kewenangan rapat umum pemegang saham tersebut dapat didelegasikan kepada Dewan Komisaris.",
        );
        wA(
            "12.7",
            "Apabila oleh sebab apapun, dalam Direksi terdapat jabatan yang lowong, maka dalam jangka waktu 30 (tiga puluh) hari setelah terjadinya kekosongan jabatan itu, rapat umum pemegang saham harus diselenggarakan untuk mengisi lowongan tersebut, dengan memperhatikan ketentuan Pasal 12.2.",
        );
        wA(
            "12.8",
            "Apabila oleh sebab apapun, seluruh jabatan dalam Direksi lowong, maka dalam jangka waktu 30 (tiga puluh) hari setelah terjadinya kekosongan jabatan itu, rapat umum pemegang saham harus diselenggarakan untuk mengangkat anggota Direksi yang baru, dengan memperhatikan ketentuan Pasal 12.2, dan untuk sementara Perseroan diurus oleh Dewan Komisaris.",
        );
        // ✔️ PERBAIKAN 2: Mengubah "sekurang-kurangnya" menjadi "sekurangnya"
        wA(
            "12.9",
            "Seorang anggota Direksi berhak untuk mengundurkan diri dari jabatannya dengan memberitahukan secara tertulis mengenai maksudnya tersebut kepada Perseroan sekurangnya 30 (tiga puluh) hari sebelum tanggal pengunduran dirinya.",
        );
        // ✔️ PERBAIKAN 3: Menambahkan tanda hubung pemisah dan memastikan teks rapat dengan nomor jika fungsi wA mendukung, atau sesuaikan string-nya
        wA("12.10", "-Masa jabatan anggota Direksi berakhir apabila: -");
        wA("(a)", "mengundurkan diri sesuai dengan ketentuan Pasal 12.9;", 1);
        wA(
            "(b)",
            "tidak lagi memenuhi persyaratan perundang-undangan yang berlaku;",
            1,
        );
        wA("(c)", "meninggal dunia;", 1);
        wA(
            "(d)",
            "diberhentikan berdasarkan keputusan rapat umum pemegang saham; atau",
            1,
        );
        wA(
            "(e)",
            "dinyatakan pailit atau ditempatkan di bawah pengampuan berdasarkan keputusan pengadilan.",
            1,
        );

        // ── PASAL 13 ──────────────────────
        pasal(13, "Tugas dan Wewenang Direksi");
        wA(
            "13.1",
            "Direksi bertanggung jawab penuh dalam melaksanakan tugasnya dan harus bertindak untuk kepentingan Perseroan untuk mencapai maksud dan tujuannya.",
        );
        wA(
            "13.2",
            "Setiap anggota Direksi wajib dengan itikad baik dan dengan penuh tanggung jawab menjalankan tugasnya dengan mengindahkan peraturan perundang-undangan yang berlaku.",
        );
        wA(
            "13.3",
            "Direksi berhak mewakili Perseroan di dalam dan di luar pengadilan tentang segala hal and dalam segala kejadian, mengikat Perseroan dengan pihak lain dan pihak lain dengan Perseroan, serta menjalankan segala tindakan, baik yang mengenai kepengurusan maupun kepemilikan, tetapi dengan pembatasan bahwa persetujuan Dewan Komisaris akan disyaratkan untuk:",
        );
        wA(
            "(a)",
            "Meminjam uang (dengan ketentuan bahwa memperoleh fasilitas cerukan yang lazim untuk kegiatan usaha sehari-hari atau penarikan uang dari rekening kredit atau pinjaman yang sudah disetujui tidak dianggap sebagai meminjam untuk maksud di dalam ketentuan ini), termasuk setiap penerbitan efek bersifat utang, atau memberikan pinjaman atas nama Perseroan dalam jumlah lebih dari 50% (lima puluh persen) dari jumlah seluruh modal disetor Perseroan, baik dalam mata uang Rupiah atau dengan nilai yang setara dalam mata uang lain;",
            1,
        );
        wA("(b)", "Mengikat Perseroan sebagai penjamin;", 1);
        wA(
            "(c)",
            "Mendirikan suatu perusahaan baru atau turut serta pada perusahaan lain baik di dalam maupun di luar negeri;",
            1,
        );
        wA(
            "(d)",
            "memperoleh melalui pembelian, sewa atau metode lain, barang bergerak atau barang tidak bergerak dengan biaya (dalam hal sewa, harga pembayaran sewa tahunan) yang melebihi 50% (lima puluh persen) dari seluruh modal disetor Perseroan baik dalam mata uang Rupiah atau dengan nilai yang setara dalam mata uang lain; atau",
            1,
        );
        wA(
            "(e)",
            "Membuat jaminan atas barang bergerak maupun tidak bergerak yang dimiliki oleh Perseroan.",
            1,
        );
        wP(
            "Disamping itu, tindakan-tindakan yang dimaksud pada Pasal 13.3 (a), b, c dan (d), persetujuan dari rapat umum pemegang saham diperlukan. Terhadap pihak ketiga, persetujuan rapat dewan komisaris cukup dibuktikan dengan persetujuan sesuai dengan Pasal 17.10, atau dengan persetujuan tertulis yang ditandatangani oleh para anggota Dewan Komisaris sesuai dengan ketentuan yang terdapat pada Pasal 17.14.",
            INDENT_LANJUTAN,
        );
        // ✔️ PERBAIKAN 1: Mengubah "sekurang-kurangnya" menjadi "sekurangnya" (2 kali)
        wA(
            "13.4",
            "Perbuatan hukum untuk mengalihkan hak dalam 1 (satu) tahun buku atau menjadikan harta kekayaan Perseroan sebagai jaminan utang harta kekayaan Perseroan yang merupakan lebih dari 50% (lima puluh persen) jumlah kekayaan bersih Perseroan, baik dalam satu transaksi atau dalam beberapa transaksi yang berdiri sendiri ataupun tidak berkaitan satu sama lain, harus mendapat persetujuan terlebih dahulu dari sekurangnya 3/4 (tiga perempat) bagian dari hak suara yang sah yang dikeluarkan dalam rapat umum pemegang saham yang mana pemegang saham yang memiliki sekurangnya 3/4 (tiga perempat) bagian dari seluruh saham dengan hak suara yang sah hadir atau diwakili.",
        );
        wA(
            "13.5",
            "(a) Direktur berhak dan berwenang bertindak untuk dan atas nama Direksi serta mewakili Perseroan, dalam hal terdapat lebih dari 1 (satu) Direktur, maka Direktur Utama berwenang bertindak untuk dan atas nama Direksi serta mewakili Perseroan, jika Direktur Utama berhalangan hal mana tidak perlu dibuktikan kepada pihak ketiga maka Direktur lain dapat mewakili Perseroan.",
        );
        wA(
            "(b)",
            "Jika Direktur karena alasan apapun tidak dapat hadir atau berhalangan, yang tidak perlu dibuktikan kepada pihak ketiga, maka anggota direksi lainnya memiliki hak dan kewenangan untuk bertindak untuk dan atas nama direksi serta mewakili Perseroan. Pembuktian terhadap pihak ketiga tidak diperlukan untuk ketidakhadirannya.",
            1,
        );
        // ✔️ PERBAIKAN 2: Mengubah kata "Direksi" menjadi "Direktur" pada kalimat awal
        wA(
            "(c)",
            "Jika hanya terdapat 1 (satu) Direktur, seluruh tugas dan wewenang yang diberikan kepada Direktur dan anggota Direksi lainnya didalam anggaran dasar ini berlaku terhadap Direksi tersebut.",
            1,
        );
        // ✔️ PERBAIKAN 3: Memecah Poin 13.6 menjadi dua bagian alinea bertanda hubung (-)
        wA(
            "13.6",
            "-Untuk perbuatan tertentu, Direksi berhak untuk mengangkat 1 (satu) orang atau lebih sebagai wakil atau kuasanya dengan memberikan kepadanya wewenang yang diatur dalam surat kuasa tertulis.",
        );
        wP(
            "-Pembagian tugas dan wewenang setiap anggota Direksi diatur dan ditetapkan oleh rapat umum pemegang saham. Dalam hal rapat umum pemegang saham tidak menetapkan pembagian tugas dan wewenang masing-masing anggota Direksi, maka pembagian tugas dan wewenang Direksi tersebut akan diatur dalam sebuah rapat Direksi.",
            INDENT_LANJUTAN,
        );

        wA(
            "13.7",
            "Dalam hal Perseroan mempunyai kepentingan yang bertentangan dengan kepentingan pribadi seorang anggota Direksi, maka Perseroan akan diwakili oleh anggota Direksi lainnya. Dalam hal Perseroan mempunyai kepentingan yang bertentangan dengan kepentingan seluruh anggota Direksi, maka dalam hal ini Perseroan diwakili oleh Dewan Komisaris.",
        );

        // ── PASAL 14 ──────────────────────
        pasal(14, "Rapat Direksi");
        wA(
            "14.1",
            "Rapat Direksi dapat diselenggarakan di tempat kedudukan Perseroan atau tempat dimana Perseroan memiliki kegiatan usaha.",
        );
        wA(
            "14.2",
            "Rapat Direksi dapat dilakukan setiap saat apabila dipandang perlu oleh 1 (satu) Direktur atau lebih anggota Direksi atau dengan permintaan tertulis dari 1 (satu) atau lebih anggota Dewan Komisaris, atau oleh 1 (satu) atau lebih pemegang saham yang bersama-sama mewakili setidaknya 1/10 (satu persepuluh) bagian dari jumlah seluruh saham dengan hak suara yang sah.",
        );
        wA(
            "14.3",
            "Panggilan rapat Direksi dikeluarkan oleh anggota Direksi yang berhak mewakili Direksi sesuai dengan ketentuan Pasal 13.5.",
        );

        // ✔️ PERBAIKAN 1: Memecah Poin 14.4 menjadi tiga paragraf dan memperbaiki typo "diwaki"
        wA(
            "14.4",
            "-Panggilan rapat Direksi dikirim melalui surat terdaftar, surat elektronik atau faksimili paling lambat 10 (sepuluh) hari sebelum rapat dilaksanakan, dengan tidak memperhitungkan tanggal pemanggilan dan tanggal dilaksanakannya rapat.",
        );
        wP(
            "-Setiap anggota Direksi dapat menerima panggilan dengan jangka waktu yang lebih pendek dari yang ditentukan dalam Anggaran Dasar ini, termasuk tidak adanya panggilan, jika menurut pendapat Direktur Utama, terdapat perihal yang dirasa perlu untuk diputuskan secara mendesak.",
            INDENT_LANJUTAN,
        );
        wP(
            "-Apabila semua anggota Direksi hadir atau diwakili dalam rapat, pemberitahuan sebelumnya yang dimaksud dalam pasal ini tidak akan diwajibkan dan rapat dapat diselenggarakan dimanapun dalam wilayah Republik Indonesia. Dalam rapat, keputusan yang sah dan mengikat dapat diambil berdasarkan suara setuju dari semua anggota Direksi yang hadir atau diwakili dalam rapat.",
            INDENT_LANJUTAN,
        );

        wA(
            "14.5",
            "Panggilan harus mencantumkan agenda, tanggal, waktu dan tempat dilaksanakannya rapat.",
        );

        // ✔️ PERBAIKAN 2: Memecah Poin 14.6 menjadi dua paragraf
        wA(
            "14.6",
            "-Para anggota Direksi dapat berpartisipasi dalam rapat Direksi melalui konferensi video, konferensi telepon atau sistem komunikasi sejenis jika sistem tersebut memungkinkan semua peserta rapat untuk saling melihat dan mendengar satu sama lain. Partisipasi tersebut dianggap sebagai kehadiran dalam rapat.",
        );
        wP(
            "-Berita acara rapat yang diselenggarakan melalui konferensi video, konferensi telepon atau sistem komunikasi sejenis harus dibuat secara tertulis dan diedarkan kepada seluruh anggota Direksi yang berpartisipasi dalam rapat untuk diperiksa dan mendapatkan persetujuan.",
            INDENT_LANJUTAN,
        );

        wA(
            "14.7",
            "Rapat Direksi dipimpin oleh Direktur Utama, atau dalam hal Direktur Utama tidak hadir atau berhalangan untuk hadir, hal mana tidak perlu dibuktikan kepada pihak ketiga, rapat Direksi dipimpin oleh dan dari anggota Direksi yang hadir. Ketidakhadiran tersebut tidak perlu dibuktikan kepada pihak ketiga.",
        );
        // ✔️ PERBAIKAN 3: Memperbaiki typo kata "diwili" -> "diwakili"
        wA(
            "14.8",
            "Seorang anggota Direksi dapat diwakili dalam rapat Direksi hanya oleh anggota Direksi lainnya berdasarkan surat kuasa.",
        );
        wA(
            "14.9",
            "Rapat Direksi adalah sah dan berhak untuk mengambil keputusan yang mengikat jika mayoritas dari anggota Direksi hadir atau diwakili di dalam rapat.",
        );
        wA(
            "14.10",
            "Keputusan rapat Direksi diambil berdasarkan musyawarah untuk mufakat. Dalam hal keputusan berdasarkan musyawarah untuk mufakat tidak tercapai maka keputusan diambil dengan pemungutan suara berdasarkan suara setuju lebih dari 1/2 (satu perdua) bagian dari jumlah seluruh suara yang dikeluarkan dalam rapat.",
        );
        wA(
            "14.11",
            "Apabila suara yang setuju dan yang tidak setuju berimbang, maka ketua rapat Direksi memiliki suara yang akan menentukan.",
        );
        wA(
            "14.12",
            "(a) Setiap anggota Direksi yang hadir berhak mengeluarkan 1 (satu) suara dan tambahan 1 (satu) suara untuk setiap anggota Direksi lain yang diwakilinya.",
        );
        wA(
            "(b)",
            "Pemungutan suara mengenai diri orang dilakukan dengan surat suara tertutup yang tidak ditandatangani. Pemungutan suara mengenai hal-hal lain dilakukan secara lisan, kecuali ketua rapat menentukan lain dan tanpa ada keberatan dari yang hadir.",
            1,
        );
        wA(
            "(c)",
            "Suara blanko dan suara yang tidak sah dianggap tidak dikeluarkan secara sah dan dianggap tidak ada serta tidak dihitung dalam menentukan jumlah suara yang dikeluarkan.",
            1,
        );

        // ✔️ PERBAIKAN 4: Memecah Poin 14.13 menjadi dua paragraf
        wA(
            "14.13",
            "-Berita acara rapat Direksi dibuat oleh seorang yang hadir dalam rapat Direksi yang ditunjuk oleh ketua rapat dan ditandatangani oleh ketua rapat untuk memastikan kelengkapan dan kebenaran berita acara rapat tersebut. Apabila berita acara rapat dibuat oleh seorang notaris, tandatangan di atas tidak diperlukan.",
        );
        wP(
            "-Berita acara yang dibuat dan ditandatangani seperti tersebut di atas merupakan bukti yang sah bagi semua anggota Direksi dan pihak ketiga atas keputusan yang diambil dan kejadian yang terjadi dalam rapat tersebut.",
            INDENT_LANJUTAN,
        );

        // ✔️ PERBAIKAN 5: Memecah Poin 14.14 menjadi dua paragraf
        wA(
            "14.14",
            "-Direksi dapat juga mengambil keputusan yang sah tanpa mengadakan rapat Direksi, dengan ketentuan semua anggota Direksi telah diberitahu secara tertulis dan semua anggota Direksi memberikan persetujuan mengenai usul yang diajukan secara tertulis tersebut yang dibuktikan dengan tanda tangan persetujuan mereka.",
        );
        wP(
            "-Keputusan yang diambil dengan cara demikian mempunyai kekuatan yang sama dengan keputusan yang diambil dengan sah dalam rapat Direksi. Semua keputusan tersebut dapat memuat beberapa dokumen serupa, yang masing-masing ditandatangani oleh 1 (satu) atau lebih Direktur.",
            INDENT_LANJUTAN,
        );

        wA(
            "14.15",
            "Salinan, atau kutipan dari, berita acara rapat Direksi atau keputusan yang diambil sesuai dengan Pasal 14.14 dianggap sebagai salinan atau kutipan yang sah apabila dinyatakan sebagai salinan atau kutipan yang sesuai aslinya dan ditandatangani oleh Direktur Utama atau apabila dikeluarkan oleh notaris sipil yang membuat berita acara tersebut.",
        );

        // ── PASAL 15 ─────────────────
        pasal(15, "Dewan Komisaris");
        wA(
            "15.1",
            "Dewan Komisaris terdiri dari paling sedikit 1 (satu) Komisaris. Jika terdapat lebih dari 1 (satu) Komisaris yang diangkat, maka salah satu dari mereka akan menjabat sebagai Komisaris Utama.",
        );
        // ✔️ PERBAIKAN 1: Memperbaiki typo kata "perundang-undangan"
        wA(
            "15.2",
            "Para anggota Dewan Komisaris harus diangkat dari orang-orang yang memenuhi syarat menurut peraturan perundang-undangan yang berlaku.",
        );
        // ✔️ PERBAIKAN 2: Mengubah kata "pemberhentikan" menjadi "pemberhentian"
        wA(
            "15.3",
            "Para anggota Dewan Komisaris diangkat oleh rapat umum pemegang saham untuk jangka waktu 5 (lima) tahun sejak tanggal rapat umum pemegang saham dimana mereka diangkat, tanpa mengesampingkan hak dari rapat umum pemegang saham untuk memberhentikan setiap anggota Dewan Komisaris sewaktu-waktu dengan menyebutkan alasan pemberhentian.",
        );
        wA(
            "15.4",
            "Masa jabatan seseorang yang diangkat menjadi anggota Dewan Komisaris untuk mengisi jabatan yang lowong karena sebab apapun adalah sisa masa jabatan dari anggota Dewan Komisaris yang digantikannya, kecuali ditentukan lain oleh rapat umum pemegang saham.",
        );
        wA(
            "15.5",
            "Para anggota Dewan Komisaris dapat diangkat kembali setelah masa jabatannya berakhir.",
        );
        wA(
            "15.6",
            "Para anggota Dewan Komisaris dapat diberi gaji dan/atau tunjangan, yang jumlahnya ditentukan oleh rapat umum pemegang saham.",
        );
        wA(
            "15.7",
            "Apabila oleh sebab apapun, jabatan dalam Dewan Komisaris lowong, maka dalam jangka waktu 30 (tiga puluh) hari setelah terjadinya kekosongan jabatan itu, rapat umum pemegang saham harus diselenggarakan untuk mengangkat anggota Dewan Komisaris yang baru dengan memperhatikan ketentuan Pasal 15.2.",
        );
        wA(
            "15.8",
            "Apabila oleh suatu sebab apapun, seluruh jabatan anggota Dewan Komisaris lowong, maka dalam jangka waktu 30 (tiga puluh) hari setelah kekosongan jabatan itu, rapat umum pemegang saham harus dilakukan untuk mengangkat anggota Dewan Komisaris yang baru dengan memperhatikan ketentuan Pasal 15.2.",
        );
        wA(
            "15.9",
            "Seorang anggota Dewan Komisaris berhak mengundurkan diri dari jabatannya dengan memberitahukan secara tertulis 30 (tiga puluh) hari sebelum tanggal pengunduran dirinya mengenai maksud pengunduran diri tersebut kepada Perseroan.",
        );
        wA("15.10", "Masa jabatan anggota Dewan Komisaris berakhir apabila:");
        wA("(a)", "mengundurkan diri sesuai dengan ketentuan Pasal 15.9;", 1);
        // ✔️ PERBAIKAN 3: Menghilangkan tanda hubung pada "perundang undangan" sesuai dokumen
        wA(
            "(b)",
            "tidak lagi memenuhi persyaratan perundang undangan yang berlaku;",
            1,
        );
        wA("(c)", "meninggal dunia;", 1);
        wA(
            "(d)",
            "diberhentikan berdasarkan keputusan rapat umum pemegang saham; atau",
            1,
        );
        wA(
            "(e)",
            "dinyatakan pailit atau ditempatkan di bawah pengampuan berdasarkan keputusan pengadilan.",
            1,
        );

        // ── PASAL 16 ────────────────
        pasal(16, "Tugas dan Wewenang Dewan Komisaris");
        wA(
            "16.1",
            "Dewan Komisaris melakukan pengawasan atas kebijakan Direksi dalam menjalankan Perseroan serta memberikan nasihat kepada Direksi.",
        );
        wA(
            "16.2",
            "Dewan Komisaris, baik bersama-sama maupun sendiri-sendiri, setiap waktu dalam jam kerja kantor Perseroan berhak memasuki bangunan atau tempat lain yang dipergunakan atau yang dikuasai oleh Perseroan, memeriksa semua pembukuan, surat-surat dan alat bukti Perseroan lainnya, memeriksa dan mencocokkan keadaan keuangan Perseroan serta mengetahui segala tindakan yang telah dijalankan oleh Direksi.",
        );
        wA(
            "16.3",
            "Direksi dan setiap anggota Direksi wajib untuk memberikan penjelasan tentang segala hal yang ditanyakan oleh Dewan Komisaris.",
        );
        wA(
            "16.4",
            "Dewan Komisaris setiap waktu berhak untuk memberhentikan sementara anggota Direksi, apabila anggota Direksi tersebut bertindak bertentangan dengan anggaran dasar dan/atau peraturan perundang-undangan yang berlaku.",
        );
        // ✔️ PERBAIKAN 1: Mengubah "Pemberhentikan" menjadi "Pemberhentian"
        wA(
            "16.5",
            "Pemberhentian sementara itu harus diberitahukan kepada yang bersangkutan dengan disertai alasannya.",
        );
        // ✔️ PERBAIKAN 2: Mengubah "pemberhentikan" menjadi "pemberhentian"
        wA(
            "16.6",
            "Dalam jangka waktu 30 (tiga puluh) hari sesudah pemberhentian sementara itu, Dewan Komisaris diwajibkan untuk menyelenggarakan rapat umum pemegang saham yang akan memutuskan apakah anggota Direksi yang bersangkutan akan diberhentikan seterusnya atau dikembalikan kepada kedudukannya semula, sedangkan anggota Direksi yang diberhentikan sementara itu diberi kesempatan untuk hadir guna membela diri.",
        );
        wA(
            "16.7",
            "Rapat sebagaimana dimaksud dalam Pasal 16.6 dipimpin oleh Komisaris Utama atau, apabila ia tidak hadir, oleh 1 (satu) orang yang dipilih oleh dan dari antara mereka yang hadir. Ketidakhadiran tersebut tidak perlu dibuktikan kepada pihak ketiga.",
        );
        // ✔️ PERBAIKAN 3: Mengubah "pemberhentikan" menjadi "pemberhentian" (2 kali)
        wA(
            "16.8",
            "Apabila rapat umum pemegang saham tersebut tidak diadakan dalam jangka waktu 30 (tiga puluh) hari setelah pemberhentian sementara itu, maka pemberhentian sementara itu menjadi batal demi hukum dan yang bersangkutan berhak menjabat kembali jabatannya semula.",
        );
        // ✔️ PERBAIKAN 4: Memecah Poin 16.9 menjadi dua alinea terpisah menggunakan wP
        wA(
            "16.9",
            "-Apabila seluruh anggota Direksi diberhentikan sementara dan Perseroan tidak mempunyai seorangpun anggota Direksi maka untuk sementara Dewan Komisaris diwajibkan untuk mengurus Perseroan.",
        );
        wP(
            "-Dalam hal demikian, Dewan Komisaris berhak untuk memberikan kekuasaan sementara kepada 2 (dua) orang atau lebih anggota Direksi atas tanggungan mereka bersama.",
            INDENT_LANJUTAN,
        );
        wA(
            "16.10",
            "Dalam hal hanya ada 1 (satu) anggota Dewan Komisaris, maka segala tugas dan wewenang yang diberikan kepada Komisaris Utama atau anggota Dewan Komisaris dalam Anggaran Dasar ini berlaku pula baginya.",
        );

        // ── PASAL 17 ────────────────
        pasal(17, "Rapat Dewan Komisaris");
        wA(
            "17.1",
            "Rapat Dewan Komisaris dapat diselenggarakan di tempat kedudukan Perseroan atau tempat dimana Perseroan memiliki kegiatan usaha.",
        );
        wA(
            "17.2",
            "Rapat Dewan Komisaris diadakan setiap waktu apabila dipandang perlu oleh 1 (satu) atau lebih anggota Dewan Komisaris, atas permintaan tertulis dari 1 (satu) orang atau lebih anggota Direksi atau atas permintaan tertulis dari 1 (satu) atau lebih pemegang saham yang bersama-sama mewakili sekurang-kurangnya 1/10 (satu persepuluh) bagian dari jumlah seluruh saham dengan hak suara yang sah.",
        );
        wA(
            "17.3",
            "Panggilan rapat Dewan Komisaris hanya dapat dilakukan oleh Komisaris Utama.",
        );

        // ✔️ PERBAIKAN 1: Memecah Poin 17.4 menjadi tiga paragraf & perbaikan typo "diwaki"
        wA(
            "17.4",
            "-Panggilan mengenai rapat Dewan Komisaris harus dikirim melalui surat terdaftar, surat elektronik atau faksimili paling lambat 10 (sepuluh) hari sebelum rapat dilaksanakan, dengan tidak memperhitungkan tanggal pemanggilan dan tanggal dilaksanakannya rapat.",
        );
        wP(
            "-Setiap anggota Dewan Komisaris dapat menerima panggilan dengan jangka waktu yang lebih pendek dari yang ditentukan dalam Anggaran Dasar ini, termasuk tidak adanya panggilan, jika menurut pendapat Komisaris Utama terdapat perihal yang dirasa perlu untuk diputuskan secara mendesak.",
            INDENT_LANJUTAN,
        );
        wP(
            "-Apabila semua anggota Dewan Komisaris hadir atau diwakili dalam rapat, pemberitahuan sebelumnya yang dimaksud dalam pasal ini tidak akan diwajibkan dan rapat dapat diselenggarakan dimanapun dalam wilayah Republik Indonesia. Dalam rapat, keputusan yang sah dan mengikat dapat diambil berdasarkan suara setuju dari semua anggota Dewan Komisaris yang hadir atau diwakili dalam rapat.",
            INDENT_LANJUTAN,
        );

        wA(
            "17.5",
            "Panggilan harus mencantumkan agenda, tanggal, waktu dan tempat rapat.",
        );

        // ✔️ PERBAIKAN 2: Memecah Poin 17.6 menjadi dua paragraf
        wA(
            "17.6",
            "-Anggota Dewan Komisaris dapat berpartisipasi dalam rapat Dewan Komisaris melalui konferensi video, konferensi telepon atau sistem komunikasi sejenis jika sistem tersebut memungkinkan semua peserta rapat untuk saling mendengar dan melihat satu sama lain. Partisipasi tersebut dianggap sebagai kehadiran dalam rapat.",
        );
        wP(
            "-Berita acara rapat yang diselenggarakan melalui konferensi video, konferensi telepon atau sistem komunikasi sejenis harus dibuat secara tertulis dan diedarkan kepada seluruh anggota Dewan Komisaris yang berpartisipasi dalam rapat untuk diperiksa dan mendapatkan persetujuan.",
            INDENT_LANJUTAN,
        );

        wA(
            "17.7",
            "Rapat Dewan Komisaris dipimpin oleh Komisaris Utama, atau dalam hal Komisaris Utama tidak dapat hadir atau berhalangan, maka rapat tersebut akan dipimpin oleh salah seorang anggota Komisaris yang dipilih oleh dan dari antara anggota Dewan Komisaris yang hadir. Pembuktian terhadap pihak ketiga tidak diperlukan untuk ketidakhadirannya.",
        );
        wA(
            "17.8",
            "Seorang anggota Dewan Komisaris dapat diwakili dalam rapat Dewan Komisaris hanya oleh seorang anggota Komisaris lainnya berdasarkan surat kuasa.",
        );
        wA(
            "17.9",
            "Rapat Dewan Komisaris adalah sah and berhak mengambil keputusan yang mengikat apabila lebih dari 1/2 (satu perdua) anggota Dewan Komisaris hadir atau diwakili dalam rapat.",
        );
        wA(
            "17.10",
            "Keputusan rapat Dewan Komisaris diambil berdasarkan musyawarah untuk mufakat. Dalam hal keputusan berdasarkan musyawarah untuk mufakat tidak tercapai maka keputusan diambil dengan pemungutan suara berdasarkan suara setuju lebih dari 1/2 (satu perdua) bagian dari jumlah seluruh suara yang dikeluarkan secara sah dalam rapat.",
        );
        wA(
            "17.11",
            "Apabila suara yang setuju dan yang tidak setuju berimbang, maka ketua rapat Dewan Komisaris memiliki suara yang akan menentukan.",
        );
        wA(
            "17.12",
            "(a) Setiap anggota Dewan Komisaris yang hadir berhak mengeluarkan 1 (satu) suara dan tambahan 1 (satu) suara untuk setiap anggota Dewan Komisaris lain yang diwakilinya.",
        );
        wA(
            "(b)",
            "Pemungutan suara mengenai diri orang dilakukan dengan surat suara tertutup tanpa tanda tangan. Pemungutan suara mengenai hal-hal lain dilakukan secara lisan, kecuali ketua rapat menentukan lain dan tanpa ada keberatan dari yang hadir.",
            1,
        );
        wA(
            "(c)",
            "Suara blanko dan suara yang tidak sah dianggap tidak dikeluarkan secara sah dan dianggap tidak dihitung dalam menentukan jumlah suara yang dikeluarkan.",
            1,
        );

        // ✔️ PERBAIKAN 3: Memecah Poin 17.13 menjadi dua paragraf
        wA(
            "17.13",
            "-Berita acara rapat Dewan Komisaris harus dibuat oleh seorang yang hadir dalam rapat yang ditunjuk oleh ketua rapat dan harus ditandatangani oleh ketua rapat untuk memastikan kelengkapan dan kebenaran berita acara rapat tersebut. Jika berita acara dibuat di hadapan notaris, maka tanda tangan yang disebutkan di atas tidak diperlukan.",
        );
        wP(
            "-Berita acara yang dibuat dan ditandatangani seperti tersebut di atas merupakan bukti yang sah bagi semua anggota Dewan Komisaris dan pihak ketiga atas keputusan yang diambil dan kejadian yang terjadi dalam rapat tersebut.",
            INDENT_LANJUTAN,
        );

        // ✔️ PERBAIKAN 4: Memecah Poin 17.14 menjadi dua paragraf & penyesuaian redaksi "adalah mengikat seperti"
        wA(
            "17.14",
            "-Dewan Komisaris dapat juga mengambil keputusan yang sah tanpa mengadakan rapat Dewan Komisaris, dengan ketentuan semua anggota Dewan Komisaris telah diberitahu secara tertulis dan semua anggota Dewan Komisaris memberikan persetujuan mengenai usul yang diajukan secara tertulis tersebut yang dibuktikan dengan tanda tangan persetujuan mereka.",
        );
        wP(
            "-Keputusan yang diambil dengan cara demikian adalah mengikat seperti keputusan yang diambil secara sah dalam rapat Dewan Komisaris. Keputusan tersebut dapat terdiri dari beberapa dokumen serupa, masing-masing ditandatangani oleh 1 (satu) atau lebih Komisaris.",
            INDENT_LANJUTAN,
        );

        wA(
            "17.15",
            "Salinan, atau kutipan dari, berita acara rapat Dewan Komisaris atau keputusan yang diambil sesuai dengan Pasal 17.14 dianggap sebagai salinan atau kutipan yang sah apabila dinyatakan sebagai salinan atau kutipan yang sesuai aslinya dan ditandatangani oleh Komisaris Utama atau apabila dikeluarkan oleh notaris sipil yang membuat berita acara tersebut.",
        );

        // ── PASAL 18 ────────────────
        pasal(18, "Rencana Kerja, Tahun Buku dan Laporan Keuangan");
        wA(
            "18.1",
            "Direksi harus menyampaikan rencana kerja yang memuat juga anggaran tahunan Perseroan kepada Dewan Komisaris untuk mendapat persetujuan sebelum tahun buku dimulai.",
        );
        // ✔️ PERBAIKAN 1: Memperbaiki typo "dimulainnya" -> "dimulainya"
        wA(
            "18.2",
            "Rencana kerja sebagaimana dimaksud pada Pasal 18.1 harus disampaikan kepada Dewan Komisaris paling lambat 30 (tiga puluh) hari sebelum dimulainya tahun buku yang akan datang.",
        );

        // ✔️ PERBAIKAN 2: Memecah Poin 18.3 menjadi tiga paragraf sesuai tanda hubung dokumen
        wA(
            "18.3",
            "-Tahun buku Perseroan berjalan dari tanggal 1 (satu) Januari sampai dengan tanggal 31 (tigapuluh satu)Desember",
        );
        wP(
            "-Pada akhir bulan Desember setiap tahun, buku Perseroan harus ditutup.",
            INDENT_LANJUTAN,
        );
        wP(
            `-Tahun buku pertama Perseroan akan dimulai pada tanggal akta pendirian ini dan ditutup pada tanggal 31 (tigapuluh satu) ${thD} (${angkaTerbilang(thD)}).`,
            INDENT_LANJUTAN,
        );

        // ✔️ PERBAIKAN 3: Memecah Poin 18.4 menjadi dua paragraf & memperbaiki typo "perundang-undang-undangan"
        wA(
            "18.4",
            "-Dalam waktu 6 (enam) bulan setelah buku Perseroan ditutup, Direksi menyusun laporan tahunan, yang ditandatangani oleh semua anggota Direksi dan Dewan Komisaris, untuk diajukan dalam rapat umum pemegang saham tahunan sesuai dengan perundang-undangan yang berlaku.",
        );
        wP(
            "-Laporan tahunan tersebut harus sudah disediakan di kantor Perseroan selambatnya 14 (empat belas) hari sebelum tanggal rapat umum pemegang saham tahunan diselenggarakan, agar dapat diperiksa oleh para pemegang saham.",
            INDENT_LANJUTAN,
        );

        // ── PASAL 19 ────────────────
        pasal(19, "Penggunaan Laba");
        wA(
            "19.1",
            "Laba bersih Perseroan dalam suatu tahun buku seperti tercantum dalam neraca dan perhitungan laba rugi yang telah disetujui oleh rapat umum pemegang saham tahunan dan merupakan saldo laba positif harus dibagi menurut cara penggunaannya yang ditentukan oleh rapat tersebut.",
        );
        wA(
            "19.2",
            "Dalam hal rapat umum pemegang saham tahunan tidak menentukan penggunaannya, laba bersih, setelah dikurangi dana cadangan yang diwajibkan oleh Undang-Undang dan anggaran dasar Perseroan, dibagikan sebagai dividen.",
        );
        wA(
            "19.3",
            "Apabila perhitungan laba rugi pada suatu tahun buku menunjukkan kerugian yang tidak dapat ditutup dengan dana cadangan, maka kerugian itu akan tetap dicatat dan dimasukkan dalam perhitungan laba rugi, dan dalam tahun buku selanjutnya Perseroan dianggap tidak mendapat laba selama kerugian yang tercatat dan dimasukkan dalam perhitungan laba rugi itu belum tertutup seluruhnya.",
        );

        // ✔️ PERBAIKAN 1: Memecah Poin 19.4 menjadi tiga paragraf menggunakan wP
        wA(
            "19.4",
            "-Laba yang dibagikan sebagai dividen yang tidak diambil dalam waktu 5 (lima) tahun setelah disediakan untuk dibayarkan, dimasukkan ke dalam dana cadangan yang khusus diperuntukkan untuk itu.",
        );
        wP(
            "-Dividen dalam dana cadangan khusus tersebut dapat diambil oleh pemegang saham yang berhak sebelum lewatnya jangka waktu 10 (sepuluh) tahun, dengan setelahnya menyampaikan bukti haknya atas dividen tersebut yang dapat diterima oleh Direksi Perseroan.",
            INDENT_LANJUTAN,
        );
        wP(
            "-Dividen yang tidak diambil setelah lewat waktu tersebut menjadi milik Perseroan.",
            INDENT_LANJUTAN,
        );

        // ✔️ PERBAIKAN 2: Memperbaiki typo kata "perundang-undang-undangan" -> "perundang-undangan"
        wA(
            "19.5",
            "Perseroan dapat membagikan dividen interim sebelum berakhirnya suatu tahun buku berdasarkan keputusan Direksi setelah mendapat persetujuan dari Dewan Komisaris dan dengan memperhatikan ketentuan-ketentuan sebagaimana disyaratkan oleh peraturan perundang-undangan yang berlaku.",
        );

        // ── PASAL 20 ────────────
        pasal(20, "Penggunaan Dana Cadangan");
        wA(
            "20.1",
            "Penyisihan laba bersih untuk cadangan yang dilakukan sampai mencapai 20% (dua puluh persen) dari jumlah modal ditempatkan dan disetor hanya dapat dipergunakan untuk menutup kerugian yang tidak dipenuhi oleh cadangan lain.",
        );
        wA(
            "20.2",
            "Apabila jumlah cadangan telah melebihi jumlah sekurang-kurangnya 20% (dua puluh persen) dari modal yang ditempatkan dan disetor, rapat umum pemegang saham dapat memutuskan agar jumlah kelebihannya digunakan untuk keperluan Perseroan.",
        );
        // ✔️ PERBAIKAN: Memperbaiki typo kata "perundang-undang-undangan" -> "perundang-undangan"
        wA(
            "20.3",
            "Cadangan sebagaimana disebutkan dalam Pasal 20.1 yang belum dipergunakan untuk menutup kerugian dan kelebihan cadangan, yang penggunaannya sebagaimana disebutkan dalam Pasal 20.2 belum disetujui oleh rapat umum pemegang saham, dikelola oleh Direksi dengan cara yang dianggapnya tepat serta memperhatikan peraturan perundang-undangan yang berlaku.",
        );

        // ── PASAL 21 ──────────
        pasal(21, "Perubahan Anggaran Dasar");
        wA(
            "21.1",
            "Perubahan anggaran dasar ditetapkan oleh rapat umum pemegang saham yang dihadiri oleh pemegang saham yang mewakili paling sedikit 2/3 (dua pertiga) bagian dari seluruh saham yang dikeluarkan dengan hak suara yang sah dan keputusan disetujui oleh paling sedikit 2/3 (dua pertiga) bagian dari jumlah suara yang dikeluarkan dengan sah dalam rapat.",
        );
        wA(
            "21.2",
            "Perubahan ketentuan anggaran dasar yang menyangkut perubahan nama, tempat kedudukan, maksud dan tujuan, kegiatan usaha, jangka waktu berdirinya Perseroan, atau jumlah modal dasar, atau pengurangan modal ditempatkan dan disetor atau perubahan status Perseroan dari perusahaan tertutup menjadi perusahaan terbuka dan atau sebaliknya, wajib dimohonkan untuk mendapat persetujuan dari Menteri Hukum dan Hak Asasi Manusia Republik Indonesia sesuai dengan peraturan perundang-undangan yang berlaku.",
        );
        // ✔️ PERBAIKAN 1: Memperbaiki typo kata "perundang-undang-undangan" -> "perundang-undangan"
        wA(
            "21.3",
            "Perubahan anggaran dasar selain yang menyangkut hal-hal yang disebutkan dalam Pasal 21.2 cukup diberitahukan kepada Menteri Hukum dan Hak Asasi Manusia Republik Indonesia sesuai dengan ketentuan peraturan perundang-undangan yang berlaku.",
        );

        // ✔️ PERBAIKAN 2: Memecah Poin 21.4 menjadi dua paragraf & perbaiki kata "memperhitung" -> "memperhitungkan"
        wA(
            "21.4",
            "-Apabila dalam rapat sebagaimana dimaksud dalam Pasal 21.1, kuorum yang disyaratkan tidak terpenuhi, paling cepat 10 (sepuluh) hari dan paling lambat 21 (dua puluh satu) hari setelah rapat pertama, rapat kedua dapat diselenggarakan dengan syarat-syarat dan agenda yang sama sebagaimana disyaratkan untuk rapat pertama, namun panggilan rapat harus disampaikan paling lambat 7 (tujuh) hari sebelum rapat kedua, dengan tidak memperhitungkan tanggal panggilan dan tanggal rapat.",
        );
        wP(
            "-Rapat kedua adalah sah dan berhak mengambil keputusan yang mengikat apabila dihadiri oleh pemegang saham yang mewakili sedikitnya 3/5 (tiga perlima) bagian dari seluruh saham yang dikeluarkan dengan hak suara yang sah dan keputusan disetujui oleh sedikitnya 2/3 (dua pertiga) bagian dari jumlah suara yang dikeluarkan secara sah dalam rapat.",
            INDENT_LANJUTAN,
        );

        // ✔️ PERBAIKAN 3: Penyesuaian total redaksi media pengumuman & tenggat waktu hukum pada Poin 21.5
        wA(
            "21.5",
            "Keputusan mengenai pengurangan modal harus diberitahukan terlebih dahulu kepada kreditur dari Perseroan dan diumumkan melalui 1 (satu) surat kabar harian berbahasa Indonesia yang beredar secara nasional oleh Direksi paling lambat 7 (tujuh) hari sejak dibuatnya keputusan pengurangan modal.",
        );

        // ── PASAL 22 ──────────
        // ✔️ PERBAIKAN 1: Mengubah total judul pasal sesuai dokumen
        pasal(22, "Penggabungan, Peleburan, Pengambilalihan dan Pemisahan");

        // ✔️ PERBAIKAN 2: Mengubah total isi poin 22.1 sesuai dokumen
        wA(
            "22.1",
            "Dengan mengindahkan ketentuan peraturan perundang-undangan yang berlaku maka penggabungan, peleburan, pengambilalihan, atau pemisahan hanya dapat dilakukan berdasarkan keputusan rapat umum pemegang saham yang dihadiri oleh pemegang saham yang mewakili sekurangnya 3/4 (tiga perempat) bagian dari jumlah seluruh saham dengan hak suara yang sah dan keputusan disetujui sekurangnya oleh 3/4 (tiga perempat) bagian dari jumlah suara yang dikeluarkan secara sah dalam rapat.",
        );

        // ✔️ PERBAIKAN 3: Mengubah total isi poin 22.2 sesuai dokumen
        wA(
            "22.2",
            "Direksi wajib mengumumkan secara tertulis kepada para karyawan dan juga dalam 1 (satu) surat kabar berbahasa Indonesia yang beredar secara nasional rencana penggabungan, peleburan, pengambilalihan atau pemisahan Perseroan dalam jangka waktu paling lambat 30 (tiga puluh hari) sebelum pemanggilan rapat umum pemegang saham.",
        );

        // ── PASAL 23 ──────────
        pasal(23, "Pembubaran dan Likuidasi");

        wA(
            "23.1",
            "Dengan mengindahkan ketentuan peraturan perundang-undangan yang berlaku, pembubaran Perseroan hanya dapat dilakukan berdasarkan keputusan rapat umum pemegang saham yang dihadiri oleh pemegang saham yang mewakili sekurangnya 3/4 (tiga perempat) bagian dari jumlah seluruh saham dengan hak suara yang sah dan keputusan disetujui oleh sekurangnya 3/4 (tiga perempat) bagian dari jumlah suara yang dikeluarkan secara sah dalam rapat.",
        );
        wA(
            "23.2",
            "Apabila Perseroan dibubarkan, baik karena dibubarkan berdasarkan keputusan rapat umum pemegang saham atau karena dinyatakan bubar berdasarkan penetapan pengadilan, maka likuidasi harus dilakukan oleh likuidator.",
        );
        wA(
            "23.3",
            "Direksi harus bertindak sebagai likuidator apabila dalam keputusan rapat umum pemegang saham atau penetapan sebagaimana dimaksud dalam Pasal 23.2 tidak menunjuk likuidator.",
        );
        wA(
            "23.4",
            "Upah bagi para likuidator, jika ada, ditentukan oleh rapat umum pemegang saham atau penetapan pengadilan.",
        );
        wA(
            "23.5",
            "Likuidator wajib mematuhi ketentuan hukum dan peraturan perundang-undangan yang berlaku sehubungan dengan proses likuidasi Perseroan.",
        );
        wA(
            "23.6",
            "Sisa perhitungan likuidasi akan dibagikan di antara para pemegang saham, masing-masing untuk bagian proporsional dengan nilai saham yang dimilikinya.",
        );
        wA(
            "23.7",
            "Anggaran dasar seperti yang termaktub dalam akta pendirian ini beserta perubahannya tetap berlaku sampai dengan tanggal disahkannya perhitungan likuidasi oleh rapat umum pemegang saham dan diberikannya pelunasan dan pembebasan sepenuhnya kepada para likuidator.",
        );

        // [Tabel Susunan Pemegang Saham Telah Dihapus karena tidak ada di dokumen]
        // Setelah baris ini, script Anda bisa langsung menyambung ke baris Pasal 24 yang kemarin kita susun.

        // ── PASAL 24 ────────────────
        pasal(24, "Ketentuan Penutup");
        wA(
            "-",
            "Segala sesuatu yang tidak atau belum cukup diatur dalam Anggaran Dasar ini akan diputuskan dalam rapat umum pemegang saham sesuai dengan anggaran dasar.",
        );
        wA(
            "-",
            "Selanjutnya, penghadap yang bertindak dalam kedudukannya sebagaimana tersebut di atas menerangkan bahwa:",
        );

        // --- POIN I: Rincian Modal & Pemegang Saham ---
        const totalSaham = nS > 0 ? Math.round(mDt / nS) : 0;

        wP(
            `I.  Untuk pertama kalinya 100% (seratus persen) dari saham, atau sejumlah ${totalSaham.toLocaleString("id-ID")} saham dengan nilai nominal seluruhnya sebesar Rp ${mDt.toLocaleString("id-ID")},- telah diambil bagian oleh para pemegang saham dengan rincian sebagai berikut:`,
            5,
        );

        // Looping data pemegang saham (a, b, dst.) secara breakdown berundak
        pemegangSaham.forEach((ps, i) => {
            const abjad = String.fromCharCode(97 + i); // a, b, c, dst.
            const pct = parseFloat(ps.kepemilikan) || 0;
            const nominal = Math.round((mDt * pct) / 100);
            const jumlahSaham = nS > 0 ? Math.round(nominal / nS) : 0;
            const tandaBaca = i === pemegangSaham.length - 1 ? "," : ",-";

            wP(`${abjad}.  ${ps.nama || "_______________"},`, 10);
            wP(`    sebanyak ${pct}% atau`, 10);
            wP(`    sebesar ${jumlahSaham.toLocaleString("id-ID")} saham`, 10);
            wP(`    dengan nilai`, 10);
            wP(`    nominal seluruhnya-`, 10);
            wP(
                `    sejumlah . . . . . . . .         Rp. ${nominal.toLocaleString("id-ID")}${tandaBaca}`,
                10,
            );
        });

        // Penutup breakdown Poin I
        wP("Sehingga seluruhnya berjumlah", 5);
        wP(`${totalSaham.toLocaleString("id-ID")} saham atau`, 5);
        wP("dengan nilai nominal", 5);
        wP("seluruhnya sejumlah", 5);
        wP(`        Rp. ${mDt.toLocaleString("id-ID")},-`, 5);

        // --- POIN II: Susunan Pengurus Pertama Kali ---
        wP(
            "II. Menyimpang dari ketentuan-ketentuan dalam Pasal 12 dan Pasal 15 Anggaran Dasar ini mengenai tata cara pengangkatan anggota Direksi dan Dewan Komisaris, maka untuk pertama kalinya diangkat sebagai:",
            5,
        );
        wP("Direksi", 10);
        wP("-Direktur    : _________________________.", 10);
        wP("Dewan Komisaris", 10);
        wP("-Komisaris   : _________________________.", 10);
        wP(
            "-Pengangkatan anggota Direksi dan Dewan Komisaris- tersebut telah diterima oleh masing-masing yang bersangkutan.",
            10,
        );

        // --- POIN III: Kuasa & Jaminan Hukum Penghadap ---
        wP(
            "III. Selanjutnya, penghadap dengan ini memberi kuasa kepada saya, Notaris, dengan hak substitusi, untuk mengajukan permohonan persetujuan dan pengesahan akta pendirian ini dari instansi yang berwenang, termasuk tidak terbatas pada Kementerian Hukum dan Hak Asasi Manusia, sesuai dengan hukum dan peraturan yang berlaku, untuk melaksanakan segala tindakan dan menandatangani segala permohonan sebagaimana dianggap perlu dan untuk membuat perubahan dan/atau tambahan dalam bentuk yang bagaimanapun juga yang diperlukan untuk memperoleh pengesahan tersebut, tanpa kecuali.",
            5,
        );
        wP(
            "-Penghadap menyatakan dengan ini menjamin akan kebenaran, keaslian dan kelengkapan identitas pihak-pihak yang namanya tersebut dalam akta ini dan seluruh dokumen yang menjadi dasar dibuatnya akta ini tanpa ada yang dikecualikan, yang disampaikan kepada saya, Notaris, sehingga apabila dikemudian hari sejak ditandatangani akta ini timbul sengketa dengan nama dan dalam bentuk apapun yang disebabkan karena akta ini, maka penghadap yang membuat keterangan dengan ini berjanji mengikatkan dirinya untuk bertanggung jawab dan bersedia menanggung resiko yang timbul dan dengan ini penghadap menyatakan dengan tegas membebaskan saya, Notaris, dan para saksi dari turut bertanggung jawab dan memikul baik sebagian maupun seluruhnya akibat hukum yang timbul karena sengketa tersebut.",
        );
        wP("-Penghadap telah dikenal oleh saya, Notaris.");
        wP("-Maka dari hal-hal yang tersebut di atas, dibuatlah:");

        // ── PENUTUP STRUKTUR AKTA ────────────────
        sp(6);
        sf(12, "bold");
        doc.text(
            "------------------ A K T A  -  I N I ------------------",
            pW / 2,
            y,
            {
                align: "center",
            },
        );
        y += LH + 2;

        sp(15); // Ruang vertikal kosong sebelum tanda tangan / penanda halaman baru

        // ══════════════════════════════════
        //  FOOTER SETIAP HALAMAN
        // ══════════════════════════════
        const totH = doc.internal.getNumberOfPages();
        for (let i = 1; i <= totH; i++) {
            doc.setPage(i);
            sf(8, "normal");
            doc.setTextColor(140);
            doc.setLineWidth(0.2);
            doc.setDrawColor(200);
            doc.line(mL, pH - 14, pW - mR, pH - 14);
            doc.text(
                `PT ${namaPerseroan || "Perseroan"} \u2014 Simulasi Akta Pendirian`,
                mL,
                pH - 10,
            );
            doc.text(`Hal. ${i} / ${totH}`, pW - mR, pH - 10, {
                align: "right",
            });
            doc.setTextColor(0);
            doc.setDrawColor(0);
        }

        const pdfBlob = doc.output("blob");
        const blobUrl = URL.createObjectURL(pdfBlob);
        const filename = `Simulasi_Akta_PT_${(namaPerseroan || "Perseroan")
            .replace(/[^a-zA-Z0-9\s]/g, "")
            .replace(/\s+/g, "_")
            .substring(0, 40)}.pdf`;
        return { blobUrl, filename };
    };
    return { generateAktaPDF };
};
