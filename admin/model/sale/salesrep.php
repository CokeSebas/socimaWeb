<?php
class ModelSaleSalesRep extends Model {
	public function addSalesRep($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "salesrep SET name = '" . $this->db->escape($data['name']) ."', area = '" . $this->db->escape($data['area']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', address = '" . $this->db->escape($data['address']) . "', code = '" . $this->db->escape($data['code']) . "', status = '" . (int)$data['status'] . "', public = '" . (int)$data['public'] . "', alert = '" . (int)$data['alert'] . "', additional_emails = '" . $this->db->escape($data['additional_emails']) . "', cargo = '" . $this->db->escape($data['cargo']) . "', date_added = NOW()");
	}
	
	public function editSalesRep($salesrep_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "salesrep SET name = '" . $this->db->escape($data['name']) . "', area = '" . $this->db->escape($data['area']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', address = '" . $this->db->escape($data['address']) . "', code = '" . $this->db->escape($data['code']) . "', status = '" . (int)$data['status'] . "', public = '" . (int)$data['public'] . "', alert = '" . (int)$data['alert'] . "', additional_emails = '" . $this->db->escape($data['additional_emails']) . "', cargo = '" . $this->db->escape($data['cargo']) . "' WHERE salesrep_id = '" . (int)$salesrep_id . "'");
	}

	public function deleteSalesRep($salesrep_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "salesrep WHERE salesrep_id = '" . (int)$salesrep_id . "'");
	}
	
	public function getSalesRep($salesrep_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "salesrep WHERE salesrep_id = '" . (int)$salesrep_id . "'");
	
		return $query->row;
	}
	
	public function getCargo(){
		$sql = "SELECT * FROM " . DB_PREFIX . "cargo";
		
		$query = $this->db->query($sql);

		return $query->rows;	
	}
			
	public function getSalesReps($data = array(), $none = 0) {
		
		$sql = "SELECT * FROM " . DB_PREFIX . "salesrep";

		$implode = array();
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$implode[] = "name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
			$implode[] = "email = '" . $this->db->escape($data['filter_email']) . "'";
		}
		
		if (isset($data['filter_area']) && !is_null($data['filter_area'])) {
			$implode[] = "area = '" . $this->db->escape($data['filter_area']) . "'";
		}	

		if (isset($data['filter_telephone']) && !is_null($data['filter_telephone'])) {
			$implode[] = "telephone = '" . $this->db->escape($data['filter_telephone']) . "'";
		}	
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "status = '" . (int)$data['filter_status'] . "'";
		}	
// v1.2
		if (isset($data['filter_public']) && !is_null($data['filter_public'])) {
			$implode[] = "public = '" . (int)$data['filter_public'] . "'";
		}	

		if (isset($data['filter_alert']) && !is_null($data['filter_alert'])) {
			$implode[] = "alert = '" . (int)$data['filter_alert'] . "'";
		}			
// v1.2 end		
		if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
			$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
			$sql .= " AND salesrep_id >= " . $none;
			} else  {
			$sql .= " WHERE salesrep_id >= " . $none;
			} 

// v1.3
		/*if ($this->user->getUserSalesRepId() != 0) {
			$sql .= " AND salesrep_id = '" . $this->user->getUserSalesRepId() . "'";
		}*/
// v1.3 end	
			
		$sort_data = array(
			'name',
			'email',
			'area',
			'telephone',
			'status',
// v1.2
			'public',
			'alert',
// v1.2 end			
			'date_added'
		);	
			
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY name";	
		}
			
		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}			

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
			
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}		
		
		$query = $this->db->query($sql);
		
		return $query->rows;	
	}
	
	public function getTotalSalesReps($data = array(), $none = 0) {
      	$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "salesrep";
			
		$implode = array();
		
		if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
			$implode[] = "name LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
		}
		
		if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
			$implode[] = "email = '" . $this->db->escape($data['filter_email']) . "'";
		}
		
		if (isset($data['filter_area']) && !is_null($data['filter_area'])) {
			$implode[] = "area = '" . $this->db->escape($data['filter_area']) . "'";
		}	

		if (isset($data['filter_telephone']) && !is_null($data['filter_telephone'])) {
			$implode[] = "telephone = '" . $this->db->escape($data['filter_telephone']) . "'";
		}	
		
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "status = '" . (int)$data['filter_status'] . "'";
		}	

