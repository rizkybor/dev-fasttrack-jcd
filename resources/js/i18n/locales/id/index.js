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
import badanUsahaLuarNegeriDetail from './services/show/badan-usaha-luar-negeri-detail'
import digitalMarketingDetail from './services/show/digital-marketing-detail'
import izinTinggalTerbatasDetail from './services/show/izin-tinggal-terbatas-detail'
import izinTinggalTetapDetail from './services/show/izin-tinggal-tetap-detail'
import kantorPerwakilanDetail from './services/show/kantor-perwakilan-detail'
import keimigrasianWniWnaDetail from './services/show/keimigrasian-wni-wna-detail'
import kekayaanIntelektualDetail from './services/show/kekayaan-intelektual-detail'
import kewajibanPelaporanUsahaDetail from './services/show/kewajiban-pelaporan-perusahaan-detail'
import legalisasiKedutaanDetail from './services/show/legalisasi-kedutaan-detail'
import notarisVirtualDanAktaDetail from './services/show/notaris-virtual-dan-akta-detail'
import oneSingleSubmissionDetail from './services/show/one-single-submission-detail'
import penutupanBadanUsahaDetail from './services/show/penutupan-badan-usaha-detail'
import perizinanBerusahaDetail from './services/show/perizinan-berusaha-detail'
import perizinanLainnyaDetail from './services/show/perizinan-lainnya-detail'
import perpajakanDanPembukuanDetail from './services/show/perpajakan-dan-pembukuan-detail'
import restrukturisasiPerseroanTerbatasDetail from './services/show/restrukturisasi-perseroan-terbatas-detail'
import virtualOfficeDetail from './services/show/virtual-office-detail'
import visaIndonesiaDetail from './services/show/visa-indonesia-detail'
import visaMancanegaraDetail from './services/show/visa-mancanegara-detail'
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
        kantorPerwakilanDetail,
        izinTinggalTerbatas,
        izinTinggalTerbatasDetail,
        izinTinggalTetap,
        izinTinggalTetapDetail,
        badanUsahaLuarNegeri,
        badanUsahaLuarNegeriDetail,
        kekayaanIntelektual,
        kekayaanIntelektualDetail,
        kewajibanPelaporanUsaha,
        kewajibanPelaporanUsahaDetail,
        legalisasiKedutaan,
        legalisasiKedutaanDetail,
        oneSingleSubmission,
        oneSingleSubmissionDetail,
        perizinanLainnya,
        perizinanLainnyaDetail,
        perizinanBerusaha,
        perizinanBerusahaDetail,
        notarisVirtualDanAkta,
        notarisVirtualDanAktaDetail,
        restrukturisasiPerseroanTerbatas,
        restrukturisasiPerseroanTerbatasDetail,
        penutupanBadanUsaha,
        penutupanBadanUsahaDetail,
        keimigrasianWniWna,
        keimigrasianWniWnaDetail,
        visaMancanegara,
        visaMancanegaraDetail,
        perpajakanDanPembukuan,
        perpajakanDanPembukuanDetail,
        virtualOffice,
        virtualOfficeDetail,
        digitalMarketing,
        digitalMarketingDetail,
        visaIndonesia,
        visaIndonesiaDetail
    },
}