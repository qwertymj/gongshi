<?php
	class Userinfo extends CI_Model {
		public function __construct() {
			$this->load->database();
		}

		public function isUserValid($username, $password) {
			if (!($username && $password))
				return false;
			$q = $this->db->select("name")
					      ->where("name", $username)
					      ->where("password", $password)
					      ->get("t_user");
			if ($q->num_rows() > 0)
				return true;
			return false;
		}
		public function SearchAuthority($username) {
			if (!$username)
				return false;
			$q = $this->db->select("role")
					      ->where("name", $username)
					      ->get("t_user");
			$r=$q->row_array(0);
			return $r['role'];
		}
		public function adduser($name, $password,$role) {
			$data = array("name"=>$name,
			              "password"=>md5($password),
						  "role"=>$role);
			$this->db->insert("t_user", $data);
			return ;
		}
	}
?>