// v1.2
		if (isset($data['filter_public']) && !is_null($data['filter_public'])) {
			$implode[] = "public = '" . (int)$data['filter_public'] . "'";
		}	

		if (isset($data['filter_alert']) && !is_null($data['filter_alert'])) {
			$implode[] = "alert = '" . (int)$data['filter_alert'] . "'";
		}	
// v1.2 end		

		if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
			$implode[] = "DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
			$sql .= " AND salesrep_id >= " . $none;
			} else  {
			$sql .= " WHERE salesrep_id >= " . $none;
			} 

// v1.3
		if ($this->user->getUserSalesRepId() != 0) {
			$sql .= " AND salesrep_id = '" . $this->user->getUserSalesRepId() . "'";
		}
// v1.3 end				
			
		$query = $this->db->query($sql);
				
		return $query->row['total'];
	}

	public function getSalesRepByEmail($email) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "salesrep WHERE LCASE(email) = '" . $this->db->escape(strtolower($email)) . "'");
	
		return $query->row;
	}

	public function addTransaction($salesrep_id, $description = '', $amount = '', $order_id = 0) {
		$salesrep_info = $this->getSalesRep($salesrep_id);
		
		if ($salesrep_info) { 
			$this->db->query("INSERT INTO " . DB_PREFIX . "salesrep_transaction SET salesrep_id = '" . (int)$salesrep_id . "', order_id = '" . (float)$order_id . "', description = '" . $this->db->escape($description) . "', amount = '" . (float)$amount . "', date_added = NOW()");
		
			$this->language->load('mail/salesrep');
							
			$message  = sprintf($this->language->get('text_transaction_received'), $this->currency->format($amount, $this->config->get('config_currency'))) . "\n\n";
			$message .= sprintf($this->language->get('text_transaction_total'), $this->currency->format($this->getTransactionTotal($salesrep_id), $this->config->get('config_currency')));
								
			$mail = new Mail();
			$mail->protocol = $this->config->get('config_mail_protocol');
			$mail->parameter = $this->config->get('config_mail_parameter');
			$mail->hostname = $this->config->get('config_smtp_host');
			$mail->username = $this->config->get('config_smtp_username');
			$mail->password = $this->config->get('config_smtp_password');
			$mail->port = $this->config->get('config_smtp_port');
			$mail->timeout = $this->config->get('config_smtp_timeout');
			$mail->setTo($salesrep_info['email']);
			$mail->setFrom($this->config->get('config_email'));
			$mail->setSender($this->config->get('config_name'));
			$mail->setSubject(html_entity_decode(sprintf($this->language->get('text_transaction_subject'), $this->config->get('config_name')), ENT_QUOTES, 'UTF-8'));
			$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$mail->send();
		}
	}
	
	public function deleteTransaction($order_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "salesrep_transaction WHERE order_id = '" . (int)$order_id . "'");
	}
	
	public function getTransactions($salesrep_id, $start = 0, $limit = 10) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "salesrep_transaction WHERE salesrep_id = '" . (int)$salesrep_id . "' ORDER BY date_added DESC LIMIT " . (int)$start . "," . (int)$limit);
	
		return $query->rows;
	}

	public function getTotalTransactions($salesrep_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total  FROM " . DB_PREFIX . "salesrep_transaction WHERE salesrep_id = '" . (int)$salesrep_id . "'");
	
		return $query->row['total'];
	}
			
	public function getTransactionTotal($salesrep_id) {
		$query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "salesrep_transaction WHERE salesrep_id = '" . (int)$salesrep_id . "'");
	
		return $query->row['total'];
	}	
	
	public function getTotalTransactionsByOrderId($order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "salesrep_transaction WHERE order_id = '" . (int)$order_id . "'");
	
		return $query->row['total'];
	}		
	
}
?>