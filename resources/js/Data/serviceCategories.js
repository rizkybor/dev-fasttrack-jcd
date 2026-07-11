import { computed } from "vue";
import { useI18n } from "vue-i18n";

export function useServiceCategories() {
    const { locale } = useI18n();

    const data = {
        id: [
            {
                title: "PENDIRIAN BADAN USAHA INDONESIA",
                path: "/badan-usaha",
                items: [
                    {
                        title: "PT Perorangan",
                        description:
                            "Perseroan Terbatas (PT) Perorangan adalah Badan Hukum yang didirikan oleh 1 (satu) seorang",
                        price: "Rp 750.000",
                        packages: "3 Paket",
                        path: "/badan-usaha/1",
                        icon: "/icons/ic-card-1.svg",
                    },
                    {
                        title: "PT. PMDN",
                        description:
                            "Penanaman Modal Dalam Negeri (PMDN) adalah kegiatan menanam modal menggunakan Modal Dalam Negeri.",
                        price: "Rp 3.250.000",
                        packages: "5 Paket",
                        path: "/badan-usaha/2",
                        icon: "/icons/ic-card-2.svg",
                    },
                    {
                        title: "PT. PMA",
                        description:
                            "Penanaman Modal Asing (PMA) adalah kegiatan investasi atau menanam modal oleh Penanam Modal Asing",
                        price: "Rp 17.250.000",
                        packages: "3 Paket",
                        path: "/badan-usaha/3",
                        icon: "/icons/ic-card-3.svg",
                    },
                    {
                        title: "Pendirian CV",
                        description:
                            "CV merupakan bentuk persekutuan yang didirikan oleh dua orang atau lebih",
                        price: "Rp 2.750.000",
                        packages: "4 Paket",
                        path: "/badan-usaha/4",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "OSS & NOMOR INDUK BERUSAHA (NIB)",
                path: "/one-single-submission",
                items: [
                    {
                        title: "NIB - PERORANGAN",
                        description:
                            "Pengurusan NIB resmi untuk pelaku usaha perseorangan melalui sistem OSS.",
                        price: "Rp 750.000",
                        packages: "3 Paket",
                        path: "/one-single-submission/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "NIB - PT - UMK",
                        description:
                            "Pengurusan NIB untuk Perseroan Terbatas berkategori Usaha Mikro dan Kecil.",
                        price: "Rp 750.000",
                        packages: "3 Paket",
                        path: "/one-single-submission/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "NIB - PT - NON UMK",
                        description:
                            "Pengurusan NIB untuk PT skala menengah, besar, PMDN, maupun PMA.",
                        price: "Rp 750.000",
                        packages: "3 Paket",
                        path: "/one-single-submission/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "NIB - CV",
                        description:
                            "Pengurusan NIB resmi untuk badan usaha berbentuk Commanditaire Vennootschap (CV).",
                        price: "Rp 750.000",
                        packages: "3 Paket",
                        path: "/one-single-submission/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "PERIZINAN DASAR & PERIZINAN LAINNYA",
                path: "/perizinan-berusaha",
                items: [
                    {
                        title: "Kesesuaian Kegiatan Pemanfaatan Ruang",
                        description:
                            "Perizinan dasar sebagai syarat awal operasional usaha, mencakup kesesuaian tata ruang, lingkungan, dan bangunan.",
                        price: "Hubungi Kami",
                        packages: "3 Paket",
                        path: "/perizinan-berusaha/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Perizinan Berusaha (Sertifikat Standar/Izin)",
                        description:
                            "Pengurusan sertifikat standar atau izin berusaha sesuai tingkat risiko kegiatan usaha melalui sistem OSS.",
                        price: "Hubungi Kami",
                        packages: "11 Paket",
                        path: "/perizinan-berusaha/2",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Perizinan Berusaha Untuk Menunjang Kegiatan Usaha (PB UMKU)",
                        description:
                            "Pengurusan izin tambahan yang dibutuhkan untuk menunjang kegiatan usaha utama sesuai regulasi yang berlaku.",
                        price: "Rp. 2.000.000",
                        packages: "3 Paket",
                        path: "/perizinan-berusaha/3",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Nomor Pokok Wajib Pajak (NPWP)",
                        description:
                            "Pengurusan pendaftaran NPWP badan usaha sebagai identitas wajib pajak secara resmi.",
                        price: "Rp. 1.250.000",
                        packages: "1 Paket",
                        path: "/perizinan-lainnya/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "NOTARIS VIRTUAL – AKTA PERUSAHAAN DAN PERORANGAN",
                path: "/",
                items: [
                    {
                        title: "Perubahan Anggaran Dasar Perseroan Terbatas (PT)",
                        description:
                            "Perubahan nama, tempat kedudukan, jangka waktu, maksud dan tujuan usaha, serta modal dasar dan modal disetor PT.",
                        price: "Rp 3.500.000",
                        packages: "3 Paket",
                        path: "/notaris-virtual-dan-akta/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Perubahan Data Perseroan",
                        description:
                            "Pergantian atau pengangkatan kembali Direksi dan Dewan Komisaris melalui RUPS yang dituangkan dalam akta notaris.",
                        price: "Rp 3.000.000",
                        packages: "3 Paket",
                        path: "/notaris-virtual-dan-akta/2",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Rapat Umum Pemegang Saham (RUPS) Tahunan",
                        description:
                            "Pembuatan akta RUPS Tahunan untuk pengesahan laporan keuangan dan pelaporan ke Kementerian Hukum RI.",
                        price: "Rp 750.000",
                        packages: "3 Paket",
                        path: "/notaris-virtual-dan-akta/3",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Akta Notaris Lainnya",
                        description:
                            "Penerbitan akta cabang, akuisisi, kuasa, jual beli saham, hingga perjanjian pranikah dan pisah harta.",
                        price: "Rp 750.000",
                        packages: "3 Paket",
                        path: "/notaris-virtual-dan-akta/4",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "IZIN TINGGAL ATAU KERJA WARGA NEGARA ASING",
                path: "/izin-tinggal-terbatas",
                items: [
                    {
                        title: "IZIN TINGGAL TERBATAS DAN KERJA TENAGA KERJA ASING",
                        description:
                            "Pengurusan ITAS dan izin kerja resmi untuk tenaga kerja asing di Indonesia.",
                        price: "Rp 9.050.000",
                        packages: "3 Paket",
                        path: "/izin-tinggal-terbatas/1",
                        icon: "/icons/ic-card-1.svg",
                    },
                    {
                        title: "IZIN TINGGAL TERBATAS KELUARGA TENAGA KERJA ASING",
                        description:
                            "Pengurusan ITAS untuk anggota keluarga yang mengikuti tenaga kerja asing.",
                        price: "Rp 9.050.000",
                        packages: "3 Paket",
                        path: "/izin-tinggal-terbatas/2",
                        icon: "/icons/ic-card-1.svg",
                    },
                    {
                        title: "IZIN TINGGAL TERBATAS INVESTOR",
                        description:
                            "Pengurusan ITAS untuk investor asing yang menanamkan modal di Indonesia.",
                        price: "Rp 12.750.000",
                        packages: "3 Paket",
                        path: "/izin-tinggal-terbatas/3",
                        icon: "/icons/ic-card-1.svg",
                    },
                    {
                        title: "IZIN TINGGAL TERBATAS PASANGAN (SPOUSE)",
                        description:
                            "Pengurusan ITAS untuk pasangan sah dari pemegang izin tinggal terbatas.",
                        price: "Rp 7.000.000",
                        packages: "3 Paket",
                        path: "/izin-tinggal-terbatas/4",
                        icon: "/icons/ic-card-1.svg",
                    },
                ],
            },
            {
                title: "VISA KE INDONESIA",
                path: "/visa-indonesia",
                items: [
                    {
                        title: "Visa Kunjungan Satu Kali Perjalanan",
                        description:
                            "Visa untuk kunjungan wisata, bisnis, atau keperluan lain dengan satu kali masuk ke Indonesia.",
                        price: "Rp 3.000.000",
                        packages: "11 Paket",
                        path: "/visa-indonesia/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Visa Kunjungan Beberapa Kali Perjalanan",
                        description:
                            "Visa untuk kunjungan berulang ke Indonesia dalam periode tertentu tanpa pengajuan ulang setiap kedatangan.",
                        price: "Rp 3.500.000",
                        packages: "4 Paket",
                        path: "/visa-indonesia/2",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Visa Investor",
                        description:
                            "Visa bagi investor asing yang menanamkan modal atau mendirikan usaha di Indonesia.",
                        price: "Rp 3.000.000",
                        packages: "8 Paket",
                        path: "/visa-indonesia/3",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Visa Keluarga",
                        description:
                            "Visa bagi anggota keluarga yang mengikuti suami, istri, atau orang tua pemegang izin tinggal di Indonesia.",
                        price: "Rp 750.000",
                        packages: "10 Paket",
                        path: "/visa-indonesia/4",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "VISA MANCANEGARA",
                path: "/visa-mancanegara",
                items: [
                    {
                        title: "China",
                        description:
                            "Layanan pengurusan Visa China untuk keperluan wisata maupun bisnis dengan proses yang cepat, aman, dan didampingi secara profesional sesuai persyaratan kedutaan.",
                        price: "Rp 1.000.000",
                        packages: "2 Paket",
                        path: "/visa-mancanegara/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "United Stated of America",
                        description:
                            "Layanan pengurusan Visa Amerika Serikat (B1/B2) untuk kebutuhan wisata, bisnis, maupun kunjungan, dengan pendampingan lengkap hingga proses pengajuan selesai.",
                        price: "Rp 4.200.000",
                        packages: "1 Paket",
                        path: "/visa-mancanegara/2",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Uni Emirate Arab",
                        description:
                            "Layanan pengurusan Visa Uni Emirat Arab untuk perjalanan wisata atau kunjungan singkat dengan proses mudah, cepat, dan sesuai ketentuan imigrasi UEA.",
                        price: "Rp 3.000.000",
                        packages: "1 Paket",
                        path: "/visa-mancanegara/3",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Australia",
                        description:
                            "Layanan pengurusan Visa Australia untuk wisata, bisnis, maupun kunjungan keluarga dengan bantuan persiapan dokumen dan pendampingan selama proses pengajuan.",
                        price: "Rp 2.800.000",
                        packages: "1 Paket",
                        path: "/visa-mancanegara/4",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "KEIMIGRASIAN & NATURALISASI",
                path: "/",
                items: [
                    {
                        title: "E-Paspor Republik Indonesia",
                        description:
                            "Pengurusan penerbitan e-paspor bagi Warga Negara Indonesia untuk keperluan perjalanan internasional secara resmi.",
                        price: "Rp 3.150.000",
                        packages: "2 Paket",
                        path: "/keimigrasian-wni-wna/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Mutasi Alamat",
                        description:
                            "Pengurusan pengukuhan PKP bagi perusahaan yang wajib memungut dan melaporkan PPN.",
                        price: "Rp 1.750.000",
                        packages: "2 Paket",
                        path: "/keimigrasian-wni-wna/2",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Mutasi Paspor Pemegang ITAS",
                        description:
                            "Pengurusan pemindahan data paspor baru pemegang ITAS sesuai ketentuan keimigrasian yang berlaku.",
                        price: "Rp 1.750.000",
                        packages: "1 Paket",
                        path: "/naturalisasi/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Exit Permit Only (EPO)",
                        description:
                            "Pengurusan izin keluar permanen bagi tenaga kerja asing maupun keluarga yang akan meninggalkan Indonesia dan tidak kembali.",
                        price: "Rp 3.000.000",
                        packages: "2 Paket",
                        path: "/naturalisasi/2",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
        ],
        en: [
            {
                title: "ESTABLISHMENT OF INDONESIAN BUSINESS ENTITIES",
                path: "/badan-usaha",
                items: [
                    {
                        title: "Sole Proprietorship PT (PT Perorangan)",
                        description:
                            "A Sole Proprietorship PT (PT Perorangan) is a Legal Entity established by 1 (one) person",
                        price: "Rp 750.000",
                        packages: "3 Packages",
                        path: "/badan-usaha/1",
                        icon: "/icons/ic-card-1.svg",
                    },
                    {
                        title: "PT. PMDN",
                        description:
                            "Domestic Capital Investment (PMDN) is an investment activity carried out using Domestic Capital.",
                        price: "Rp 3.250.000",
                        packages: "5 Packages",
                        path: "/badan-usaha/2",
                        icon: "/icons/ic-card-2.svg",
                    },
                    {
                        title: "PT. PMA",
                        description:
                            "Foreign Capital Investment (PMA) is an investment activity carried out by Foreign Investors",
                        price: "Rp 17.250.000",
                        packages: "3 Packages",
                        path: "/badan-usaha/3",
                        icon: "/icons/ic-card-3.svg",
                    },
                    {
                        title: "CV Establishment",
                        description:
                            "A CV is a form of partnership established by two or more persons",
                        price: "Rp 2.750.000",
                        packages: "4 Packages",
                        path: "/badan-usaha/4",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "OSS & BUSINESS IDENTIFICATION NUMBER (NIB)",
                path: "/one-single-submission",
                items: [
                    {
                        title: "NIB - INDIVIDUAL",
                        description:
                            "Official NIB processing for individual business operators through the OSS system.",
                        price: "Rp 750.000",
                        packages: "3 Packages",
                        path: "/one-single-submission/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "NIB - PT - MICRO & SMALL BUSINESS",
                        description:
                            "NIB processing for Limited Liability Companies (PT) classified as Micro and Small Enterprises.",
                        price: "Rp 750.000",
                        packages: "3 Packages",
                        path: "/one-single-submission/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "NIB - PT - NON MICRO & SMALL BUSINESS",
                        description:
                            "NIB processing for medium/large-scale PT, PMDN, and PMA companies.",
                        price: "Rp 750.000",
                        packages: "3 Packages",
                        path: "/one-single-submission/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "NIB - CV",
                        description:
                            "Official NIB processing for business entities in the form of a Commanditaire Vennootschap (CV).",
                        price: "Rp 750.000",
                        packages: "3 Packages",
                        path: "/one-single-submission/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "BASIC LICENSING & OTHER LICENSES",
                path: "/perizinan-berusaha",
                items: [
                    {
                        title: "Conformity of Spatial Utilization Activities (KKPR)",
                        description:
                            "Basic licensing as an initial requirement for business operations, covering spatial planning, environmental, and building conformity.",
                        price: "Contact Us",
                        packages: "3 Packages",
                        path: "/perizinan-berusaha/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Business License (Standard Certificate/Permit)",
                        description:
                            "Processing of standard certificates or business licenses according to business risk level through the OSS system.",
                        price: "Contact Us",
                        packages: "11 Packages",
                        path: "/perizinan-berusaha/2",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Business License to Support Business Activities (PB UMKU)",
                        description:
                            "Processing of additional permits required to support core business activities in accordance with applicable regulations.",
                        price: "Rp. 2.000.000",
                        packages: "3 Packages",
                        path: "/perizinan-berusaha/3",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Tax Identification Number (NPWP)",
                        description:
                            "Processing of business entity NPWP registration as an official taxpayer identity.",
                        price: "Rp. 1.250.000",
                        packages: "1 Package",
                        path: "/perizinan-lainnya/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "VIRTUAL NOTARY – CORPORATE AND PERSONAL DEEDS",
                path: "/",
                items: [
                    {
                        title: "Amendment of Limited Liability Company (PT) Articles of Association",
                        description:
                            "Changes to the company name, domicile, term of establishment, business purpose and objectives, as well as authorized and paid-up capital of the PT.",
                        price: "Rp 3.500.000",
                        packages: "3 Packages",
                        path: "/notaris-virtual-dan-akta/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Amendment of Company Data",
                        description:
                            "Replacement or reappointment of the Board of Directors and Board of Commissioners through a General Meeting of Shareholders (GMS), set forth in a notarial deed.",
                        price: "Rp 3.000.000",
                        packages: "3 Packages",
                        path: "/notaris-virtual-dan-akta/2",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Annual General Meeting of Shareholders (GMS)",
                        description:
                            "Preparation of the Annual GMS deed for the ratification of financial statements and reporting to the Ministry of Law of the Republic of Indonesia.",
                        price: "Rp 750.000",
                        packages: "3 Packages",
                        path: "/notaris-virtual-dan-akta/3",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Other Notarial Deeds",
                        description:
                            "Issuance of branch deeds, acquisition deeds, powers of attorney, share sale and purchase deeds, as well as prenuptial and separate property agreements.",
                        price: "Rp 750.000",
                        packages: "3 Packages",
                        path: "/notaris-virtual-dan-akta/4",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "STAY OR WORK PERMIT FOR FOREIGN NATIONALS",
                path: "/izin-tinggal-terbatas",
                items: [
                    {
                        title: "LIMITED STAY PERMIT AND WORK PERMIT FOR FOREIGN WORKERS",
                        description:
                            "Official processing of ITAS and work permits for foreign workers in Indonesia.",
                        price: "Rp 9.050.000",
                        packages: "3 Packages",
                        path: "/izin-tinggal-terbatas/1",
                        icon: "/icons/ic-card-1.svg",
                    },
                    {
                        title: "LIMITED STAY PERMIT FOR FOREIGN WORKERS' FAMILY MEMBERS",
                        description:
                            "ITAS processing for family members accompanying a foreign worker.",
                        price: "Rp 9.050.000",
                        packages: "3 Packages",
                        path: "/izin-tinggal-terbatas/2",
                        icon: "/icons/ic-card-1.svg",
                    },
                    {
                        title: "LIMITED STAY PERMIT FOR INVESTORS",
                        description:
                            "ITAS processing for foreign investors investing capital in Indonesia.",
                        price: "Rp 12.750.000",
                        packages: "3 Packages",
                        path: "/izin-tinggal-terbatas/3",
                        icon: "/icons/ic-card-1.svg",
                    },
                    {
                        title: "LIMITED STAY PERMIT FOR SPOUSE",
                        description:
                            "ITAS processing for the legal spouse of a limited stay permit holder.",
                        price: "Rp 7.000.000",
                        packages: "3 Packages",
                        path: "/izin-tinggal-terbatas/4",
                        icon: "/icons/ic-card-1.svg",
                    },
                ],
            },
            {
                title: "VISA TO INDONESIA",
                path: "/visa-indonesia",
                items: [
                    {
                        title: "Single-Entry Visit Visa",
                        description:
                            "Visa for tourism, business, or other purposes with a single entry into Indonesia.",
                        price: "Rp 3.000.000",
                        packages: "11 Packages",
                        path: "/visa-indonesia/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Multiple-Entry Visit Visa",
                        description:
                            "Visa for repeated visits to Indonesia within a certain period without needing to reapply for each arrival.",
                        price: "Rp 3.500.000",
                        packages: "4 Packages",
                        path: "/visa-indonesia/2",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Investor Visa",
                        description:
                            "Visa for foreign investors investing capital or establishing a business in Indonesia.",
                        price: "Rp 3.000.000",
                        packages: "8 Packages",
                        path: "/visa-indonesia/3",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Family Visa",
                        description:
                            "VA visa for family members accompanying a spouse or parent who holds a residence permit in Indonesia.",
                        price: "Rp 750.000",
                        packages: "10 Packages",
                        path: "/visa-indonesia/4",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "OVERSEAS VISA",
                path: "/visa-mancanegara",
                items: [
                    {
                        title: "China",
                        description:
                            "China Visa processing service for tourism or business purposes, with a fast, secure process accompanied professionally in accordance with embassy requirements.",
                        price: "Rp 1.000.000",
                        packages: "2 Packages",
                        path: "/visa-mancanegara/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "United States of America",
                        description:
                            "United States Visa (B1/B2) processing service for tourism, business, or visit purposes, with full assistance until the application process is complete.",
                        price: "Rp 4.200.000",
                        packages: "1 Package",
                        path: "/visa-mancanegara/2",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "United Arab Emirates",
                        description:
                            "United Arab Emirates Visa processing service for tourism or short visits, with an easy, fast process in accordance with UAE immigration provisions.",
                        price: "Rp 3.000.000",
                        packages: "1 Package",
                        path: "/visa-mancanegara/3",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Australia",
                        description:
                            "Australia Visa processing service for tourism, business, or family visit purposes, with document preparation assistance and support throughout the application process.",
                        price: "Rp 2.800.000",
                        packages: "1 Package",
                        path: "/visa-mancanegara/4",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "IMMIGRATION & NATURALIZATION",
                path: "/",
                items: [
                    {
                        title: "Republic of Indonesia E-Passport",
                        description:
                            "Processing of e-passport issuance for Indonesian citizens for official international travel purposes.",
                        price: "Rp 3.150.000",
                        packages: "2 Packages",
                        path: "/keimigrasian-wni-wna/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Address Mutation",
                        description:
                            "Processing of Taxable Entrepreneur (PKP) confirmation for companies required to collect and report VAT.",
                        price: "Rp 1.750.000",
                        packages: "2 Packages",
                        path: "/keimigrasian-wni-wna/2",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Passport Mutation for ITAS Holders",
                        description:
                            "Processing of new passport data transfer for ITAS holders in accordance with applicable immigration provisions.",
                        price: "Rp 1.750.000",
                        packages: "1 Package",
                        path: "/naturalisasi/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Exit Permit Only (EPO)",
                        description:
                            "Processing of permanent exit permits for foreign workers or family members departing Indonesia without returning.",
                        price: "Rp 3.000.000",
                        packages: "2 Packages",
                        path: "/naturalisasi/2",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
        ],
        zh: [
            {
                title: "印尼企业设立",
                path: "/badan-usaha",
                items: [
                    {
                        title: "个人有限公司（PT Perorangan）",
                        description:
                            "个人有限公司（PT Perorangan）是由1（一）人设立的法人实体",
                        price: "Rp 750.000",
                        packages: "3个套餐",
                        path: "/badan-usaha/1",
                        icon: "/icons/ic-card-1.svg",
                    },
                    {
                        title: "内资有限公司（PT. PMDN）",
                        description:
                            "境内投资（PMDN）是指使用境内资本进行的投资活动。",
                        price: "Rp 3.250.000",
                        packages: "5个套餐",
                        path: "/badan-usaha/2",
                        icon: "/icons/ic-card-2.svg",
                    },
                    {
                        title: "外资有限公司（PT. PMA）",
                        description:
                            "外资投资（PMA）是指由外国投资者进行的投资活动",
                        price: "Rp 17.250.000",
                        packages: "3个套餐",
                        path: "/badan-usaha/3",
                        icon: "/icons/ic-card-3.svg",
                    },
                    {
                        title: "有限合伙企业（CV）设立",
                        description: "CV是由两人或以上共同设立的合伙形式企业",
                        price: "Rp 2.750.000",
                        packages: "4个套餐",
                        path: "/badan-usaha/4",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "OSS 与营业识别号（NIB）",
                path: "/one-single-submission",
                items: [
                    {
                        title: "NIB——个人",
                        description: "通过OSS系统为个体经营者办理正式NIB。",
                        price: "Rp 750.000",
                        packages: "3个套餐",
                        path: "/one-single-submission/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "NIB——有限公司（微小型企业）",
                        description:
                            "为归类于微型及小型企业的有限公司办理NIB。",
                        price: "Rp 750.000",
                        packages: "3个套餐",
                        path: "/one-single-submission/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "NIB——有限公司（非微小型企业）",
                        description:
                            "为中大型有限公司、境内投资（PMDN）及外资投资（PMA）公司办理NIB。",
                        price: "Rp 750.000",
                        packages: "3个套餐",
                        path: "/one-single-submission/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "NIB——有限合伙企业（CV）",
                        description:
                            "为有限合伙企业（Commanditaire Vennootschap，CV）办理正式NIB。",
                        price: "Rp 750.000",
                        packages: "3个套餐",
                        path: "/one-single-submission/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "基础许可与其他许可",
                path: "/perizinan-berusaha",
                items: [
                    {
                        title: "空间利用活动符合性认定（KKPR）",
                        description:
                            "作为企业运营初始条件的基础许可，涵盖空间规划、环境及建筑符合性。",
                        price: "请联系我们",
                        packages: "3个套餐",
                        path: "/perizinan-berusaha/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "营业许可（标准证书/许可证）",
                        description:
                            "通过OSS系统，依据经营活动风险等级办理标准证书或营业许可。",
                        price: "请联系我们",
                        packages: "11个套餐",
                        path: "/perizinan-berusaha/2",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "支持经营活动所需营业许可（PB UMKU）",
                        description:
                            "依据现行法规，办理支持主营业务所需的附加许可。",
                        price: "Rp. 2.000.000",
                        packages: "3个套餐",
                        path: "/perizinan-berusaha/3",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "纳税人识别号（NPWP）",
                        description: "为企业办理正式纳税人身份的NPWP注册登记。",
                        price: "Rp. 1.250.000",
                        packages: "1个套餐",
                        path: "/perizinan-lainnya/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "线上公证服务——公司及个人文书",
                path: "/",
                items: [
                    {
                        title: "有限责任公司（PT）章程变更",
                        description:
                            "变更公司名称、住所地、经营期限、经营目的与范围，以及授权资本与实缴资本。",
                        price: "Rp 3.500.000",
                        packages: "3个套餐",
                        path: "/notaris-virtual-dan-akta/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "公司资料变更",
                        description:
                            "通过股东大会（RUPS）更换或重新委任董事及监事，并以公证文书形式记载。",
                        price: "Rp 3.000.000",
                        packages: "3个套餐",
                        path: "/notaris-virtual-dan-akta/2",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "年度股东大会（RUPS）",
                        description:
                            "制作年度股东大会文书，用于核准财务报表并向印尼法律与人权部报送。",
                        price: "Rp 750.000",
                        packages: "3个套餐",
                        path: "/notaris-virtual-dan-akta/3",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "其他公证文书",
                        description:
                            "包括分公司设立文书、收购文书、授权书、股份买卖文书，以及婚前协议与分别财产协议等。",
                        price: "Rp 750.000",
                        packages: "3个套餐",
                        path: "/notaris-virtual-dan-akta/4",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "外籍人士居留或工作许可",
                path: "/izin-tinggal-terbatas",
                items: [
                    {
                        title: "外籍劳工临时居留许可及工作许可",
                        description:
                            "为在印尼工作的外籍劳工办理正式ITAS及工作许可。",
                        price: "Rp 9.050.000",
                        packages: "3个套餐",
                        path: "/izin-tinggal-terbatas/1",
                        icon: "/icons/ic-card-1.svg",
                    },
                    {
                        title: "外籍劳工家属临时居留许可",
                        description: "为随行外籍劳工的家属办理ITAS。",
                        price: "Rp 9.050.000",
                        packages: "3个套餐",
                        path: "/izin-tinggal-terbatas/2",
                        icon: "/icons/ic-card-1.svg",
                    },
                    {
                        title: "投资者临时居留许可",
                        description: "为在印尼投资的外国投资者办理ITAS。",
                        price: "Rp 12.750.000",
                        packages: "3个套餐",
                        path: "/izin-tinggal-terbatas/3",
                        icon: "/icons/ic-card-1.svg",
                    },
                    {
                        title: "配偶临时居留许可",
                        description: "为临时居留许可持有人的合法配偶办理ITAS。",
                        price: "Rp 7.000.000",
                        packages: "3个套餐",
                        path: "/izin-tinggal-terbatas/4",
                        icon: "/icons/ic-card-1.svg",
                    },
                ],
            },
            {
                title: "印尼签证",
                path: "/visa-indonesia",
                items: [
                    {
                        title: "单次入境访问签证",
                        description:
                            "供旅游、商务或其他目的、单次入境印尼使用的签证。",
                        price: "Rp 3.000.000",
                        packages: "11个套餐",
                        path: "/visa-indonesia/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "多次入境访问签证",
                        description:
                            "供在一定期限内多次往返印尼使用、无需每次重新申请的签证。",
                        price: "Rp 3.500.000",
                        packages: "4个套餐",
                        path: "/visa-indonesia/2",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                       title: "投资者签证",
                        description:
                            "供在印尼投资或设立企业的外国投资者使用的签证。",
                        price: "Rp 3.000.000",
                        packages: "8个套餐",
                        path: "/visa-indonesia/3",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "家庭签证",
                        description:
                            "供陪同在印尼持有居留许可的配偶或父母的家庭成员使用的签证。",
                        price: "Rp 750.000",
                        packages: "10个套餐",
                        path: "/visa-indonesia/4",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "他国签证",
                path: "/visa-mancanegara",
                items: [
                    {
                        title: "中国",
                        description:
                            "提供中国签证代办服务，适用于旅游或商务用途，流程快速、安全，并依照使馆要求提供专业陪同服务。",
                        price: "Rp 1.000.000",
                        packages: "2个套餐",
                        path: "/visa-mancanegara/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "美国",
                        description:
                            "提供美国签证（B1/B2）代办服务，适用于旅游、商务或探亲访友用途，全程协助至申请完成。",
                        price: "Rp 4.200.000",
                        packages: "1个套餐",
                        path: "/visa-mancanegara/2",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "阿拉伯联合酋长国",
                        description:
                            "提供阿联酋签证代办服务，适用于旅游或短期访问，流程简便快捷，符合阿联酋移民相关规定。",
                        price: "Rp 3.000.000",
                        packages: "1个套餐",
                        path: "/visa-mancanegara/3",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "澳大利亚",
                        description:
                            "提供澳大利亚签证代办服务，适用于旅游、商务或探亲访友用途，协助准备文件并全程陪同申请过程。",
                        price: "Rp 2.800.000",
                        packages: "1个套餐",
                        path: "/visa-mancanegara/4",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "移民与入籍",
                path: "/",
                items: [
                    {
                        title: "印尼共和国电子护照",
                        description:
                            "为印尼公民办理电子护照签发，用于正式国际旅行用途。",
                        price: "Rp 3.150.000",
                        packages: "2个套餐",
                        path: "/keimigrasian-wni-wna/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "地址变更",
                        description:
                            "为须代扣代缴增值税（VAT）的公司办理应税企业（PKP）确认登记。",
                        price: "Rp 1.750.000",
                        packages: "2个套餐",
                        path: "/keimigrasian-wni-wna/2",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "ITAS持有人护照信息变更",
                        description:
                            "依照现行移民相关规定，为ITAS持有人办理新护照资料变更。",
                        price: "Rp 1.750.000",
                        packages: "1个套餐",
                        path: "/naturalisasi/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "永久离境许可（EPO）",
                        description:
                            "为即将离开印尼且不再返回的外籍劳工或其家属办理永久离境许可。",
                        price: "Rp 3.000.000",
                        packages: "2个套餐",
                        path: "/naturalisasi/2",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
        ],
    };

    const serviceCategories = computed(() => data[locale.value] ?? data.id);

    return { serviceCategories };
}
