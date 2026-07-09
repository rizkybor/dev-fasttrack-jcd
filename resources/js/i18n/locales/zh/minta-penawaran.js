export default {
    hero: {
        breadcrumb: '索取报价',
        title: 'Fasttrack报价',
        desc: '快速获取FASTTRACK服务的第一步。',
    },
    pilih_layanan: {
        link: '选择服务',
        kategori_label: '类别',
        kategori_placeholder: '请选择类别',
        layanan_label: '服务',
        layanan_placeholder: '请选择服务',
        detail_label: '服务详情',
        detail_placeholder: '请选择服务详情',
        starting_from: '起价',
        empty_state: '请选择类别、服务及服务详情以查看报价摘要。',
    },
    kategori_options: [
        { value: 'pendirian-badan-usaha', label: '企业设立' },
        { value: 'perizinan', label: '许可证办理' },
        { value: 'keimigrasian', label: '移民事务' },
        { value: 'perpajakan', label: '税务与账务' },
    ],
    layanan_by_kategori: {
        'pendirian-badan-usaha': [
            { value: 'pendirian-pt-perorangan', label: '个人独资PT设立' },
            { value: 'pendirian-pt-pmdn', label: 'PT PMDN设立' },
            { value: 'pendirian-pt-pma', label: 'PT PMA设立' },
            { value: 'pendirian-cv', label: 'CV设立' },
            { value: 'pendirian-yayasan', label: '基金会设立' },
        ],
        perizinan: [
            { value: 'nib', label: '营业识别码（NIB）' },
            { value: 'izin-usaha', label: '营业执照' },
        ],
        keimigrasian: [
            { value: 'kitas', label: 'KITAS居留许可' },
            { value: 'visa-kunjungan', label: '访问签证' },
        ],
        perpajakan: [
            { value: 'pembukuan-bulanan', label: '月度账务' },
            { value: 'lapor-pajak', label: '年度纳税申报' },
        ],
    },
    detail_by_layanan: {
        'pendirian-pt-perorangan': [
            { value: 'standar', label: '个人独资PT设立', harga: 3500000 },
        ],
        'pendirian-pt-pmdn': [
            { value: 'standar', label: 'PT PMDN设立', harga: 5500000 },
        ],
        'pendirian-pt-pma': [
            { value: 'standar', label: 'PT PMA设立', harga: 12000000 },
        ],
        'pendirian-cv': [
            { value: 'standar', label: 'CV设立', harga: 3000000 },
        ],
        'pendirian-yayasan': [
            { value: 'standar', label: '基金会设立', harga: 6000000 },
        ],
        nib: [{ value: 'standar', label: 'NIB办理', harga: 1500000 }],
        'izin-usaha': [{ value: 'standar', label: '营业执照', harga: 2500000 }],
        kitas: [{ value: 'standar', label: 'KITAS居留许可', harga: 8000000 }],
        'visa-kunjungan': [
            { value: 'standar', label: '访问签证', harga: 1200000 },
        ],
        'pembukuan-bulanan': [
            { value: 'standar', label: '月度账务', harga: 1000000 },
        ],
        'lapor-pajak': [
            { value: 'standar', label: '年度纳税申报', harga: 1500000 },
        ],
    },
    biaya: {
        title: '服务费用',
        biaya_label: '服务费',
        ppn_label: '增值税11%',
        subtotal_label: '小计',
        note: '以上价格不含其他费用。完整明细请查看服务详情页面。',
        empty: '请先选择服务以查看费用明细。',
    },
    pemohon: {
        title: '申请人',
        nama_label: '姓名',
        nama_placeholder: '请输入您的全名',
        perusahaan_label: '公司',
        perusahaan_placeholder: '请输入公司名称',
        whatsapp_label: 'WhatsApp号码',
        whatsapp_placeholder: '请输入WhatsApp号码',
        email_label: '邮箱',
        email_placeholder: '请输入邮箱地址',
    },
    captcha_label: '我不是机器人',
    submit_cta: '索取报价',
    info_box: '您的提交将为您在客户仪表板创建账户。登录客户仪表板将通过WhatsApp发送的OTP验证码进行。请确保使用有效的WhatsApp号码。',
    cta: {
        title: '需要更具体的说明？',
        desc: '我们的团队随时准备协助您找到符合企业法律需求的合适解决方案。',
        whatsapp: '直接通过WhatsApp聊天',
    },
}
