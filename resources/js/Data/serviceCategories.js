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
                title: "PERIZINAN BERUSAHA",
                path: "/",
                items: [
                    {
                        title: "Kesesuaian Kegiatan Pemanfaatan Ruang",
                        description:
                            "Perizinan dasar sebagai syarat awal operasional usaha, mencakup kesesuaian tata ruang, lingkungan, dan bangunan.",
                        price: "Hubungi Kami",
                        packages: "3 Paket",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Perizinan Berusaha (Sertifikat Standar/Izin)",
                        description:
                            "Pengurusan sertifikat standar atau izin berusaha sesuai tingkat risiko kegiatan usaha melalui sistem OSS.",
                        price: "Hubungi Kami",
                        packages: "11 Paket",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Perizinan Berusaha Untuk Menunjang Kegiatan Usaha (PB UMKU)",
                        description:
                            "Pengurusan izin tambahan yang dibutuhkan untuk menunjang kegiatan usaha utama sesuai regulasi yang berlaku.",
                        price: "Rp. 2.000.000",
                        packages: "3 Paket",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "NOTARIS VIRTUAL – AKTA PERUSAHAAN DAN PERORANGAN",
                path: "/",
                items: [
                    {
                        title: "Akta Notaris – PT (Perseroan Terbatas)",
                        description:
                            "Pengurusan akta perubahan anggaran dasar, pengurus, saham, dan RUPS Tahunan PT secara resmi.",
                        price: "Rp 3.000.000",
                        packages: "3 Paket",
                        path: "/notaris-virtual-dan-akta/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Akta Lainnya",
                        description:
                            "Penerbitan akta cabang, akuisisi, kuasa, jual beli saham, hingga perjanjian pranikah dan pisah harta.Perubahan Anggaran Dasar Perseroan Pasal 1-4",
                        price: "Rp 750.000",
                        packages: "7 Paket",
                        path: "/notaris-virtual-dan-akta/2",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Layanan Notaris Lainnya",
                        description:
                            "Pengesahan dokumen melalui waarmerking, legalisir, legalisasi, dan penerbitan profil perseroan dari AHU.",
                        price: "Rp 250.000",
                        packages: "4 Paket",
                        path: "/notaris-virtual-dan-akta/3",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "IZIN TINGGAL ATAU KERJA WARGA NEGARA ASING",
                path: "/foreignservice",
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
                path: "/",
                items: [
                    {
                        title: "Visa Kunjungan Satu Kali Perjalanan",
                        description:
                            "Visa untuk kunjungan wisata, bisnis, atau keperluan lain dengan satu kali masuk ke Indonesia.",
                        price: "Rp 3.000.000",
                        packages: "11 Paket",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Visa Kunjungan Beberapa Kali Perjalanan",
                        description:
                            "Visa untuk kunjungan berulang ke Indonesia dalam periode tertentu tanpa pengajuan ulang setiap kedatangan.",
                        price: "Rp 3.500.000",
                        packages: "4 Paket",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Visa Kerja",
                        description:
                            "Visa bagi tenaga kerja asing yang akan bekerja secara resmi di perusahaan atau proyek di Indonesia.",
                        price: "Rp 3.500.000",
                        packages: "18 Paket",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Visa Investor",
                        description:
                            "Visa bagi investor asing yang menanamkan modal atau mendirikan usaha di Indonesia.",
                        price: "Rp 3.000.000",
                        packages: "8 Paket",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "VISA MANCANEGARA",
                path: "/",
                items: [
                    {
                        title: "China",
                        description:
                            "Layanan pengurusan Visa China untuk keperluan wisata maupun bisnis dengan proses yang cepat, aman, dan didampingi secara profesional sesuai persyaratan kedutaan.",
                        price: "Rp 1.000.000",
                        packages: "2 Paket",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "United Stated of America",
                        description:
                            "Layanan pengurusan Visa Amerika Serikat (B1/B2) untuk kebutuhan wisata, bisnis, maupun kunjungan, dengan pendampingan lengkap hingga proses pengajuan selesai.",
                        price: "Rp 4.200.000",
                        packages: "1 Paket",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Uni Emirate Arab",
                        description:
                            "Layanan pengurusan Visa Uni Emirat Arab untuk perjalanan wisata atau kunjungan singkat dengan proses mudah, cepat, dan sesuai ketentuan imigrasi UEA.",
                        price: "Rp 3.000.000",
                        packages: "1 Paket",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Australia",
                        description:
                            "Layanan pengurusan Visa Australia untuk wisata, bisnis, maupun kunjungan keluarga dengan bantuan persiapan dokumen dan pendampingan selama proses pengajuan.",
                        price: "Rp 2.800.000",
                        packages: "1 Paket",
                        path: "/ON-DEVELOPMENT",
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
                title: "BUSINESS ENTITY ESTABLISHMENT",
                path: "/badan-usaha",
                items: [
                    {
                        title: "Individual PT",
                        description:
                            "Individual Limited Liability Company (PT) is a Legal Entity established by 1 (one) person",
                        price: "Rp 750,000",
                        packages: "3 Packages",
                        path: "/badan-usaha/1",
                        icon: "/icons/ic-card-1.svg",
                    },
                    {
                        title: "PT. PMDN",
                        description:
                            "Domestic Investment (PMDN) is the activity of investing using Domestic Capital.",
                        price: "Rp 3,250,000",
                        packages: "5 Packages",
                        path: "/badan-usaha/2",
                        icon: "/icons/ic-card-2.svg",
                    },
                    {
                        title: "PT. PMA",
                        description:
                            "Foreign Investment (PMA) is the activity of investing by Foreign Investors",
                        price: "Rp 17,250,000",
                        packages: "3 Packages",
                        path: "/badan-usaha/3",
                        icon: "/icons/ic-card-3.svg",
                    },
                    {
                        title: "CV Establishment",
                        description:
                            "CV is a form of partnership established by two or more people",
                        price: "Rp 2,750,000",
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
                        title: "NIB – INDIVIDUAL",
                        description:
                            "Official NIB processing for individual business owners through the OSS system.",
                        price: "Rp 750,000",
                        packages: "3 Packages",
                        path: "/one-single-submission/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "NIB – PT – SME",
                        description:
                            "NIB processing for Limited Liability Companies categorized as Micro and Small Businesses.",
                        price: "Rp 750,000",
                        packages: "3 Packages",
                        path: "/one-single-submission/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "NIB – PT – NON SME",
                        description:
                            "NIB processing for medium, large, PMDN, or PMA-scale PT companies.",
                        price: "Rp 750,000",
                        packages: "3 Packages",
                        path: "/one-single-submission/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "NIB – CV",
                        description:
                            "Official NIB processing for business entities in the form of Commanditaire Vennootschap (CV).",
                        price: "Rp 750,000",
                        packages: "3 Packages",
                        path: "/one-single-submission/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "BUSINESS LICENSING",
                path: "/",
                items: [
                    {
                        title: "Spatial Utilization Activity Conformity",
                        description:
                            "Basic licensing as an initial requirement for business operations, covering spatial planning, environmental, and building conformity.",
                        price: "Contact Us",
                        packages: "3 Packages",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Business License (Standard Certificate/Permit)",
                        description:
                            "Processing of standard certificates or business licenses according to the risk level of business activities through the OSS system.",
                        price: "Contact Us",
                        packages: "11 Packages",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Business Support License (PB UMKU)",
                        description:
                            "Processing of additional permits required to support main business activities in accordance with applicable regulations.",
                        price: "Rp 2,000,000",
                        packages: "3 Packages",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "VIRTUAL NOTARY – COMPANY & PERSONAL DEEDS",
                path: "/notaris-virtual-dan-akta",
                items: [
                    {
                        title: "Notary Deed – PT (Limited Liability Company)",
                        description:
                            "Processing of amendments to articles of association, directors, shares, and Annual GMS of PT officially.",
                        price: "Rp 3,000,000",
                        packages: "3 Packages",
                        path: "/notaris-virtual-dan-akta/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Other Deeds",
                        description:
                            "Issuance of branch deeds, acquisitions, power of attorney, share sale and purchase, up to prenuptial agreements and separation of assets.",
                        price: "Rp 750,000",
                        packages: "7 Packages",
                        path: "/notaris-virtual-dan-akta/2",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Other Notary Services",
                        description:
                            "Document authentication through waarmerking, legalization, and issuance of corporate profiles from AHU.",
                        price: "Rp 250,000",
                        packages: "4 Packages",
                        path: "/notaris-virtual-dan-akta/3",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "LIMITED STAY PERMIT & WORK PERMIT FOR FOREIGN NATIONALS",
                path: "/izin-tinggal-terbatas",
                items: [
                    {
                        title: "ITAS AND WORK PERMIT FOR FOREIGN WORKERS",
                        description:
                            "Official ITAS and work permit processing for foreign workers in Indonesia.",
                        price: "Rp 9,050,000",
                        packages: "3 Packages",
                        path: "/izin-tinggal-terbatas/1",
                        icon: "/icons/ic-card-1.svg",
                    },
                    {
                        title: "ITAS FOR FOREIGN WORKER FAMILY MEMBERS",
                        description:
                            "ITAS processing for family members accompanying foreign workers.",
                        price: "Rp 9,050,000",
                        packages: "3 Packages",
                        path: "/izin-tinggal-terbatas/2",
                        icon: "/icons/ic-card-1.svg",
                    },
                    {
                        title: "INVESTOR ITAS",
                        description:
                            "ITAS processing for foreign investors investing capital in Indonesia.",
                        price: "Rp 12,750,000",
                        packages: "3 Packages",
                        path: "/izin-tinggal-terbatas/3",
                        icon: "/icons/ic-card-1.svg",
                    },
                    {
                        title: "SPOUSE ITAS",
                        description:
                            "ITAS processing for the legal spouse of a limited stay permit holder.",
                        price: "Rp 7,000,000",
                        packages: "3 Packages",
                        path: "/izin-tinggal-terbatas/4",
                        icon: "/icons/ic-card-1.svg",
                    },
                ],
            },
            {
                title: "VISA TO INDONESIA",
                path: "/",
                items: [
                    {
                        title: "Single Entry Visit Visa",
                        description:
                            "Visa for tourism, business, or other purposes with a single entry into Indonesia.",
                        price: "Rp 3,000,000",
                        packages: "11 Packages",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Multiple Entry Visit Visa",
                        description:
                            "Visa for repeated visits to Indonesia within a certain period without re-applying for each arrival.",
                        price: "Rp 3,500,000",
                        packages: "4 Packages",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Work Visa",
                        description:
                            "Visa for foreign workers who will officially work at a company or project in Indonesia.",
                        price: "Rp 3,500,000",
                        packages: "18 Packages",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Investor Visa",
                        description:
                            "Visa for foreign investors investing capital or establishing a business in Indonesia.",
                        price: "Rp 3,000,000",
                        packages: "8 Packages",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "OVERSEAS VISA",
                path: "/",
                items: [
                    {
                        title: "China",
                        description:
                            "China visa processing service for tourism or business purposes, handled quickly, safely, and professionally in accordance with embassy requirements.",
                        price: "Rp 1,000,000",
                        packages: "2 Packages",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "United States of America",
                        description:
                            "US Visa (B1/B2) processing service for tourism, business, or visit purposes, with comprehensive assistance until the application is complete.",
                        price: "Rp 4,200,000",
                        packages: "1 Package",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "United Arab Emirates",
                        description:
                            "UAE visa processing service for tourism or short visits, with an easy, fast process in accordance with UAE immigration requirements.",
                        price: "Rp 3,000,000",
                        packages: "1 Package",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Australia",
                        description:
                            "Australia visa processing service for tourism, business, or family visits with document preparation assistance and support throughout the application process.",
                        price: "Rp 2,800,000",
                        packages: "1 Package",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "IMMIGRATION & NATURALIZATION",
                path: "/",
                items: [
                    {
                        title: "Indonesian E-Passport",
                        description:
                            "Processing of e-passport issuance for Indonesian Citizens for official international travel purposes.",
                        price: "Rp 3,150,000",
                        packages: "2 Packages",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Address Transfer",
                        description:
                            "Processing of address transfer for Indonesian Citizens or ITAS holders in accordance with applicable regulations.",
                        price: "Rp 1,750,000",
                        packages: "2 Packages",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Passport Transfer for ITAS Holders",
                        description:
                            "Processing of new passport data transfer for ITAS holders in accordance with applicable immigration regulations.",
                        price: "Rp 1,750,000",
                        packages: "1 Package",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "Exit Permit Only (EPO)",
                        description:
                            "Processing of permanent exit permits for foreign workers or families who will leave Indonesia and not return.",
                        price: "Rp 3,000,000",
                        packages: "2 Packages",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
        ],
        zh: [
            {
                title: "印度尼西亚商业实体注册",
                path: "/badan-usaha",
                items: [
                    {
                        title: "个人PT",
                        description:
                            "个人有限责任公司（PT）是由1（一）人设立的法人实体",
                        price: "Rp 750.000",
                        packages: "3个套餐",
                        path: "/badan-usaha/1",
                        icon: "/icons/ic-card-1.svg",
                    },
                    {
                        title: "PT. PMDN",
                        description:
                            "国内投资（PMDN）是使用国内资本进行投资的活动。",
                        price: "Rp 3.250.000",
                        packages: "5个套餐",
                        path: "/badan-usaha/2",
                        icon: "/icons/ic-card-2.svg",
                    },
                    {
                        title: "PT. PMA",
                        description:
                            "外国投资（PMA）是外国投资者进行投资或注入资本的活动",
                        price: "Rp 17.250.000",
                        packages: "3个套餐",
                        path: "/badan-usaha/3",
                        icon: "/icons/ic-card-3.svg",
                    },
                    {
                        title: "CV注册",
                        description: "CV是由两人或两人以上设立的合伙形式",
                        price: "Rp 2.750.000",
                        packages: "4个套餐",
                        path: "/badan-usaha/4",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "在线单一提交系统 (OSS) 及营业执照号码 (NIB)",
                path: "/one-single-submission",
                items: [
                    {
                        title: "NIB – 个人",
                        description: "通过OSS系统为个人企业主办理正式NIB。",
                        price: "Rp 750.000",
                        packages: "3个套餐",
                        path: "/one-single-submission/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "NIB – PT – 中小微企业",
                        description:
                            "为微型和小型企业类别的有限责任公司办理NIB。",
                        price: "Rp 750.000",
                        packages: "3个套餐",
                        path: "/one-single-submission/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "NIB – PT – 非中小微企业",
                        description:
                            "为中型、大型、PMDN或PMA规模的PT公司办理NIB。",
                        price: "Rp 750.000",
                        packages: "3个套餐",
                        path: "/one-single-submission/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "NIB – CV",
                        description:
                            "为有限合伙企业（CV）形式的商业实体办理正式NIB。",
                        price: "Rp 750.000",
                        packages: "3个套餐",
                        path: "/one-single-submission/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "营业许可",
                path: "/",
                items: [
                    {
                        title: "空间利用活动适宜性",
                        description:
                            "作为企业运营初始要求的基本许可，涵盖空间规划、环境和建筑合规性。",
                        price: "联系我们",
                        packages: "3个套餐",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "营业许可（标准证书/许可）",
                        description:
                            "通过OSS系统根据经营活动风险等级处理标准证书或营业许可证。",
                        price: "联系我们",
                        packages: "11个套餐",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "支持经营活动许可 (PB UMKU)",
                        description:
                            "根据适用法规，处理支持主要经营活动所需的附加许可证。",
                        price: "Rp 2.000.000",
                        packages: "3个套餐",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "虚拟公证 – 公司及个人契约",
                path: "/notaris-virtual-dan-akta",
                items: [
                    {
                        title: "公证契约 – PT（有限责任公司）",
                        description:
                            "正式处理PT章程、董事、股份及年度股东大会的变更事宜。",
                        price: "Rp 3.000.000",
                        packages: "3个套餐",
                        path: "/notaris-virtual-dan-akta/1",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "其他契约",
                        description:
                            "签发分支机构契约、收购、授权书、股份买卖，直至婚前协议和财产分离。",
                        price: "Rp 750.000",
                        packages: "7个套餐",
                        path: "/notaris-virtual-dan-akta/2",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "其他公证服务",
                        description:
                            "通过waarmerking、合法化及从AHU签发公司档案进行文件认证。",
                        price: "Rp 250.000",
                        packages: "4个套餐",
                        path: "/notaris-virtual-dan-akta/3",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "外国公民有限居留许可及工作许可",
                path: "/izin-tinggal-terbatas",
                items: [
                    {
                        title: "外国工人有限居留和工作许可",
                        description:
                            "为在印度尼西亚的外国工人办理正式ITAS和工作许可。",
                        price: "Rp 9.050.000",
                        packages: "3个套餐",
                        path: "/izin-tinggal-terbatas/1",
                        icon: "/icons/ic-card-1.svg",
                    },
                    {
                        title: "外国工人家属有限居留许可",
                        description: "为陪同外国工人的家庭成员办理ITAS。",
                        price: "Rp 9.050.000",
                        packages: "3个套餐",
                        path: "/izin-tinggal-terbatas/2",
                        icon: "/icons/ic-card-1.svg",
                    },
                    {
                        title: "投资者有限居留许可",
                        description:
                            "为在印度尼西亚投资资本的外国投资者办理ITAS。",
                        price: "Rp 12.750.000",
                        packages: "3个套餐",
                        path: "/izin-tinggal-terbatas/3",
                        icon: "/icons/ic-card-1.svg",
                    },
                    {
                        title: "配偶有限居留许可",
                        description: "为有限居留许可持有人的合法配偶办理ITAS。",
                        price: "Rp 7.000.000",
                        packages: "3个套餐",
                        path: "/izin-tinggal-terbatas/4",
                        icon: "/icons/ic-card-1.svg",
                    },
                ],
            },
            {
                title: "印度尼西亚签证",
                path: "/",
                items: [
                    {
                        title: "单次入境访问签证",
                        description:
                            "用于旅游、商务或其他目的，单次入境印度尼西亚的签证。",
                        price: "Rp 3.000.000",
                        packages: "11个套餐",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "多次入境访问签证",
                        description:
                            "在特定时期内多次访问印度尼西亚，无需每次抵达时重新申请的签证。",
                        price: "Rp 3.500.000",
                        packages: "4个套餐",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "工作签证",
                        description:
                            "适用于将在印度尼西亚公司或项目正式工作的外国工人的签证。",
                        price: "Rp 3.500.000",
                        packages: "18个套餐",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "投资者签证",
                        description:
                            "适用于在印度尼西亚投资资本或创办企业的外国投资者的签证。",
                        price: "Rp 3.000.000",
                        packages: "8个套餐",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "海外签证",
                path: "/",
                items: [
                    {
                        title: "中国",
                        description:
                            "为旅游或商务目的提供中国签证办理服务，流程快速、安全，并按照大使馆要求专业协助。",
                        price: "Rp 1.000.000",
                        packages: "2个套餐",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "美利坚合众国",
                        description:
                            "为旅游、商务或访问目的提供美国签证（B1/B2）办理服务，提供全程协助直至申请完成。",
                        price: "Rp 4.200.000",
                        packages: "1个套餐",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "阿拉伯联合酋长国",
                        description:
                            "为旅游或短期访问提供阿联酋签证办理服务，流程简便、快速，符合阿联酋移民要求。",
                        price: "Rp 3.000.000",
                        packages: "1个套餐",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "澳大利亚",
                        description:
                            "为旅游、商务或家庭访问提供澳大利亚签证办理服务，包含文件准备协助及全程申请支持。",
                        price: "Rp 2.800.000",
                        packages: "1个套餐",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
            {
                title: "移民与归化",
                path: "/",
                items: [
                    {
                        title: "印度尼西亚电子护照",
                        description:
                            "为印度尼西亚公民办理用于正式国际旅行的电子护照签发手续。",
                        price: "Rp 3.150.000",
                        packages: "2个套餐",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "地址迁移",
                        description:
                            "根据适用法规为印度尼西亚公民或ITAS持有人办理地址迁移手续。",
                        price: "Rp 1.750.000",
                        packages: "2个套餐",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "ITAS持有人护照迁移",
                        description:
                            "根据适用移民法规为ITAS持有人办理新护照数据迁移手续。",
                        price: "Rp 1.750.000",
                        packages: "1个套餐",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                    {
                        title: "仅限出境许可 (EPO)",
                        description:
                            "为将离开印度尼西亚且不再返回的外国工人或家属办理永久出境许可。",
                        price: "Rp 3.000.000",
                        packages: "2个套餐",
                        path: "/ON-DEVELOPMENT",
                        icon: "/icons/ic-card-4.svg",
                    },
                ],
            },
        ],
    };

    const serviceCategories = computed(() => data[locale.value] ?? data.id);

    return { serviceCategories };
}
