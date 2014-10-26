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
		public function SearchAuthority($name) {
			if (!$name)
				return false;
			$q = $this->db->select("role")
					      ->where("name", $name)
					      ->get("t_user");
			$r=$q->row_array(0);
			if(!$r) return false;
			return $r['role'];
		}
		public function Search_user($name){
			$q = $this->db->select("name,username,job,password,role")
					      ->where("name", $name)
					      ->get("t_user");
			$r=$q->row_array(0);
			return $r;
		}
		public function Search_role($role){
			$q = $this->db->query("select name,username,job from t_user where role &".$role);
			return $q->result_array();
		}
		public function adduser($name,$username,$password,$job,$type) {
			$data = array("name"=>$name,
						  "username"=>$username,
			              "password"=>md5($password),
			              "job"=>$job,
						  "role"=>$type);
			$this->db->insert("t_user", $data);
			return ;
		}
		public function deleteuser($name) {
			$q = $this->db->query("delete from t_user where name='".$name."'");
			return ;
		}
		public function edituser($name,$new_username,$job,$type) {
			$this->db->where("name", $name);
			$this->db->set("role", $type);
			$this->db->set("username", $new_username);
			$this->db->set("job", $job);
			$this->db->update("t_user");
			return ;
		}
		public function edituserpsd($name,$password) {
			$this->db->where("name", $name);
			$this->db->set("password", md5($password));
			$this->db->update("t_user");
			return ;
		}
	}
?>