<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pendaftaran_model extends MY_Model {

    protected $table = 'pdf_pasien';
    protected $table_ply = 'ply_rawat_jalan';
    protected $table_ply_tindakan = 'ply_rawat_jalan_tindakan';
    protected $table_ply_farmasi = 'ply_rawat_jalan_farmasi';
    protected $table_apt = 'apt_rawat_jalan';
    protected $table_apt_item = 'apt_rawat_jalan_item';
    protected $id_field = 'id';
    protected $joins = array(
        array('table' => 'mst_pasien', 'cond' => 'mst_pasien.no_mr = pdf_pasien.no_mr', 'type' => 'INNER'),
        array('table' => 'mst_tipe_pasien', 'cond' => 'mst_tipe_pasien.id = pdf_pasien.tipe_pasien_id', 'type' => 'INNER'),
        array('table' => 'mst_pegawai', 'cond' => 'mst_pegawai.id = pdf_pasien.dokter_id', 'type' => 'LEFT'),
        array('table' => 'mst_poli', 'cond' => 'mst_poli.id = pdf_pasien.poli_id', 'type' => 'LEFT'),
        array('table' => 'mst_perusahaan', 'cond' => 'mst_perusahaan.id = pdf_pasien.perusahaan_id', 'type' => 'LEFT'),
    );
    protected $fields = 'pdf_pasien.id AS id,
						pdf_pasien.no_reg AS no_reg,
						(pdf_pasien.created::date) AS tanggal_pendaftaran,
						(pdf_pasien.created::time) AS jam_pendaftaran,
						pdf_pasien.no_mr AS no_mr,
						pdf_pasien.rujukan_tanggal AS tanggal_rujukan,
						pdf_pasien.jenis_kunjungan AS jenis_kunjungan,
						pdf_pasien.diagnosa_sementara AS diagnosa_sementara,
						pdf_pasien.poli_id,
						mst_pasien.nama AS nama_pasien,
						pdf_pasien.alamat AS alamat_pasien,
						mst_tipe_pasien.nama AS tipe_pasien,
						mst_pegawai.nama AS dokter,
						mst_poli.nama AS poliklinik,
						mst_perusahaan.nama AS perusahaan,
						pdf_pasien.dirujuk_ke_poli_id';
    protected $orderby = array(
        'field' => 'pdf_pasien.created',
        'type' => 'desc'
    );

    function __construct() {
        $this->ci = & get_instance();
    }
    
    function drop_options($params = array() ) {
        $query = $this->db->select('id, no_reg, nama')
                ->where($params)
                ->order_by('nama', 'ASC')
                ->get($this->table);
        $result = $query->result();
        $options[''] = '';
        foreach ($result as $item) {
            $options[$item->id] = $item->no_reg . ' - '. $item->nama;
        }
        return $options;
    }

    function get_list_view($base_url = '', $offset = 0, $limit = 0) {
        // If base_url is empty, list all data.
        if (empty($base_url))
            return $this->db->get_where($this->table, array('status ' => 1))->result();
        else {
            $this->load->library('pagination');

            // Set pagination limit
            if (empty($limit)) {
                if ($this->input->get('page_limit'))
                    $limit = (int) $this->input->get('page_limit');
                else
                    $limit = $this->config->item('rows_limit');
            }

            // Set pagination offset
            if (empty($offset)) {
                if ($this->pagination->page_query_string)
                    $offset = (int) $this->input->get($this->pagination->query_string_segment);
                else {
                    $offset = $this->uri->segment(4);
                    if ($this->pagination->use_page_numbers && ($offset > 0))
                        $offset = ($offset - 1) * $limit;
                }
            }

            // Set base_url, 
            if ($this->pagination->page_query_string) {
                $last_char = substr($base_url, -1, 1);
                if ($last_char == '/')
                    $base_url .= '?';
                elseif ($last_char != '?')
                    $base_url .= '/?';
            }

            // Get number of rows
            foreach ($this->joins as $join) {
                $this->db->join($join['table'], $join['cond'], $join['type']);
            }
            $this->db->where(array("{$this->table}.status" => 1))->get($this->table, $limit, $offset);
            $row_counts = $this->db->count_all_results($this->table);

            // Create pagination
            $config['base_url'] = $base_url;
            $config['total_rows'] = $row_counts;
            $config['per_page'] = $limit;
            $this->pagination->initialize($config);

            // Execute query
            $this->db->select($this->fields);
            foreach ($this->joins as $join) {
                //var_dump($join[0], $join[1]);
                $this->db->join($join['table'], $join['cond'], $join['type']);
            }
            $this->db->order_by($this->orderby['field'], $this->orderby['type']);
            $query = $this->db->where(array("{$this->table}.status" => 1))->get($this->table, $limit, $offset);
            //echo $this->db->last_query(); die();
            return $query->result();
        }
    }

    function get_all_for_insert_layanan_lab() {

        $this->db->select('id, no_reg, no_mr, nama, alamat, rujukan_dari_id, rujukan_dari, rujukan_nama');
        $this->db->order_by($this->orderby['field'], $this->orderby['type']);
        $this->db->where("status_layanan", 0);
        $this->db->where("status", 1);
        $this->db->where("poli_id", $this->config->item('poli_id_laboratorium'));
        $query = $this->db->get($this->table);
        
        return $query->result();
    }
    
    function get_all_for_insert_layanan_rad() {

        $this->db->select($this->fields . ', status_layanan, dirujuk_ke_poli_id, dirujuk_ke_poli_nama, dirujuk_ke_dokter_id, dirujuk_ke_dokter_nama');
        foreach ($this->joins as $join) {
            $this->db->join($join['table'], $join['cond'], $join['type']);
        }
        $this->db->order_by($this->orderby['field'], $this->orderby['type']);
        $this->db->where("{$this->table}.status_layanan", 1);
        $this->db->where("{$this->table}.dirujuk_ke_poli_id", $this->config->item('poli_id_radiologi'));
        $this->db->or_where("{$this->table}.poli_id", $this->config->item('poli_id_radiologi'));
        $query = $this->db->get($this->table);
        
        return $query->result();
    }
    
    function get_all_for_insert_layanan_fisioterapi() {

        $this->db->select($this->fields);
        foreach ($this->joins as $join) {
            $this->db->join($join['table'], $join['cond'], $join['type']);
        }
        $this->db->order_by($this->orderby['field'], $this->orderby['type']);
        $query = $this->db->where(array("{$this->table}.dirujuk_ke_poli_id " => "{$this->ci->config->item('poli_id_radiologi')}",
                    "{$this->table}.status_layanan" => 1))->get($this->table);
        return $query->result();
    }
    
    function get_all_for_insert_apotek() {
        $arrParams = array();
        $arrParams['status_farmasi']= 0;
        $arrParams['status']        = 1;
        $arrParams['poli_id != ']   = $this->ci->config->item('poli_id_laboratorium');
        
        $this->db->select('id, no_reg, no_mr, nama, alamat, poli_id, poli_nama, dokter_id, dokter_nama');
        $this->db->order_by($this->orderby['field'], $this->orderby['type']);
        $query = $this->db->where($arrParams)->get($this->table);
        return $query->result();
    }

    function get_all_by_poli_to_insert_layanan($poli = null) {

        $this->db->distinct()
                ->select($this->fields . ', status_layanan, ' . $this->table . '.created');
        foreach ($this->joins as $join) {
            $this->db->join($join['table'], $join['cond'], $join['type']);
        }
        $this->db->order_by($this->orderby['field'], $this->orderby['type']);
        if($poli > 0){
            $this->db->where("{$this->table}.poli_id", $poli);
        }
        $this->db->where("{$this->table}.status", 1);
        $this->db->where("{$this->table}.status_layanan", 0);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    function get_all_inserted_layanan_rwj() {

        $this->db->select($this->fields . ', status_layanan');
        foreach ($this->joins as $join) {
            $this->db->join($join['table'], $join['cond'], $join['type']);
        }
        $this->db->order_by($this->orderby['field'], $this->orderby['type']);
        $this->db->where("{$this->table}.status_layanan", 2);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    function get_all_inserted_layanan_rwj_by_poli($poli) {

        $this->db->distinct()
                ->select($this->fields . ', status_layanan, ' . $this->table . '.created');
        foreach ($this->joins as $join) {
            $this->db->join($join['table'], $join['cond'], $join['type']);
        }
        $this->db->order_by($this->orderby['field'], $this->orderby['type']);
        $this->db->where("{$this->table}.poli_id", $poli);
        $this->db->where("{$this->table}.status_layanan", 2);
        $query = $this->db->get($this->table);
        return $query->result();
    }

    function get_by_id($id, $is_array = false) {
        $pasien_fields = array(
            $this->joins[0]['table'] . '.id AS pasien_id',
            $this->joins[0]['table'] . '.nama',
            $this->joins[0]['table'] . '.jenis_kelamin',
            $this->joins[0]['table'] . '.golongan_darah',
            $this->joins[0]['table'] . '.tempat_lahir',
            $this->joins[0]['table'] . '.tanggal_lahir',
            $this->joins[0]['table'] . '.agama',
            $this->joins[0]['table'] . '.kewarganegaraan',
            $this->joins[0]['table'] . '.negara',
            $this->joins[0]['table'] . '.nama_ayah',
            $this->joins[0]['table'] . '.nama_ibu',
            $this->joins[3]['table'] . '.nama AS poli_nama',
            $this->joins[2]['table'] . '.nama AS dokter_nama'
        );
        $this->db->select("{$this->table}.*", FALSE);
        $this->db->select($pasien_fields);
        $this->db->join($this->joins[0]['table'], $this->joins[0]['cond'], $this->joins[0]['type'], FALSE);
        $this->db->join($this->joins[2]['table'], $this->joins[2]['cond'], $this->joins[2]['type'], FALSE);
        $this->db->join($this->joins[3]['table'], $this->joins[3]['cond'], $this->joins[3]['type'], FALSE);
        $this->db->where("{$this->table}.id = " . $id);
        $this->db->where("{$this->table}.status = 1");
        $query = $this->db->get("{$this->table}");
        if ($query->num_rows() > 0)
            return $query->row();
        else
            return FALSE;
    }

    function get_by_no_reg($noReg) {
        $pasien_fields = array(
            $this->joins[0]['table'] . '.id AS pasien_id',
            $this->joins[0]['table'] . '.nama',
            $this->joins[0]['table'] . '.jenis_kelamin',
            $this->joins[0]['table'] . '.golongan_darah',
            $this->joins[0]['table'] . '.tempat_lahir',
            $this->joins[0]['table'] . '.tanggal_lahir',
            $this->joins[0]['table'] . '.agama',
            $this->joins[0]['table'] . '.kewarganegaraan',
            $this->joins[0]['table'] . '.negara',
            $this->joins[0]['table'] . '.nama_ayah',
            $this->joins[0]['table'] . '.nama_ibu',
            $this->joins[3]['table'] . '.nama AS poli_nama',
            $this->joins[2]['table'] . '.nama AS dokter_nama'
        );
        $this->db->select("{$this->table}.*", FALSE);
        $this->db->select($pasien_fields);
        $this->db->join($this->joins[0]['table'], $this->joins[0]['cond'], $this->joins[0]['type'], FALSE);
        $this->db->join($this->joins[2]['table'], $this->joins[2]['cond'], $this->joins[2]['type'], FALSE);
        $this->db->join($this->joins[3]['table'], $this->joins[3]['cond'], $this->joins[3]['type'], FALSE);
        $this->db->where("{$this->table}.no_reg = '" . $noReg . "'");
        $this->db->where("{$this->table}.status = 1");
        $query = $this->db->get("{$this->table}");
        if ($query->num_rows() > 0)
            return $query->row();
        else
            return FALSE;
    }

    function create_no_registrasi() {

        $maxNoUrut = 0;
        $rowMaxNoUrut = $this->db->select('MAX(LEFT(no_reg,7))::int AS max_no_urut', false)
                ->where("to_char(created,'MM')", date("m"))
                ->where("to_char(created,'YYYY')", date("Y"))
                ->get('pdf_pasien')
                ->row();
        if (isset($maxNoUrut)) {
            $maxNoUrut = $rowMaxNoUrut->max_no_urut;
        }
        $noUrutNext = (int) $maxNoUrut + 1;

        $noReg = substr('0000' . $noUrutNext, -6) . substr('0' . date("m"), -2) . date("y");
        return $noReg;
    }

    function create_no_antrian($poli_id = NULL) {
        $str_cond = ($poli_id == NULL) ? "ISNULL" : "= {$poli_id}";

        $sql = "SELECT no_antrian FROM {$this->table} WHERE created::date = now()::date AND poli_id {$str_cond} ORDER BY pdf_pasien.no_antrian DESC LIMIT 1";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return str_pad(((int) pos($query->row())) + 1, 3, '0', STR_PAD_LEFT); 
        } else {
            return str_pad(1, 3, '0', STR_PAD_LEFT); $this->utility->lead_zero(3, 1);
        }
    }

    function autocomplete_no_reg() {
        $select = array(
            "lpad({$this->table}.id::text, 10, '0') AS no_reg",
            $this->joins[0]['table'] . '.nama AS pasien_nama',
            $this->joins[3]['table'] . '.nama AS poli_nama',
            $this->joins[2]['table'] . '.nama AS dokter_nama'
        );
        $this->db->select($select);
        $this->db->select("{$this->table}.*");
        $this->db->from($this->table);
        $this->db->join($this->joins[0]['table'], $this->joins[0]['cond'], $this->joins[0]['type']);
        $this->db->join($this->joins[2]['table'], $this->joins[2]['cond'], $this->joins[2]['type']);
        $this->db->join($this->joins[3]['table'], $this->joins[3]['cond'], $this->joins[3]['type']);
        $this->db->like("no_reg", $_GET['term']);
        $this->db->order_by("{$this->table}.id", 'ASC');
        $query = $this->db->get();
        $result = $query->result();
        $arrData = array();

        if (empty($result)) {
            $arrData[] = array('' => '');
        } else {
            foreach ($result as $row) {
                $arrData[] = array(
                    'label' => $row->no_reg,
                    'value' => $row->no_reg,
                    'id' => $row->id,
                    'no_mr' => $row->no_mr,
                    'alamat' => $row->alamat,
                    'pasien_nama' => $row->pasien_nama,
                    'poli_nama' => $row->poli_nama,
                    'dokter_nama' => $row->dokter_nama
                );
            }
        }

        return $arrData;
    }

    function autocomplete_pasien($params = array()) {
        $this->db->select('pdf_pasien.id,pdf_pasien.no_reg, pdf_pasien.no_mr, pdf_pasien.alamat, mst_pasien.nama AS pasien_nama, mst_poli.nama AS poli_nama, mst_pegawai.nama AS dokter_nama');
        $this->db->from($this->table);
        $this->db->join('mst_pasien', 'mst_pasien.no_mr = ' . $this->table . '.no_mr ', false);
        $this->db->join('mst_pegawai', 'mst_pegawai.id = ' . $this->table . '.dokter_id ', false);
        $this->db->join('mst_poli', 'mst_poli.id = ' . $this->table . '.poli_id ', false);
        $this->db->where($params);
        $this->db->where("(no_reg ILIKE '%".$_GET['term']."%' OR pdf_pasien.no_mr ILIKE '%".$_GET['term']."%' OR mst_pasien.nama ILIKE '%".$_GET['term']."%')");
        $this->db->order_by("{$this->table}.no_reg", 'ASC');
        $query = $this->db->get();
        $result = $query->result();
        $arrData = array();

        if (empty($result)) {
            $arrData[] = array('id' => 0, 'value' => 'Pasien tidak ditemukan.');
        } else {
            foreach ($result as $row) {
                $arrData[] = array(
                    'label' => $row->no_reg . ' - ' . $row->pasien_nama,
                    'value' => $row->no_reg,
                    'id' => $row->id,
                    'no_mr' => $row->no_mr,
                    'alamat' => $row->alamat,
                    'pasien_nama' => $row->pasien_nama,
                    'poli_nama' => $row->poli_nama,
                    'dokter_nama' => $row->dokter_nama
                );
            }
        }

        return $arrData;
    }
    
    function autocomplete_pasien_inserted_tindakan() {
        $this->db->select('pdf_pasien.id,pdf_pasien.no_reg, pdf_pasien.no_mr, pdf_pasien.alamat, mst_pasien.nama AS pasien_nama, mst_poli.nama AS poli_nama, mst_pegawai.nama AS dokter_nama');
        $this->db->from($this->table);
        $this->db->join('mst_pasien', 'mst_pasien.no_mr = ' . $this->table . '.no_mr ', false);
        $this->db->join('mst_pegawai', 'mst_pegawai.id = ' . $this->table . '.dokter_id ', false);
        $this->db->join('mst_poli', 'mst_poli.id = ' . $this->table . '.poli_id ', false);
        $this->db->where(array('status_layanan' => 2));
        $this->db->like("no_reg", $_GET['term']);
        $this->db->or_like("LOWER(mst_pasien.nama)", strtolower($_GET['term']));
        $this->db->order_by("{$this->table}.no_reg", 'ASC');
        $query = $this->db->get();
        $result = $query->result();
        $arrData = array();

        if (empty($result)) {
            $arrData[] = array('id' => 0, 'value' => 'Pasien tidak ditemukan.');
        } else {
            foreach ($result as $row) {
                $arrData[] = array(
                    'label' => $row->no_reg . ' - ' . $row->pasien_nama,
                    'value' => $row->no_reg,
                    'id' => $row->id,
                    'no_mr' => $row->no_mr,
                    'alamat' => $row->alamat,
                    'pasien_nama' => $row->pasien_nama,
                    'poli_nama' => $row->poli_nama,
                    'dokter_nama' => $row->dokter_nama
                );
            }
        }

        return $arrData;
    }

    

    function get_lima_terbaru() {

        $this->db->distinct()->select($this->fields . ', ' . $this->table . '.created');
        foreach ($this->joins as $join) {
            $this->db->join($join['table'], $join['cond'], $join['type']);
        }
        $this->db->order_by("({$this->table}.created)", 'DESC');
        $query = $this->db->limit(10)->where(array(
                    "{$this->table}.status_layanan" => 1))
                ->order_by("({$this->table}.created)", 'DESC')
                ->limit(5)
                ->get($this->table);
        return $query->result();
    }

    function get_all_by_date($date) {

        $this->db->select($this->fields);
        foreach ($this->joins as $join) {
            $this->db->join($join['table'], $join['cond'], $join['type']);
        }
        $this->db->order_by($this->orderby['field'], $this->orderby['type']);
        $query = $this->db->where(array(
                    "{$this->table}.status_layanan" => 1,
                    "({$this->table}.created::date)" => $date))
                ->get($this->table);
        return $query->result();
    }

    function get_jumlah_group_by_tipe_by_date($date) {

        $this->db->select('tipe_pasien_id, COUNT(id) AS jumlah');
        $query = $this->db->where(array(
                    "({$this->table}.created::date)" => $date))
                ->group_by('tipe_pasien_id')
                ->get($this->table);
        $result = $query->result();
        return $result;
    }

    function get_jumlah_group_by_tipe_by_month($month) {

        $this->db->select('tipe_pasien_id, COUNT(id) AS jumlah');
        $query = $this->db->where(array(
                    "EXTRACT(MONTH FROM pdf_pasien.created::date) = " . $month => null))
                ->group_by('tipe_pasien_id')
                ->get($this->table);
        $result = $query->result();
        return $result;
    }

    function pasien_hari_ini_by_jenis_kunjungan($jenisKunjungan = null) {

        $query = $this->db->where('created::date', "'" . date('Y-m-d', now()) . "'", false)
                ->where('jenis_kunjungan', "'" . $jenisKunjungan . "'", false)
                ->where('status', 1, false)
                ->where('status_layanan', 1, false)
                ->get($this->table);
        $result = $query->result();
        return $result;
    }

    function jml_pasien_hari_ini_by_jenis_kunjungan($jenisKunjungan = null) {

        $query = $this->db->select('COUNT(id) AS numrows', false)
                ->where('created::date', "'" . date('Y-m-d', now()) . "'", false)
                ->where('jenis_kunjungan', "'" . $jenisKunjungan . "'", false)
                ->get($this->table, 1, false);
        $row = $query->row();
        $result = $row->numrows;
        return $result;
    }

    function get_all_pemeriksaan_by_mr($no_mr) {
        $this->db->select($this->table . '.no_reg,
                    ' . $this->table . '.created,    
                    ' . $this->table_ply . '.keluhan,
                    ' . $this->table_ply . '.tinggi_badan,
                    ' . $this->table_ply . '.berat_badan,
                    ' . $this->table_ply . '.tensi,
                    ' . $this->table_ply . '.suhu,
                    ' . $this->table_ply . '.nadi,
                    ' . $this->table_ply . '.anamnesa,
                    ' . $this->table_ply . '.diagnosa,
                    mst_poli.nama as poli', FALSE)
                ->from($this->table)
                ->join($this->table_ply, $this->table_ply . '.pendaftaran_id = ' . $this->table . '.id', FALSE)
                ->join('mst_poli', 'mst_poli.id = ' . $this->table_ply . '.poli_id', FALSE)
                ->where(array($this->table . '.no_mr' => $no_mr, $this->table . '.status' => '1'));
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function get_all_tindakan_by_mr($no_mr) {
        $this->db->select($this->table . '.no_reg,
                    ' . $this->table . '.created,    
                    mst_poli.nama as poli,
                    mst_tindakan.nama as tindakan,
                    mst_pegawai.nama as dokter,
                    ' . $this->table_ply_tindakan . '.banyaknya,
                    ' . $this->table_ply_tindakan . '.created as tgl_tindakan', FALSE)
                ->from($this->table)
                ->join($this->table_ply, $this->table_ply . '.pendaftaran_id = ' . $this->table . '.id', FALSE)
                ->join($this->table_ply_tindakan, $this->table_ply_tindakan . '.pelayanan_rawat_jalan_id = ' . $this->table_ply . '.id AND ' . $this->table_ply_tindakan . '.status = 1', FALSE)
                ->join('mst_tindakan', 'mst_tindakan.id = ' . $this->table_ply_tindakan . '.tindakan_id', FALSE)
                ->join('mst_pegawai', 'mst_pegawai.id = ' . $this->table_ply_tindakan . '.pegawai_id', FALSE)
                ->join('mst_poli', 'mst_poli.id = ' . $this->table_ply . '.poli_id', FALSE)
                ->where(array($this->table . '.no_mr' => $no_mr, $this->table . '.status' => '1'))
                ->order_by($this->table . '.no_reg');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    function get_all_bhp_by_mr($no_mr) {
        $this->db->select($this->table . '.no_reg,
                    ' . $this->table . '.created,    
                        mst_poli.nama as poli,
                        mst_farmasi.nama as obat_bhp,
                    ' . $this->table_ply_farmasi . '.banyaknya,
                    ' . $this->table_ply_farmasi . '.created as tgl_tindakan', FALSE)
                ->from($this->table)
                ->join($this->table_ply, $this->table_ply . '.pendaftaran_id = ' . $this->table . '.id', FALSE)
                ->join($this->table_ply_farmasi, $this->table_ply_farmasi . '.pelayanan_rawat_jalan_id::numeric = ' . $this->table_ply . '.id AND ' . $this->table_ply_farmasi . '.status = 1', FALSE)
                ->join('mst_farmasi', 'mst_farmasi.id = ' . $this->table_ply_farmasi . '.farmasi_id', FALSE)   
                ->join('mst_poli', 'mst_poli.id = ' . $this->table_ply_farmasi . '.poli_id', FALSE)
                ->where(array($this->table . '.no_mr' => $no_mr, $this->table . '.status' => '1'))
                ->order_by($this->table . '.no_reg');
        $query = $this->db->get();
        $result = $query->result();
        return $result;       
    }
    
    function get_all_obat_by_mr($no_mr) {
        $this->db->select($this->table . '.no_reg,
                    ' . $this->table . '.created,    
                       mst_farmasi.nama as obat_apt,
                    ' . $this->table_apt_item . '.banyaknya,   
                       mst_satuan.nama as satuan,
                    ' . $this->table_apt_item . '.created as tgl_obat', FALSE)
                ->from($this->table)
                ->join($this->table_apt, $this->table_apt . '.pendaftaran_id = ' . $this->table . '.id', FALSE)
                ->join($this->table_apt_item, $this->table_apt_item . '.apotek_rawat_jalan_id = ' . $this->table_apt . '.id AND ' . $this->table_apt_item . '.status = 1', FALSE)
                ->join('mst_farmasi', 'mst_farmasi.id = ' . $this->table_apt_item . '.item_id', FALSE)   
                ->join('mst_satuan', 'mst_satuan.id = ' . $this->table_apt_item . '.satuan_id', FALSE)
                ->where(array($this->table . '.no_mr' => $no_mr, $this->table . '.status' => '1'))
                ->order_by($this->table . '.no_reg');
        $query = $this->db->get();
        $result = $query->result();
        return $result;               
    }
    
}
