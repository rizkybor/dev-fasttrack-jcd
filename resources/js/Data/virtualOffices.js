import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

// Meta yang tidak perlu ditranslasi
const officesMeta = [
    { image: '/images/dummy-virtual-office.png', kpp: 'KPP Setia Budi' },
    { image: '/images/dummy-virtual-office.png', kpp: 'KPP Setia Budi' },
    { image: '/images/dummy-virtual-office.png', kpp: 'KPP Tanah Abang' },
    { image: '/images/dummy-virtual-office.png', kpp: 'KPP Kebayoran Baru' },
]

const data = {
    id: [
        { name: 'Centennial Tower',          location: 'Jakarta Selatan', status: 'TERSEDIA' },
        { name: 'Menara Kuningan',           location: 'Jakarta Selatan', status: 'TERSEDIA' },
        { name: 'Sudirman Business District', location: 'Jakarta Selatan', status: 'TERSEDIA' },
        { name: 'Pondok Indah Office',       location: 'Jakarta Selatan', status: 'TERSEDIA' },
    ],
    en: [
        { name: 'Centennial Tower',          location: 'South Jakarta', status: 'AVAILABLE' },
        { name: 'Menara Kuningan',           location: 'South Jakarta', status: 'AVAILABLE' },
        { name: 'Sudirman Business District', location: 'South Jakarta', status: 'AVAILABLE' },
        { name: 'Pondok Indah Office',       location: 'South Jakarta', status: 'AVAILABLE' },
    ],
    zh: [
        { name: 'Centennial Tower',          location: '南雅加达', status: '可用' },
        { name: 'Menara Kuningan',           location: '南雅加达', status: '可用' },
        { name: 'Sudirman Business District', location: '南雅加达', status: '可用' },
        { name: 'Pondok Indah Office',       location: '南雅加达', status: '可用' },
    ],
}

export function useVirtualOffices() {
    const { locale } = useI18n()

    const virtualOffices = computed(() =>
        (data[locale.value] ?? data.id).map((item, i) => ({
            ...officesMeta[i],
            ...item,
        }))
    )

    return { virtualOffices }
}