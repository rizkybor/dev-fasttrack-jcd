// id/index.js, en/index.js, zh/index.js
import common from './common'
import home from './home'
import badanUsaha from './services/badan-usaha'
import kantorPerwakilan from './services/kantor-perwakilan'
import izinTinggalTerbatas from './services/izin-tinggal-terbatas'

export default {
    common,
    home,
    services: {
        badanUsaha,
        kantorPerwakilan,
        izinTinggalTerbatas
    },
}