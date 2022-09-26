<?php

/**
 * Main Navigation.
 * Primarily being used in views/layouts/admin.php
 *
 */
$config['navigation'] = array(
	'reservasi' => array(
		'title' => 'Reservasi',
		'icon' => 'icon-home4 mr-2',
		'children' => array(
			'reservasi' => array(
				'title' => 'Hari Ini',
				'icon' => 'icon-bookmark3',
				'uri' => 'reservasi/home'
			),
			'izin_dokter' => array(
				'title' => 'Izin/Cuti Dokter',
				'icon' => 'icon-bell-cross',
				'uri' => 'reservasi/izin_dokter'
			),
			'laporan' => array(
				'title' => 'laporan',
				'icon' => 'icon-bell-cross',
				'uri' => 'reservasi/laporan'
			),
			'setup' => array(
				'title' => 'setup',
				'icon' => 'icon-cog3',
				'children' => array(
					'setup_poli' => array(
						'title' => 'Setup Poliklinik',
						'icon' => 'icon-cog',
						'uri' => 'reservasi/setup_poliklinik'
					),
					'setup_dokter' => array(
						'title' => 'Setup Dokter',
						'icon' => 'icon-cog3',
						'uri' => 'reservasi/setup_dokter'
					),
				)
			)
		)
	),
	'display' => array(
		'title' => 'Display',
		'icon' => 'icon-home4 mr-2',
		'children' => array(
			'display_antrian' => array(
				'title' => 'Ambil Nomor',
				'icon' => 'icon-display',
				'uri' => 'antrian/get_nomor'
			),
			'group_display' => array(
				'title' => 'Display',
				'icon' => 'icon-display',
				'uri' => 'antrian/group_display'
			)
		)
	),
	'pendaftaran' => array(
		'title' => 'Pendaftaran',
		'icon' => 'icon-home4 mr-2',
		'children' => array(
			'pendaftaran_pasien_rwj' => array(
				'uri' => 'pendaftaran/home',
				'title' => 'Pasien Rawat Jalan',
				'icon' => 'icon-qrcode'
			),
			'pendaftaran_pasien_rwi' => array(
				'uri' => 'pendaftaran/rwi',
				'title' => 'Pasien Rawat Inap',
				'icon' => 'icon-barcode2'
			),
			'data_pasien' => array(
				'uri' => 'pendaftaran/info/pasien',
				'title' => 'Data Pasien',
				'icon' => 'icon-database2'
			),
			'history' => array(
				'uri' => 'pendaftaran/history',
				'title' => 'History Pendaftaran',
				'icon' => 'icon-history'
			)
		)
	),
	// ===================================
	// ========== L A P O R A N ==========
	// ===================================
	'laporan' => array(
		'title' => 'Laporan',
		'icon' => 'icon-home4 mr-2',
		'children' => array(
			// PENDAFTARAN
			'laporan_pendaftaran' => array(
				'title' => 'Pendaftaran',
				'icon' => 'icon-newspaper2',
				'children' => array(
					'pendaftaran_rawat_jalan' => array(
						'uri' => 'laporan/pendaftaran_rwj',
						'title' => 'Pendaftaran Rawat Jalan',
					),
					'pendaftaran_rawat_inap' => array(
						'uri' => 'laporan/pendaftaran_rwi',
						'title' => 'Pendaftaran Rawat Inap',
					),
					'batal_registrasi' => array(
						'uri' => 'laporan/batal_registrasi',
						'title' => 'Batal Registrasi',
					)
				)
			),
		)
	),

	'eis' => array(
		'title' => 'EIS',
		'icon' => 'icon-home4 mr-2',
		'children' => array(
			'eis_pdf_pasien_per_periode' => array(
				'title' => 'Pendaftaran per Periode',
				'icon' => 'icon-graph',
				'uri' => 'eis/pdf_pasien_per_periode'
			),
			'eis_pdf_pasien_per_bulan' => array(
				'title' => 'Pendaftaran per Bulan',
				'icon' => 'icon-graph',
				'uri' => 'eis/pdf_pasien_per_bulan'
			),
			'eis_pdf_pasien_per_poli_per_periode' => array(
				'title' => 'Jumlah Per Poliklinik Per Periode',
				'icon' => 'icon-graph',
				'uri' => 'eis/pdf_pasien_per_poli_per_periode'
			),
			'eis_pdf_pasien_per_poli_per_bulan' => array(
				'title' => 'Jumlah Per Poliklinik Per Bulan',
				'icon' => 'icon-graph',
				'uri' => 'eis/pdf_pasien_per_poli_per_bulan'
			)
		)
	),

	'master' => array(
		'title' => 'Data Master',
		'icon' => 'icon-home4 mr-2',
		'children' => array(
			// 'alasan_pembatalan_registrasi' => array(
			// 	'title' => 'Alasan Pembatalan Reg.',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/alasan_pembatalan_registrasi'
			// ),
			// 'apotek' => array(
			// 	'title' => 'Apotek',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/apotek'
			// ),
			// 'asuransi' => array(
			// 	'title' => 'Asuransi',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/asuransi'
			// ),
			// 'bank' => array(
			// 	'title' => 'Bank',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/bank'
			// ),
			// 'bentuk_sediaan' => array(
			// 	'title' => 'Bentuk Sediaan Obat',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/bentuk_sediaan'
			// ),
			// 'rekening_bank' => array(
			// 	'title' => 'Rekening Bank',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/rekening_bank'
			// ),
			// 'farmakologi_farmasi' => array(
			// 	'title' => 'Farmakologi Farmasi',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/farmakologi_farmasi'
			// ),
			// 'zat_aktif' => array(
			// 	'title' => 'Zat Aktif',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/zat_aktif'
			// ),
			// 'jenis_farmasi' => array(
			// 	'title' => 'Jenis Farmasi',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/jenis_farmasi'
			// ),
			// 'kelompok_farmasi' => array(
			// 	'title' => 'Kelompok Farmasi',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/kelompok_farmasi'
			// ),
			// 'kategori_farmasi' => array(
			// 	'title' => 'Kategori Farmasi',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/kategori_farmasi'
			// ),
			// 'farmasi' => array(
			// 	'title' => 'Obat, BHP dan Alkes',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/farmasi'
			// ),
			// 'produsen' => array(
			// 	'title' => 'Produsen',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/produsen'
			// ),
			// 'supplier' => array(
			// 	'title' => 'Supplier',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/supplier'
			// ),
			// 'jabatan' => array(
			// 	'title' => 'Jabatan Struktural',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/jabatan'
			// ),
			// 'unit_medis_fungsional' => array(
			// 	'title' => 'Unit Medis Fungsional',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/unit_medis_fungsional'
			// ),
			// 'jabatan_medis_fungsional' => array(
			// 	'title' => 'Jabatan Medis Fungsional',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/jabatan_medis_fungsional'
			// ),
			// 'pegawai' => array(
			// 	'title' => 'Pegawai',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/pegawai'
			// ),
			// 'poli' => array(
			// 	'title' => 'Poliklinik',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/poli'
			// ),
			
        // 'master/group_bagian_rs/index'                          => array('icon' => '' , 'label' => 'Group Bagian RS (Jasmed)'),
        // 'master/group_tindakan_rs/index'                        => array('icon' => '' , 'label' => 'Group Tindakan RS (Jasmed)'),
        // 'master/jenis_barang/index'                             => array('icon' => '' , 'label' => 'Jenis/Kategori Barang'),
        // 'master/kartu_bayar/index'                              => array('icon' => '' , 'label' => 'Jenis Kartu Pembayaran'),
        // 'master/jenjang_jabatan/index'                          => array('icon' => '' , 'label' => 'Jenjang Jabatan'),
        // 'master/kategori_tindakan/index'                        => array('icon' => '' , 'label' => 'Kategori/Golongan Tindakan'),                
        // 'master/kategori_jasa_medis/index'                      => array('icon' => '' , 'label' => 'Kategori Jasa Medis'),
        // 'master/klasifikasi_tarif/index'                        => array('icon' => '' , 'label' => 'Klasifikasi Tarif'),
        // 'master/konversi_satuan/index'                          => array('icon' => '' , 'label' => 'Konversi Satuan'),        
        // 'master/pemeriksaan_lab/index'                          => array('icon' => '' , 'label' => 'Pemeriksaan Lab.'),
        // 'master/penanggung/index'                               => array('icon' => '' , 'label' => 'Penanggung'),
        // 'master/perusahaan/index'                               => array('icon' => '' , 'label' => 'Perusahaan/Rekanan'),
        // 'master/ruangan/index'                                  => array('icon' => '' , 'label' => 'Ruangan'),
        // 'master/rujukan/index'                                  => array('icon' => '' , 'label' => 'Rujukan'),
        // 'master/signatura/index'                                => array('icon' => '' , 'label' => 'Signatura Resep'),
        // 'master/sumber_pendapatan/index'                        => array('icon' => '' , 'label' => 'Sumber Pendapatan'),
			
			
			// 'ruangan' => array(
			// 	'title' => 'Ruangan/Kamar/Bed',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/ruangan'
			// ),
			// 'tindakan' => array(
			// 	'title' => 'Tindakan',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/tindakan'
			// ),
			// 'tindakan_paket' => array(
			// 	'title' => 'Tindakan Paket',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/tindakan_paket'
			// ),
			// 'status_akhir_pasien' => array(
			// 	'title' => 'Status Akhir Pasien',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/status_akhir_pasien'
			// ),
			
			// 'jenis_dokumen' => array(
			// 	'title' => 'Jenis Dokumen',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/jenis_dokumen'
			// ),
			// 'jenis_barang' => array(
			// 	'title' => 'Golongan Barang',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/jenis_barang'
			// ),
			// 'lokasi_barang' => array(
			// 	'title' => 'Lokasi Barang',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/lokasi_barang'
			// ),
			// 'kondisi_barang' => array(
			// 	'title' => 'Kondisi Barang',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/kondisi_barang'
			// ),
			// 'tipe_barang' => array(
			// 	'title' => 'Tipe Barang',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/tipe_barang'
			// ),
			// 'merk' => array(
			// 	'title' => 'Merk',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/merk'
			// ),
			// 'satuan' => array(
			// 	'title' => 'Satuan',
			// 	'icon' => 'icon-package',
			// 	'uri' => 'master/satuan'
			// ),
		)
	),
	'access-management' => array(
		'title' => 'Access Management',
		'icon' => 'icon-home4 mr-2',
		'children' => array(
			'user' => array(
				'uri' => 'auth/user',
				'title' => 'Users',
				'icon' => 'icon-users'
			),
			'rules' => array(
				'uri' => 'acl/rule',
				'title' => 'Rules',
				'icon' => 'icon-cube3'
			),
			'roles' => array(
				'uri' => 'acl/role',
				'title' => 'Roles',
				'icon' => 'icon-accessibility'
			),
			'resources' => array(
				'uri' => 'acl/resource',
				'title' => 'Resources',
				'icon' => 'icon-cube'
			)
		)
	),
	'utils' => array(
		'title' => 'Utils',
		'icon' => 'icon-home4 mr-2',
		'children' => array(
			'generate' => array(
				'uri' => 'utils/generate',
				'title' => 'Generate Data',
				'icon' => 'fa fa-cogs'
			),
			'email_test' => array(
				'uri' => 'utils/email_test',
				'title' => 'Email Test',
				'icon' => 'fa fa-envelope',
			),
			'system_logs' => array(
				'uri' => 'utils/logs/system',
				'title' => 'System Log',
				'icon' => 'fa fa-laptop-code'
			),
			'deploy_logs' => array(
				'uri' => 'utils/logs/deploy',
				'title' => 'Deploy Log',
				'icon' => 'fa fa-cloud-upload-alt'
			),
			'info' => array(
				'uri' => 'utils/info',
				'title' => 'Info',
				'icon' => 'fa fa-info-circle'
			),
			'samples' => array(
				'uri' => 'samples',
				'title' => 'Samples',
				'icon' => 'fa fa-flask',
				'children' => array(
					'blank' => array(
						'uri' => 'samples/blank_page',
						'title' => 'Blank Page',
					),
					'form' => array(
						'uri' => 'samples/forms',
						'title' => 'Form',
					)
				)
			)
		)
	)
);