<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	
	public $data = array('base_url' => '', 'menu' => '', 'hasil'=> '', 'marker' => '', 'list' => '', 'map' => '', 
						 'pagination' => '', 'logged_in' => '', 'modul' => 'main/index','dt_table' => '', 'tombol' => '',
						 'printdata' => '', 'notification' => '', 'photo' => '');
						 
	public $GMconfig = array('center' => '-6.260697, 107.337584', 'zoom' => '10');
	public $marker = array('position' => '-6.260697, 107.337584', 'animation' => 'DROP',
						   'infowindow_content' => '', 'icon' => '');
	public $base_url ='', $cari="", $k_list="KOSONG";

	public function __construct() {
		parent::__construct();

		$this->data['base_url']= $this->config->base_url();
		$this->base_url = $this->config->base_url();
		$this->data['menu'] = $this->ex->menu();
	}

	public function index(){
		$this->data['logged_in'] = $this->ex->logged_in();
		$this->session->set_userdata('cari', "");
		$this->session->set_userdata('k_list', "KOSONG");
		//echo "A". $this->session->userdata('cari') . "B" . $this->session->userdata('k_list');
		
		//Gmap
		$this->googlemaps->initialize($this->GMconfig);	
		$this->googlemaps->add_marker($this->marker);			
		//EOF-Gmap
		$this->data['map'] = $this->googlemaps->create_map();
		$this->data['menu'] = $this->ex->menu();
		$this->data['list'] = $this->ex->kategori();
		
		if($this->session->userdata('ADM')==1){
			$this->load->view('v_backend', $this->data);	
		}else{
			$this->load->view('main', $this->data);
		}
		//DEFAULT MARKER markers=color:blue%7Clabel:S%7Ccoorlat,coorlan
	}
	
	public function login($arg=''){		
		if(!$this->session->userdata('LGN')&& $arg==''){
			$this->load->view('login', $this->data);
		}else if($arg==1){
			$ue = $this->input->post('UE');
			$psw = md5(md5($this->input->post('PSW')));

			$query = $this->db->query($this->m_query->q_auth . $ue . "'");
			if ($query->num_rows() > 0){
				foreach ($query->result() as $row){
					$PII = $row->PII_PII=="1" ? 1 : 2;
					if($row->PII_PSW==$psw){
						$newdata = array('LGN' => TRUE, 'ADM' => $PII, 'cari' => '', 'k_list'=>'', 'NM' => $row->PII_NM);
						$this->session->set_userdata($newdata);
						echo $this->ex->redirect();
					}else{
						echo "Wrong Username/ Password".$this->ex->redirect();
					}
				}
			}else{
				echo "Wrong Username/ Password".$this->ex->redirect();
			}
		}else{
			echo $this->ex->redirect();
		}
	}
	
	public function search($arg1=0){
		$this->data['logged_in'] = $this->ex->logged_in();
		
		if($this->session->userdata('cari')==""){
			$this->session->set_userdata('cari', $this->input->post("cari"));
		}else if($this->input->post('cari')!=""){
			$this->session->set_userdata('cari', $this->input->post("cari"));
		}
		
		if($this->session->userdata('k_list')=="KOSONG" && $this->session->userdata('cari')==""){
			$this->session->set_userdata('k_list', $this->input->post("k_list"));
		}else if($this->session->userdata('cari')!="" && $this->session->userdata('k_list')!="KOSONG"){
			$this->session->set_userdata('k_list', $this->input->post("k_list"));
		}else if($this->input->post('k_list')!=""){
			$this->session->set_userdata('k_list', $this->input->post("k_list"));
		}else{
			$this->session->set_userdata('k_list', "KOSONG");
		}
		$this->cari = $this->session->userdata('cari');
		$this->k_list = $this->session->userdata('k_list');
					
		//echo "|". $this->session->userdata('cari') . "|" . $this->session->userdata('k_list') . "|". $this->cari . "|". $this->k_list;
			
		$this->data['list'] = $this->ex->kategori();
		$this->googlemaps->initialize($this->GMconfig);
		
		$this->data['hasil'] .=$this->k_list=='KOSONG' ? 
							   'Pencarian berdasarkan Kata "'. $this->cari .'"':
							   'Pencarian Berdasarkan Kategori "'. $this->k_list .'"';

		$byKat = $this->k_list=="KOSONG" ? 
					"a.PRS_NM LIKE '%". $this->cari ."%'" :
					"a.PRS_KT='" .$this->k_list."'";
		
		$p_query = $this->db->query("SELECT a.PRS_NM, a.PRS_ID, b.SRE_LT, b.SRE_LN 
										FROM TB_PRS a, TB_SRE b 
										WHERE ".$byKat." AND b.PRS_ID=a.PRS_ID");
		
		$query = $this->db->query("SELECT a.PRS_AL, a.PRS_TN, a.PRS_NM, a.PRS_ID, b.SRE_LT, b.SRE_LN 
										FROM TB_PRS a, TB_SRE b 
										WHERE ".$byKat." AND b.PRS_ID=a.PRS_ID limit ".$arg1.",2");
		//pagination
		$banyakRow = $p_query->num_rows();
		$config['base_url'] = $this->base_url ."index.php/main/search/";
		$config['total_rows'] = $banyakRow;
		$config['per_page'] = 2; 
		$config['first_link'] = 'Pertama';
		$config['last_link'] = 'Terakhir';
		$this->pagination->initialize($config);
		$this->data['pagination']= "<div class='pagination'>" . $this->pagination->create_links() ."</div>";
		//--EOF paginaion
											
		if ($query->num_rows() > 0){
			$a=1;
			foreach ($query->result() as $row){
				$this->data['marker'].= "&markers=color:blue%7Clabel:".$a."%7C";
				$this->data['hasil'] .= "<a href='". $this->base_url."index.php/main/result/". 
				                        $row->PRS_ID ."'><h3 class='summary'>".$a. ".".$row->PRS_NM ."</h3></a>";
				$this->data['hasil'] .= $this->ex->getGambar($row->PRS_ID)."<p align='justify'>".substr($row->PRS_TN,0,100)."...</p>";				
				$this->data['printdata'] .= $a. ". " . $row->PRS_NM . " - ".$row->PRS_AL."<br/>";
				$this->marker['position'] = $row->SRE_LT . ',' . $row->SRE_LN ;
				$this->data['marker'] .= $row->SRE_LT . ',' . $row->SRE_LN ;
				$this->marker['infowindow_content'] = $row->PRS_NM;
				$this->marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='.$a.'|9999FF|000000';
				$this->googlemaps->add_marker($this->marker);
				$a++;
			}
		}else{
			$this->data['hasil'] .= "<br/> Tidak ada Hasil dari Pencarian";
		}
	
		$this->data['map'] = $this->googlemaps->create_map();
		$this->load->view('main', $this->data);
	}
	
	public function result($arg1=''){
		$this->data['pagination'] = "<h3 class='summary'><a href='#' onclick='doPrint()'> Print Peta</a></h3>";
		$this->data['logged_in'] = $this->ex->logged_in();
		$this->data['menu'] = $this->ex->menu();
		$this->data['list'] = $this->ex->kategori();
		
		$query = $this->db->query("SELECT b.PRS_AL, a.SRE_LT, a.SRE_LN, b.PRS_NM, b.PRS_ID, b.PRS_TN FROM TB_SRE a, TB_PRS b WHERE b.PRS_ID='". $arg1 ."' AND a.PRS_ID='".$arg1."'");
		if ($query->num_rows() > 0){
			$row = $query->row();
			$this->data['printdata'] .= $row->PRS_NM . " - ".$row->PRS_AL."<br/>";
			$this->data['marker'] .= "&markers=";
			$this->GMconfig['center'] = $row->SRE_LT . ',' . $row->SRE_LN ;
			$this->GMconfig['zoom'] = '12';
			$this->googlemaps->initialize($this->GMconfig);
			$this->data['hasil'] = "<h3 class='summary'>" . $row->PRS_NM ."</h3>";
			$this->data['hasil'] .= $this->ex->getGambar($row->PRS_ID). "<p align='justify'>".$row->PRS_TN."</p>";
			$this->marker['position'] = $row->SRE_LT . ',' . $row->SRE_LN ;
			$this->data['marker'] .= $row->SRE_LT . ',' . $row->SRE_LN ;
			$this->marker['animation'] = 'DROP';
			$this->googlemaps->add_marker($this->marker);
		}else{
			$this->index();
		}
		
		$this->data['map'] = $this->googlemaps->create_map();	
		
		$this->load->view('main', $this->data);

	}
	
	public function f_print(){
		if(!$this->session->userdata('LGN')){
			$this->load->view('login', $this->data);
		}else{
			$this->load->view('print', $this->data);
		}
	}
	
	public function logout(){
		$array_items = array('LGN' => 'FALSE', 'ADM' => '');
		$this->session->unset_userdata($array_items);
		echo $this->ex->redirect();
	}

	public function notifikasi(){
		$this->data['notification'] = $this->ex->notification();
		$this->load->view('v_backend', $this->data);
	}
}