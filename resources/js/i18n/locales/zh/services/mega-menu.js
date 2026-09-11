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
                        { label: "个人独资有限公司（PT Perorangan）", path: "/badan-usaha/pt-perorangan" },
                        { label: "设立国内投资公司（PT PMDN）", path: "/badan-usaha/pendirian-pt-pmdn" },
                        { label: "设立外商投资公司（PT PMA）", path: "/badan-usaha/pt-pendirian-pma" },
                        { label: "设立有限合伙（CV）", path: "/badan-usaha/pendirian-cv" },
                        { label: "设立基金会（Yayasan）", path: "/badan-usaha/pendirian-yayasan" },
                        { label: "设立合作社（Koperasi）", path: "/badan-usaha/pendirian-koperasi" },
                        { label: "民事合伙（Persekutuan Perdata）", path: "/badan-usaha/persekutuan-perdata" },
                        { label: "普通合伙（Firma）", path: "/badan-usaha/persekutuan-firma" },
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
                        { label: "外国公司代表处（KPPA）", path: "/kantor-perwakilan/kantor-perwakilan-perusahaan-asing-kppa" },
                        { label: "外国贸易公司代表处（KP3A）", path: "/kantor-perwakilan/kantor-perwakilan-perusahaan-perdagangan-asing" },
                        { label: "电子系统贸易代表处（KP3A）", path: "/kantor-perwakilan/kp3a-perdagangan-melalui-sistem-elektronik" },
                        { label: "外国建筑服务企业代表处（BUJKA）", path: "/kantor-perwakilan/kantor-perwakilan-badan-usaha-jasa-konstruksi-asing" },
                    ],
                },
                {
                    title: "境外企业",
                    path: "/badan-usaha-luar-negeri",
                    items: [
                        { label: "特许经营授权方（特许经营注册证）", path: "/badan-usaha-luar-negeri/pemberi-waralaba-surat-tanda-pendaftaran-waralaba" },
                        { label: "外国电子系统运营商", path: "/badan-usaha-luar-negeri/penyelenggara-sistem-elektronik-asing" },
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
                        { label: "个人NIB", path: "/one-single-submission/pendaftaran-nomor-induk-berusaha-nib" },
                        { label: "NIB——微小企业及非PT主体", path: "/one-single-submission/pendaftaran-nomor-induk-berusaha-nib" },
                        { label: "NIB——非微小企业（PMDN/PMA）", path: "/one-single-submission/pendaftaran-nomor-induk-berusaha-nib" },
                        { label: "分公司NIB", path: "/one-single-submission/pendaftaran-nomor-induk-berusaha-nib" },
                    ],
                },
                {
                    title: "NIB变更/更新",
                    path: "/one-single-submission",
                    items: [
                        { label: "企业主体数据变更", path: "/one-single-submission/perubahan-pemutakhiran-nib" },
                        { label: "企业数据新增", path: "/one-single-submission/perubahan-pemutakhiran-nib" },
                        { label: "企业数据注销", path: "/one-single-submission/perubahan-pemutakhiran-nib" },
                        { label: "OSS问题与故障处理", path: "/one-single-submission/perubahan-pemutakhiran-nib" },
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
                        { label: "空间利用活动符合性（KKPR）", path: "/perizinan-berusaha/perizinan-dasar" },
                        { label: "环境许可", path: "/perizinan-berusaha/perizinan-dasar" },
                        { label: "建筑物批准（PBG）", path: "/perizinan-berusaha/perizinan-dasar" },
                        { label: "使用功能合格证（SLF）", path: "/perizinan-berusaha/perizinan-dasar" },
                    ],
                },
                {
                    title: "经营许可",
                    path: "/perizinan-berusaha",
                    items: [
                        { label: "国内私营电子系统注册", path: "/perizinan-berusaha/perizinan-berusaha-sertifikat-standar-izin" },
                        { label: "使用手册与保修卡登记", path: "/perizinan-berusaha/perizinan-berusaha-sertifikat-standar-izin" },
                        { label: "仓库登记证", path: "/perizinan-berusaha/perizinan-berusaha-sertifikat-standar-izin" },
                    ],
                },
                {
                    title: "其他许可",
                    path: "/perizinan-berusaha",
                    items: [
                        { label: "纳税人识别号（NPWP）", path: "/perizinan-berusaha/perizinan-berusaha-untuk-menunjang-kegiatan-usaha-pb-umku" },
                        { label: "增值税纳税人确认函（SP PKP）", path: "/perizinan-berusaha/perizinan-berusaha-untuk-menunjang-kegiatan-usaha-pb-umku" },
                        { label: "社会福利机构登记（LKS）", path: "/perizinan-berusaha/perizinan-berusaha-untuk-menunjang-kegiatan-usaha-pb-umku" },
                        { label: "地方社会福利机构活动许可——雅加达特区", path: "/perizinan-berusaha/perizinan-berusaha-untuk-menunjang-kegiatan-usaha-pb-umku" },
                        { label: "基金会注册证", path: "/perizinan-berusaha/perizinan-berusaha-untuk-menunjang-kegiatan-usaha-pb-umku" },
                        { label: "公司规章制度", path: "/perizinan-berusaha/perizinan-berusaha-untuk-menunjang-kegiatan-usaha-pb-umku" },
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
                        { label: "公司章程变更", path: "/notaris-virtual-dan-akta/perubahan-anggaran-dasar-perseroan" },
                        { label: "公司数据变更", path: "/notaris-virtual-dan-akta/perubahan-data-perseroan" },
                        { label: "年度股东大会", path: "/notaris-virtual-dan-akta/rapat-umum-pemegang-saham-tahunan" },
                    ],
                },
                {
                    title: "其他契据",
                    path: "/notaris-virtual-dan-akta",
                    items: [
                        { label: "分公司契据", path: "/notaris-virtual-dan-akta/akta-notaris-lainnya" },
                        { label: "股份买卖契据", path: "/notaris-virtual-dan-akta/akta-notaris-lainnya" },
                        { label: "收购契据", path: "/notaris-virtual-dan-akta/akta-notaris-lainnya" },
                        { label: "合并契据", path: "/notaris-virtual-dan-akta/akta-notaris-lainnya" },
                        { label: "授权委托契据", path: "/notaris-virtual-dan-akta/akta-notaris-lainnya" },
                        { label: "婚前财产分割协议", path: "/notaris-virtual-dan-akta/akta-notaris-lainnya" },
                        { label: "婚后财产分割协议", path: "/notaris-virtual-dan-akta/akta-notaris-lainnya" },
                    ],
                },
                {
                    title: "其他公证服务",
                    path: "/notaris-virtual-dan-akta",
                    items: [
                        { label: "存证公证（Waarmerking）", path: "/notaris-virtual-dan-akta/akta-notaris-lainnya" },
                        { label: "文件认证", path: "/notaris-virtual-dan-akta/akta-notaris-lainnya" },
                        { label: "合法化认证", path: "/notaris-virtual-dan-akta/akta-notaris-lainnya" },
                        { label: "司法部公司完整档案", path: "/notaris-virtual-dan-akta/akta-notaris-lainnya" },
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
                        { label: "公司收购", path: "/restrukturisasi-perseroan-terbatas/pengambilalihan-perseroan-akuisisi" },
                        { label: "公司合并", path: "/restrukturisasi-perseroan-terbatas/penggabungan-perseroan-merger" },
                        { label: "公司性质变更", path: "/restrukturisasi-perseroan-terbatas/alih-status-perseroan" },
                    ],
                },
                {
                    title: "合同起草与审查",
                    path: "/restrukturisasi-perseroan-terbatas",
                    items: [
                        { label: "协议/合同", path: "/restrukturisasi-perseroan-terbatas/penggabungan-perseroan-merger" },
                    ],
                },
                {
                    title: "常年法律顾问/订阅服务",
                    path: "/retainer-berlangganan/retainer-berlangganan",
                    items: [
                        { label: "常规套餐", path: "/retainer-berlangganan/retainer-berlangganan" },
                        { label: "企业秘书订阅服务", path: "/retainer-berlangganan/retainer-berlangganan" },
                    ],
                },
                {
                    title: "法律尽职调查",
                    path: "/uji-tuntas-hukum/uji-tuntas-hukum",
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
                        { label: "公司解散——PMDN/PMA", path: "/penutupan-badan-usaha/pembubaran-perseroan" },
                        { label: "CV注销", path: "/penutupan-badan-usaha/penutupan-cv" },
                        { label: "代表处注销", path: "/penutupan-badan-usaha/penutupan-kantor-perwakilan" },
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
                    path: "/penerjemah/penerjemah-tersumpah-sworn-translator",
                    items: [],
                },
                {
                    title: "使馆认证/海牙认证",
                    path: "/legalisasi-kedutaan",
                    items: [
                        { label: "使馆认证", path: "/legalisasi-kedutaan/legalisasi-kedutaan" },
                        { label: "海牙认证（Apostille）", path: "/legalisasi-kedutaan/apostille" },
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
                        { label: "商标注册", path: "/kekayaan-intelektual/pendaftaran-merek" },
                        { label: "商标续展", path: "/kekayaan-intelektual/perpanjangan-merek" },
                        { label: "著作权", path: "/kekayaan-intelektual/hak-cipta" },
                    ],
                },
            ],
        },
        {
            title: "外籍人士与移民服务",
            icon: "shield",
            services: [
                {
                    title: "临时居留许可（ITAS）",
                    path: "/izin-tinggal-terbatas",
                    items: [
                        { label: "外籍劳工居留及工作许可", path: "/izin-tinggal-terbatas/izin-tinggal-kerja-tenaga-kerja-asing" },
                        { label: "外籍劳工家属居留许可", path: "/izin-tinggal-terbatas/izin-tinggal-keluarga-tenaga-kerja-asing" },
                        { label: "投资者临时居留许可", path: "/izin-tinggal-terbatas/izin-tinggal-terbatas-investor" },
                        { label: "老年人临时居留许可", path: "/izin-tinggal-terbatas/izin-tinggal-terbatas-lansia" },
                    ],
                },
                {
                    title: "永久居留许可（ITAP）",
                    path: "/izin-tinggal-tetap",
                    items: [
                        { label: "由公司担保的临时居留许可转永久居留许可地位转换", path: "/izin-tinggal-tetap/itap-sponsor-perusahaan" },
                        { label: "由印尼籍配偶担保的临时居留许可转永久居留许可地位转换", path: "/izin-tinggal-tetap/itap-sponsor-suami-istri-wni" },
                    ],
                },
                {
                    title: "印尼籍与外籍人士移民服务",
                    path: "/keimigrasian-wni-wna",
                    items: [
                        { label: "印度尼西亚共和国电子护照", path: "/keimigrasian-wni-wna/e-paspor-republik-indonesia" },
                        { label: "地址变更", path: "/keimigrasian-wni-wna/mutasi-alamat" },
                        { label: "ITAS持有人护照变更", path: "/keimigrasian-wni-wna/mutasi-paspor-pemegang-itas" },
                        { label: "单次出境许可（EPO）", path: "/keimigrasian-wni-wna/exit-permit-only-epo" },
                        { label: "出境居留许可终止（TSP）", path: "/keimigrasian-wni-wna/exit-termination-of-stay-permit-tsp" },
                    ],
                },
                {
                    title: "印度尼西亚签证",
                    path: "/visa-indonesia",
                    items: [
                        { label: "单次入境访问签证", path: "/visa-indonesia/visa-kunjungan-satu-kali-perjalanan" },
                        { label: "多次入境访问签证", path: "/visa-indonesia/visa-kunjungan-beberapa-kali-perjalanan" },
                        { label: "投资者签证", path: "/visa-indonesia/visa-investor" },
                        { label: "家庭签证", path: "/visa-indonesia/visa-keluarga" },
                        { label: "前印尼籍人士及其后裔遣返签证", path: "/visa-indonesia/visa-repatriasi-dan-keturunan-ex-wni" },
                        { label: "第二居所签证", path: "/visa-indonesia/visa-rumah-kedua" },
                    ],
                },
                {
                    title: "境外签证",
                    path: "/visa-mancanegara",
                    items: [
                        { label: "中国签证", path: "/visa-mancanegara/visa-china" },
                        { label: "美利坚合众国签证", path: "/visa-mancanegara/visa-united-state-of-america" },
                        { label: "阿拉伯联合酋长国签证", path: "/visa-mancanegara/visa-uni-emirat-arab" },
                        { label: "澳大利亚签证", path: "/visa-mancanegara/visa-australia" },
                        { label: "台湾签证", path: "/visa-mancanegara/visa-taiwan" },
                        { label: "韩国签证", path: "/visa-mancanegara/visa-korea-selatan" },
                        { label: "印度签证", path: "/visa-mancanegara/visa-india" },
                        { label: "英国签证", path: "/visa-mancanegara/visa-united-kingdom-inggris" },
                        { label: "南非签证", path: "/visa-mancanegara/visa-afrika-selatan" },
                        { label: "申根签证-德国", path: "/visa-mancanegara/visa-schengen-germany" },
                        { label: "申根签证-意大利", path: "/visa-mancanegara/visa-schengen-italy" },
                        { label: "申根签证-新西兰", path: "/visa-mancanegara/visa-schengen-new-zealand" },
                        { label: "申根签证-瑞典", path: "/visa-mancanegara/visa-schengen-sweden" },
                        { label: "日本签证", path: "/visa-mancanegara/visa-jepang" },
                    ],
                },
                {
                    title: "入籍",
                    path: "/naturalisasi/naturalisasi-alih-kewarganegaraan",
                    items: [],
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
            path: "/simulasi-akta",
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
