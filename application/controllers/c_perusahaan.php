<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class C_perusahaan extends CI_Controller {
		
		public $data = array('base_url' => '', 'menu' => '', 'pagination' => '', 'dt_table' => '', 'modul' => '',
							 'tombol' => '', 'photo' => '');
		public $base_url ='', $cari='';

		public function __construct() {
			parent::__construct();

			$this->data['base_url']= $this->config->base_url();
			$this->base_url = $this->config->base_url();
			$this->data['menu'] = $this->ex->menu('backend');
		}
		
		public function index($arg0=0,$arg1=0,$arg2=6){
			$this->data['modul'] = 'c_perusahaan/index/1';
			if($arg0==0){
				$this->session->set_userdata('cari', '');
			}else if($arg0==1){
				$this->session->set_userdata('cari', $this->input->post('cari'));
			}
			
			$this->cari = $this->session->userdata('cari');
			
			//--default if result not found and redirect
			$this->data['dt_table'] = '<b>Tidak ada Hasil Pencarian dari ' .$this->input->post('cari').'</b>'.
									  $this->ex->redirect("index.php/c_perusahaan"); 
			//--
			
			$q = $this->cari==""?"SELECT * FROM TB_PRS ORDER BY PRS_ID DESC limit ".$arg1.",".$arg2."":
				 "SELECT * FROM TB_PRS WHERE PRS_NM LIKE '%". $this->cari ."%' ORDER BY PRS_ID DESC limit ".$arg1.",".$arg2."";
			$this->data['base_url'] = $this->config->base_url();
			$base_url = $this->config->base_url();

			//--pagination
			$query = $this->cari==""?$this->db->get("TB_PRS"):
					 $this->db->query("SELECT * FROM TB_PRS WHERE PRS_NM LIKE '%". $this->cari ."%'");
			$banyakRow = $query->num_rows();
			$config['base_url'] = $base_url ."index.php/c_perusahaan/index/2/";
			$config['total_rows'] = $banyakRow;
			$config['per_page'] = $arg2; 
			$config['uri_segment'] = 4;
			$this->pagination->initialize($config);
			$this->data['pagination']= "<div class='pagination'>" . $this->pagination->create_links() . "</div>";
			//--EOF paginaion
			
			$urledit ='';
			$urldelete='';
			
			if(!$this->session->userdata('LGN')){
				echo $this->ex->redirect();
			}else{
				$query = $this->db->query($q);
				if ($query->num_rows() > 0){
					$this->data['dt_table'] = $arg0==1?'Pencarian Berdasarkan Kata "' . $this->cari . '" ':'';
					foreach ($query->result() as $row){
						if($this->session->userdata('ADM')==1){
							$urledit = "c_perusahaan/edit/".$row->PRS_ID;
							$urldelete = "c_perusahaan/delete/".$row->PRS_ID;
						}
						$this->data['dt_table'] .= $this->ex->getList('','<b>'.$row->PRS_NM.'</b><br/>'.substr($row->PRS_AL,0,100).'...<br/>'.substr($row->PRS_KT,0,50).'...',
										'c_perusahaan/detail/'.$row->PRS_ID,'',$urledit, $urldelete);
					}
					$this->data['tambah'] = $this->session->userdata('ADM')==1 ? "<a href='".$base_url."index.php/c_perusahaan/tambah'>TAMBAH</a>":"";
					
				}
				if($this->session->userdata('ADM')==1){ 
					$this->data['tombol'] .= '<a href="'.$this->base_url.'index.php/c_perusahaan/tambah" name="edit" class="edit-button btn btn-info">Tambah Perusahaan</a>';
				}
				$this->load->view('v_backend', $this->data);
			}
		}
		
		public function tambah($arg1=""){
			$base_url = $this->config->base_url();
			$this->data['mode']='tambah';
			$this->data['id'] = '';
			if(!$this->session->userdata('LGN')){
				echo $this->ex->redirect();
			}else if($this->session->userdata('ADM')==1){
				if(!$arg1=="save"){
					$this->data['dt_table'] = '<h3>Tambah Perusahaan</h3><form method="POST" action="'.$this->base_url.'index.php/c_perusahaan/tambah/save">
									Nama Perusahaan   : <input type="text" name="NM" style="width:300px" maxlength="150" /><br />
									Alamat Perusahaan : <textarea name="AL" style="width:300px;height:100px;"></textarea><br />
									Telepon Perusahaan : <input type="text" name="TL" style="width:300px" maxlength="150" /><br />
									Kategori Perusahaan : <input type="text" name="KT" style="width:300px" maxlength="150" /><br/>
									Tentang Perusahaan : <textarea name="TN" style="width:300px;height:100px;"></textarea><br/>
									<input type="hidden" name="ID" />
									<button type="submit" value="Save" name="detail" class="edit-button btn btn-primary">Simpan</button>
									<button type="reset" value="Reset" name="detail" class="edit-button btn btn-primary">Reset</button>
								</form>';
					$this->load->view('v_backend', $this->data);
				}else{
					$nm = $this->input->post('NM');
					$al = $this->input->post('AL');
					$tl = $this->input->post('TL');
					$kt = $this->input->post('KT');
					$tn = $this->input->post('TN');
					
					$query = $this->db->query("INSERT INTO TB_PRS VALUES(NULL,'".$nm."','".$al."','".$tl."','".$kt."','".$tn."')");
					//E01
					if(!$this->db->affected_rows()==1){
						echo "E01";
					}else{
						$this->data['dt_table'] = "<div class='alert alert-success'><h4>Data Berhasil Tersimpan</h4></div>" . $this->ex->redirect("index.php/c_perusahaan");
					$this->load->view('v_backend', $this->data);
					}
				}
			}else{
				echo $this->ex->redirect();
			}
		}
		
		public function edit($arg1=""){
			$hasil='';
			$this->data['mode']='edit';
			if(!$this->session->userdata('LGN')){
				echo $this->ex->redirect();
			}else if($this->session->userdata('ADM')==1){
				if($arg1>0||$arg1!="save"){
					$query = $this->db->query($this->m_query->q_prs_w . " WHERE PRS_ID=". $arg1);
					if ($query->num_rows() > 0){
						$this->data['dt_table'] = "";
						$row=$query->row();
						$this->data['dt_table'] = '<h3>Ubah Perusahaan</h3><form method="POST" action="'.$this->base_url.'index.php/c_perusahaan/edit/save">
									Nama Perusahaan   : <input type="text" name="NM" value="'.$row->PRS_NM.'" style="width:300px" maxlength="150" /><br />
									Alamat Perusahaan : <textarea name="AL" style="width:300px;height:100px;">'.$row->PRS_AL.'</textarea><br />
									Telepon Perusahaan : <input type="text" name="TL" style="width:300px" value="'.$row->PRS_TL.'" maxlength="150" /><br />
									Kategori Perusahaan : <input type="text" name="KT" style="width:300px" value="'.$row->PRS_KT.'" maxlength="150" /><br/>
									Tentang Perusahaan : <textarea name="TN" style="width:300px;height:100px;">'.$row->PRS_TN.'</textarea><br/>
									<input type="hidden" name="ID" value="'.$row->PRS_ID.'" />
									<button type="submit" name="detail" class="edit-button btn btn-primary" value="Save">Simpan</button>&nbsp;
									<button type="reset" name="detail" class="edit-button btn btn-warning" value="Save">Reset</button>
								</form>';
						//$this->load->view('v_user', $this->data);
					}else{
						echo "E02"; //E02
						//echo "<script type='text/javascript'>window.location='" . $this->config->base_url() . "';</script>"; //redirect
					}
					
					$this->load->view('v_backend', $this->data);
				}else{
					//SAVE UPDATE
					$simpan = array('PRS_NM' => $this->input->post('NM'), 
									'PRS_AL' => $this->input->post('AL'),
									'PRS_TL' => $this->input->post('TL'),
									'PRS_KT' => $this->input->post('KT'),
									'PRS_TN' => $this->input->post('TN'));
					$this->db->where('PRS_ID', $this->input->post('ID'));
					$this->db->update('TB_PRS', $simpan);
					$this->data['dt_table'] = "<div class='alert alert-success'><h4>Data Berhasil Tersimpan</h4></div>" . $this->ex->redirect("index.php/c_perusahaan");
					$this->load->view('v_backend', $this->data);
				}
			}else{
				echo $this->ex->redirect();
			}
		}
		
		public function delete($prs_id=''){
			if($this->session->userdata('ADM')==1){
				$this->db->select('SRE_ID');
				$this->db->from('TB_SRE');
				$this->db->where('PRS_ID', $prs_id);
				$query = $this->db->get();
				$row=$query->row();
				if($query->num_rows()>0){
					$tables1 = array('TB_PRS', 'TB_MSPRZ');
					$tables2 = array('TB_SRE', 'TB_PT');
				}else{
					$tables1 = array('TB_PRS', 'TB_MSPRZ');					
				}
				$this->db->where('PRS_ID', $prs_id);
				$this->db->delete($tables1);
				if($query->num_rows()>0){
					$this->db->where('SRE_ID', $row->SRE_ID);
					$this->db->delete($tables2);
				}
				$this->data['dt_table'] = "<div class='alert alert-success'><h4>Data Berhasil Dihapus</h4></div>" . $this->ex->redirect("index.php/c_perusahaan");
				$this->load->view('v_backend', $this->data);
			}
		}
		
		public function detail($arg1="", $arg2=0){
			$this->data['base_url'] = $this->config->base_url();
			$this->data['linknya'] = $this->base_url . 'index.php/c_perusahaan/'. $arg1;
			$this->data['prs_id'] = $arg1;
			
			if(!$this->session->userdata('LGN')){
				echo "<script type='text/javascript'>window.location='" . $this->base_url . "';</script>"; //redirect
			}else{
				$query = $this->db->query($this->m_query->q_prs_w . " WHERE PRS_ID=" . $arg1);
				if ($query->num_rows() > 0){
					$Arow=$query->row();
						$this->data['dt_table'] = $this->ex->getList('','<center>Detail Perusahaan <b>'.$Arow->PRS_NM.'</b></center>','','','','','colspan=5');
						$this->data['dt_table'] .= $this->ex->getList('','Nama Perusahaan : '. $Arow->PRS_NM.
																	 '<br/>Alamat Perusahaan : '. $Arow->PRS_AL.
																	 '<br/>Telepon Perusahaan : '.$Arow->PRS_TL.
																	 '<br/>Kategori Perusahaan : '.$Arow->PRS_KT.
																	 '<br/>Tentang Perusahaan : '.$Arow->PRS_TN,'','','','',
																	 'colspan=5');
				}else{
					echo $this->ex->redirect();
				}
				
				//pagination
				$banyakRow = $this->m_query->getRow($this->m_query->MSPRZ($arg1));
				$config['base_url'] = $this->base_url ."index.php/c_perusahaan/detail/".$arg1."/";
				$config['total_rows'] = $banyakRow;
				$config['uri_segment'] = 4;
				$config['per_page'] = 6; 
				$this->pagination->initialize($config);
				$this->data['pagination']= "<tr><td colspan=5><div class='pagination'>" . $this->pagination->create_links() . "</td></div></tr>";
				//--EOF paginaion
				$urldelete = '';
				
				$query = $this->db->query($this->m_query->MSPRZ($arg1, "limit ".$arg2.",6"));
				if ($query->num_rows() > 0){
					$a=1;
					$this->data['dt_table'] .= $this->ex->getList('','<center>Data Masa Perizinan Perusahaan <b>'.$Arow->PRS_NM.'</b></center>','','','','','colspan=5');
					foreach ($query->result() as $row){
						$hasil = "<td width='8%'>".$a++."</td>";
						$hasil .= "<td width='50%'>" . $row->PRZ_NM . "</td>";
						$hasil .= "<td width='50%'>Masa Berlaku Perizinan s/d <b>" . date('d F Y' , strtotime($row->MSPRZ_MS_BR)) . "</b></td>";
						if($this->session->userdata('ADM')==1){
							$urldelete = 'c_perizinan/delete/'.$row->PRS_ID.'/'.$row->MSPRZ_ID;
						}
						$this->data['dt_table'] .= $this->ex->getList($hasil,'','','','',
												   $urldelete,'');
					}
					
				}else if($query->num_rows() == 0){
					$this->data['dt_table'] .= "<tr><td colspan=5>Perusahaan <b>".$Arow->PRS_NM."</b> Belum Mempunyai Data Masa Perizinan</td></tr>";
				}else{
					echo $this->ex->redirect();
				}				
			}
			if($this->session->userdata('ADM')==1){
				$this->data['tombol'] .= '<a href="'.$this->base_url.'index.php/c_perizinan/tambah/'.$Arow->PRS_ID.'" name="edit" class="edit-button btn btn-info">Tambah Masa Perizinan</a>';
			}
			$this->load->view('v_backend', $this->data);
		}
	}