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
        {
            value: 'pendirian-badan-usaha',
            label: '印尼企业设立',
        },
        {
            value: 'kantor-perwakilan-asing',
            label: '代表处与外国企业实体',
        },
        {
            value: 'oss-nib',
            label: 'OSS 与营业识别号（NIB）',
        },
        {
            value: 'perizinan',
            label: '基础许可与营业许可',
        },
        {
            value: 'notaris-akta',
            label: '公证 - 公司/个人文书',
        },
        {
            value: 'hukum-korporasi',
            label: '公司法律服务',
        },
        {
            value: 'penutupan-badan-usaha',
            label: '企业解散',
        },
        {
            value: 'legalisasi-terjemahan',
            label: '认证、海牙认证与翻译',
        },
        {
            value: 'kekayaan-intelektual',
            label: '知识产权',
        },
        {
            value: 'keimigrasian-visa',
            label: '移民与签证',
        },
        {
            value: 'perpajakan-kepatuhan',
            label: '税务与企业合规',
        },
        {
            value: 'sertifikasi-lainnya',
            label: '认证与其他服务',
        },
    ],
    layanan_by_kategori: {
        'pendirian-badan-usaha': [
            {
                value: 'badan-usaha',
                label: '企业实体',
            },
        ],
        'kantor-perwakilan-asing': [
            {
                value: 'kantor-perwakilan',
                label: '代表处',
            },
            {
                value: 'badan-usaha-luar-negeri',
                label: '境外企业实体',
            },
        ],
        'oss-nib': [
            {
                value: 'oss-nib-layanan',
                label: 'NIB 注册与变更',
            },
        ],
        perizinan: [
            {
                value: 'perizinan-berusaha',
                label: '营业许可',
            },
            {
                value: 'perizinan-lainnya',
                label: '其他许可',
            },
        ],
        'notaris-akta': [
            {
                value: 'notaris-akta-layanan',
                label: '公证文书',
            },
        ],
        'hukum-korporasi': [
            {
                value: 'restrukturisasi-pt',
                label: '有限责任公司重组',
            },
            {
                value: 'penyusunan-perjanjian',
                label: '合同起草与审查',
            },
            {
                value: 'retainer-berlangganan',
                label: '常年顾问/订阅服务',
            },
            {
                value: 'uji-tuntas-hukum',
                label: '法律尽职调查',
            },
        ],
        'penutupan-badan-usaha': [
            {
                value: 'penutupan-badan-usaha-layanan',
                label: '企业解散/关闭',
            },
        ],
        'legalisasi-terjemahan': [
            {
                value: 'legalisasi-apostille',
                label: '使馆认证/海牙认证',
            },
            {
                value: 'penerjemah',
                label: '翻译',
            },
        ],
        'kekayaan-intelektual': [
            {
                value: 'kekayaan-intelektual-layanan',
                label: '知识产权服务',
            },
        ],
        'keimigrasian-visa': [
            {
                value: 'visa-indonesia',
                label: '印尼签证',
            },
            {
                value: 'visa-mancanegara',
                label: '他国签证',
            },
            {
                value: 'izin-tinggal-terbatas',
                label: '临时居留许可（ITAS）',
            },
            {
                value: 'izin-tinggal-tetap',
                label: '永久居留许可（ITAP）',
            },
            {
                value: 'keimigrasian-wni-wna',
                label: '印尼籍/外籍移民事务',
            },
            {
                value: 'naturalisasi',
                label: '入籍',
            },
        ],
        'perpajakan-kepatuhan': [
            {
                value: 'perpajakan-pembukuan',
                label: '税务与账务',
            },
            {
                value: 'kewajiban-pelaporan',
                label: '企业报告义务',
            },
        ],
        'sertifikasi-lainnya': [
            {
                value: 'sertifikasi-badan-usaha',
                label: '企业认证',
            },
            {
                value: 'digital-marketing',
                label: '数字营销与设计',
            },
            {
                value: 'virtual-office',
                label: '虚拟办公室',
            },
        ],
    },
    detail_by_layanan: {
        'badan-usaha': [
            {
                value: 'pt-perorangan',
                label: 'PT Perorangan',
                harga: 750000,
            },
            {
                value: 'pt-pmdn',
                label: '设立印尼国内投资公司（PT PMDN）',
                harga: 3250000,
            },
            {
                value: 'pt-pma',
                label: '设立外商投资有限公司（PT PMA）',
                harga: 17250000,
            },
            {
                value: 'cv',
                label: '设立有限合伙公司（CV）',
                harga: 2750000,
            },
            {
                value: 'yayasan',
                label: '设立基金会（Yayasan）',
                harga: 3250000,
            },
            {
                value: 'koperasi',
                label: '设立合作社（Koperasi）',
                harga: 9750000,
            },
            {
                value: 'persekutuan-perdata',
                label: '民事合伙（Persekutuan Perdata）',
                harga: 2750000,
            },
            {
                value: 'persekutuan-firma',
                label: '普通合伙（Firma）',
                harga: 2750000,
            },
        ],
        'kantor-perwakilan': [
            {
                value: 'kppa',
                label: '外国公司代表处（KPPA）',
                harga: 4500000,
            },
            {
                value: 'kp3a-perdagangan',
                label: '外国贸易公司代表处（KP3A）',
                harga: 4500000,
            },
            {
                value: 'kp3a-pmse',
                label: '电子系统贸易KP3A（PMSE领域代表处）',
                harga: 3500000,
            },
            {
                value: 'bujka',
                label: '外国建筑服务企业代表处（BUJKA）',
                harga: 3500000,
            },
        ],
        'badan-usaha-luar-negeri': [
            {
                value: 'pemberi-waralaba',
                label: '特许经营授权方（特许经营注册证书）',
                harga: 9000000,
            },
            {
                value: 'pse-asing',
                label: '外国电子系统提供者',
                harga: 3500000,
            },
        ],
        'oss-nib-layanan': [
            {
                value: 'pendaftaran-nib',
                label: '营业执照号码（NIB）注册',
                harga: 1000000,
            },
            {
                value: 'perubahan-nib',
                label: 'NIB变更/更新',
                harga: 1000000,
            },
        ],
        'perizinan-berusaha': [
            {
                value: 'perizinan-dasar',
                label: '基础许可',
                harga: null,
            },
            {
                value: 'sertifikat-standar',
                label: '营业许可（标准证书/许可证）',
                harga: null,
            },
            {
                value: 'pb-umku',
                label: '支持经营活动的营业许可（PB UMKU）',
                harga: 2000000,
            },
        ],
        'perizinan-lainnya': [
            {
                value: 'npwp',
                label: '纳税人识别号（NPWP）',
                harga: 1250000,
            },
            {
                value: 'sp-pkp',
                label: '应税企业家确认函（SP PKP）',
                harga: 1750000,
            },
            {
                value: 'lks',
                label: '社会福利机构注册证书（LKS）',
                harga: null,
            },
            {
                value: 'izin-lks-dki',
                label: '地区/地方LKS活动许可证——雅加达首都特区',
                harga: null,
            },
            {
                value: 'daftar-yayasan',
                label: '基金会注册证书',
                harga: null,
            },
            {
                value: 'peraturan-perusahaan',
                label: '公司规章制度',
                harga: null,
            },
        ],
        'notaris-akta-layanan': [
            {
                value: 'perubahan-anggaran-dasar',
                label: '公司章程修订案',
                harga: 3500000,
            },
            {
                value: 'perubahan-data-perseroan',
                label: '公司数据变更',
                harga: 1750000,
            },
            {
                value: 'rups-tahunan',
                label: '年度股东大会',
                harga: 3000000,
            },
            {
                value: 'akta-lainnya',
                label: '其他公证文书',
                harga: 750000,
            },
        ],
        'restrukturisasi-pt': [
            {
                value: 'akuisisi',
                label: '公司收购（并购接管）',
                harga: 9000000,
            },
            {
                value: 'merger',
                label: '公司合并（Merger）',
                harga: 9000000,
            },
            {
                value: 'alih-status',
                label: '公司地位转换',
                harga: 9000000,
            },
        ],
        'penyusunan-perjanjian': [
            {
                value: 'penyusunan-kontrak',
                label: '合同/协议的起草与审查',
                harga: 500000,
            },
        ],
        'retainer-berlangganan': [
            {
                value: 'retainer',
                label: '常年顾问/订阅服务',
                harga: 2000000,
            },
        ],
        'uji-tuntas-hukum': [
            {
                value: 'uji-tuntas',
                label: '法律尽职调查',
                harga: null,
            },
        ],
        'penutupan-badan-usaha-layanan': [
            {
                value: 'pembubaran-pt',
                label: '公司解散',
                harga: 12000000,
            },
            {
                value: 'penutupan-cv',
                label: 'CV关闭',
                harga: 7000000,
            },
            {
                value: 'penutupan-kantor-perwakilan',
                label: '代表处关闭',
                harga: 3000000,
            },
        ],
        'legalisasi-apostille': [
            {
                value: 'legalisasi-kedutaan',
                label: '使馆认证',
                harga: 4500000,
            },
            {
                value: 'apostille',
                label: '海牙认证（Apostille）',
                harga: null,
            },
        ],
        penerjemah: [
            {
                value: 'penerjemah-tersumpah',
                label: '宣誓翻译（Sworn Translator）',
                harga: 50000,
            },
        ],
        'kekayaan-intelektual-layanan': [
            {
                value: 'merek',
                label: '商标注册',
                harga: 3000000,
            },
            {
                value: 'perpanjangan-merek',
                label: '商标续展',
                harga: 3000000,
            },
            {
                value: 'hak-cipta',
                label: '著作权',
                harga: 3000000,
            },
        ],
        'visa-indonesia': [
            {
                value: 'visa-kunjungan-1x',
                label: '单次入境访问签证',
                harga: 2000000,
            },
            {
                value: 'visa-kunjungan-multi',
                label: '多次入境访问签证',
                harga: 3500000,
            },
            {
                value: 'visa-investor',
                label: '投资者签证',
                harga: 12750000,
            },
            {
                value: 'visa-keluarga',
                label: '家庭签证',
                harga: 9050000,
            },
            {
                value: 'visa-repatriasi',
                label: '前印尼籍人士及其后裔遣返签证',
                harga: 12750000,
            },
            {
                value: 'visa-rumah-kedua',
                label: '第二居所签证',
                harga: 19750000,
            },
        ],
        'visa-mancanegara': [
            {
                value: 'visa-china',
                label: '中国签证',
                harga: 1000000,
            },
            {
                value: 'visa-usa',
                label: '美利坚合众国签证',
                harga: 1000000,
            },
            {
                value: 'visa-uea',
                label: '阿拉伯联合酋长国签证',
                harga: 1000000,
            },
            {
                value: 'visa-australia',
                label: '澳大利亚签证',
                harga: 1000000,
            },
            {
                value: 'visa-taiwan',
                label: '台湾签证',
                harga: 1000000,
            },
            {
                value: 'visa-korsel',
                label: '韩国签证',
                harga: 1000000,
            },
            {
                value: 'visa-india',
                label: '印度签证',
                harga: 1000000,
            },
            {
                value: 'visa-uk',
                label: '英国签证',
                harga: 1000000,
            },
            {
                value: 'visa-afsel',
                label: '南非签证',
                harga: 1000000,
            },
            {
                value: 'visa-schengen-jerman',
                label: '申根签证-德国',
                harga: 1000000,
            },
            {
                value: 'visa-schengen-italia',
                label: '申根签证-意大利',
                harga: 1000000,
            },
            {
                value: 'visa-schengen-selandia-baru',
                label: '申根签证-新西兰',
                harga: 1000000,
            },
            {
                value: 'visa-schengen-swedia',
                label: '申根签证-瑞典',
                harga: 1000000,
            },
            {
                value: 'visa-jepang',
                label: '日本签证',
                harga: 1000000,
            },
        ],
        'izin-tinggal-terbatas': [
            {
                value: 'itas-kerja-tka',
                label: '外籍劳工居留及工作许可',
                harga: 9050000,
            },
            {
                value: 'itas-keluarga-tka',
                label: '外籍劳工家属居留许可',
                harga: 9050000,
            },
            {
                value: 'itas-investor',
                label: '投资者临时居留许可',
                harga: 4500000,
            },
            {
                value: 'itas-lansia',
                label: '老年人临时居留许可',
                harga: 3500000,
            },
        ],
        'izin-tinggal-tetap': [
            {
                value: 'itap-sponsor-perusahaan',
                label: '由公司担保的临时居留许可转永久居留许可地位转换',
                harga: 4500000,
            },
            {
                value: 'itap-sponsor-pasangan',
                label: '由印尼籍配偶担保的临时居留许可转永久居留许可地位转换',
                harga: 3500000,
            },
        ],
        'keimigrasian-wni-wna': [
            {
                value: 'e-paspor',
                label: '印度尼西亚共和国电子护照',
                harga: 3150000,
            },
            {
                value: 'mutasi-alamat',
                label: '地址变更',
                harga: 1750000,
            },
            {
                value: 'mutasi-paspor-itas',
                label: 'ITAS持有人护照变更',
                harga: 1750000,
            },
            {
                value: 'epo',
                label: '单次出境许可（EPO）',
                harga: 4000000,
            },
            {
                value: 'tsp',
                label: '出境居留许可终止（TSP）',
                harga: 3750000,
            },
        ],
        naturalisasi: [
            {
                value: 'naturalisasi',
                label: '入籍（国籍变更）',
                harga: null,
            },
        ],
        'perpajakan-pembukuan': [
            {
                value: 'akuntansi-pajak',
                label: '会计与税务申报',
                harga: 4000000,
            },
            {
                value: 'lapor-spt-pribadi',
                label: '个人纳税申报表（SPT）申报服务',
                harga: 2500000,
            },
            {
                value: 'lapor-spt-badan',
                label: '企业纳税申报表（SPT）申报服务',
                harga: 4500000,
            },
        ],
        'kewajiban-pelaporan': [
            {
                value: 'lkpm',
                label: '投资活动报告（LKPM）',
                harga: 1000000,
            },
            {
                value: 'siinas',
                label: '工业报告（SIINAS）',
                harga: 1750000,
            },
            {
                value: 'wajib-lapor-ketenagakerjaan',
                label: '企业强制劳动报告',
                harga: 1500000,
            },
            {
                value: 'wajib-lapor-fasilitas-kesejahteraan',
                label: '员工福利设施强制报告',
                harga: 2000000,
            },
        ],
        'sertifikasi-badan-usaha': [
            {
                value: 'sbu-jasa-konstruksi',
                label: '建筑服务企业认证',
                harga: 2500000,
            },
        ],
        'digital-marketing': [
            {
                value: 'design',
                label: '设计',
                harga: 9000000,
            },
            {
                value: 'digital-marketing',
                label: '数字营销',
                harga: 3500000,
            },
        ],
        'virtual-office': [
            {
                value: 'virtual-office',
                label: '虚拟办公室',
                harga: 2000000,
            },
        ],
    },
    biaya: {
        title: '服务费用',
        biaya_label: '服务费',
        ppn_label: '增值税11%',
        subtotal_label: '小计',
        note: '以上价格不含其他费用。完整明细请查看服务详情页面。',
        empty: '请先选择服务以查看费用明细。',
        hubungi_kami: '请联系我们',
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
    submit_cta: '索取报价',
    submitting: '发送中...',
    info_box: '您的提交将为您在客户仪表板创建账户。登录客户仪表板将通过WhatsApp发送的OTP验证码进行。请确保使用有效的WhatsApp号码。',
    errors: {
        kategori_required: '请先选择类别、服务及服务详情。',
        nama_required: '请填写姓名。',
        email_required: '请填写电子邮件地址。',
        email_invalid: '电子邮件地址格式无效。',
        whatsapp_required: '请填写 WhatsApp 号码。',
        whatsapp_invalid: 'WhatsApp 号码必须为数字，长度在 10 到 13 位之间。',
    },
    close: '关闭',
    submit_success_title: '发送成功！',
    submit_success: '您的报价请求已成功发送。我们的团队将尽快与您联系。',
    submit_error: '报价请求发送失败，请重试。',
    cta: {
        title: '需要更具体的说明？',
        desc: '我们的团队随时准备协助您找到符合企业法律需求的合适解决方案。',
        whatsapp: '直接通过WhatsApp聊天',
    },
}
