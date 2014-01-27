<?php
	class Ex extends CI_Model{
	
		var $debug = TRUE;
		
		function __construct(){
			parent::__construct();
		}
		
		public function redirect($arg1='', $arg2='1500'){
			return "<script type='text/javascript'>setInterval(function(){window.location='" . $this->config->base_url() . "".$arg1."';},".$arg2.");</script>"; //redirect
		}
		
		public function menu($arg1=''){
			$base_url = $this->config->base_url();
			$data['menu'] = '';
			if(!$this->session->userdata('LGN')){ //GUEST
				//$data['menu'] .= "<a href='". $base_url ."index.php/main/login' >Login</a>";
				$data['menu'] .= "<a href='". $base_url ."' > Beranda</a>";
				$data['menu'] .= "<a href='#' onclick='doPrint()'> Print Peta</a>";
			}else if($this->session->userdata('ADM')==2){ //USER CHILD
				if($arg1==''){
					$data['menu'] .= "<a href='". $base_url ."' > Beranda</a>";
					$data['menu'] .= "<a href='". $base_url ."index.php/c_perusahaan' >Perusahaan </a> ";
					$data['menu'] .= "<a href='". $base_url ."index.php/c_survey' >Survey </a> ";
					$data['menu'] .= "<a href='#' onclick='doPrint()'> Print Peta</a>";
				}else{
					$data['menu'] .='<div class="summary-container">
									<a href="'.$base_url.'">
									<li class="summary"><i class="icon-home"></i> Beranda</a></li>
									<a href="'.$base_url.'index.php/c_perusahaan">
									<li class="summary"><i class="icon-folder-open"></i> Master Perusahaan</a></li>
									<a href="'.$base_url.'index.php/c_survey">
									<li class="summary"><i class="icon-briefcase"></i> Master Survey</a></li>
									</div> ';
				}
			}else{ //ADMIN
				$data['menu'] .='<div class="summary-container">
								<a href="'.$base_url.'">
								<li class="summary"><i class="icon-home"></i> Beranda</a></li>
								<a href="'.$base_url.'index.php/main/notifikasi">
								<li class="summary"><i class="icon-list"></i> Notif Masa Perizinan  <span class="badge pull-right badge-warning">'.$this->notification("hitung").'</span></a></li>
							    <a href="'.$base_url.'index.php/c_user">
								<li class="summary"><i class="icon-user"></i> Master User</a></li>
								<a href="'.$base_url.'index.php/c_perusahaan">
								<li class="summary"><i class="icon-folder-open"></i> Master Perusahaan</a></li>
							    <a href="'.$base_url.'index.php/c_survey">
								<li class="summary"><i class="icon-briefcase"></i> Master Survey</a></li>
								</div> ';
			}
			
			return $data['menu'];
		}
		
		public function logged_in(){
			$hasil = '';
			$base_url = $this->config->base_url();
			if(!$this->session->userdata('LGN')){
				$hasil = '<a class="dropdown-toggle" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#">
							<b>LOG IN
						  <span class="caret icon-white"></b></a>';
			}else{
				$hasil = '<a class="dropdown-toggle" id="dLabel" role="button" data-target="#" href="'. $base_url .'index.php/main/logout">
							<b>LOG OUT</b></a>';
			}
			
			return $hasil;
		}
		
		public function kategori(){
			$hasil ='';
			$query = $this->db->query("select PRS_KT from TB_PRS group by prs_kt having count(*)");
			if($query->num_rows() > 0){
				foreach ($query->result() as $row){
					$hasil .= "<option value='". $row->PRS_KT ."'>". $row->PRS_KT ."</option>";
				}
			}
			
			return $hasil;
		}
		
		public function getGambar($arg1=""){
			$hasil ="";
			$base_url = $this->config->base_url();
			$query = $this->db->query("SELECT a.PT_NM_FL FROM TB_PT a, TB_SRE b WHERE b.PRS_ID =".$arg1." AND a.SRE_ID = b.SRE_ID GROUP BY PT_NM_FL HAVING COUNT(*)");
			if($query->num_rows() > 0){
				$row = $query->row_array();
				$hasil = "<img src='".$base_url."img/".str_replace('.jpg', '_thumb150.jpg',$row['PT_NM_FL'])."'/>";
			}else{
				$hasil = "<img src='".$base_url."img/NIA.jpg' height='80%' width='40%'/>";
			}
			return $hasil;
		}
		
		public function kalender($arg1='',$arg2='',$arg3=''){
			$kalenderTGL = "<select style='width:80px' name='tgl'>";
			for($a=1;$a<=31;$a++){
				$tgl=$a<10?"0".$a:$a;
				$tgl_selected = $arg1==$tgl ? "selected" : "";
				$kalenderTGL .="<option value='".$tgl."' ". $tgl_selected." >".$tgl."</option>";
			}
			$kalenderTGL .="</select>&nbsp;";
			$bln = array(0=>array('01','Januari'), 1 =>array('02','Februari'), 
						 2=>array('03','Maret'), 3 =>array('04','April'), 
						 4=>array('05','Mei'), 5 =>array('06','Juni'), 
						 6=>array('07','Juli'), 7 =>array('08','Agustus'), 
						 8=>array('09','September'), 9 =>array('10','Oktober'), 
						 10=>array('11','November'), 11 =>array('12','Desember'));
			$kalenderBLN = "<select style='width:110px' name='bln'>";
			for($a=0;$a<12;$a++){
				$bln_selected = $arg2==$bln[$a][0]? "selected" : "";
				$kalenderBLN .= "<option value='".$bln[$a][0]."' ". $bln_selected ." >".$bln[$a][1]."</option>";
			}			
			$kalenderBLN .="</select>&nbsp;";
			$kalenderTHN = "<select style='width:100px' name='thn'>";
			for($a=1950;$a<=2100;$a++){
				$thn_selected = $arg3==$a ? "selected" : "";
				$kalenderTHN .="<option value='".$a."' ". $thn_selected ." >".$a."</option>";
			}
			$kalenderTHN .="</select>";
			
			return $kalenderTGL . " " . $kalenderBLN . " " . $kalenderTHN;
		}
		
		public function list_perizinan($arg1='', $arg2=''){
			$hasil ="<select style='width:400px' name='prz_nm' ".$arg2.">";
			$base_url = $this->config->base_url();
			$query = $this->db->query("SELECT PRZ_NM, PRZ_ID FROM TB_PRZ");
			if($query->num_rows() > 0){
				foreach ($query->result() as $row){
					$list_selected=$arg1==$row->PRZ_ID?"selected":"";
					$hasil .= "<option value='". $row->PRZ_ID ."' ".$list_selected.">". $row->PRZ_NM ."</option>";
				}
			}
			return $hasil."</select>";
		}
		
		public function list_perusahaan($arg1='', $arg2=''){
			$hasil ="<select name='prs_nm' ".$arg2.">";
			$base_url = $this->config->base_url();
			$query = $this->db->query("SELECT PRS_NM, PRS_ID FROM TB_PRS");
			if($query->num_rows() > 0){
				foreach ($query->result() as $row){
					$list_selected=$arg1==$row->PRS_ID?"selected":"";
					$hasil .= "<option value='". $row->PRS_ID ."' ".$list_selected.">". $row->PRS_NM ."</option>";
				}
			}
			return $hasil."</select>";
		}

		public function list_survey($arg1='', $arg2=''){
			$hasil ="<select name='prs_nm' ".$arg2.">";
			$base_url = $this->config->base_url();
			$query = $this->db->query("SELECT a.PRS_NM, a.PRS_ID FROM TB_PRS a, TB_SRE b WHERE b.SRE_ID='".$arg1."' AND a.PRS_ID=b.PRS_ID");
			if($query->num_rows() > 0){
				foreach ($query->result() as $row){
					$list_selected=$arg1==$row->PRS_ID?"selected":"";
					$hasil .= "<option value='". $row->PRS_ID ."' ".$list_selected.">". $row->PRS_NM ."</option>";
				}
			}
			return $hasil."</select>";
		}
		
		public function defVar($arg1=''){
			if($arg1=="main"){
				$data = array('base_url' => $this->config->base_url(), 
							  'menu' => '', 'hasil'=> '');
			}
		}
		
		public function getList($customtable='', $isi='', $urldetail='', $urlphoto='', $urledit='', $urldelete='', $addonisi=''){
			$base_url = $this->config->base_url();
			$hapus='';
			$lul = "window.location=confirm('Apakah Yaking untuk menghapus data?')?'".$base_url."index.php/".$urldelete."':'';";
			if($urldelete!=''){
				$hapus .='<td width="8%"><center>
											<a href="#" onclick="'.$lul.'" type="submit" name="delete" class="edit-button btn btn-danger">
											<i class="icon icon-remove icon-white"></i></a></center></td>';
			}
			$urledit = $urledit!=''?'<td width="8%"><center>
										<a href="'.$base_url.'index.php/'.$urledit.'" type="submit" name="edit" class="edit-button btn btn-warning">
										<i class="icon icon-edit icon-white"></i></a></center></td>':'';
			$urldetail = $urldetail!=''?'<td width="8%"><center>
										<a href="'.$base_url.'index.php/'.$urldetail.'" type="submit" name="detail" class="edit-button btn btn-success">
										<i class="icon icon-list-alt icon-white"></i></a></center></td>':'';
			$urlphoto = $urlphoto!=''?'<td width="8%"><center>
										<a href="'.$base_url.$urlphoto.'" type="submit" name="detail" class="edit-button btn btn-primary" title="Photo">
										<i class="icon icon-picture icon-white"></i></a></center></td>':'';
			$hasil = $customtable==''?'<tr>
					<td width="84%" '.$addonisi.'>'.$isi.'</td>':"<tr>".$customtable;
			return $hasil.$urldetail.$urlphoto.$urledit.$hapus.'</tr>';
		}
		
		public function notification($mode=""){
			$hasil = '<table class="table table-bordered" width="100%">';
			$query = $this->db->query("SELECT c.PRZ_NM, a.MSPRZ_MS_BR, b.PRS_NM FROM TB_MSPRZ a, TB_PRS b, TB_PRZ c
									    WHERE a.PRS_ID = b.PRS_ID AND a.PRZ_ID = c.PRZ_ID order by a.MSPRZ_ID desc ");
			$rowcount = 0;
			foreach($query->result() as $row){
				$alert = "<strong>Perhatian</strong> Masa Perizinan <strong>" . $row->PRZ_NM . "</strong> Pada <strong>" . $row->PRS_NM . "</strong> Mempunyai Sisa Waktu : <b>" . 
						  intval(date('z', strtotime($row->MSPRZ_MS_BR))-date('z')) . "</b> hari ";

				if(intval(date('Y', strtotime($row->MSPRZ_MS_BR))-date('Y'))==0){
					if(intval(date('W', strtotime($row->MSPRZ_MS_BR))-date('W'))<5){
						if(intval(date('z', strtotime($row->MSPRZ_MS_BR))-date('z'))<8){
							$rowcount++;
						}
					}
				}

				$hasil .= intval(date('Y', strtotime($row->MSPRZ_MS_BR))-date('Y'))==0?
							intval(date('W', strtotime($row->MSPRZ_MS_BR))-date('W'))<5?
								intval(date('z', strtotime($row->MSPRZ_MS_BR))-date('z'))<8?
									$this->ex->getList('',$alert,'','','','','bgcolor=#f89406') 
									//"<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>&times;</button>".$alert."</div>"
								:$this->ex->getList('',$alert,'','','','','bgcolor=#ee5f5b')
								//"<div class='alert alert-block'><button type='button' class='close' data-dismiss='alert'>&times;</button>".$alert."</div>"
							:""
						 :"";
			}
			return $mode=="hitung"?$rowcount:$hasil ."</table>";
		}
	}
?>