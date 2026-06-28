import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

export function useVirtualOffices() {
    const { locale, messages } = useI18n({ useScope: 'global' })

    const virtualOffices = computed(() => {
        return messages.value[locale.value]?.home?.virtualOffice?.items ?? []
    })

    return { virtualOffices }
}