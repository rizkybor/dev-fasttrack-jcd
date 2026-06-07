import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

const languages = [
    { code: 'id', label: 'Indonesia', flag: '🇮🇩' },
    { code: 'en', label: 'English',   flag: '🇬🇧' },
    { code: 'zh', label: '中文',      flag: '🇨🇳' },
]

export function useLocale() {
    const { locale } = useI18n()

    const current = computed(() =>
        languages.find(l => l.code === locale.value) ?? languages[0]
    )

    function setLocale(code) {
        locale.value = code
        localStorage.setItem('locale', code)
        document.documentElement.lang = code
    }

    return { languages, current, setLocale }
}