// id/index.js, en/index.js, zh/index.js
import common from './common'
import home from './home'
import badanUsaha from './services/badan-usaha'

export default {
    common,
    home,          // ← hapus serviceCategories dari sini
    services: {
        badanUsaha,
    },
}