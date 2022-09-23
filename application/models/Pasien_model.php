<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pasien_model extends MY_Model 
{
	protected $table	= 'mst_pasien';
	protected $table_pdf	= 'pdf_pasien';
	protected $table_ply	= 'ply_rawat_jalan';
	protected $id_field = 'id';
	
	function __construct()
	{
            
	}	

	function get_by_no_mr($noMR)
	{
		$query = $this->db->get_where($this->table, array($this->table . '.no_mr'=> $noMR));
		if ($query->num_rows() > 0)
			return $query->row();
		else
			return FALSE;
	}
        
	function get_by_no_kartu_bpjs($noMR)
	{
		$query = $this->db->get_where($this->table, array($this->table . '.no_mr'=> $noMR));
		if ($query->num_rows() > 0)
			return $query->row();
		else
			return FALSE;
	}
	
        function get_user_pdf_to_ply_distinct(){
            $this->db->select('DISTINCT '.$this->table.'.nama,
                              '.$this->table.'.no_mr,
                              '.$this->table.'.alamat,
                              '.$this->table.'.jenis_kelamin', FALSE)
            ->from($this->table)
            ->join($this->table_pdf, $this->table_pdf.'.no_mr = '.$this->table.'.no_mr AND '.$this->table_pdf.'.status = 1', FALSE)
            ->join($this->table_ply, $this->table_ply.'.pendaftaran_id = '.$this->table_pdf.'.id', FALSE);
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }
        
        function get_user_pdf_to_ply($no_mr){
            $this->db->select('DISTINCT '.$this->table.'.nama,
                              '.$this->table.'.no_mr,
                              '.$this->table.'.alamat,
                              '.$this->table.'.jenis_kelamin,
                              '.$this->table_pdf.'.no_reg,
                              '.$this->table_pdf.'.ID AS pdf_id,
                              '.$this->table_ply.'.ID AS ply_rj_id', FALSE)
            ->from($this->table)
            ->join($this->table_pdf, $this->table_pdf.'.no_mr = '.$this->table.'.no_mr AND '.$this->table_pdf.'.status = 1', FALSE)
            ->join($this->table_ply, $this->table_ply.'.pendaftaran_id = '.$this->table_pdf.'.id', FALSE)
            ->where(array($this->table_pdf.'.no_mr' => $no_mr));
            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }
        
	function search($param = NULL)
	{
		$query = $this->db
			->like('LOWER('. $this->table.'.no_mr)', strtolower($param), 'both', FALSE)
                                  ->or_like('LOWER('. $this->table.'.nama)', strtolower($param), 'both', FALSE)
                                  ->or_like('LOWER('. $this->table.'.alamat)', strtolower($param), 'both', FALSE)
                                  ->get($this->table);
		if ($query->num_rows() > 0)
			return $query->result();
		else
			return FALSE;
	}
	
	function create_no_mr(){
            
		$query = $this->db->query('SELECT LAST_VALUE AS no_mr_next FROM '.$this->table.'_seq');
                
		if ($query->num_rows() > 0){
                        $result = $query->row();
			return str_pad($result->no_mr_next,9, '0', STR_PAD_LEFT);
		}
		else{
			return str_pad(1, 9, '0', STR_PAD_LEFT);
		}
	}
	
	function autocomplete() {

        $query = $this->db->select('id, no_mr, nama,alamat')
                ->like('LOWER(no_mr)', strtolower($_GET['term']))
                ->or_like('LOWER('. $this->table.'.nama)', strtolower($_GET['term']), 'both', FALSE)
                ->or_like('LOWER('. $this->table.'.alamat)', strtolower($_GET['term']), 'both', FALSE)
                ->order_by('nama', 'ASC')
                ->get($this->table);
        $result = $query->result();
		$arrData = array();
                if(!empty($result)):
        foreach ($result as $row) {
            $arrData[] = array(
            	'label' => $row->no_mr.' - '.$row->nama,
            	'value' => $row->no_mr,
            	'id' => $row->id,
//            	'no_mr' => $row->no_mr,
//            	'nama' => $row->nama,
//            	'tipe_pasien_id' => $row->tipe_pasien_id,
//            	'jenis_kelamin' => $row->jenis_kelamin,
//            	'golongan_darah' => $row->golongan_darah,
//            	'tempat_lahir' => $row->tempat_lahir,
//            	'tanggal_lahir' => $row->tanggal_lahir,
//            	'umur_tahun' => $row->umur_tahun,
//            	'umur_bulan' => $row->umur_bulan,
//            	'umur_hari' => $row->umur_hari,
//            	'pendidikan_terakhir' => $row->pendidikan_terakhir,
//            	'pekerjaan' => $row->pekerjaan,
//            	'no_identitas' => $row->no_identitas,
//            	'agama' => $row->agama,
//            	'kewarganegaraan' => $row->kewarganegaraan,
//            	'negara' => $row->negara,
//            	'status_perkawinan' => $row->status_perkawinan,
//            	'nama_pasangan' => $row->nama_pasangan,
//            	'nama_ayah' => $row->nama_ayah,
//            	'nama_ibu' => $row->nama_ibu,
            	'alamat' => $row->alamat,
//            	'telepon' => $row->telepon,
//            	'telepon_kantor' => $row->telepon_kantor,
			);
        }
        else:
            $arrData[] = array(
            	'label' => '',
            	'value' => 'Pencarian tidak ditemukan',
            	'alamat' => '',
            	'id' => '0');
        endif;
        return $arrData;
    }
}
