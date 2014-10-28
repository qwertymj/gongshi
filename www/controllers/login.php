<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Login extends CI_Controller {

		public function __construct()
        {
            parent::__construct();
            $this->load->library('session');
            $this->load->model("userinfo");
        }

		public function index() {
			$username = $this->input->post("username");
			$password = $this->input->post("password");
			$result = false;
			$user_type;
				
			if (@$username && @$password) {
				if ($user_type = $this->userinfo->isUserValid($username, md5($password))) {
					$this->session->set_userdata(array("user"=>$username, "key"=>md5($password)));
					$result = true;
				} else {
					$data['wrong_user'] = true;
				}
			}
			else $data['empty_user']=true;
			if ($result) {
				//echo "chenkechenke".$username;
				$usrinfo=$this->userinfo->Search_user($username);
				$ip=$this->input->ip_address();
				$logtime=gmdate("Y-m-d H:i:s", mktime() + 8 * 3600);
				$this->userinfo->User_add_loginfo($usrinfo['name'],
					$usrinfo['username'],$ip,$logtime);
				header("location: /dashboard");
			}
			else {
				//echo "1".$this->input->ip_address()."<br>";
				//echo "2".$this->session->userdata('ip_address');

				$data['copyright'] = COPYRIGHT;
				$this->load->view("login", $data);
			}
		}
	}
?>