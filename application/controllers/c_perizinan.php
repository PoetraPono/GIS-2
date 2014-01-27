<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_perizinan extends CI_Controller {

	public $data = array('base_url' => '', 'menu' => '', 'pagination' => '', 'dt_table' => '', 'modul' => 'c_perizinan/index/1',
						 'tombol' => '');
	public $base_url ='', $cari='';
	
	public function __construct() {
		parent::__construct();

		if(!$this->session->userdata('SSI_LGN_')) echo $this->m_var->redirect('index.php','500');
		$this->data['base_url']= $this->config->base_url();
		$this->base_url = $this->config->base_url();
		$this->data['menu'] = $this->ex->menu();
	}
	
	public function index(){
		echo $this->ex->redirect();
	}
	
	public function tambah($arg1='', $arg2=''){
		if(!$arg2=='save'){
			$this->data['dt_table'] = '<form method="POST" action="'.$this->base_url.'index.php/c_perizinan/tambah/'.$arg1.'/save">
								Nama Perizinan   : '.$this->ex->list_perizinan().'<br/>
								Masa Perizinan   : '.$this->ex->kalender().'
								<input type="hidden" name="redirect" value="'.$this->base_url.'index.php/c_perusahaan/'.$arg1.'" />
								<input type="hidden" name="prs_id" value="'.$arg1.'" /><br/>
								<button type="submit" name="detail" class="edit-button btn btn-primary" value="Save">Simpan</button>
							</form>';
		}else if($arg2=='save'){
			$query = $this->db->query("SELECT a.PRS_ID, c.PRZ_NM, a.MSPRZ_MS_BR, b.PRS_NM FROM TB_MSPRZ a, TB_PRS b, TB_PRZ c
									    WHERE a.PRS_ID = ".$this->input->post('prs_id')." AND 
										a.PRZ_ID = ".$this->input->post('prz_nm')."");
			if($query->num_rows()>0){
				$row = $query->row();
				$this->data['dt_table'] = "<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>&times;</button>
										  <strong>Gagal Tambah!!</strong> Perusahaan ".$row->PRS_NM." sudah mempunyai Perizinan " . $row->PRZ_NM . "</div>";
				$this->data['dt_table'] .= $this->ex->redirect('index.php/c_perusahaan/detail/' . $row->PRS_ID,'2000');
			}else{
				$simpan = array(
				   'MSPRZ_ID' => NULL ,
				   'PRZ_ID' => $this->input->post('prz_nm'),
				   'PRS_ID' => $this->input->post('prs_id'),
				   'MSPRZ_MS_BR' => $this->input->post('thn') ."-". $this->input->post('bln') ."-". $this->input->post('tgl')
				);
				$this->data['dt_table'] = "<div class='alert alert-success'><h4>Data Berhasil Tersimpan</h4></div>" . $this->ex->redirect("index.php/c_perusahaan/detail/". $arg1);
				$this->db->insert('TB_MSPRZ', $simpan);
			}
		}
		$this->load->view('v_backend', $this->data);
	}
	
	public function edit($arg1=''){
		if($arg1=='save'){
			
		}else{
			$this->data['dt_table'] = '<form method="POST" action="'.$this->base_url.'index.php/c_perizinan/tambah/'.$arg1.'/save">
								Nama Perizinan   : '.$this->ex->list_perizinan().'<br/>
								Masa Perizinan   : '.$this->ex->kalender().'
								<input type="hidden" name="redirect" value="'.$this->base_url.'index.php/c_perusahaan/'.$arg1.'" />
								<input type="hidden" name="prs_id" value="'.$arg1.'" /><br/>
								<button type="submit" name="detail" class="edit-button btn btn-primary" value="Save">Simpan</button>
							</form>';
			$query=$this->db->query("SELECT PRZ_ID, MSPRZ_MS_BR from TB_MSPRZ WHERE MSPRZ_ID=".$arg1);
			$row= $query->row_array();
			$thn = substr($row['MSPRZ_MS_BR'],0,4);
			$bln = substr($row['MSPRZ_MS_BR'],5,2);
			$tgl = substr($row['MSPRZ_MS_BR'],8,2);
			$data['base_url'] = $this->config->base_url();
			$data['redirect'] = $this->input->post('linknya');
			$data['nm_list'] = $this->ex->list_perizinan($row['PRZ_ID'],"disabled");
			$data['kalender'] = $this->ex->kalender($tgl, $bln, $thn);
			$data['prs_id'] = $this->input->post('prs_id');
			$this->load->view('v_tambah_mizin', $data);
		}
	}
	
	public function delete($arg0='',$arg1=''){
		$this->db->delete('TB_MSPRZ', array('MSPRZ_ID' => $arg1));
		$this->data['dt_table'] = $this->ex->redirect('index.php/c_perusahaan/detail/'.$arg0);
		$this->load->view('v_backend', $this->data);
	}
}