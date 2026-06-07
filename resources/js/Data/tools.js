import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

// Meta yang tidak perlu ditranslasi
const toolsMeta = [
    { id: 'cek-nama-pt',     bg: '#D6F8E6', iconColor: '#22C55E', icon: '/icons/ic-tools-sedianamapt.svg', url: null },
    { id: 'panduan-kbli',    bg: '#FFF6D0', iconColor: '#EAB308', icon: '/icons/ic-tools-panduankbli.svg',  url: '/panduan-kbli' },
    { id: 'tabel-konversi',  bg: '#A8BDED', iconColor: '#3B82F6', icon: '/icons/ic-tools-tablekonversi.svg', url: '/konversi-kbli' },
    { id: 'simulasi-akta',   bg: '#FFD4AE', iconColor: '#F97316', icon: '/icons/ic-tools-simulasiakta.svg', url: '/simulasi-akta' },
    { id: 'generator-nama',  bg: '#CAF6FF', iconColor: '#06B6D4', icon: '/icons/ic-tools-gennama.svg',      url: null },
]

const data = {
    id: [
        { title: 'Cek Ketersediaan Nama PT',            description: 'Cek ketersediaan nama PT Anda sebelum mendaftar ke AHU Kemenkum RI.',                              cta: 'Cek Nama PT' },
        { title: 'Panduan KBLI 2025',                   description: 'Temukan kode KBLI yang tepat untuk bidang usaha Anda berdasarkan data terbaru 2025.',               cta: 'Lihat Panduan' },
        { title: 'Tabel Konversi KBLI 2020 x KBLI 2025', description: 'Konversi kode KBLI lama ke format terbaru 2025.',                                                 cta: 'Buka Tabel' },
        { title: 'Simulasi AKTA Pendirian',             description: 'Simulasikan dokumen akta pendirian Perseroan Terbatas sebelum proses resmi dimulai.',               cta: 'Mulai Simulasi' },
        { title: 'Generator Nama',                      description: 'Kesulitan menemukan nama Perusahaan untuk PT yang mau kamu buat?',                                  cta: 'Generate Sekarang' },
    ],
    en: [
        { title: 'Check PT Name Availability',          description: 'Check your PT name availability before registering with AHU Ministry of Law.',                      cta: 'Check Name' },
        { title: 'KBLI 2025 Guide',                     description: 'Find the right KBLI code for your business field based on the latest 2025 data.',                   cta: 'View Guide' },
        { title: 'KBLI 2020 x KBLI 2025 Conversion Table', description: 'Convert old KBLI codes to the latest 2025 format.',                                             cta: 'Open Table' },
        { title: 'Deed of Establishment Simulation',    description: 'Simulate the deed of establishment document for a Limited Liability Company before the official process begins.', cta: 'Start Simulation' },
        { title: 'Name Generator',                      description: 'Having trouble finding a company name for the PT you want to establish?',                           cta: 'Generate Now' },
    ],
    zh: [
        { title: '查询PT名称可用性',                     description: '在向法务部AHU注册之前，查询您的PT名称是否可用。',                                                   cta: '查询名称' },
        { title: 'KBLI 2025 指南',                       description: '根据最新的2025年数据，找到适合您业务领域的KBLI代码。',                                             cta: '查看指南' },
        { title: 'KBLI 2020 x KBLI 2025 转换表',         description: '将旧的KBLI代码转换为最新的2025年格式。',                                                          cta: '打开表格' },
        { title: '公司注册契约模拟',                     description: '在正式流程开始之前，模拟有限责任公司的设立契约文件。',                                              cta: '开始模拟' },
        { title: '名称生成器',                           description: '难以为您想要设立的PT找到公司名称？',                                                               cta: '立即生成' },
    ],
}

export function useTools() {
    const { locale } = useI18n()

    const tools = computed(() =>
        (data[locale.value] ?? data.id).map((item, i) => ({
            ...toolsMeta[i],
            ...item,
        }))
    )

    return { tools }
}