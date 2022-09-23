<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tindakan extends Admin_Controller {

    protected $form = array(
        'kategori_tindakan_id' => array(
            'label' => 'Kategori Tindakan/Layanan',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'sumber_pendapatan_id' => array(
            'label' => 'Sumber Pendapatan',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
		'group_bagian_rs_id' => array(
            'label' => 'Relasi Bagian',
            'rules' => 'trim|required',
            'helper' => 'form_dropdownlabel'
        ),
		'group_tindakan_rs_id' => array(
            'label' => 'Relasi Tindakan',
            'rules' => 'trim|required',
            'helper' => 'form_dropdownlabel'
        ),
        'is_parent' => array(
            'label' => 'Is Parent',
            'rules' => 'trim|required',
            'helper' => 'form_dropdownlabel'
        ),
        'kode' => array(
            'label' => 'Kode',
            'rules' => 'trim|required|max_length[150]',
            'helper' => 'form_inputlabel'
        ),
        'nama' => array(
            'label' => 'Nama',
            'rules' => 'trim|required|max_length[150]',
            'helper' => 'form_inputlabel'
        ),
		'satuan_id' => array(
            'label' => 'Satuan',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        /* 'default_poli_id' => array(
            'label' => 'Default untuk Poliklinik',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ), */
		'tipe_jasmed' => array(
            'label' => 'Tipe Jasa Medis',
            'rules' => 'trim',
            'helper' => 'form_dropdownlabel'
        ),
        'tarif' => array(
            'label' => 'Tarif',
            'rules' => 'trim|required|max_length[150]',
            'helper' => 'form_inputlabel'
        ),
        'id' => array(
            'helper' => 'form_hidden'
        )
    );

    function __construct() {
        parent::__construct();
        $this->load->helper('form_helper');
        
        $this->load->model('poli_model');
        $this->load->model('kategori_tindakan_model');
        $this->load->model('sumber_pendapatan_model');
        $this->load->model('satuan_model');
        $this->load->model('group_bagian_rs_model');
        $this->load->model('group_tindakan_rs_model');
        $this->load->model('group_tindakan_rs_persen_model');
        $this->load->model('kategori_jasa_medis_model');
        $this->load->model('jasa_medis_model');
        $this->load->model('tindakan_model');
		// $this->load->model('aplikasi_lama/aplikasi_lama_model');
        if ($this->input->post('cancel-button'))
            redirect('master/tindakan/index');
    }

    function index($kodeRoot = '') {
        $rowsRoot = $this->db->query("SELECT kode, nama FROM mst_tindakan WHERE kode like '%000000000000' AND status = 1 ORDER BY kode ASC")->result();
        $kodeParam = '';
//        if($kodeRoot != ''){
//            $kodeParam = substr($kodeRoot,0,3);
//            $rowsRoot = $this->db->query("SELECT kode, nama FROM mst_tindakan WHERE kode LIKE '".$kodeParam."%' AND SUBSTRING(kode, 7,6) = '000000' AND status = 1 ORDER BY kode ASC")->result();
//        }
        $arrNodes[] = array();
        foreach ($rowsRoot as $row):
//            if($kodeRoot != $row->kode){
//                $arrNodes = $this->load_child($row->kode);
//                var_dump($arrNodes);
                $arrData[] = array('text' => $row->kode.' - '.$row->nama, 'tags' => '0', 'nodes' => $arrNodes);
//            }
        endforeach;
        $this->data['rowsRoot'] = $rowsRoot;
        $this->data['arrData'] = $arrData;
        $this->data['kodeRoot'] = $kodeRoot;
        $this->data['optionsRoot'] = $this->tindakan_model->drop_options_kode("kode like '%000000000000'");
        
        $this->template
                // ->set_css('theme-default/libs/nestable/nestable')
                ->set_js('jquery.nestable', true)
                // ->set_js('libs/bootstrap-treeview/bootstrap-treeview', true)
                ->build('master/tindakan-list', $this->data);
    }
    
    function get_by_parent($parentKode){
        $lengthKode = strlen($parentKode);
        $rows = $this->db->query("SELECT kode, nama FROM mst_tindakan WHERE kode LIKE '".$parentKode."%' AND RIGHT(kode, ".(15-($lengthKode+3)).") = '000000' AND status = 1 ORDER BY kode ASC")->result();
        $arrData = array();
        foreach ($rows as $row){
            if($row->kode != str_pad($parentKode, 15, '0', STR_PAD_RIGHT)){
                $arrData['"'.$row->kode.'"'] = $row->nama;
            }
        }
        
        header('Content-Type: application/json');
        echo json_encode($arrData);
    }
    
    function load_child($pKodeParent){
            $kodeParent = substr($pKodeParent, 0, 3);
            $rowsNextLevel = $this->db->query("SELECT kode, nama FROM mst_tindakan WHERE kode LIKE '".$kodeParent."%' AND SUBSTRING(kode, 9,10) = '0000000' AND status = 1 ORDER BY kode ASC")->result();
            $arrNodes = array();
            foreach ($rowsNextLevel as $rowNext):
                if($pKodeParent != $rowNext->kode){
                    $arrNodes = $this->load_child2($rowNext->kode);
                $arrNodes[] = array('text' => $rowNext->kode.' - '. $rowNext->nama, 'tags' => '1', 'nodes' => $arrNodes);
                }
            endforeach;        
            return $arrNodes;
    }
    function load_child2($pKodeParent){
            $kodeParent = substr($pKodeParent, 0, 6);
            $rowsNextLevel = $this->db->query("SELECT kode, nama FROM mst_tindakan WHERE kode LIKE '".$kodeParent."%' AND SUBSTRING(kode, 12,7) = '0000' AND status = 1 ORDER BY kode ASC")->result();
            $arrNodes = array();
            foreach ($rowsNextLevel as $rowNext):
                if($pKodeParent != $rowNext->kode){
                $arrNodes[] = array('text' => $rowNext->kode.' - '. $rowNext->nama, 'href' => '#', 'parentId' => $rowNext->kode, 'nodes' => '');
                }
            endforeach;        
            return $arrNodes;
    }

    function datatables_sourcedata() {
        $this->load->library('datatables');
        $params['mst_tindakan.status'] = 1;
        $this->datatables
                ->select("mst_tindakan.id, 
                   kategori_tindakan.nama AS kategori, 
                   mst_tindakan.nama, 
                   mst_tindakan.tarif", FALSE)
                ->where($params, FALSE, FALSE)
                ->from('mst_tindakan')
                ->add_column('link', '
                   <div style="margin: 0;" class="btn-toolbar">
                        <div class="btn-group">
                          <a class="btn ink-reaction btn-raised btn-xs btn-info" data-toggle="tooltip" data-placement="top" title="Setting Default Pendaftaran" data-button="edit" href="' . site_url('master/tindakan/default_pendaftaran') . '/$1" style="margin-left: 5px;"><i class="fa fa-list"></i></a>
                          <a class="btn ink-reaction btn-raised btn-xs btn-success" data-toggle="tooltip" data-placement="top" title="Edit" data-button="edit" href="' . site_url('master/tindakan/edit') . '/$1" style="margin-left: 5px;"><i class="fa fa-edit"></i></a>
                          <a class="btn ink-reaction btn-raised btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Delete" data-button="delete" href="' . site_url('master/tindakan/delete') . '/$1" style="margin-left: 5px;"><i class="fa fa-trash-o"></i></a>
                        </div>
                    </div>
        ', 'id');
        $this->datatables->join('mst_kategori_tindakan AS kategori_tindakan', 'kategori_tindakan.id = mst_tindakan.kategori_tindakan_id', 'LEFT');
        echo $this->datatables->generate();
    }

    function edit($id) {
        $this->data['form_title'] = 'Edit Layanan';
        $this->_updatedata($id);
    }

    function add() {
        $this->data['form_title'] = 'Input Layanan';
        $this->_updatedata();
    }

    function _updatedata($id = 0) {
        $this->load->library('form_validation');

        $tindakanForm = $this->form;
		$this->data['id'] = $id;
    //    $arrPoli = $this->poli_model->drop_options();
    //    $arrPoli['9999'] = 'SEMUA POLI';
        $tindakanForm['kategori_tindakan_id']['options'] = $this->kategori_tindakan_model->drop_options();
        $tindakanForm['sumber_pendapatan_id']['options'] = $this->sumber_pendapatan_model->drop_options();
        $tindakanForm['satuan_id']['options'] = $this->satuan_model->drop_options();
        $tindakanForm['group_bagian_rs_id']['options'] = $this->group_bagian_rs_model->drop_options();
		$tindakanForm['tipe_jasmed']['options'] = array('P' => 'Presentase','N' => 'Nominal');
    //    $tindakanForm['default_poli_id']['options'] = $arrPoli;
        $tindakanForm['is_parent']['options'] = array('0' => 'Tidak','1' => 'Ya');
		$this->data['tipe_jasmed'] = '';
        $this->data['isDefault'] = 0;
        if ($id > 0) {
            $rowTindakan = $this->tindakan_model->get_by_id((int) $id);
            $tindakanForm['kategori_tindakan_id']['value'] = $rowTindakan->kategori_tindakan_id;
            $tindakanForm['sumber_pendapatan_id']['value'] = $rowTindakan->sumber_pendapatan_id;
            $tindakanForm['satuan_id']['value'] = $rowTindakan->satuan_id;
            $tindakanForm['group_bagian_rs_id']['value'] = $rowTindakan->group_bagian_rs_id;
			$tindakanForm['group_tindakan_rs_id']['options'] = $this->group_tindakan_rs_model->drop_options(array('group_bagian_rs_id'=>$rowTindakan->group_bagian_rs_id));
            $tindakanForm['group_tindakan_rs_id']['value'] = $rowTindakan->group_tindakan_rs_id;
            $tindakanForm['is_parent']['value'] = $rowTindakan->is_parent;
            $tindakanForm['kode']['value'] = $rowTindakan->kode;
            $tindakanForm['nama']['value'] = $rowTindakan->nama;
            $tindakanForm['tipe_jasmed']['value'] = $rowTindakan->tipe_jasmed;
            $tindakanForm['tarif']['value'] = (int) $rowTindakan->tarif;
        //    $tindakanForm['default_poli_id']['value'] = $rowTindakan->default_poli_id;
			$this->data['tipe_jasmed'] = $rowTindakan->tipe_jasmed;
        }

        $this->form_validation->init($tindakanForm);

        if ($this->form_validation->run()) {
			/* echo '<pre>';
			print_r($this->input->post());die;
			echo '</pre>'; */
			
            $data = $this->form_validation->get_values();
            $data['kode'] = '-';
            $data['is_parent'] = $this->input->post('is_parent');
            if ($id > 0) {
                if($this->tindakan_model->update($id, $data)){
					// $this->aplikasi_lama_model->updateMasterLayananAplikasiLama($id, $data);
					if($this->input->post('tipe_jasmed')=='N'){
						foreach($this->input->post('tarif_jasmed') as $tarif_jasmed){
							$tarifJasmed['kategori_jasa_medis_id'] = $tarif_jasmed['kategori_jasa_medis_id'];
							$tarifJasmed['tindakan_id'] = $id;
							$tarifJasmed['jasa_medis_rupiah'] = $tarif_jasmed['tarif'];
							$kode = $tarif_jasmed['kode_nominal'];
							if($tarif_jasmed['jasmed_id'] > 0){
								if($this->jasa_medis_model->update($tarif_jasmed['jasmed_id'], $tarifJasmed)){
									// $this->aplikasi_lama_model->updateMasterLayananTarifRupiahAplikasiLama($id, $tarifJasmed, $kode);
								}
							}else{
								if($this->jasa_medis_model->insert($tarifJasmed)){
									// $this->aplikasi_lama_model->updateMasterLayananTarifRupiahAplikasiLama($id, $tarifJasmed, $kode);
								}
							}
						}
					}else{
						/* $settingPersens = $this->group_tindakan_rs_persen_model->get_by_tindakan($data['group_tindakan_rs_id']);
						foreach($settingPersens as $persen_jasmed){
							$persenJasmed['kategori_jasa_medis_id'] = $persen_jasmed->kategori_jasa_medis_id;
							$persenJasmed['tindakan_id'] = $id;
							$persenJasmed['jasa_medis_persen'] = $persen_jasmed->persen;
							$kode = $persen_jasmed->kode_persen;
							
							$Jasmeds = $this->jasa_medis_model->get_by_tindakan($id);
							foreach($Jasmeds as $Jasmed){
								if($Jasmed->kategori_jasa_medis_id==$persen_jasmed->kategori_jasa_medis_id){
									$jasmed_id = $Jasmed->id;
								}
							}
							
							if($persen_jasmed->jasmed_id > 0){
								if($this->jasa_medis_model->update($persen_jasmed->jasmed_id, $persenJasmed)){
									$this->aplikasi_lama_model->updateMasterLayananTarifRupiahAplikasiLama($id, $persenJasmed, $kode);
								}
							}else{
								if($this->jasa_medis_model->insert($persenJasmed)){
									$this->aplikasi_lama_model->updateMasterLayananTarifRupiahAplikasiLama($id, $persenJasmed, $kode);
								}
							}
						} */
					}
				}
                $this->template->set_flashdata('success', 'Tindakan berhasil diupdate ');
            } else {
				/* echo '<pre>';
				print_r($data);die;
				echo '</pre>'; */
                $layanan_id = $this->tindakan_model->insert($data);
				// $this->aplikasi_lama_model->insertMasterLayananAplikasiLama($layanan_id, $data);
				if($this->input->post('tipe_jasmed')=='N'){
					foreach($this->input->post('tarif_jasmed') as $tarif_jasmed){
						$tarifJasmed['kategori_jasa_medis_id'] = $tarif_jasmed['kategori_jasa_medis_id'];
						$tarifJasmed['tindakan_id'] = $layanan_id;
						$tarifJasmed['jasa_medis_rupiah'] = $tarif_jasmed['tarif'];
						$kode = $tarif_jasmed['kode_nominal'];
						if($this->jasa_medis_model->insert($tarifJasmed)){
							// $this->aplikasi_lama_model->updateMasterLayananTarifRupiahAplikasiLama($layanan_id, $tarifJasmed, $kode);
						}
					}
				}else{
					
				}
                $this->template->set_flashdata('success', 'Tindakan berhasil diupdate ');
            }

            redirect('master/tindakan');
        }

        $this->data['form'] = $this->form_validation;
        $this->template->build('master/tindakan-form', $this->data);
    }

    function delete($id) {
        $this->tindakan_model->update($id, array('status' => 0));
        $this->template->set_flashdata('success', 'Tindakan berhasil diupdate ');
        redirect('master/tindakan');
    }
	
    function delete_default_pendaftaran($tindakan_id, $id) {
		$this->load->model('tindakan_default_pendaftaran_model');
        $this->tindakan_default_pendaftaran_model->update($id, array('status' => 0));
        $this->template->set_flashdata('success', 'Setting berhasil diupdate ');
        redirect('master/tindakan/default_pendaftaran/'.$tindakan_id);
    }
	
	function get_group_bagian_rs(){
        $bagianId = $this->input->post('id');
        $ddTindakan = $this->group_tindakan_rs_model->drop_options(array('group_bagian_rs_id' => $bagianId));
        $ddTindakanNew = array();
        foreach ($ddTindakan as $key => $val){
            $ddTindakanNew['"'.$key.'"'] = $val;
        }
        
        header('Content-Type: application/json');
        echo json_encode($ddTindakanNew,true);
    }
	
	function default_pendaftaran($id){
        $this->load->helper('form');
		$this->load->library('form_validation');
        $this->load->model('asuransi_model');
        //$this->load->model('perusahaan_model');
        $this->load->model('poli_model');
        $this->load->model('tindakan_default_pendaftaran_model');
        if($this->input->post('allow_submit')=='Y'){
			            
            foreach($this->input->post('data') as $defaultItem){
                
				$dataDef['tindakan_id'] = $id;
				$dataDef['poli_id'] = $defaultItem['poli_id'];
				$dataDef['asuransi_id'] = $defaultItem['asuransi_id'];
				if($defaultItem['default_id'] > 0){
					$this->tindakan_default_pendaftaran_model->update($defaultItem['default_id'], $dataDef);
				}else{
					$this->tindakan_default_pendaftaran_model->insert($dataDef);
				}
                
            }
            $this->template->set_flashdata('success', 'Setting berhasil');
            redirect('master/tindakan');
        } 
		$defaultPendaftarans = $this->tindakan_default_pendaftaran_model->get_by_tindakanId($id);
        $tindakan  = $this->tindakan_model->get_by_id($id);
        $arrPoli = $this->poli_model->drop_options();
        $arrAsuransi = $this->asuransi_model->drop_options();
        $this->data['defaultPendaftarans'] = $defaultPendaftarans;
        $this->data['tindakan'] = $tindakan;
        $this->data['arrPoli'] = $arrPoli;
        $this->data['arrAsuransi'] = $arrAsuransi;
        $this->data['tindakan_id'] = $id;
        $this->template->build('master/tindakan_default_pendaftaran-form', $this->data);
    }
    
    function autocomplete() {
        echo json_encode($this->tindakan_model->autocomplete());
    }

}
