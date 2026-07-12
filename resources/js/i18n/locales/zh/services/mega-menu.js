export default {
    categories: [
        {
            title: "印度尼西亚企业设立",
            icon: "building",
            services: [
                {
                    title: "企业设立",
                    path: "/badan-usaha",
                    items: [
                        { label: "个人独资有限公司（PT Perorangan）", path: "/badan-usaha/1" },
                        { label: "设立国内投资公司（PT PMDN）", path: "/badan-usaha/2" },
                        { label: "设立外商投资公司（PT PMA）", path: "/badan-usaha/3" },
                        { label: "设立有限合伙（CV）", path: "/badan-usaha/4" },
                        { label: "设立基金会（Yayasan）", path: "/badan-usaha/5" },
                        { label: "设立合作社（Koperasi）", path: "/badan-usaha/6" },
                        { label: "民事合伙（Persekutuan Perdata）", path: "/badan-usaha/7" },
                        { label: "普通合伙（Firma）", path: "/badan-usaha/8" },
                    ],
                },
            ],
        },
        {
            title: "代表处与境外企业",
            icon: "license",
            services: [
                {
                    title: "代表处",
                    path: "/kantor-perwakilan",
                    items: [
                        { label: "外国公司代表处（KPPA）", path: "/kantor-perwakilan/1" },
                        { label: "外国贸易公司代表处（KP3A）", path: "/kantor-perwakilan/2" },
                        { label: "电子系统贸易代表处（KP3A）", path: "/kantor-perwakilan/3" },
                        { label: "外国建筑服务企业代表处（BUJKA）", path: "/kantor-perwakilan/4" },
                    ],
                },
                {
                    title: "境外企业",
                    path: "/badan-usaha-luar-negeri",
                    items: [
                        { label: "特许经营授权方（特许经营注册证）", path: "/badan-usaha-luar-negeri/1" },
                        { label: "外国电子系统运营商", path: "/badan-usaha-luar-negeri/2" },
                    ],
                },
            ],
        },
        {
            title: "OSS与营业识别号（NIB）",
            icon: "document",
            services: [
                {
                    title: "营业识别号（NIB）注册",
                    path: "/one-single-submission",
                    items: [
                        { label: "个人NIB", path: "/one-single-submission/1" },
                        { label: "NIB——微小企业及非PT主体", path: "/one-single-submission/1" },
                        { label: "NIB——非微小企业（PMDN/PMA）", path: "/one-single-submission/1" },
                        { label: "分公司NIB", path: "/one-single-submission/1" },
                    ],
                },
                {
                    title: "NIB变更/更新",
                    path: "/one-single-submission",
                    items: [
                        { label: "企业主体数据变更", path: "/one-single-submission/2" },
                        { label: "企业数据新增", path: "/one-single-submission/2" },
                        { label: "企业数据注销", path: "/one-single-submission/2" },
                        { label: "OSS问题与故障处理", path: "/one-single-submission/2" },
                    ],
                },
            ],
        },
        {
            title: "基础许可与经营许可",
            icon: "document-check",
            services: [
                {
                    title: "基础许可",
                    path: "/perizinan-berusaha",
                    items: [
                        { label: "空间利用活动符合性（KKPR）", path: "/perizinan-berusaha/1" },
                        { label: "环境许可", path: "/perizinan-berusaha/1" },
                        { label: "建筑物批准（PBG）", path: "/perizinan-berusaha/1" },
                        { label: "使用功能合格证（SLF）", path: "/perizinan-berusaha/4" },
                    ],
                },
                {
                    title: "经营许可",
                    path: "/perizinan-berusaha",
                    items: [
                        { label: "国内私营电子系统注册", path: "/perizinan-berusaha/2" },
                        { label: "使用手册与保修卡登记", path: "/perizinan-berusaha/2" },
                        { label: "仓库登记证", path: "/perizinan-berusaha/2" },
                    ],
                },
                {
                    title: "其他许可",
                    path: "/perizinan-berusaha",
                    items: [
                        { label: "纳税人识别号（NPWP）", path: "/perizinan-berusaha/3" },
                        { label: "增值税纳税人确认函（SP PKP）", path: "/perizinan-berusaha/3" },
                        { label: "社会福利机构登记（LKS）", path: "/perizinan-berusaha/3" },
                        { label: "地方社会福利机构活动许可——雅加达特区", path: "/perizinan-berusaha/3" },
                        { label: "基金会注册证", path: "/perizinan-berusaha/3" },
                        { label: "公司规章制度", path: "/perizinan-berusaha/3" },
                    ],
                },
            ],
        },
        {
            title: "公证——企业/个人契据",
            icon: "doc-stack",
            services: [
                {
                    title: "公证书——有限责任公司（PT）",
                    path: "/notaris-virtual-dan-akta",
                    items: [
                        { label: "公司章程变更", path: "/notaris-virtual-dan-akta/1" },
                        { label: "公司数据变更", path: "/notaris-virtual-dan-akta/2" },
                        { label: "年度股东大会", path: "/notaris-virtual-dan-akta/3" },
                    ],
                },
                {
                    title: "其他契据",
                    path: "/notaris-virtual-dan-akta",
                    items: [
                        { label: "分公司契据", path: "/notaris-virtual-dan-akta/4" },
                        { label: "股份买卖契据", path: "/notaris-virtual-dan-akta/4" },
                        { label: "收购契据", path: "/notaris-virtual-dan-akta/4" },
                        { label: "合并契据", path: "/notaris-virtual-dan-akta/4" },
                        { label: "授权委托契据", path: "/notaris-virtual-dan-akta/4" },
                        { label: "婚前财产分割协议", path: "/notaris-virtual-dan-akta/4" },
                        { label: "婚后财产分割协议", path: "/notaris-virtual-dan-akta/4" },
                    ],
                },
                {
                    title: "其他公证服务",
                    path: "/notaris-virtual-dan-akta",
                    items: [
                        { label: "存证公证（Waarmerking）", path: "/notaris-virtual-dan-akta/4" },
                        { label: "文件认证", path: "/notaris-virtual-dan-akta/4" },
                        { label: "合法化认证", path: "/notaris-virtual-dan-akta/4" },
                        { label: "司法部公司完整档案", path: "/notaris-virtual-dan-akta/4" },
                    ],
                },
            ],
        },
        {
            title: "企业法律服务",
            icon: "globe",
            services: [
                {
                    title: "有限责任公司重组",
                    path: "/restrukturisasi-perseroan-terbatas",
                    items: [
                        { label: "公司收购", path: "/restrukturisasi-perseroan-terbatas/1" },
                        { label: "公司合并", path: "/restrukturisasi-perseroan-terbatas/2" },
                        { label: "公司性质变更", path: "/restrukturisasi-perseroan-terbatas/3" },
                    ],
                },
                {
                    title: "合同起草与审查",
                    path: "/restrukturisasi-perseroan-terbatas",
                    items: [
                        { label: "协议/合同", path: "/restrukturisasi-perseroan-terbatas/2" },
                    ],
                },
                {
                    title: "常年法律顾问/订阅服务",
                    path: "/retainer-berlangganan/1",
                    items: [
                        { label: "常规套餐", path: "/retainer-berlangganan/1" },
                        { label: "企业秘书订阅服务", path: "/retainer-berlangganan/1" },
                    ],
                },
                {
                    title: "法律尽职调查",
                    path: "/uji-tuntas-hukum/1",
                    items: [],
                },
            ],
        },
        {
            title: "企业解散",
            icon: "pin",
            services: [
                {
                    title: "公司解散/企业注销",
                    path: "/penutupan-badan-usaha",
                    items: [
                        { label: "公司解散——PMDN/PMA", path: "/penutupan-badan-usaha/1" },
                        { label: "CV注销", path: "/penutupan-badan-usaha/2" },
                        { label: "代表处注销", path: "/penutupan-badan-usaha/3" },
                    ],
                },
            ],
        },
        {
            title: "认证、海牙认证与翻译",
            icon: "grid",
            services: [
                {
                    title: "宣誓翻译",
                    path: "/penerjemah/1",
                    items: [],
                },
                {
                    title: "使馆认证/海牙认证",
                    path: "/legalisasi-kedutaan",
                    items: [
                        { label: "使馆认证", path: "/legalisasi-kedutaan/1" },
                        { label: "海牙认证（Apostille）", path: "/legalisasi-kedutaan/2" },
                    ],
                },
            ],
        },
        {
            title: "知识产权",
            icon: "grid",
            services: [
                {
                    title: "知识产权",
                    path: "/kekayaan-intelektual",
                    items: [
                        { label: "商标注册", path: "/kekayaan-intelektual/1" },
                        { label: "商标续展", path: "/kekayaan-intelektual/2" },
                        { label: "著作权", path: "/kekayaan-intelektual/3" },
                    ],
                },
            ],
        },
    ],
    tools: [
        {
            title: "查询PT公司名称可用性",
            path: "/",
            icon: "/icons/ic-tools-sedianamapt.svg",
            items: [],
        },
        {
            title: "2025年KBLI指南",
            path: "/panduan-kbli",
            icon: "/icons/ic-tools-panduankbli.svg",
            items: [],
        },
        {
            title: "2020与2025年KBLI对照表",
            path: "/konversi-kbli",
            icon: "/icons/ic-tools-tablekonversi.svg",
            desc: "",
        },
        {
            title: "设立契据模拟",
            path: "",
            icon: "/icons/ic-tools-simulasiakta.svg",
            desc: "",
        },
        {
            title: "名称生成器",
            path: "/",
            icon: "/icons/ic-tools-gennama.svg",
            items: [],
        },
    ],
};
