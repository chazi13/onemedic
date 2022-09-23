<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Default Wilayah
 * 
 */

$config['provinsi_id'] = 32;
$config['kabupaten_id'] = 3216;
$config['kecamatan_id'] = 3216023;
$config['kelurahan_id'] = 30149;
/**
 * Array Jenis Identitas
 * 
 */
$config['jenis_identitas'] = array('KTP' => 'KTP', 'SIM' => 'SIM');

/**
 * Array Jenis Kunjungan
 * 
 */
$config['jenis_kunjungan'] = array('BARU' => 'BARU', 'LAMA' => 'LAMA');

/**
 * Array Shift Jam Kerja
 * 
 */
$config['shift_jam_kerja'] = array('07:00-14:00' => 'PAGI', '14:00-21:00' => 'SORE', '21:00-00:00' => 'MALAM (1)', '00:01-07:00' => 'MALAM (2)');

/**
 * Array Jenis Kunjungan
 * 
 */
$config['kelas'] = array('VIP' => 'VIP', 'KELAS I' => 'KELAS I', 'KELAS II' => 'KELAS II', 'KELAS III' => 'KELAS III');

/**
 * Array Jenis Kedatangan
 * 
 */
$config['jenis_kedatangan'] = array('Non Rujukan' => 'Non Rujukan', 'Rujukan' => 'Rujukan');

/**
 * Array Jenis Kelamin 
 * 
 */
$config['jenis_kelamin'] = array('Perempuan' => 'Perempuan', 'Laki-laki' => 'Laki-laki');

/**
 * Array Golongan Darah 
 * 
 */
$config['golongan_darah'] = array('-' => '-', 'O' => 'O', 'A' => 'A', 'B' => 'B', 'AB' => 'AB');

/**
 * Array Pendidikan
 * 
 */
$config['pendidikan'] = array('-' => '-', 'SD' => 'SD', 'SMP' => 'SMP', 'SMA' => 'SMA', 'D1' => 'D1', 'D3' => 'D3', 'S1' => 'S1', 'S2' => 'S2', 'S3' => 'S3');

/**
 * Array Pekerjaan
 * 
 */
$config['pekerjaan'] = array('-' => '-', 'PNS' => 'PNS', 'SWASTA' => 'SWASTA', 'WIRAWASTA' => 'WIRAWASTA', 'TNI' => 'TNI', 'POLRI' => 'POLRI', 'PROFESI' => 'PROFESI');

/**
 * Array Agama
 * 
 */
$config['agama'] = array( '' => '', 'ISLAM' => 'ISLAM', 'KATOLIK' => 'KATOLIK', 'KRISTEN PROTESTAN' => 'KRISTEN PROTESTAN', 'HINDU' => 'HINDU', 'BUDHA' => 'BUDHA', 'KEPERCAYAAN' => 'KEPERCAYAAN', 'LAIN-LAIN' => 'LAIN-LAIN');

/**
 * Array Kewarganegaraan
 * 
 */
$config['kewarganegaraan'] = array('WNI' => 'WNI', 'WNA' => 'WNA');

/**
 * Array Status Pernikahan
 * 
 */
$config['status_pernikahan'] = array('-' => '-', 'BELUM MENIKAH' => 'BELUM MENIKAH', 'MENIKAH' => 'MENIKAH', 'CERAI' => 'CERAI');

/**
 * Array Perujuk
 * 
 */
$config['perujuk'] = array('BIDAN' => 'BIDAN', 'DOKTER PRAKTEK' => 'DOKTER PRAKTEK', 'KLINIK' => 'KLINIK', 'PUSKESMAS' => 'PUSKESMAS', 'RUMAH BERSALIN' => 'RUMAH BERSALIN', 'RUMAH SAKIT' => 'RUMAH SAKIT');

/**
 * Define asuransi_id for BPJS 
 * 
 */
$config['asuransi_bpjs_id'] = 1;

/**
 * Default number of PPN 
 * 
 */
$config['ppn'] = 10;

/**
 * Default of lead 
 * 
 */
$config['length_lead_zero'] = 9;

/**
 * set id kategori jabatan medis
 * 
 */
$config['kategori_jabatan_medis'] = array('DOKTER' => 'DOKTER', 'PERAWAT' => 'PERAWAT', 'BIDAN' => 'BIDAN', 'APOTEKER' => 'APOTEKER', 'ANALIS' => 'ANALIS');

/**
 * Default Inventory Method 
 * 
 */
$config['inventory_method'] = 1; // 1 = FIFO; 2 = LILO; 3 = Average  

/**
 * Default Asset Kondisi 
 * 
 */
$config['kondisi_asset'] = array('BAIK' => 'BAIK', 'SEDANG' => 'SEDANG', 'RUSAK' => 'RUSAK', 'RUSAK BERAT' => 'RUSAK BERAT'); 

/**
 * Default number of rows to display on data tables 
 * 
 */
$config['rows_limit'] = 10;

/**
 * set id poli 
 * 
 */
$config['poli_id_skin_care'] = 126;
$config['poli_id_igd'] = 100;
$config['poli_id_mcu'] = 211;
$config['poli_id_laboratorium'] = 203;
$config['poli_id_radiologi'] = 204;
$config['poli_id_fisioterapi'] = 205;
$config['tipe_pasien_id_mcu'] = 211;
