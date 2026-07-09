// id/index.js, en/index.js, zh/index.js
import common from './common'
import home from './home'
import faq from './faq'
import kerjasama from './kerjasama'
import mintaPenawaran from './minta-penawaran'
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
import perizinanBerusaha from './services/perizinan-berusaha'
import notarisVirtualDanAkta from './services/notaris-virtual-dan-akta'
import restrukturisasiPerseroanTerbatas from './services/restrukturisasi-perseroan-terbatas'
import penutupanBadanUsaha from './services/penutupan-badan-usaha'
import keimigrasianWniWna from './services/keimigrasian-wni-wna'
import visaMancanegara from './services/visa-mancanegara'
import perpajakanDanPembukuan from './services/perpajakan-dan-pembukuan'
import layanan from './services/layanan'
import virtualOffice from './services/virtual-office'
import digitalMarketing from './services/digital-marketing'
import visaIndonesia from './services/visa-indonesia'

export default {
    common,
    home,
    faq,
    kerjasama,
    mintaPenawaran,
    services: {
        layanan,
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
        perizinanBerusaha,
        notarisVirtualDanAkta,
        restrukturisasiPerseroanTerbatas,
        penutupanBadanUsaha,
        keimigrasianWniWna,
        visaMancanegara,
        perpajakanDanPembukuan,
        virtualOffice,
        digitalMarketing,
        visaIndonesia
    },
}