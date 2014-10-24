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
		public function deleteuser($name) {
			$q = $this->db->query("delete from t_user where name='".$name."'");
			return ;
		}
		public function edituser($name,$passwd,$type) {
			$this->db->where("name", $name);
			$this->db->set("password",md5($passwd));
			$this->db->set("role", $type);
			$this->db->update("t_user");
			return ;
		}
	}
?>