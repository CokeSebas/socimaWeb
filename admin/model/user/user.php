<?php
class ModelUserUser extends Model {
	public function addUser($data) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "user` SET username = '" . $this->db->escape($data['username']) . "', salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', user_group_id = '" . (int)$data['user_group_id'] . "', status = '" . (int)$data['status'] . "', date_added = NOW(), meta = '" . $this->db->escape($data['meta']) . "'");
		
		if($data['localidad'] == '1'){
			$localidad = 'STGO';
		}else if($data['localidad'] == '2'){
			$localidad = 'REG';
		}
		
		$user_id = $this->db->getLastId();
		
		$this->db->query("INSERT INTO `" . DB_PREFIX . "salesrep`(`name`, `email`, `username`, `password`, `date_added`, `cargo`, `MM`,user_id, localidad) VALUES ('" . $this->db->escape($data['firstname']) . "', '" . $this->db->escape($data['email']) . "', '" . $this->db->escape($data['username']) . "', '" . $this->db->escape($data['password']) . "', NOW(), '" . (int)$data['user_group_id'] . "', '" . $this->db->escape($data['meta']) . "', '" . $this->db->escape($user_id) . "', '" . $this->db->escape($localidad) . "')");
	}

	public function editUser($user_id, $data) {
		$this->db->query("UPDATE `" . DB_PREFIX . "user` SET username = '" . $this->db->escape($data['username']) . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', user_group_id = '" . (int)$data['user_group_id'] . "', status = '" . (int)$data['status'] . "', meta = '" . $this->db->escape($data['meta']) . "' WHERE user_id = '" . (int)$user_id . "'");
		
		if($data['localidad'] == '1'){
			$localidad = 'STGO';
		}else if($data['localidad'] == '2'){
			$localidad = 'REG';
		}
		
		$this->db->query("UPDATE `" . DB_PREFIX . "salesrep` SET `name`= '" . $this->db->escape($data['firstname']) . "', `email`= '" . $this->db->escape($data['email']) . "', `username`= '" . $this->db->escape($data['username']) . "', `cargo`= '" . (int)$data['user_group_id'] . "', `MM`= '" . $this->db->escape($data['meta']) . "', `localidad`= '" . $localidad . "' WHERE `user_id` = '" . (int)$user_id . "'");

		if ($data['password']) {
			$this->db->query("UPDATE `" . DB_PREFIX . "user` SET salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "' WHERE user_id = '" . (int)$user_id . "'");
			
			$this->db->query("UPDATE " . DB_PREFIX . "salesrep SET password = '" . $this->db->escape($data['password']) . "', username = '" . $this->db->escape($data['username']) . "' WHERE `user_id` = '" . (int)$user_id . "'");
		}
	}

	public function editPassword($user_id, $password) {
		$this->db->query("UPDATE `" . DB_PREFIX . "user` SET salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($password)))) . "', code = '' WHERE user_id = '" . (int)$user_id . "'");
	}

	public function editCode($email, $code) {
		$this->db->query("UPDATE `" . DB_PREFIX . "user` SET code = '" . $this->db->escape($code) . "' WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
	}

	public function deleteUser($user_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "user` WHERE user_id = '" . (int)$user_id . "'");
		
		$this->db->query("DELETE FROM `" . DB_PREFIX . "salesrep` WHERE user_id = '" . (int)$user_id . "'");
	}

	public function getUser($user_id) {
		//$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "user` WHERE user_id = '" . (int)$user_id . "'");
		
		$query = $this->db->query("SELECT u.*, s.localidad  FROM " . DB_PREFIX . "user u JOIN " . DB_PREFIX ."salesrep s ON (u.user_id = s.user_id) WHERE u.user_id = '" . (int)$user_id . "'");

		return $query->row;
	}
	
	public function getEmail($user_id){
		$query = $this->db->query("SELECT `email` FROM `" . DB_PREFIX . "user` WHERE `user_id` = '" . (int)$user_id . "'");
		
		return $query->row;
	}
	
	public function getSalesrepId($email){
		$query = $this->db->query("SELECT `salesrep_id` FROM `" . DB_PREFIX . "salesrep` WHERE `email` = '" . $email . "'");
		
		return $query->row;
	}
	
	public function getActual($salesrep){
		//$query = $this->db->query("SELECT IFNULL(SUM(total), 0) AS total FROM " . DB_PREFIX . "order WHERE `salesrep_id` = '" . (int)$salesrep . "' AND date_added BETWEEN DATE_SUB( CURDATE(), INTERVAL 30 DAY ) AND CURDATE()");
		$query = $this->db->query("SELECT IFNULL(SUM(total), 0) AS total FROM " . DB_PREFIX . "order WHERE `salesrep_id` = '" . (int)$salesrep . "' AND DATE_FORMAT(date_added, '%m-%Y') = DATE_FORMAT(CURDATE(), '%m-%Y')");
		
		return $query->row;
	}
	
	public function getUserGroup($user_id){
		$query = $this->db->query("SELECT `user_group_id` FROM `" . DB_PREFIX . "user` WHERE user_id = '" . (int)$user_id . "'");
		
		return $query->row;
	}

	public function getUserByUsername($username) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "user` WHERE username = '" . $this->db->escape($username) . "'");

		return $query->row;
	}

	public function getUserByCode($code) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "user` WHERE code = '" . $this->db->escape($code) . "' AND code != ''");

		return $query->row;
	}

	public function getUsers($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "user`";

		$sort_data = array(
			'username',
			'status',
			'date_added'
		);	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY username";	
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

	public function getTotalUsers() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "user`");

		return $query->row['total'];
	}

	public function getTotalUsersByGroupId($user_group_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "user` WHERE user_group_id = '" . (int)$user_group_id . "'");

		return $query->row['total'];
	}

	public function getTotalUsersByEmail($email) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "user` WHERE LCASE(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

		return $query->row['total'];
	}	
}
?>