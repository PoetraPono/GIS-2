<?php
	class M_query extends CI_Model {
		
		var $q_auth = "SELECT PII_UE, PII_PSW, PII_PII, PII_NM FROM TB_PII WHERE PII_UE='";
		
		var $q_user = "SELECT PII_ID, PII_NM, PII_UE, PII_PII FROM TB_PII ORDER BY PII_ID DESC";
		
		var $q_prs = "SELECT * FROM TB_PRS ORDER BY PRS_ID DESC";
		
		var $q_prs_w = "SELECT * FROM TB_PRS";
						
		public function MSPRZ($arg1="", $arg2=''){
			$query ="SELECT
						a.MSPRZ_ID, a.PRS_ID,
						a.MSPRZ_MS_BR, b.PRZ_NM
						from TB_MSPRZ a, TB_PRZ b
						where a.PRS_ID=" . $arg1 . " AND a.PRZ_ID = b.PRZ_ID
						order by a.MSPRZ_ID desc
						 ".$arg2;
						
			return $query;
		}
		
		public function getRow($arg1=""){
			$query = $this->db->query($arg1);
			return $query->num_rows();
		}
	}
?>