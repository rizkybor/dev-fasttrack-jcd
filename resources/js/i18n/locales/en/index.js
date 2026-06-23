// id/index.js, en/index.js, zh/index.js
import common from './common'
import home from './home'
import badanUsaha from './services/badan-usaha'
import kantorPerwakilan from './services/kantor-perwakilan'
import izinTinggalTerbatas from './services/izin-tinggal-terbatas'
import badanUsahaDetail from './services/show/badan-usaha-detail'

export default {
    common,
    home,
    services: {
        badanUsaha,
        badanUsahaDetail,
        kantorPerwakilan,
        izinTinggalTerbatas
    },
}