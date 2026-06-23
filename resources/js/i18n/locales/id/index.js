// id/index.js, en/index.js, zh/index.js
import common from './common'
import home from './home'
import badanUsaha from './services/badan-usaha'
import kantorPerwakilan from './services/kantor-perwakilan'
import izinTinggalTerbatas from './services/izin-tinggal-terbatas'
import izinTinggalTetap from './services/izin-tinggal-tetap'
import badanHukumLuarNegeri from './services/badan-hukum-luar-negeri'
import kekayaanIntelektual from './services/kekayaan-intelektual'
import kewajibanPelaporanUsaha from './services/kewajiban-pelaporan-perusahaan'
import legalisasiKedutaan from './services/legalisasi-kedutaan'
import oneSingleSubmission from './services/one-single-submission'
import badanUsahaDetail from './services/show/badan-usaha-detail'

export default {
    common,
    home,
    services: {
        badanUsaha,
        badanUsahaDetail,
        kantorPerwakilan,
        izinTinggalTerbatas,
        izinTinggalTetap,
        badanHukumLuarNegeri,
        kekayaanIntelektual,
        kewajibanPelaporanUsaha,
        legalisasiKedutaan,
        oneSingleSubmission
    },
}