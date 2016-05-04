<?php
// v1.1
class ModelAccountSalesRep extends Model {
	
	public function getSalesRep($salesrep_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "salesrep WHERE salesrep_id = '" . (int)$salesrep_id . "'");
	
		return $query->row;
	}
		
	public function getSalesReps() {
		$sql = "SELECT * FROM " . DB_PREFIX . "salesrep" . " WHERE public = '1' AND status = '1';" ;
		
		$query = $this->db->query($sql);
		
		return $query->rows;	
	}
	
	public function getTotalSalesReps() {
      	$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "salesrep" . " WHERE public = '1' AND status = '1';" ;
		
		$query = $this->db->query($sql);
				
		return $query->row['total'];
	}
		
}
?>