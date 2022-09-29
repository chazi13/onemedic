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
		'children' => array()
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