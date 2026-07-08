// id/index.js, en/index.js, zh/index.js
import common from './common'
import home from './home'
import badanUsaha from './services/badan-usaha'
import kantorPerwakilan from './services/kantor-perwakilan'
import izinTinggalTerbatas from './services/izin-tinggal-terbatas'
import badanUsahaDetail from './services/show/badan-usaha-detail'
import layanan from './services/layanan'
import badanUsahaLuarNegeri from './services/badan-usaha-luar-negeri'
import oneSingleSubmission from './services/one-single-submission'
import perizinanLainnya from './services/perizinan-lainnya'
import notarisVirtualDanAkta from './services/notaris-virtual-dan-akta'
import restrukturisasiPerseroanTerbatas from './services/restrukturisasi-perseroan-terbatas'
import penutupanBadanUsaha from './services/penutupan-badan-usaha'
import kekayaanIntelektual from './services/kekayaan-intelektual'
import perpajakanDanPembukuan from './services/perpajakan-dan-pembukuan'
import legalisasiKedutaan from './services/legalisasi-kedutaan'
import kewajibanPelaporanUsaha from './services/kewajiban-pelaporan-perusahaan'
import izinTinggalTetap from './services/izin-tinggal-tetap'
import keimigrasianWniWna from './services/keimigrasian-wni-wna'
import visaMancanegara from './services/visa-mancanegara'

export default {
    common,
    home,
    services: {
        layanan,
        badanUsaha,
        badanUsahaDetail,
        kantorPerwakilan,
        izinTinggalTerbatas,
        badanUsahaLuarNegeri,
        oneSingleSubmission,
        perizinanLainnya,
        notarisVirtualDanAkta,
        restrukturisasiPerseroanTerbatas,
        penutupanBadanUsaha,
        kekayaanIntelektual,
        perpajakanDanPembukuan,
        legalisasiKedutaan,
        kewajibanPelaporanUsaha,
        izinTinggalTetap,
        keimigrasianWniWna,
        visaMancanegara
    },
}