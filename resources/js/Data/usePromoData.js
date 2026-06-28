import { computed } from 'vue'
import { useI18n } from 'vue-i18n'

export function usePromoData() {
    const { locale, messages } = useI18n({ useScope: 'global' })

    const promoItems = computed(() => {
        return messages.value[locale.value]?.home?.promo?.items ?? []
    })

    return { promoItems }
}