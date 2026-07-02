// id/index.js, en/index.js, zh/index.js
import common from './common'
import home from './home'
import badanUsaha from './services/badan-usaha'
import kantorPerwakilan from './services/kantor-perwakilan'
import izinTinggalTerbatas from './services/izin-tinggal-terbatas'
import izinTinggalTetap from './services/izin-tinggal-tetap'
import badanUsahaLuarNegeri from './services/badan-usaha-luar-negeri'
import kekayaanIntelektual from './services/kekayaan-intelektual'
import kewajibanPelaporanUsaha from './services/kewajiban-pelaporan-perusahaan'
import legalisasiKedutaan from './services/legalisasi-kedutaan'
import oneSingleSubmission from './services/one-single-submission'
import badanUsahaDetail from './services/show/badan-usaha-detail'
import perizinanLainnya from './services/perizinan-lainnya'
import notarisVirtualDanAkta from './services/notaris-virtual-dan-akta'
import restrukturisasiPerseroanTerbatas from './services/restrukturisasi-perseroan-terbatas'
import penutupanBadanUsaha from './services/penutupan-badan-usaha'
import keimigrasianWniWna from './services/keimigrasian-wni-wna'
import visaMancanegara from './services/visa-mancanegara'

export default {
    common,
    home,
    services: {
        badanUsaha,
        badanUsahaDetail,
        kantorPerwakilan,
        izinTinggalTerbatas,
        izinTinggalTetap,
        badanUsahaLuarNegeri,
        kekayaanIntelektual,
        kewajibanPelaporanUsaha,
        legalisasiKedutaan,
        oneSingleSubmission,
        perizinanLainnya,
        notarisVirtualDanAkta,
        restrukturisasiPerseroanTerbatas,
        penutupanBadanUsaha,
        keimigrasianWniWna,
        visaMancanegara
    },
}