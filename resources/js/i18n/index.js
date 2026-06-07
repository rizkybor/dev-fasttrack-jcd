import { createI18n } from 'vue-i18n'
import id from './locales/id'
import en from './locales/en'
import zh from './locales/zh'

const savedLocale = localStorage.getItem('locale') || 'id'

export const i18n = createI18n({
    legacy: false,
    locale: savedLocale,
    fallbackLocale: 'id',
    messages: { id, en, zh },
})