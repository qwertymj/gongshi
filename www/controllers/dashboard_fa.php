<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Dashboard extends CI_Controller {
		var $username;
		var $password;
		var $user_type;
		//var $mysite_url="http://www.zjdxwyxyxly.0x271828.com/";
		var $mysite_url="http://localhost:600/";
		
		public function __construct()
        {
            parent::__construct();
            $this->load->library('session');
            $this->load->library('pagination');//系统的library    
            $this->load->helper('url');//系统的帮助类
            $this->username = $this->session->userdata("user");
            $this->password = $this->session->userdata("key");
            $this->load->model("userinfo");
            $this->load->model("project");
            //$this->load->model("moneyaccount");
            if (!$this->userinfo->isUserValid($this->username, $this->password)) {
            	header("location: /login");
            	return;
            }
            $this->data['account_name'] = $this->username;
            $this->data['user_role'] = $this->userinfo->SearchAuthority($this->username);
			$this->data['copyright'] = COPYRIGHT;
			define("NORMAL", '0');
			define("CANNTFIND", '1');
			define("DEAD", '2');

        }


		public function index() {
			//echo 123;
			if ($this->data['user_role'] & 1 ) {
				$this->User_Maintain();
			}
			else if ($this->data['user_role']& 2 ){
				$this->Project_Maintain();
			}
			else if ($this->data['user_role']& 4){
				$this->ProjectUnit_Maintain();
			}
			else if ($this->data['user_role']& 8){
				$this->UsrSearchProject();
			}
			else if ($this->data['user_role']& 16){
				$this->UsrSearchWork();
			}
			else if ($this->data['user_role']& 32){
				$this->SHProject();
			}
			else if ($this->data['user_role']& 64){
				$this->ProjectJZ();
			}
			else if ($this->data['user_role']& 128){
				$this->BossSearchWork();
			}
			else if ($this->data['user_role']& 256){
				$this->AllUsrLogin_log();
			}
			else 
				$this->UsrSearchLogin_log();
			// header("location: /dashboard/viewactivitystateone");
		}
		public function logout()
		{
			//$this->session->set_userdata(array("user"=>"", "key"=>""));
			//$this->data['haslogin'] = false;
			//$this->load->view("login", $this->data);
            $this->data['username'] = "";
			$this->data['password'] = "";
			$this->session->set_userdata(array("user"=>"", "key"=>""));
			//echo 123;
//echo "123";
			//echo $this->session->userdata("user");
            //echo $this->session->userdata("key");
            //echo "usr";
            //echo "<script> alert('注销成功');</script>";
			header("location: /login");
			//$this->load->view("login", $this->data);
		
				//echo 12323;	
		}
		public function User_Maintain(){
			//if ($_SERVER['REQUEST_METHOD'] == "GET") {
			//	;// if ($method == "password")
					// $this->data['inputpassword'] = true;
			//} else {	

			//}	
			$count=$this->userinfo->Search_role(0xffff);
			$url=$this->mysite_url."dashboard/User_Maintain/";
			$config=$this->page_config(count($count),$url);
			//var_dump($config);
			$this->pagination->initialize($config);
			$this->data['page_links']=$this->pagination->create_links();
			$this->data['all_usr']=$this->userinfo->Page_Search_role(0xffff,intval($config ['cur_page']),$config['per_page']);

			//$this->data['all_usr']=$this->userinfo->Search_role(0xffff);
			$this->load->view("dashboard/User_Maintain", $this->data);	
		}
		public function newuser($method = "") {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;// if ($method == "password")
					// $this->data['inputpassword'] = true;
			} else {
			$error = array();
			if( $this->data['user_role'] & 1){
				$name = $this->input->post("name", true);
				//echo $this->userinfo->SearchAuthority($name);
				$username = $this->input->post("username", true);
				$passwd = $this->input->post("passwd", true);
				$passwdagain = $this->input->post("passwdagain", true);
				$job = $this->input->post("job", true);
				$role = $this->input->post("type", true);

				//var_dump($role);

				if (@$name && $name != "") {
				if (@$username && $username != "") {
					if (@$passwd && $passwd != "") {
						if (@$passwdagain && $passwdagain != "") {
							if ($passwd==$passwdagain)  {
								if (@$role && $role ) {
									$type=0;
									foreach ($role as $r) {
										$type+=$r;
									}
									if(!$this->userinfo->SearchAuthority($name)){
										$this->userinfo->adduser($name,$username,$passwd,$job,$type);
										$this->data['addsuccess']=true;
									} else { $error[] = "该账号已经存在"; }
								} else { $error[] = "未选择员工类型"; }
							} else { $error[] = "两次密码输入不一致";}
						} else { $error[] = "请再次输入密码";}
					} else {	$error[] = "密码不为空"; }
				} else 	{	$error[] = "员工姓名不为空";}
			} else 	{	$error[] = "员工账号不为空";}
			}else {$error[] = "你没有该权限";}
			$this->data['error'] = $error;
			}
			$this->load->view("dashboard/newuser", $this->data);
		}
		public function edituser($method = "") {

			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				//echo "chenkesb";
				$name = $this->input->get("name", true);
				//$name = $this->input->post("name", true);
				;// if ($method == "password")
					// $this->data['inputpassword'] = true;
			} else {
			$error = array();
			if( $this->data['user_role'] & 1){
				$name = $this->input->post("name", true);
				$new_username = $this->input->post("new_username", true);
				//$passwd = $this->input->post("passwd", true);
				//$passwdagain = $this->input->post("passwdagain", true);
				$job = $this->input->post("job", true);
				$role = $this->input->post("type", true);
				$type=0;
				foreach ($role as $r) {
					$type+=$r;
				}
				

				if (@$new_username && $new_username != "") {
					//if (@$passwd && $passwd != "") {
						//if (@$passwdagain && $passwdagain != "") {
						//	if ($passwd==$passwdagain)  {
								if (@$type && $type != "") {
									
									$this->userinfo->edituser($name,$new_username,$job,$type);
									$this->data['success']=true;
								} else { $error[] = "未选择员工类型"; }
						//	} else { $error[] = "两次密码输入不一致";}
						//} else { $error[] = "请再次输入密码";}
					//} else {	$error[] = "密码不为空"; }
				} else 	{	$error[] = "用户名不为空";}
			}else {$error[] = "你没有该权限";}
			$this->data['error'] = $error;
			}
			//echo $name;
			$this->data['name'] = $name;
			$this->data['userinfo'] = $this->userinfo->Search_user($name);
									
			//$this->data['all_usr']=$this->userinfo->Search_role(7);
			$this->load->view("dashboard/edituser", $this->data);
		}
		public function editmypsd($method = "") {

			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;//$name = $this->input->get("name", true);
			} else {

				$name = $this->session->userdata("user");
				$password = $this->input->post("password", true);
				$newpasswd = $this->input->post("newpasswd", true);
				$newpasswdagain = $this->input->post("newpasswdagain", true);			
				$error = array();
			//if( $this->data['user_role'] & 8){
				
				if (@$password && $password != "") {
					if($this->userinfo->isUserValid($name, md5($password))){
						if (@$newpasswdagain && $newpasswdagain != "") {
							if ($newpasswd==$newpasswdagain)  {
								if(	$this->userinfo->Search_user($name)){
									$this->userinfo->edituserpsd($name,$newpasswd);
									$this->data['success']=true;	

								}
								else {$error[]= "该用户不存在";}				
							} else { $error[] = "两次密码输入不一致";}
						} else { $error[] = "请再次输入密码";}
					}else { $error[] = "密码验证错误";}
				} else {	$error[] = "密码不为空"; }
				
			//}else {$error[] = "你没有该权限";}
			$this->data['error'] = $error;
			}
			$this->load->view("dashboard/editmypsd", $this->data);
		}


		public function edituserpsd($method = "") {

			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				$name = $this->input->get("name", true);
			} else {
			$error = array();
			if( $this->data['user_role'] & 1){
				$name = $this->input->post("name", true);
				$passwd = $this->input->post("passwd", true);
				$passwdagain = $this->input->post("passwdagain", true);
				if (@$passwd && $passwd != "") {
					if (@$passwdagain && $passwdagain != "") {
						if ($passwd==$passwdagain)  {
							if(	$this->userinfo->Search_user($name)){
								$this->userinfo->edituserpsd($name,$passwd);
								$this->data['success']=true;	
							}
							else {$error[]= "该用户不存在";}				
						} else { $error[] = "两次密码输入不一致";}
					} else { $error[] = "请再次输入密码";}
				} else {	$error[] = "密码不为空"; }	
			}else {$error[] = "你没有该权限";}
			$this->data['error'] = $error;
			}
			//echo $name;
			$this->data['name'] = $name;
									
			//$this->data['all_usr']=$this->userinfo->Search_role(7);
			$this->load->view("dashboard/edituserpsd", $this->data);
		}
		public function deleteuser($method = "") {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;// if ($method == "password")
					// $this->data['inputpassword'] = true;
			} else {
				//echo "12qdafs";
				//if($this->input->post("delete", true)=="yes"){
				$error = array();
				if($this->data['user_role'] & 1){
					$username = $this->input->post("name", true);

					if (@$username && $username != "") {
						if(	$this->userinfo->Search_user($username)){
							$this->userinfo->deleteuser($username);
							$this->data['success']=true;
						}
						else {$error[]= "该用户已被删除";}

					} else 	{	$error[] = "请选择要删除的用户";}
				}else {$error[] = "你没有该权限";}
				$this->data['error'] = $error;
				//}
			}
			$this->data['all_usr']=$this->userinfo->Search_role(0xffff);
			$this->User_Maintain();
			//$this->load->view("dashboard/User_Maintain", $this->data);
		}
		public function ProjectUnit_Maintain() {
			//if ($_SERVER['REQUEST_METHOD'] == "POST") {
			//	;
			//} else {
				$error = array();
				if($this->data['user_role'] & 4){
					//$this->data['Search_result']=$this->project->SearchAllProject();
					//$this->data['all_unit']=$this->project->Search_Unit();	

			$count=$this->project->Search_Unit();
			$url=$this->mysite_url."dashboard/ProjectUnit_Maintain/";
			$config=$this->page_config(count($count),$url);
			//var_dump($config);
			$this->pagination->initialize($config);
			$this->data['page_links']=$this->pagination->create_links();
			$this->data['all_unit']=$this->project->Page_Search_Unit(intval($config ['cur_page']),$config['per_page']);

			//$this->data['all_usr']=$this->userinfo->Search_role(0xffff);
			
				}
				else {$error[] = "你没有该权限";}

				$this->data['error'] = $error;
			//}
			$this->load->view("dashboard/ProjectUnit_Maintain", $this->data);
		}
		public function editunit($method = "") {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				$bh = $this->input->get("unit_bh", true);
				// if ($method == "password")
					// $this->data['inputpassword'] = true;
			} else {
			if($this->data['user_role'] & 4){
				$bh = $this->input->post("unit_bh", true);
				$unit_name = $this->input->post("unit_name", true);
				$price = $this->input->post("price", true);
				$workunit = $this->input->post("workunit", true);
				$error = array();
				
				if (@$unit_name && $unit_name != "") {
					if (@$price && $price != "") {
						if (@$workunit && $workunit != "") {
							if (@$bh && $bh != "")  {
								if ($this->project->isBhExist($bh)) {
									
									$this->project->EditWorkUnit($unit_name,$price,$workunit,$bh);
									$this->data['success']=true;
								} else { $error[] = "该编号不存在"; }
							} else { $error[] = "编号不能为空";}
						} else { $error[] = "名称不能为空";}
					} else {	$error[] = "单价不能为空"; }
				} else 	{	$error[] = "单位名称不能为空";}
			}else {$error[] = "你没有该权限";}
			$this->data['error'] = $error;
			}

			$this->data['unit_info']=$this->project->Search_Unit_by_Bh($bh);	
			$this->load->view("dashboard/editunit", $this->data);
		}
		public function deleteunit($method = "") {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;// if ($method == "password")
					// $this->data['inputpassword'] = true;
			} else {
				//if($this->input->post("delete", true)=="yes"){
				$error = array();
				if($this->data['user_role'] & 4){
					$bh = $this->input->post("unit_bh", true);
					if (@$bh && $bh != "")  {
						if ($this->project->isBhExist($bh)) {
										
							$this->project->deleteunit($bh);
							$this->data['success']=true;
						} else { $error[] = "该编号已经被删除或者不存在"; }
					} else { $error[] = "编号不能为空";}

				}else {$error[] = "你没有该权限";}
				$this->data['error'] = $error;
				
			}
			$this->data['all_unit']=$this->project->Search_Unit();	

			$this->ProjectUnit_Maintain();
			//$this->load->view("dashboard/ProjectUnit_Maintain", $this->data);
		}
		public function newunit($method = "") {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;// if ($method == "password")
					// $this->data['inputpassword'] = true;
			} else {
			$error = array();
			if($this->data['user_role'] & 4){
				$unit_name = $this->input->post("unit_name", true);
				$price = $this->input->post("price", true);
				$workunit = $this->input->post("workunit", true);
				$bh = $this->input->post("bh", true);
				//echo "123cc".$unit_name."455cc";
				
				if (@$unit_name && $unit_name != "") {
					if (@$price && $price != "") {
						if (@$workunit && $workunit != "") {
							if (@$bh && $bh != "")  {
								if (!$this->project->isBhExist($bh)) {
									
									$this->project->AddWorkUnit($unit_name,$price,$workunit,$bh);
									$this->data['addsuccess']=true;
								} else { $error[] = "该编号已经存在"; }
							} else { $error[] = "编号不能为空";}
						} else { $error[] = "名称不能为空";}
					} else {	$error[] = "单价不能为空"; }
				} else 	{	$error[] = "单位名称不能为空";}
			}else {$error[] = "你没有该权限";}
			$this->data['error'] = $error;
			}
			$this->load->view("dashboard/newunit", $this->data);
		}
		public function Project_Maintain() {
			//if ($_SERVER['REQUEST_METHOD'] == "POST") {
			//	;
			//} else {
				$error = array();
				
				if($this->data['user_role'] & 2){
					//$this->data['Search_result']=$this->project->SearchAllProject();
			$count=$this->project->SearchAllProject();
			$url=$this->mysite_url."dashboard/Project_Maintain/";
			$config=$this->page_config(count($count),$url);
			//var_dump($config);
			$this->pagination->initialize($config);
			$this->data['page_links']=$this->pagination->create_links();
			$this->data['Search_result']=$this->project->Page_SearchAllProject(intval($config ['cur_page']),$config['per_page']);

				}else {$error[] = "你没有该权限";}

				$this->data['error'] = $error;
			//}
			$this->load->view("dashboard/Project_Maintain", $this->data);
		}
		public function deleteproject($method = "") {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;// if ($method == "password")
					// $this->data['inputpassword'] = true;
			} else {
				//if($this->input->post("delete", true)=="yes"){
				if($this->data['user_role'] & 2){
					$project_code = $this->input->post("project_code", true);
					$error = array();
						if (@$project_code && $project_code != "") {
							if(	$this->project->SearchProject_by_code($project_code)){
								$this->project->deleteproject($project_code);
								$this->data['success']=true;
							}
							else {$error[]= "该项目已被删除";}

						} else 	{	$error[] = "请选择要删除的用户";}
					}else {$error[] = "你没有该权限";}
					$this->data['error'] = $error;
				//}
			}
			$this->data['Search_result']=$this->project->SearchAllProject();
			$this->Project_Maintain();
			//$this->load->view("dashboard/Project_Maintain", $this->data);
		}
		public function editproject($method = "") {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				$project_code = $this->input->get("project_code", true);
				//echo "123".$project_code;
				// if ($method == "password")
					// $this->data['inputpassword'] = true;
			} else {
			$error = array();
				//var_dump($project_user);
			if($this->data['user_role'] & 2){
				$project_code = $this->input->post("project_code", true);
				$project_name = $this->input->post("project_name", true);
				$pcontent = $this->input->post("pcontent", true);
				//$project_user = array_filter(array_unique($this->input->post("project_user", true)));
				$startdate = $this->input->post("startdate", true);
				$enddate = $this->input->post("enddate", true);
				$sts = $this->input->post("sts", true);
	
				if (@$project_code && $project_code != "") {
					if (@$project_name && $project_name != "") {
						if ($startdate != "" || $enddate != "") {						
								if($this->project->SearchProject_by_code($project_code)){
									$this->project->editproject($project_code,$project_name,$sts,$startdate,$enddate,$pcontent);

									$this->data['success']=true;
								}else { $error[] = "该项目代码不存在！"; }						
						} else  {	$error[] = "起止日期不能为空"; }			
					} else {	$error[] = "项目名称不能为空"; }
				} else {	$error[] = "项目代码不能为空"; }
			} else {$error[] = "你没有该权限";}
			$this->data['error'] = $error;
			}
			//$this->data['all_usr']=$this->userinfo->Search_role(1);
			//$this->data['all_project']=$this->project->SearchAllProject();
			$this->data['project_info']=$this->project->SearchProject_by_code($project_code);

			$this->load->view("dashboard/editproject", $this->data);
		}

		public function project_addusr() {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;
			} else {
			$error = array();
			if($this->data['user_role'] & 2){
				$project_code =$this->input->post("project_code", true);
				$add_view =$this->input->post("add_view", true);
				//echo $add_view."asdasfafadsf";


				if(@$add_view && $add_view != ""){
					;
					//echo "1fafasdfasdf";
				}
				else{



					$t=$this->input->post("project_user", true);
					//var_dump($project_user);
					if (@$t && $t != "") {
						$project_user = array_filter(array_unique($t));
						$has_usr=$this->project->project_find_usr($project_code);
						$this->data['success']=true;
						foreach($project_user as $each_add_user){
							$flag=1;
							foreach($has_usr as $each_usr){
								// echo "table".$each_usr['uname']."\n";
								// echo "tianguo".$each_add_user."\n"."\n";
								// echo "strcmp".strcmp($each_usr['uname'],$each_add_user[0])."\n\n";
								if(strcmp($each_usr['uname'],$each_add_user)==0){
									//echo "fuck!";
									$this->data['success']=false;
									$error[] = $each_usr['uname']."已经存在于这个项目中，其余员工添加成功";
									$flag=0;
								}
							}
							if($flag==1)
								$this->project->AddProjectUser($project_code,$each_add_user);							
						}
						
					} else { $error[] = "至少选择一名员工"; }
				}
			} else {$error[] = "你没有该权限";}
			$this->data['error'] = $error;
			$this->data['project_code']=$project_code;
		}
		$this->data['all_usr']=$this->userinfo->Search_role(8);
		$this->load->view("dashboard/project_addusr", $this->data);
	}

		public function newproject($method = "") {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;
				// if ($method == "password")
					// $this->data['inputpassword'] = true;
			} else {
			$error = array();
			if($this->data['user_role'] & 2){	
				$project_code = $this->input->post("project_code", true);
				$project_name = $this->input->post("project_name", true);
				$pcontent = $this->input->post("pcontent", true);
				$project_user = array_filter(array_unique($this->input->post("project_user", true)));
				$startdate = $this->input->post("startdate", true);
				$enddate = $this->input->post("enddate", true);

				if (@$project_code && $project_code != "") {
					if (@$project_name && $project_name != "") {
						if ($startdate != "" || $enddate != "") {
							if (@$project_user && $project_user != "") {
								if(!$this->project->SearchProject_by_code($project_code)){
									$this->project->AddProject($project_code,$project_name,$startdate,$enddate,$pcontent);
									foreach($project_user as $each_add_user){
										$this->project->AddProjectUser($project_code,$each_add_user);
									}
									$this->data['addsuccess']=true;
								}else { $error[] = "该项目代码已经存在，请另外设置一个新的项目代码"; }
							} else { $error[] = "至少选择一名员工"; }
						} else  {	$error[] = "起止日期不能为空"; }			
					} else {	$error[] = "项目名称不能为空"; }
				} else 	{	$error[] = "项目代码不能为空";}
			} else {$error[] = "你没有该权限";}
			$this->data['error'] = $error;
			}
			$this->data['all_usr']=$this->userinfo->Search_role(8);
			$this->load->view("dashboard/newproject", $this->data);
		}
		public function project_cancel() {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;
			} else {
				$error = array();
				if($this->data['user_role'] & 2){
					$project_code = $this->input->post("project_code", true);
					$r=$this->project->SearchProject_by_code($project_code);
					$r=$r->row_array(0);
					if($r['sts']==1) {
						$this->project->CancelProject_by_code($project_code);
						$this->data['success']=true;
					}else { $error[]="该项目已经被取消或者不存在";}
				$this->data['Search_result']=$this->project->SearchAllProject();
			} else {$error[] = "你没有该权限";}
				$this->data['error'] = $error;
			}
			$this->Project_Maintain();
			//$this->load->view("dashboard/Project_Maintain", $this->data);
		}

		public function UsrSearchLogin_log() {
			//if ($_SERVER['REQUEST_METHOD'] == "POST") {
			//	;
			//} else {
				$error = array();
				//echo "123cc";
				//if($this->data['user_role'] & 1){
					$count=$this->userinfo->User_Search_MyLoginfo($this->username);
					$url=$this->mysite_url."dashboard/UsrSearchLogin_log/";

					$config=$this->page_config(count($count),$url);
					//$config ['cur_page'] = 20;
					$this->data['Search_result']=$this->userinfo->Page_User_Search_MyLoginfo($this->username,intval($config ['cur_page']),$config['per_page']);
					$this->pagination->initialize($config);
					$this->data['page_links']=$this->pagination->create_links();
				//$this->data['Search_result']=$this->userinfo->User_Search_MyLoginfo($this->username);
				//$this->data['success']=true;
				//}else {$error[] = "你没有该权限";}

				$this->data['error'] = $error;
			//}
			$this->load->view("dashboard/UsrSearchLogin_log", $this->data);
		}

		public function AllUsrLogin_log() {
			//if ($_SERVER['REQUEST_METHOD'] == "POST") {
			//	;
			//} else {
				$error = array();
				//echo "123cc";
				if($this->data['user_role'] & 256){
					$count=$this->userinfo->Search_AllUsrLogin_log();
					$url=$this->mysite_url."dashboard/AllUsrLogin_log/";
					$config=$this->page_config(count($count),$url);
					$this->data['Search_result']=$this->userinfo->Page_Search_AllUsrLogin_log(intval($config['cur_page']),$config['per_page']);
					$config['cur_tag_open'] = '<b>';
					$config['cur_tag_close'] = '</b>';
					$this->pagination->initialize($config);
					$this->data['page_links']=$this->pagination->create_links();
					//$this->data['success']=true;
				}else {$error[] = "你没有该权限";}

				$this->data['error'] = $error;
			//}
			$this->load->view("dashboard/AllUsrLogin_log", $this->data);
		}
		public function UsrSearchProject() {
			//if ($_SERVER['REQUEST_METHOD'] == "POST") {
			//	;
			//} else {
				$error = array();
				//echo "123cc";
				if($this->data['user_role'] & 8){
					$count=$this->project->Search_Project_byUser($this->username);
					$url=$this->mysite_url."dashboard/UsrSearchProject/";
					$config=$this->page_config(count($count),$url);
					//var_dump($config);
					$this->pagination->initialize($config);
					$this->data['page_links']=$this->pagination->create_links();
					$this->data['Search_result']=$this->project->Page_Search_Project_byUser($this->username,intval($config ['cur_page']),$config['per_page']);
					$this->data['success']=true;
				}else {$error[] = "你没有该权限";}

				$this->data['error'] = $error;
			//}
			$this->load->view("dashboard/UsrSearchProject", $this->data);
		}
		public function UsrSearchWork() {
			//if ($_SERVER['REQUEST_METHOD'] == "POST") {
			//	;
			//} else {
				$error = array();
				//echo "123cc";
				if($this->data['user_role'] & 16){
					$count=$this->project->Search_Work_byUser($this->username);
					$url=$this->mysite_url."dashboard/UsrSearchWork/";
					$config=$this->page_config(count($count),$url);
					//var_dump($config);
					$this->pagination->initialize($config);
					$this->data['page_links']=$this->pagination->create_links();
					$this->data['Search_result']=$this->project->Page_Search_Work_byUser($this->username,intval($config ['cur_page']),$config['per_page']);
					$this->data['success']=true;
					//$this->data['Search_result']=$this->project->Search_Work_byUser($this->username);
					//$this->data['success']=true;
				}else {$error[] = "你没有该权限";}

				$this->data['error'] = $error;
			//}
			//$this->data['display']="我的工时报告";
			$this->load->view("dashboard/UsrSearchWork", $this->data);
		}	
		public function BossSearchWork() {
			//if ($_SERVER['REQUEST_METHOD'] == "POST") {
			//	;
			//} else {
				$error = array();
				//echo "123cc";
				if($this->data['user_role'] & 128){
					//$this->data['Search_result']=$this->project->Search_All_Work();
					$count=$this->project->Search_All_Work();
					$url=$this->mysite_url."dashboard/BossSearchWork/";
					$config=$this->page_config(count($count),$url);
					//var_dump($config);
					$this->pagination->initialize($config);
					$this->data['page_links']=$this->pagination->create_links();
					$this->data['Search_result']=$this->project->Page_Search_All_Work(intval($config ['cur_page']),$config['per_page']);
					
					$this->data['success']=true;
				}else {$error[] = "你没有该权限";}

				$this->data['error'] = $error;
			//}
			//$this->data['display']="工时报告汇总";
			$this->load->view("dashboard/BossSearchWork", $this->data);
		}	
		public function delete_work($method = "") {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;// if ($method == "password")
					// $this->data['inputpassword'] = true;
			} else {
				//echo "12qdafs";
				//if($this->input->post("delete", true)=="yes"){
				$error = array();
				if($this->data['user_role'] & 128){
					$boss = $this->input->post("boss", true);
					$usr = $this->input->post("usr", true);
					$work_log_id = $this->input->post("work_log_id", true);
					if (@$work_log_id && $work_log_id != "") {
						if(	$this->project->Search_worklog_byid($work_log_id)){
							$this->project->delete_worklog($work_log_id);
							$this->data['deletesuccess']=true;
						}
						else {$error[]= "该报告已被删除";}

					} else 	{	$error[] = "请选择要删除的工时报告";}
				}else {$error[] = "你没有该权限";}
				$this->data['error'] = $error;
				//}
			}
			//$this->data['all_usr']=$this->userinfo->Search_role(7);
			//var_dump($boss);
			if(@$boss && $boss==1 ){
				//$this->BossSearchWork();
					$count=$this->project->Search_All_Work();
					$url=$this->mysite_url."dashboard/BossSearchWork/";
					$config=$this->page_config(count($count),$url);
					//var_dump($config);
					$this->pagination->initialize($config);
					$this->data['page_links']=$this->pagination->create_links();
					$this->data['Search_result']=$this->project->Page_Search_All_Work(intval($config ['cur_page']),$config['per_page']);
							
				//$this->data['Search_result']=$this->project->Search_All_Work();
				$this->load->view("dashboard/BossSearchWork", $this->data);
			}
			else if (@$usr && $usr==1){
				$this->UsrSearchWork();
				//$this->data['Search_result']=$this->project->Search_Work_byUser($this->username);
				//$this->load->view("dashboard/UsrSearchWork", $this->data);
			}
		}
		public function project_report() {
			$error = array();
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				if($this->data['user_role'] & 64){

					$this->data['Search_result']=$this->project->SearchUsrAllProject($this->username);
					$this->data['new_project']=true;
				}else {$error[] = "你没有该权限";}
			} else {
				if($this->data['user_role'] & 64){
					$this->data['new_project']=$this->input->post("new_project", true);
					if(@$this->data['new_project'] && $this->data['new_project'])
						$this->data['Search_result']=$this->project->SearchUsrAllProject($this->username);
					
					$project_code =$this->input->post("project_code", true);
					$project_id =$this->input->post("project_id", true);
					//var_dump($project_id);
					$report_view =$this->input->post("report_view", true);
					if(@$report_view && $report_view){
						;
					}
					else{	
						$shr=$this->input->post("shr", true);
						$hourcount=$this->input->post("hourcount", true);
						$worklogproject=$this->input->post("worklogproject", true);
						$project_unit_amount=$this->input->post("project_unit_amount", true);
						$project_unit_bh=$this->input->post("project_unit_bh", true);
						
						if(@$project_unit_bh && $project_unit_bh!="")
							$project_unit_bh=array_filter($project_unit_bh);
						
						if(@$project_unit_amount && $project_unit_amount!="")
							$project_unit_amount=array_filter($project_unit_amount);
						if(@$hourcount && $hourcount){
							if(@$project_unit_bh && $project_unit_bh!=""){
								if(count($project_unit_bh)==count($project_unit_amount)){
									$this->project->usr_report_project($project_id,$hourcount,$this->username,
										$project_unit_amount,$worklogproject,$shr,$project_unit_bh,$shr);
									$this->data['addsuccess']=true;
								}else {$error[] = "所有申报材料的数量必须填写";}
							}else {$error[] = "至少申报一项材料";}
						}else {$error[] = "工作时长不能为空";}
						
					}
					$this->data['project_code']=$project_code;
					$this->data['project_id']=$project_id;
				}else {$error[] = "你没有该权限";}
			}
			$this->data['error'] = $error;
			$this->data['all_shr']=$this->userinfo->Search_role(32);
			$this->data['all_unit']=$this->project->Search_Unit();			
			$this->load->view("dashboard/UsrProjectReport", $this->data);
		}
		function page_config($count, $url) {

			//echo $this->input->post("cur_page","true");
			//$config ['cur_page'] = $page;
			$config ['base_url'] = $url; //设置基地址
			$config ['total_rows'] = $count;
			$config ['per_page'] = 10; //每页显示的数据数量
			$config ['uri_segment'] = 3; //设置url上第几段用于传递分页器的偏移量
			$config ['first_link'] = '首页';
			$config ['last_link'] = '末页';
			$config ['next_link'] = '下一页>';
			$config ['prev_link'] = '<上一页';
			$config['num_links'] = 4;//配置偏移量在url中的位置
			$config['cur_page'] = $this->uri->segment(3);
//	$config ['cur_page'] = 20;
			if($this->input->post("cur_page","true"))
				$config ['cur_page'] = $this->input->post("cur_page","true");
			echo $config ['cur_page'];
			return $config;
		}
		public function SHProject(){
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				
				;
			} else {
				$error = array();
				//echo $work_log_id."cce".$sts."dsafsadf";
				if($this->data['user_role'] & 32){
					$project_id = $this->input->post("project_id", true);
					$SH_result = $this->input->post("SH_result", true);
					//$sts=$this->input->post("sts", true);
					$work_log_id=$this->input->post("work_log_id", true);
					$t=$this->project->get_sts($work_log_id);
					$sts=$t['sts'];
					if($sts==2){
						$this->project->update_work_log($work_log_id,$sts,$SH_result);
						$this->data['addsuccess']=$SH_result+1;
					}else { $error[]="项目目前不处于待审核状态";}
				}else {$error[] = "你没有该权限";}
				$this->data['error'] = $error;
			}
			$count=$this->project->Search_SHResult_By_role($this->username);
			$url=$this->mysite_url."dashboard/SHProject/";
			$config=$this->page_config(count($count),$url);
			//var_dump($config);
			//$config['cur_page']=20;
			$this->pagination->initialize($config);
			$this->data['page_links']=$this->pagination->create_links();
			$this->data['SHSearch_res']=$this->project->Page_Search_SHResult_By_role($this->username,intval($config ['cur_page']),$config['per_page']);
			
			//$this->data['SHSearch_res']=$this->project->Search_SHResult_By_role($this->username);
					
			$this->load->view("dashboard/SHProject", $this->data);
		}
		public function ProjectJZ(){
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				
				;
			} else {
				$error = array();
				if($this->data['user_role'] & 64){
					$project_id = $this->input->post("project_id", true);
					$JZ_result = $this->input->post("JZ_result", true);
					//$sts=$this->input->post("sts", true);
					$work_log_id=$this->input->post("work_log_id", true);
					$t=$this->project->get_sts($work_log_id);
					$sts=$t['sts'];
					//echo "asdfgh".$SH_result."\n";

					if($sts==3){
						//echo "dsafsadf";
						$this->project->update_work_log($work_log_id,$sts,$JZ_result);
						$this->data['addsuccess']=$JZ_result+1;
					}else { $error[]="项目目前不处于待结账状态";}
				}else {$error[] = "你没有该权限";}
				$this->data['error'] = $error;
			}
			//$this->data['JZ_Search_res']=$this->project->Search_JZResult_By_Sts(3);
			$count=$this->project->Search_JZResult_By_Sts(3);
			$url=$this->mysite_url."dashboard/ProjectJZ/";
			$config=$this->page_config(count($count),$url);
			//var_dump($config);
			$this->pagination->initialize($config);
			$this->data['page_links']=$this->pagination->create_links();
			$this->data['JZ_Search_res']=$this->project->Page_Search_JZResult_By_Sts(3,intval($config ['cur_page']),$config['per_page']);
						
			$this->load->view("dashboard/ProjectJZ", $this->data);
		}

	}
?>