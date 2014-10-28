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
					      ->where("sts", 1)
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
					      ->where("sts", 1)
					      ->get("t_user");
			$r=$q->row_array(0);
			if(!$r) return false;
			return $r['role'];
		}

		public function Search_role($role){
			$q = $this->db->query("select name,username,job from t_user where sts=1 and role &".$role);
			return $q->result_array();
		}
		public function adduser($name,$username,$password,$job,$type) {
			$data = array("name"=>$name,
						  "username"=>$username,
						  "sts"=>1,
			              "password"=>md5($password),
			              "job"=>$job,
						  "role"=>$type);
			$this->db->insert("t_user", $data);
			return ;
		}
		public function deleteuser($name) {
			$this->db->where("name", $name);
			$this->db->set("sts", 0);
			$this->db->update("t_user");

			$this->db->where("uname", $name);
			$this->db->set("sts", 0);
			$this->db->update("t_login_log");

			$this->db->where("uname", $name);
			$this->db->set("sts", 0);
			$this->db->update("t_project_user");
			//$q = $this->db->query("delete from t_user where name='".$name."'");
			return ;
		}
		public function edituser($name,$new_username,$job,$type) {
			$this->db->where("name", $name);
			$this->db->where("sts", 1);
			$this->db->set("role", $type);
			$this->db->set("username", $new_username);
			$this->db->set("job", $job);
			$this->db->update("t_user");
			return ;
		}
		public function User_add_loginfo($uname,$username,$login_ip,$logtime){
			$data = array("uname"=>$uname,
						  "username"=>$username,
						  "sts"=>1,
						  "login_datetime"=>$logtime,
						  "login_ip"=>$login_ip);
			$this->db->insert("t_login_log", $data);		
		}
		public function Search_user($name){
			$q = $this->db->select("name,username,job,password,role")
					      ->where("name", $name)
					      ->where("sts", 1)
					      ->get("t_user");
			$r=$q->row_array(0);
			return $r;
		}
		public function User_Search_MyLoginfo($uname){
			$q = $this->db->select("uname,login_datetime,login_ip")
					      ->where("uname", $uname)
					      ->where("sts", 1)
					      ->get("t_login_log");
			
			return $q->result_array();		
		}
		public function Search_AllUsrLogin_log(){
			$q = $this->db->select("uname,username,login_datetime,login_ip")
						  ->where("sts", 1)
					      ->get("t_login_log");
			
			return $q->result_array();		
		}
		public function edituserpsd($name,$password) {
			$this->db->where("name", $name);
			$this->db->where("sts", 1);
			$this->db->set("password", md5($password));
			$this->db->update("t_user");
			return ;
		}
	}
?>