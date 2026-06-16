import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

export function useServiceCategories() {
    const { locale } = useI18n()

    const data = {
        id: [
            {
                title: 'PENDIRIAN BADAN USAHA',
                path: '/badan-usaha',
                items: [
                    { title: 'PT Perorangan', description: 'Perseroan Terbatas (PT) Perorangan adalah Badan Hukum yang didirikan oleh 1 (satu) seorang', price: 'Rp 750.000', packages: '3 Paket', path: '/badan-usaha', icon: '/icons/ft-person.svg' },
                    { title: 'PT. PMDN', description: 'Penanaman Modal Dalam Negeri (PMDN) adalah kegiatan menanam modal menggunakan Modal Dalam Negeri.', price: 'Rp 3.250.000', packages: '5 Paket', path: '/badan-usaha', icon: '/icons/ft-persons.svg' },
                    { title: 'PT. PMA', description: 'Penanaman Modal Asing (PMA) adalah kegiatan investasi atau menanam modal oleh Penanam Modal Asing', price: 'Rp 17.250.000', packages: '3 Paket', path: '/foreignservice', icon: '/icons/ft-person-check.svg' },
                    { title: 'Pendirian CV', description: 'CV merupakan bentuk persekutuan yang didirikan oleh dua orang atau lebih', price: 'Rp 2.750.000', packages: '4 Paket', path: '/badan-usaha', icon: '/icons/ft-building.svg' },
                ],
            },
            {
                title: 'ONLINE SINGLE SUBMISSION (OSS)',
                path: '/perizinan-usaha',
                items: [
                    { title: 'NIB – PERORANGAN', description: 'Pengurusan NIB resmi untuk pelaku usaha perseorangan melalui sistem OSS.', price: 'Rp 750.000', packages: '3 Paket', path: '/perizinan-usaha', icon: '/icons/ft-person.svg' },
                    { title: 'NIB – PT – UMK', description: 'Pengurusan NIB untuk Perseroan Terbatas berkategori Usaha Mikro dan Kecil.', price: 'Rp 750.000', packages: '3 Paket', path: '/perizinan-usaha', icon: '/icons/ft-person.svg' },
                    { title: 'NIB – PT – NON UMK', description: 'Pengurusan NIB untuk PT skala menengah, besar, PMDN, maupun PMA.', price: 'Rp 750.000', packages: '3 Paket', path: '/perizinan-usaha', icon: '/icons/ft-person.svg' },
                    { title: 'NIB – CV', description: 'Pengurusan NIB resmi untuk badan usaha berbentuk Commanditaire Vennootschap (CV).', price: 'Rp 750.000', packages: '3 Paket', path: '/perizinan-usaha', icon: '/icons/ft-person.svg' },
                ],
            },
            {
                title: 'NOTARIS VIRTUAL – AKTA PERUSAHAAN DAN PERORANGAN',
                path: '/perubahan-akta',
                items: [
                    { title: 'PT (PERSEROAN TERBATAS) MODAL DIBAWAH 1M :', description: 'Perubahan Anggaran Dasar Perseroan Pasal 1–4', price: 'Rp 750.000', packages: '3 Paket', path: '/perubahan-akta', icon: '/icons/ft-person.svg' },
                    { title: 'PT (PERSEROAN TERBATAS) MODAL DIBAWAH 1M :', description: 'Perubahan Anggaran Dasar Perseroan Selain Pasal 1–4', price: 'Rp 750.000', packages: '3 Paket', path: '/perubahan-akta', icon: '/icons/ft-person.svg' },
                    { title: 'PT (PERSEROAN TERBATAS) MODAL DIATAS 1M :', description: 'Perubahan Anggaran Dasar Perseroan Pasal 3', price: 'Rp 750.000', packages: '3 Paket', path: '/perubahan-akta', icon: '/icons/ft-person.svg' },
                    { title: 'PT (PERSEROAN TERBATAS) MODAL DIATAS 1M :', description: 'Perubahan Anggaran Dasar Perseroan Pasal 4', price: 'Rp 750.000', packages: '3 Paket', path: '/perubahan-akta', icon: '/icons/ft-person.svg' },
                ],
            },
            {
                title: 'IZIN TINGGAL TERBATAS',
                path: '/izin-tinggal-terbatas',
                items: [
                    { title: 'IZIN TINGGAL TERBATAS DAN KERJA TENAGA KERJA ASING', description: 'Pengurusan ITAS dan izin kerja resmi untuk tenaga kerja asing di Indonesia.', price: 'Rp 9.050.000', packages: '3 Paket', path: '/izin-tinggal-terbatas/1', icon: '/icons/ft-person.svg' },
                    { title: 'IZIN TINGGAL TERBATAS KELUARGA TENAGA KERJA ASING', description: 'Pengurusan ITAS untuk anggota keluarga yang mengikuti tenaga kerja asing.', price: 'Rp 9.050.000', packages: '3 Paket', path: '/izin-tinggal-terbatas/2', icon: '/icons/ft-person.svg' },
                    { title: 'IZIN TINGGAL TERBATAS INVESTOR', description: 'Pengurusan ITAS untuk investor asing yang menanamkan modal di Indonesia.', price: 'Rp 12.750.000', packages: '3 Paket', path: '/izin-tinggal-terbatas/3', icon: '/icons/ft-person.svg' },
                    { title: 'IZIN TINGGAL TERBATAS PASANGAN (SPOUSE)', description: 'Pengurusan ITAS untuk pasangan sah dari pemegang izin tinggal terbatas.', price: 'Rp 7.000.000', packages: '3 Paket', path: '/izin-tinggal-terbatas/4', icon: '/icons/ft-person.svg' },
                ],
            },
            {
                title: 'VISA KE INDONESIA',
                path: '/foreignservice',
                items: [
                    { title: 'Visa Bisnis', description: 'Pengurusan visa bisnis untuk kunjungan bisnis ke Indonesia.', price: 'Rp 750.000', packages: '3 Paket', path: '/foreignservice', icon: '/icons/ft-person.svg' },
                    { title: 'Visa Kerja', description: 'Pengurusan visa kerja untuk tenaga kerja asing di Indonesia.', price: 'Rp 750.000', packages: '3 Paket', path: '/foreignservice', icon: '/icons/ft-person.svg' },
                    { title: 'Visa Investor', description: 'Pengurusan visa investor untuk penanam modal asing.', price: 'Rp 750.000', packages: '3 Paket', path: '/foreignservice', icon: '/icons/ft-person.svg' },
                    { title: 'Visa Keluarga', description: 'Pengurusan visa untuk anggota keluarga tenaga kerja asing.', price: 'Rp 750.000', packages: '3 Paket', path: '/foreignservice', icon: '/icons/ft-person.svg' },
                ],
            },
        ],
        en: [
            {
                title: 'BUSINESS ENTITY ESTABLISHMENT',
                path: '/badan-usaha',
                items: [
                    { title: 'Individual PT', description: 'Individual Limited Liability Company (PT) is a Legal Entity established by 1 (one) person', price: 'Rp 750,000', packages: '3 Packages', path: '/badan-usaha', icon: '/icons/ft-person.svg' },
                    { title: 'PT. PMDN', description: 'Domestic Investment (PMDN) is the activity of investing using Domestic Capital.', price: 'Rp 3,250,000', packages: '5 Packages', path: '/badan-usaha', icon: '/icons/ft-persons.svg' },
                    { title: 'PT. PMA', description: 'Foreign Investment (PMA) is the activity of investing by Foreign Investors', price: 'Rp 17,250,000', packages: '3 Packages', path: '/foreignservice', icon: '/icons/ft-person-check.svg' },
                    { title: 'CV Establishment', description: 'CV is a form of partnership established by two or more people', price: 'Rp 2,750,000', packages: '4 Packages', path: '/badan-usaha', icon: '/icons/ft-building.svg' },
                ],
            },
            {
                title: 'ONLINE SINGLE SUBMISSION (OSS)',
                path: '/perizinan-usaha',
                items: [
                    { title: 'NIB – INDIVIDUAL', description: 'Official NIB processing for individual business owners through the OSS system.', price: 'Rp 750,000', packages: '3 Packages', path: '/perizinan-usaha', icon: '/icons/ft-person.svg' },
                    { title: 'NIB – PT – SME', description: 'NIB processing for Limited Liability Companies categorized as Micro and Small Businesses.', price: 'Rp 750,000', packages: '3 Packages', path: '/perizinan-usaha', icon: '/icons/ft-person.svg' },
                    { title: 'NIB – PT – NON SME', description: 'NIB processing for medium, large, PMDN, or PMA-scale PT companies.', price: 'Rp 750,000', packages: '3 Packages', path: '/perizinan-usaha', icon: '/icons/ft-person.svg' },
                    { title: 'NIB – CV', description: 'Official NIB processing for business entities in the form of Commanditaire Vennootschap (CV).', price: 'Rp 750,000', packages: '3 Packages', path: '/perizinan-usaha', icon: '/icons/ft-person.svg' },
                ],
            },
            {
                title: 'VIRTUAL NOTARY – COMPANY & PERSONAL DEEDS',
                path: '/perubahan-akta',
                items: [
                    { title: 'PT (LIMITED LIABILITY) CAPITAL BELOW 1B:', description: 'Amendment of Articles of Association Articles 1–4', price: 'Rp 750,000', packages: '3 Packages', path: '/perubahan-akta', icon: '/icons/ft-person.svg' },
                    { title: 'PT (LIMITED LIABILITY) CAPITAL BELOW 1B:', description: 'Amendment of Articles of Association Other Than Articles 1–4', price: 'Rp 750,000', packages: '3 Packages', path: '/perubahan-akta', icon: '/icons/ft-person.svg' },
                    { title: 'PT (LIMITED LIABILITY) CAPITAL ABOVE 1B:', description: 'Amendment of Articles of Association Article 3', price: 'Rp 750,000', packages: '3 Packages', path: '/perubahan-akta', icon: '/icons/ft-person.svg' },
                    { title: 'PT (LIMITED LIABILITY) CAPITAL ABOVE 1B:', description: 'Amendment of Articles of Association Article 4', price: 'Rp 750,000', packages: '3 Packages', path: '/perubahan-akta', icon: '/icons/ft-person.svg' },
                ],
            },
            {
                title: 'LIMITED STAY PERMIT (ITAS)',
                path: '/foreignservice',
                items: [
                    { title: 'ITAS AND WORK PERMIT FOR FOREIGN WORKERS', description: 'Official ITAS and work permit processing for foreign workers in Indonesia.', price: 'Rp 750,000', packages: '3 Packages', path: '/foreignservice', icon: '/icons/ft-person.svg' },
                    { title: 'ITAS FOR FOREIGN WORKER FAMILY MEMBERS', description: 'ITAS processing for family members accompanying foreign workers.', price: 'Rp 750,000', packages: '3 Packages', path: '/foreignservice', icon: '/icons/ft-person.svg' },
                    { title: 'INVESTOR ITAS', description: 'ITAS processing for foreign investors investing capital in Indonesia.', price: 'Rp 750,000', packages: '3 Packages', path: '/foreignservice', icon: '/icons/ft-person.svg' },
                    { title: 'SPOUSE ITAS', description: 'ITAS processing for the legal spouse of a limited stay permit holder.', price: 'Rp 750,000', packages: '3 Packages', path: '/foreignservice', icon: '/icons/ft-person.svg' },
                ],
            },
            {
                title: 'VISA TO INDONESIA',
                path: '/foreignservice',
                items: [
                    { title: 'Business Visa', description: 'Business visa processing for business visits to Indonesia.', price: 'Rp 750,000', packages: '3 Packages', path: '/foreignservice', icon: '/icons/ft-person.svg' },
                    { title: 'Work Visa', description: 'Work visa processing for foreign workers in Indonesia.', price: 'Rp 750,000', packages: '3 Packages', path: '/foreignservice', icon: '/icons/ft-person.svg' },
                    { title: 'Investor Visa', description: 'Investor visa processing for foreign capital investors.', price: 'Rp 750,000', packages: '3 Packages', path: '/foreignservice', icon: '/icons/ft-person.svg' },
                    { title: 'Family Visa', description: 'Visa processing for family members of foreign workers.', price: 'Rp 750,000', packages: '3 Packages', path: '/foreignservice', icon: '/icons/ft-person.svg' },
                ],
            },
        ],
        zh: [
            {
                title: '商业实体注册',
                path: '/badan-usaha',
                items: [
                    { title: '个人PT', description: '个人有限责任公司（PT）是由1（一）人设立的法人实体', price: 'Rp 750.000', packages: '3个套餐', path: '/badan-usaha', icon: '/icons/ft-person.svg' },
                    { title: 'PT. PMDN', description: '国内投资（PMDN）是使用国内资本进行投资的活动。', price: 'Rp 3.250.000', packages: '5个套餐', path: '/badan-usaha', icon: '/icons/ft-persons.svg' },
                    { title: 'PT. PMA', description: '外国投资（PMA）是外国投资者进行投资或注入资本的活动', price: 'Rp 17.250.000', packages: '3个套餐', path: '/foreignservice', icon: '/icons/ft-person-check.svg' },
                    { title: 'CV注册', description: 'CV是由两人或两人以上设立的合伙形式', price: 'Rp 2.750.000', packages: '4个套餐', path: '/badan-usaha', icon: '/icons/ft-building.svg' },
                ],
            },
            {
                title: '在线单一提交系统 (OSS)',
                path: '/perizinan-usaha',
                items: [
                    { title: 'NIB – 个人', description: '通过OSS系统为个人企业主办理正式NIB。', price: 'Rp 750.000', packages: '3个套餐', path: '/perizinan-usaha', icon: '/icons/ft-person.svg' },
                    { title: 'NIB – PT – 中小微企业', description: '为微型和小型企业类别的有限责任公司办理NIB。', price: 'Rp 750.000', packages: '3个套餐', path: '/perizinan-usaha', icon: '/icons/ft-person.svg' },
                    { title: 'NIB – PT – 非中小微企业', description: '为中型、大型、PMDN或PMA规模的PT公司办理NIB。', price: 'Rp 750.000', packages: '3个套餐', path: '/perizinan-usaha', icon: '/icons/ft-person.svg' },
                    { title: 'NIB – CV', description: '为有限合伙企业（CV）形式的商业实体办理正式NIB。', price: 'Rp 750.000', packages: '3个套餐', path: '/perizinan-usaha', icon: '/icons/ft-person.svg' },
                ],
            },
            {
                title: '虚拟公证 – 公司及个人契约',
                path: '/perubahan-akta',
                items: [
                    { title: 'PT（有限责任公司）资本低于10亿：', description: '修改公司章程第1-4条', price: 'Rp 750.000', packages: '3个套餐', path: '/perubahan-akta', icon: '/icons/ft-person.svg' },
                    { title: 'PT（有限责任公司）资本低于10亿：', description: '修改公司章程第1-4条以外的条款', price: 'Rp 750.000', packages: '3个套餐', path: '/perubahan-akta', icon: '/icons/ft-person.svg' },
                    { title: 'PT（有限责任公司）资本高于10亿：', description: '修改公司章程第3条', price: 'Rp 750.000', packages: '3个套餐', path: '/perubahan-akta', icon: '/icons/ft-person.svg' },
                    { title: 'PT（有限责任公司）资本高于10亿：', description: '修改公司章程第4条', price: 'Rp 750.000', packages: '3个套餐', path: '/perubahan-akta', icon: '/icons/ft-person.svg' },
                ],
            },
            {
                title: '有限居留许可 (ITAS)',
                path: '/foreignservice',
                items: [
                    { title: '外国工人有限居留和工作许可', description: '为在印度尼西亚的外国工人办理正式ITAS和工作许可。', price: 'Rp 750.000', packages: '3个套餐', path: '/foreignservice', icon: '/icons/ft-person.svg' },
                    { title: '外国工人家属有限居留许可', description: '为陪同外国工人的家庭成员办理ITAS。', price: 'Rp 750.000', packages: '3个套餐', path: '/foreignservice', icon: '/icons/ft-person.svg' },
                    { title: '投资者有限居留许可', description: '为在印度尼西亚投资资本的外国投资者办理ITAS。', price: 'Rp 750.000', packages: '3个套餐', path: '/foreignservice', icon: '/icons/ft-person.svg' },
                    { title: '配偶有限居留许可', description: '为有限居留许可持有人的合法配偶办理ITAS。', price: 'Rp 750.000', packages: '3个套餐', path: '/foreignservice', icon: '/icons/ft-person.svg' },
                ],
            },
            {
                title: '印度尼西亚签证',
                path: '/foreignservice',
                items: [
                    { title: '商务签证', description: '为赴印度尼西亚商务访问办理商务签证。', price: 'Rp 750.000', packages: '3个套餐', path: '/foreignservice', icon: '/icons/ft-person.svg' },
                    { title: '工作签证', description: '为在印度尼西亚的外国工人办理工作签证。', price: 'Rp 750.000', packages: '3个套餐', path: '/foreignservice', icon: '/icons/ft-person.svg' },
                    { title: '投资者签证', description: '为外国资本投资者办理投资者签证。', price: 'Rp 750.000', packages: '3个套餐', path: '/foreignservice', icon: '/icons/ft-person.svg' },
                    { title: '家属签证', description: '为外国工人家庭成员办理签证。', price: 'Rp 750.000', packages: '3个套餐', path: '/foreignservice', icon: '/icons/ft-person.svg' },
                ],
            },
        ],
    }

    const serviceCategories = computed(() => data[locale.value] ?? data.id)

    return { serviceCategories }
}