<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_user extends CI_Controller {
	
	public $data = array('base_url' => '', 'menu' => '', 'pagination' => '', 'dt_table' => '', 'modul' => '',
						 'tombol' => '','photo' => '', 'marker' => '', 'printdata' => '', 'formatprint' => '');
	public $base_url ='', $cari='';
	
	public function __construct() {
		parent::__construct();
		$this->data['base_url']= $this->config->base_url();
		$this->base_url = $this->config->base_url();
		$this->data['menu'] = $this->ex->menu('backend');
	}
		
	public function index($arg0=0, $arg1=0){
		$this->data['modul'] = 'c_user/index/1';
		$a_cari = $this->input->post('cari');
		$b_cari = !isset($a_cari)?"":" WHERE PII_NM LIKE '%" . $a_cari . "%' OR PII_UE LIKE '%".  $a_cari ."%'";
		$this->data['dt_table'] = 'NO RESULT' . $this->ex->redirect('index.php/c_user');
		$this->data['base_url'] = $this->config->base_url();
		$this->base_url = $this->config->base_url();
		
		//pagination
		$query = $this->db->query("SELECT * FROM TB_PII");
		$banyakRow = $query->num_rows();
		$config['base_url'] = $this->base_url ."index.php/c_user/index/";
		$config['total_rows'] = $banyakRow;
		$config['per_page'] = 5; 
		$this->pagination->initialize($config);
		$this->data['pagination']= $this->pagination->create_links();
		//--EOF paginaion
		
		if(!$this->session->userdata('LGN')){
			echo "<script type='text/javascript'>window.location='" . $this->config->base_url() . "';</script>"; //redirect
		}else if($this->session->userdata('ADM')==1){
			$query = $this->db->query("SELECT PII_ID, PII_NM, PII_UE, PII_PII FROM TB_PII ". $b_cari ." ORDER BY PII_ID DESC limit ". $arg1 .",5");
			if ($query->num_rows() > 0){
				$this->data['dt_table'] ='';
				foreach ($query->result() as $row){
					$PII = $row->PII_PII=='1' ? 'Admin' : 'User'; //ternarry operation
					$urledit = "c_user/edit/".$row->PII_ID;
					$urldelete = "c_user/delete/".$row->PII_ID;
					$this->data['dt_table'] .= $this->ex->getList('','<b>'.$row->PII_NM.'</b><br/> Username : '.$row->PII_UE.'<br/>Hak Kuasa : '.$PII.'',
											   '','',$urledit, $urldelete);
				}
				
			}
			$this->data['tombol'] .= '<a href="'.$this->base_url.'index.php/c_user/tambah" name="edit" class="edit-button btn btn-info">Tambah User</a>';
			$this->load->view('v_backend', $this->data);
			
		}else{
			echo $this->ex->redirect();
		}
	}
	
	public function tambah($arg1=""){
		if(!$this->session->userdata('LGN')){
			echo "<script type='text/javascript'>window.location='" . $this->base_url . "';</script>"; //redirect
		}else{
			if(!$arg1=="save"){
				$this->data['dt_table']= "<form method='POST' action=". $this->base_url ."index.php/c_user/tambah/save>
											Nama : <input type='text' name='NM' size='15' maxlength='150' /><br />
											Username: <input type='text' name='UE' maxlength='150' size='15' /><br />
											Password: <input type='password' name='PSW' maxlength='150' size='15' /><br />
											Privilege : 
											<select name='PII' >
											  <option value='1'>Admin</option>
											  <option value='2'>User</option>
											</select><br/>
											<button type='submit' value='Save' name='detail' class='edit-button btn btn-primary'>Simpan</button>
											&nbsp;<button type='reset' value='Reset' name='detail' class='edit-button btn btn-primary'>Reset</button>
										 </form>";
				$this->load->view('v_backend', $this->data);
			}else{
				$nm = $this->input->post('NM');
				$ue = $this->input->post('UE');
				$psw = md5(md5($this->input->post('PSW')));
				$pii = $this->input->post('PII');
				
				$query = $this->db->query("INSERT INTO TB_PII VALUES(NULL,'".$ue."','".$psw."','".$nm."','".$pii."')");
				//E01
				if(!$this->db->affected_rows()==1){
					echo "E01";
				}else{
					$this->data['dt_table'] = "<div class='alert alert-success'><h4>Berhasil Tambah</h4></div>" . $this->ex->redirect("index.php/c_user/");
					$this->load->view('v_backend', $this->data);
				}
			}
		}		
	}
	
	public function edit($arg1=""){
		if(!$this->session->userdata('LGN')){
			echo "<script type='text/javascript'>window.location='" . $this->config->base_url() . "';</script>"; //redirect
		}else{
			if($arg1>0||$arg1!="save"){
				$query = $this->db->query("SELECT PII_ID, PII_NM, PII_UE, PII_PII FROM TB_PII WHERE PII_ID=". $arg1);
				if ($query->num_rows() > 0){
					$this->data['dt_table'] = "";
					foreach ($query->result() as $row){
						$this->data['dt_table'] ="<form method='POST' action=". $this->base_url ."index.php/c_user/edit/save>
													<input type='hidden' name='ID' value='".$arg1."' />
													Nama : <input type='text' name='NM' size='15' value='". $row->PII_NM ."' /><br />
													Username: ".$row->PII_UE."<br />
													Password: <input type='password' name='PSW' maxlength='150' size='15' /> [Kosongkan jika password tidak akan diganti]<br />
													Privilege : 
													<select name='PII' >
													  <option value='1'>Admin</option>
													  <option value='2'>User</option>
													</select><br/>
													<button type='submit' value='Save' name='detail' class='edit-button btn btn-primary'>Simpan</button>
													&nbsp;<button type='reset' value='Reset' name='detail' class='edit-button btn btn-primary'>Reset</button>
												 </form>";
						$this->load->view('v_backend', $this->data);
					}
					//$this->load->view('v_user', $data);
				}else{
					echo "E02"; //E02
					//echo "<script type='text/javascript'>window.location='" . $this->config->base_url() . "';</script>"; //redirect
				}
			}else if($arg1=='save'){
				if($this->input->post('PSW')!==''){				
					$simpan = array('PII_NM' => $this->input->post('NM'), 
										'PII_PSW' => md5(md5($this->input->post('PSW'))),
										'PII_PII' => $this->input->post('PII'));
				}else{
					$simpan = array('PII_NM' => $this->input->post('NM'), 
										'PII_PII' => $this->input->post('PII'));
				}
				$this->db->where('PII_ID', $this->input->post('ID'));
				$this->db->update('TB_PII', $simpan);
				$this->data['dt_table'] = "<div class='alert alert-success'><h4>Data Berhasil Diubah</h4></div>" . $this->ex->redirect("index.php/c_user");
				$this->load->view('v_backend', $this->data);
			}
		}
	}
	
	public function delete($arg1=""){
		$this->data['base_url'] = $this->config->base_url();
		$this->base_url = $this->config->base_url();
		if(!$this->session->userdata('LGN')){
			echo "<script type='text/javascript'>window.location='" . $this->config->base_url() . "';</script>"; //redirect
		}else{
			$query = $this->db->query("DELETE FROM TB_PII WHERE PII_ID=" . $arg1);
			//E04
			if(!$this->db->affected_rows()==1){
				echo "E04";
			}else{
				$this->data['dt_table'] = "<div class='alert alert-success'><h4>Data Berhasil Dihapus</h4></div>" . $this->ex->redirect("index.php/c_user");
				$this->load->view('v_backend', $this->data);
			}
		}
	}
}