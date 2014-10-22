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
			if ($result) {
				header("location: /dashboard");
			}
			else {
				$data['copyright'] = COPYRIGHT;
				$this->load->view("login", $data);
			}
		}
	}
?>