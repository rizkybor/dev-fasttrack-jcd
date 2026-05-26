import React from 'react';

import styles from './index.module.scss';

const Component = () => {
  return (
    <div className={styles.frame42}>
      <p className={styles.peralatanDanFiturGra}>
        Peralatan dan Fitur Gratis untuk Kemudahan Bisnis Anda
      </p>
      <div className={styles.frame23}>
        <div className={styles.cArdtools}>
          <div className={styles.frame37}>
            <div className={styles.frame24}>
              <img src="../image/mplhujzw-be8lwn9.svg" className={styles.icon} />
            </div>
            <div className={styles.frame20}>
              <p className={styles.cekKetersediaanNamaP}>
                Cek Ketersediaan Nama PT
              </p>
              <p className={styles.cekKetersediaanNamaP2}>
                Cek ketersediaan nama PT Anda sebelum mendaftar ke AHU Kemenkum RI.
              </p>
            </div>
          </div>
          <p className={styles.button}>Cek Nama PT</p>
        </div>
        <div className={styles.cArdtools2}>
          <div className={styles.frame372}>
            <div className={styles.frame242}>
              <img src="../image/mplhujzw-h1p51q8.svg" className={styles.icon} />
            </div>
            <div className={styles.frame20}>
              <p className={styles.cekKetersediaanNamaP}>Panduan KBLI 2025</p>
              <p className={styles.cekKetersediaanNamaP2}>
                Temukan kode KBLI yang tepat untuk bidang usaha Anda berdasarkan
                data terbaru 2025.
              </p>
            </div>
          </div>
          <p className={styles.button}>Lihat Panduan</p>
        </div>
        <div className={styles.cArdtools3}>
          <div className={styles.frame373}>
            <div className={styles.frame243}>
              <img src="../image/mplhujzw-o87a791.svg" className={styles.icon} />
            </div>
            <div className={styles.frame202}>
              <p className={styles.tabelKonversiKbli202}>
                Tabel Konversi KBLI 2020 x KBLI 2025
              </p>
              <p className={styles.cekKetersediaanNamaP2}>
                Konversi kode KBLI lama ke format terbaru 2025.
              </p>
            </div>
          </div>
          <p className={styles.button}>Buka Tabel</p>
        </div>
        <div className={styles.cArdtools4}>
          <div className={styles.frame374}>
            <div className={styles.frame25}>
              <img src="../image/mplhujzw-60gmi2y.svg" className={styles.icon} />
            </div>
            <div className={styles.frame203}>
              <p className={styles.sImulasiaktapendiria}>Simulasi AKTA Pendirian</p>
              <p className={styles.cekKetersediaanNamaP2}>
                Simulasikan dokumen akta pendirian Perseroan Terbatas sebelum proses
                resmi dimulai.
              </p>
            </div>
          </div>
          <p className={styles.button}>Mulai Simulasi</p>
        </div>
        <div className={styles.cArdtools5}>
          <div className={styles.frame375}>
            <div className={styles.frame244}>
              <img src="../image/mplhujzw-ndma3za.svg" className={styles.icon} />
            </div>
            <div className={styles.frame203}>
              <p className={styles.sImulasiaktapendiria}>Generator Nama</p>
              <p className={styles.cekKetersediaanNamaP2}>
                Kesulitan menemukan nama Perusahaan untuk PT yang mau kamu buat?
              </p>
            </div>
          </div>
          <p className={styles.button2}>Generate Sekarang</p>
        </div>
      </div>
    </div>
  );
}

export default Component;
