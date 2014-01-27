<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_survey extends CI_Controller {

	public $data = array('base_url' => '', 'menu' => '', 'pagination' => '', 'dt_table' => '', 'modul' => '',
						 'tombol' => '','photo' => '', 'marker' => '', 'printdata' => '', 'formatprint' => '');
	public $GMconfig = array('center' => '-6.260697, 107.337584', 'zoom' => '10');
	public $marker = array('position' => '-6.260697, 107.337584', 'animation' => 'DROP',
						   'infowindow_content' => '', 'icon' => '');
	public $base_url ='', $cari='';
	
	public function __construct() {
		parent::__construct();
		$this->data['base_url']= $this->config->base_url();
		$this->base_url = $this->config->base_url();
		$this->data['menu'] = $this->ex->menu('backend');
	}

	public function index($arg0=0,$arg1=0){
			$this->data['modul'] = 'c_survey/index/1';
			$a_cari = $this->input->post('cari');
			$b_cari = !isset($a_cari)?"":" AND a.PRS_NM LIKE '%" . $a_cari . "%' ";
			$data['base_url'] = $this->config->base_url();
			$base_url = $this->config->base_url();
			$data['dt_table']="No Result" . $this->ex->redirect('index.php/c_survey');
			$data['tambah'] ='';
			$q_query = "SELECT a.PRS_NM, a.PRS_AL, a.PRS_KT, a.PRS_ID, b.SRE_ID FROM TB_PRS a, TB_SRE b WHERE b.PRS_ID=a.PRS_ID ". $b_cari ."ORDER BY b.SRE_ID";
			
			//pagination
			$banyakRow = $this->m_query->getRow($q_query);
			$config['base_url'] = $base_url ."index.php/c_survey/index/2/";
			$config['total_rows'] = $banyakRow;
			$config['per_page'] = 5; 
			$config['uri_segment'] = 4;
			$this->pagination->initialize($config);
			$this->data['pagination']= "<div class='pagination'>" . $this->pagination->create_links() . "</div>";
			//--EOF paginaion
			$urldetail = '';
			$urlphoto = '';
			$urledit = '';
			$urldelete = '';
			
			if(!$this->session->userdata('LGN')){
				echo $this->ex->redirect();
			}else{
				$query = $this->db->query($q_query . " limit ".$arg1.",5");
				if ($query->num_rows() > 0){
					foreach ($query->result() as $row){
							$urldetail = "c_survey/detail/".$row->SRE_ID;
							$urlphoto = "index.php/c_survey/photo/".$row->SRE_ID;
							$urledit = "c_survey/edit/".$row->SRE_ID;
							$urldelete = "c_survey/delete/".$row->SRE_ID;
						$this->data['dt_table'] .= $this->ex->getList('','<b>'.$row->PRS_NM.'</b><br/>'.substr($row->PRS_AL,0,100).'...<br/>'.substr($row->PRS_KT,0,50).'...',
												   $urldetail,$urlphoto,$urledit, $urldelete);
					}
					$this->data['tombol'] .= '<a href="'.$this->base_url.'index.php/c_survey/tambah" name="edit" class="edit-button btn btn-info">Tambah Survey</a>';
				}				
				$this->load->view('v_backend', $this->data);
			}
	}
	
	public function delete($arg1=''){
		if($this->session->userdata('LGN')){
				$tables = array('TB_SRE', 'TB_PT');
				$this->db->where('SRE_ID', $arg1);
				$this->db->delete($tables);
				$this->data['dt_table'] = "<div class='alert alert-success'><h4>Data Berhasil Dihapus</h4></div>" . $this->ex->redirect("index.php/c_survey");
				$this->load->view('v_backend', $this->data);
		}
	}
	
	public function tambah($arg1=""){
		if(!$this->session->userdata('LGN')){
			echo $this->ex->redirect();
		}else{
			if(!$arg1=='save'){
				$this->data['dt_table'] = '<form method="POST" action="'.$this->base_url.'index.php/c_survey/tambah/save">
												Pilih Perusahaan : '.$this->ex->list_perusahaan().'<br/>
												Tanggal Beridiri : '.$this->ex->kalender().'<br/>
												Jumlah Karyawan : <input type="text" name="JML" size="25" style="width:150px" maxlength="20" /><br />
												Latitude Koordinasi  : <input type="text" name="LT" style="width:300px" size="25" maxlength="30" /><br/>
												Longitude Koordinasi : <input type="text" name="LN" style="width:300px" size="25" maxlength="30" /><br/>
												<button type="submit" value="Save" name="detail" class="edit-button btn btn-primary">Simpan</button>
												&nbsp;<button type="reset" value="Reset" name="detail" class="edit-button btn btn-primary">Reset</button>
											</form>';
				$this->load->view('v_backend', $this->data);
			}else{
				$this->db->select("PRS_ID");
				$this->db->from("TB_SRE");
				$this->db->where('PRS_ID',$this->input->post('prs_nm'));
				$query = $this->db->get();
				$row = $query->row();
				if($query->num_rows()==0){
					$simpan = array('SRE_ID' => NULL,
									'PRS_ID' => $this->input->post('prs_nm'),
									'SRE_LT' => $this->input->post('LT'),
									'SRE_LN' => $this->input->post('LN'),
									'SRE_TGL_PNI' => $this->input->post('thn') . "-" . $this->input->post('bln') . "-" . $this->input->post('tgl'),
									'SRE_JML_KRA' => $this->input->post('JML'));
					$this->db->insert('TB_SRE', $simpan);
					$this->data['dt_table'] = "<div class='alert alert-success'><h4>Berhasil Tambah</h4></div>" . $this->ex->redirect("index.php/c_survey/");
					$this->load->view('v_backend', $this->data);
				}else{
					$this->db->select("PRS_NM");
					$this->db->from("TB_PRS");
					$this->db->where('PRS_ID',$this->input->post('prs_nm'));
					$query = $this->db->get();
					$row = $query->row();
					$this->data['dt_table'] = "<div class='alert alert-error'><h4>Gagal Simpan</h4> Perusahaan ". $row->PRS_NM." sudah mempunyai data survey</div>" . $this->ex->redirect("index.php/c_survey/", '2000');
					$this->load->view('v_backend', $this->data);
				}
			}
		}
	}
	
	public function edit($arg1=''){
		if(!$this->session->userdata('LGN')){
			echo $this->ex->redirect();
		}else{
			if($arg1=='save'){
				$simpan = array('SRE_LT' => $this->input->post('LT'), 
									'SRE_JML_KRA' => $this->input->post('JML'),
									'SRE_LN' => $this->input->post('LN'));
				$this->db->where('SRE_ID', $this->input->post('sre_id'));
				$this->db->update('TB_SRE', $simpan);
				$this->data['dt_table'] = "<div class='alert alert-success'><h4>Data Berhasil Tersimpan</h4></div>" . $this->ex->redirect("index.php/c_survey");
				$this->load->view('v_backend', $this->data);
			}else{
				$query=$this->db->query("SELECT SRE_LT, SRE_LN, SRE_TGL_PNI, SRE_JML_KRA FROM TB_SRE WHERE SRE_ID=".$arg1."");
				$row=$query->row_array();
				$thn = substr($row['SRE_TGL_PNI'],0,4);
				$bln = substr($row['SRE_TGL_PNI'],5,2);
				$tgl = substr($row['SRE_TGL_PNI'],8,2);
				$this->data['dt_table'] = '<form method="POST" action="'.$this->base_url.'index.php/c_survey/edit/save">
												Pilih Perusahaan : '.$this->ex->list_survey($arg1, "disabled").'<br/>
												Tanggal Beridiri : '.$this->ex->kalender($tgl, $bln, $thn).'<br/>
												Jumlah Karyawan : <input type="text" value="'.$row['SRE_JML_KRA'].'" name="JML" size="25" style="width:150px" maxlength="20" /><br />
												Latitude Koordinasi  : <input type="text" value="'.$row['SRE_LN'].'" name="LT" style="width:300px" size="25" maxlength="30" /><br/>
												Longitude Koordinasi : <input type="text" value="'.$row['SRE_LT'].'" name="LN" style="width:300px" size="25" maxlength="30" /><br/>
												<input type="hidden" name="sre_id" value="'.$arg1 .'" />
												<button type="submit" value="Save" name="detail" class="edit-button btn btn-primary">Simpan</button>
												&nbsp;<button type="reset" value="Reset" name="detail" class="edit-button btn btn-primary">Reset</button>
											</form>';
				$this->load->view('v_backend', $this->data);
			}
		}
	}
	
	public function photo($arg1='', $arg2=''){
		$data['dt_table']='';
		$data['base_url'] = $this->config->base_url();
		$base_url = $this->config->base_url();
		$data['sre_id'] = $arg1;
		if(!$this->session->userdata('LGN')){
			echo $this->ex->redirect();
		}else{
			if($arg1=='tambah'){
				$query = $this->db->query("SELECT pt_id FROM TB_PT ORDER BY pt_id DESC LIMIT 1");
				$row = $query->row_array();
				$hasil = $row['pt_id'] + 1;
				$allowedExts = array("jpeg", "jpg", "png");
				$temp = explode(".", $_FILES["fl"]["name"]);
				$extension = end($temp);
				if ($_FILES["fl"]["error"] > 0){
					echo $_FILES["fl"]["error"] . "<br>" . $this->ex->redirect('index.php/c_survey/photo/'.$this->input->post("sre_id"));
				}else{
					move_uploaded_file($_FILES["fl"]["tmp_name"],"img/" . $hasil . ".jpg");
					$simpan = array('PT_ID' => NULL, 'SRE_ID' => $this->input->post('sre_id'), 
									'PT_NM_FL' => $hasil . ".jpg");
					$this->db->insert("TB_PT", $simpan);
					$config['image_library'] = 'gd2';
					$config['source_image']	= './img/'.$hasil.'.jpg';
					$config['new_image'] = './img/'.$hasil.'_thumb274.jpg';
					$config['maintain_ratio'] = TRUE;
					$config['width'] = 274;
					$config['height'] = 204;
					$this->image_lib->initialize($config); 
					$this->image_lib->resize();
					
					$config['image_library'] = 'gd2';
					$config['source_image']	= './img/'.$hasil.'.jpg';
					$config['new_image'] = './img/'.$hasil.'_thumb150.jpg';
					$config['maintain_ratio'] = TRUE;
					$config['width'] = 150;
					$config['height'] = 75;
					$this->image_lib->initialize($config); 
					$this->image_lib->resize();
					
					$this->data['dt_table'] = "<div class='alert alert-success'><h4>Berhasil Upload</h4></div>" . $this->ex->redirect("index.php/c_survey/photo/".$this->input->post("sre_id"));
					$this->load->view('v_backend', $this->data);
				}
			}else if($arg1=='delete'){
				$this->db->select('SRE_ID, PT_NM_FL');
				$this->db->from('TB_PT');
				$this->db->where('PT_ID', $arg2);
				$query = $this->db->get();
				$row = $query->row();
				$FL1 = './img/'.$row->PT_NM_FL;
				$FL2 = './img/'.str_replace('.jpg', '_thumb274.jpg',$row->PT_NM_FL);
				$FL3 = './img/'.str_replace('.jpg', '_thumb150.jpg',$row->PT_NM_FL);
				unlink($FL1);
				unlink($FL2);
				unlink($FL3);
				$tables = array('TB_PT');
				$this->db->where('PT_ID', $arg2);
				$this->db->delete($tables);
				$this->data['dt_table'] = "<div class='alert alert-success'><h4>Berhasil Hapus</h4></div>" . $this->ex->redirect("index.php/c_survey/photo/".$row->SRE_ID);
				$this->load->view('v_backend', $this->data);
			}else{
				$porm = '<form method="POST" action="'.$this->base_url.'index.php/c_survey/photo/tambah" enctype="multipart/form-data">
												Tambah Photo <br/><input type="hidden" name="sre_id" value="'.$arg1.'" />
												<input type="file" name="fl" id="fl" /><br/>
												<button type="submit" name="submit" class="edit-button btn btn-primary" value="Save" >Upload</button>
							</form><br/>';
				$this->data['dt_table'] .= $this->ex->getList('',$porm,'','','','','colspan=5');
				$query=$this->db->query("SELECT * FROM TB_PT WHERE SRE_ID=".$arg1."");
				if($query->num_rows >0){
					$hasil = '';					
					foreach($query->result() as $row){
						$hasil = "<td style='width:150px;'><img src='".$base_url."img/".$row->PT_NM_FL."' height='25%' width='40%'  /></td>";
						$this->data['dt_table'] .= $this->ex->getList($hasil,'','','img/'.$row->PT_NM_FL,'','c_survey/photo/delete/'.$row->PT_ID,'');
					}
				}
				$this->load->view('v_backend', $this->data);
			}
		}
	}
	
	public function detail($arg1=""){
		$LN='';
		$LT='';
		$data['gambar']="";
		$data['base_url'] = $this->config->base_url();
			$base_url = $this->config->base_url();
			if(!$this->session->userdata('LGN')){
				echo "<script type='text/javascript'>window.location='" . $this->config->base_url() . "';</script>"; //redirect
			}else{
				$query = $this->db->query("SELECT a.PRS_ID, a.PRS_NM, a.PRS_AL, a.PRS_TL, a.PRS_KT, a.PRS_TN FROM 
											TB_PRS a, TB_SRE b WHERE b.SRE_ID=" . $arg1 . " AND a.PRS_ID=b.PRS_ID");
				if ($query->num_rows() > 0){
					$Arow=$query->row();
					$this->data['dt_table'] = $this->ex->getList('','<center>Detail Perusahaan <b>'.$Arow->PRS_NM.'</b></center>','','','','','colspan=5');
					$this->data['dt_table'] .= $this->ex->getList('','Nama Perusahaan : '. $Arow->PRS_NM.
																	 '<br/>Alamat Perusahaan : '. $Arow->PRS_AL.
																	 '<br/>Telepon Perusahaan : '.$Arow->PRS_TL.
																	 '<br/>Kategori Perusahaan : '.$Arow->PRS_KT.
																	 '<br/>Tentang Perusahaan : '.$Arow->PRS_TN,'','','','',
																	 'colspan=5');
					$this->data['formatprint'] = '<tr><td colspan=5><center>Detail Perusahaan <b>'.$Arow->PRS_NM.'</b></center></td></tr>';
					$this->data['formatprint'] .= '<tr><td colspan=5>Nama Perusahaan : '. $Arow->PRS_NM.
																	 '<br/>Alamat Perusahaan : '. $Arow->PRS_AL.
																	 '<br/>Telepon Perusahaan : '.$Arow->PRS_TL.
																	 '<br/>Kategori Perusahaan : '.$Arow->PRS_KT.
																	 '<br/>Tentang Perusahaan : '.$Arow->PRS_TN.'</td></tr>';
					$this->data['dt_table'] .= $this->ex->getList('','<center>Data Survey Perusahaan <b>'.$Arow->PRS_NM.'</b></center>','','','','','colspan=5');
					$this->data['formatprint'] .= '<tr><td colspan=5><center>Data Survey Perusahaan <b>'.$Arow->PRS_NM.'</b></center></td></tr>';
				}else{
					echo $this->ex->redirect();
				}
				
				$query = $this->db->query("SELECT
											c.PT_NM_FL, 
											d.SRE_JML_KRA, d.SRE_LN, d.SRE_LT, d.SRE_TGL_PNI
											from TB_PT c, TB_SRE d
											where d.SRE_ID=".$arg1." AND c.SRE_ID=".$arg1."
											limit 0,5");
				if ($query->num_rows() > 0){
					$rowS = $query->row();
					$this->data['dt_table'] .= $this->ex->getList('','Jumlah Karyawan : '. $rowS->SRE_JML_KRA.
																	 '<br/>Tanggal Berdiri : '. date('d F Y' , strtotime($rowS->SRE_TGL_PNI)),'','','','',
																	 'colspan=5');
					$this->data['formatprint'] .= '<tr><td colspan=5>Jumlah Karyawan : '. $rowS->SRE_JML_KRA.
																	 '<br/>Tanggal Berdiri : '. date('d F Y' , strtotime($rowS->SRE_TGL_PNI)).'</td></tr>';
					$this->GMconfig['center'] = $rowS->SRE_LT . ',' . $rowS->SRE_LN ;
					$this->GMconfig['zoom'] = '12';
					$this->googlemaps->initialize($this->GMconfig);
						
					$this->marker['position'] = $rowS->SRE_LT . ',' . $rowS->SRE_LN;
					$this->data['marker'] = $rowS->SRE_LT . ',' . $rowS->SRE_LN ;
					$this->googlemaps->add_marker($this->marker);
					$this->data['map'] = $this->googlemaps->create_map();
					$this->data['photo'] = '<div class="photo"><h1>Photo <small>photos about industries related</small></h1>';
					foreach($query->result() as $rowS){
						$this->data['photo'].= '<img src="' . $base_url . 'img/'. str_replace(".jpg", "_thumb274.jpg", $rowS->PT_NM_FL) .'" class="img-polaroid"/> ';	
					}
				}else{
				}
				
				$query = $this->db->query($this->m_query->MSPRZ($Arow->PRS_ID));
				if ($query->num_rows() > 0){
					$data['dt_table'] = "";
					$a=1;
					$this->data['dt_table'] .= $this->ex->getList('','<center>Data Masa Perizinan Perusahaan <b>'.$Arow->PRS_NM.'</b></center>','','','','','colspan=5');
					$this->data['formatprint'] .= '<tr><td colspan=5><center>Data Masa Perizinan Perusahaan <b>'.$Arow->PRS_NM.'</b></center></td></tr>';
					foreach ($query->result() as $row){
						$hasil = '<td width="8%">'.$a.'</td>';
						$hasil .= '<td width="50%">' . $row->PRZ_NM . '</td>';
						$hasil .= '<td width="50%">Masa Berlaku Perizinan s/d <b>' . date("d F Y" , strtotime($row->MSPRZ_MS_BR)) . '</b></td>';
						$this->data['dt_table'] .= $this->ex->getList($hasil);
						$this->data['formatprint'] .= '<tr><td width="8%">'.$a++.'</td><td width="50%">'.$row->PRZ_NM.'</td><td width="50%">Masa Berlaku Perizinan s/d <b>' . date("d F Y" , strtotime($row->MSPRZ_MS_BR)) . '</b></td></tr>';
					}
									
				}else if($query->num_rows() == 0){
					$this->data['dt_table'] .= "<tr><td colspan=5>Perusahaan <b>".$Arow->PRS_NM."</b> Belum Mempunyai Data Masa Perizinan</td></tr>";
				}else{
					echo $this->ex->redirect();
				}
				$this->data['dt_table'] .= $this->ex->getList('','<center>Posisi Perusahaan <b>'.$Arow->PRS_NM.'</b> Pada Geographic System</center>','','','','','colspan=5');
				$this->data['formatprint'] .= '<tr><td colspan=5><center>Posisi Perusahaan <b>'.$Arow->PRS_NM.'</b> Pada Geographic System</center></td></tr>';
				$this->data['tombol'] .= '<a href="#" onclick="doPrint()" name="edit" class="edit-button btn btn-info">Print</a>';
				$this->data['printdata'] .='<html><head><link rel="stylesheet" href="'.$this->base_url.'css/admin/bootstrap.css" media="all"><link rel="stylesheet" href="'.$this->base_url.'css/admin/style.css" media="print"></head><body><img src="'.$this->base_url.'images/logo.png" /><hr/><table class="table table-bordered" width="100%">'.$this->data['formatprint'].'</table></body></html>';
				$this->load->view('v_backend', $this->data);
			}
	}
}