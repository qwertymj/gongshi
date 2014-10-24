<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Dashboard extends CI_Controller {
		var $username;
		var $password;
		var $user_type;
		public function __construct()
        {
            parent::__construct();
            $this->load->library('session');
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
			if ($this->data['user_role'] & 8 ) {
				$this->load->view("dashboard/newuser", $this->data);
			}
			else if ($this->data['user_role']& 1 ){
				$this->UsrSearchProject();
			}
			else if ($this->data['user_role']& 2){
				$this->SHProject();
			}
			else if ($this->data['user_role']& 4){
				$this->ProjectJZ();
			}
			// header("location: /dashboard/viewactivitystateone");
		}
		public function User_Maintain(){
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;// if ($method == "password")
					// $this->data['inputpassword'] = true;
			} else {	

			}	
			$this->data['all_usr']=$this->userinfo->Search_role(0xffff);
			$this->load->view("dashboard/User_Maintain", $this->data);	
		}
		public function newuser($method = "") {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;// if ($method == "password")
					// $this->data['inputpassword'] = true;
			} else {
				$name = $this->input->post("name", true);
				//echo $this->userinfo->SearchAuthority($name);
				$username = $this->input->post("username", true);
				$passwd = $this->input->post("passwd", true);
				$passwdagain = $this->input->post("passwdagain", true);
				$job = $this->input->post("job", true);
				$type1 = $this->input->post("type1", true);
				$type2 = $this->input->post("type2", true);
				$type3 = $this->input->post("type3", true);
				$type4 = $this->input->post("type4", true);
				//echo ($type1+$type2+$type3+$type4);
				$type=$type1+$type2+$type3+$type4;
				$error = array();
			if( $this->data['user_role'] & 8){
				if (@$name && $name != "") {
				if (@$username && $username != "") {
					if (@$passwd && $passwd != "") {
						if (@$passwdagain && $passwdagain != "") {
							if ($passwd==$passwdagain)  {
								if (@$type && $type != "") {
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
			}
			else {$error[] = "你没有该权限";}
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

				$name = $this->input->post("name", true);
				$new_username = $this->input->post("new_username", true);
				$passwd = $this->input->post("passwd", true);
				$passwdagain = $this->input->post("passwdagain", true);
				$job = $this->input->post("job", true);
				$type1 = $this->input->post("type1", true);
				$type2 = $this->input->post("type2", true);
				$type3 = $this->input->post("type3", true);
				$type4 = $this->input->post("type4", true);
				//echo ($type1+$type2+$type3+$type4);
				$type=$type1+$type2+$type3+$type4;
				$error = array();
			if( $this->data['user_role'] & 8){
				if (@$new_username && $new_username != "") {
					if (@$passwd && $passwd != "") {
						if (@$passwdagain && $passwdagain != "") {
							if ($passwd==$passwdagain)  {
								if (@$type && $type != "") {
									
									$this->userinfo->edituser($name,$new_username,$passwd,$job,$type);
									$this->data['success']=true;
								} else { $error[] = "未选择员工类型"; }
							} else { $error[] = "两次密码输入不一致";}
						} else { $error[] = "请再次输入密码";}
					} else {	$error[] = "密码不为空"; }
				} else 	{	$error[] = "用户名不为空";}
			}
			else {$error[] = "你没有该权限";}
			$this->data['error'] = $error;
			}
			//echo $name;
			$this->data['name'] = $name;
			//$this->data['all_usr']=$this->userinfo->Search_role(7);
			$this->load->view("dashboard/edituser", $this->data);
		}
		public function deleteuser($method = "") {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;// if ($method == "password")
					// $this->data['inputpassword'] = true;
			} else {
				$username = $this->input->post("name", true);
				$error = array();
			if( $this->data['user_role'] & 8){
				if (@$username && $username != "") {
					if(	$this->userinfo->SearchAuthority($username)){
						$this->userinfo->deleteuser($username);
						$this->data['success']=true;
					}
					else {$error[]= "该用户已被删除";}

				} else 	{	$error[] = "请选择要删除的用户";}
			}
			else {$error[] = "你没有该权限";}
			$this->data['error'] = $error;
			}
			$this->data['all_usr']=$this->userinfo->Search_role(7);
			$this->load->view("dashboard/User_Maintain", $this->data);
		}
		public function deleteunit($method = "") {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;// if ($method == "password")
					// $this->data['inputpassword'] = true;
			} else {

				$bh = $this->input->post("unit_bh", true);
				//echo "123cc".$unit_name."455cc";
				$error = array();
			if($this->data['user_role'] & 8){					

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

			$this->load->view("dashboard/deleteunit", $this->data);
		}
		public function newunit($method = "") {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;// if ($method == "password")
					// $this->data['inputpassword'] = true;
			} else {
				$unit_name = $this->input->post("unit_name", true);
				$price = $this->input->post("price", true);
				$workunit = $this->input->post("workunit", true);
				$bh = $this->input->post("bh", true);
				//echo "123cc".$unit_name."455cc";
				$error = array();
			if($this->data['user_role'] & 8){					
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
		public function editproject($method = "") {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;
				// if ($method == "password")
					// $this->data['inputpassword'] = true;
			} else {
				$project_code = $this->input->post("project_code", true);
				$project_name = $this->input->post("project_name", true);
				$pcontent = $this->input->post("pcontent", true);
				//$project_user = array_filter(array_unique($this->input->post("project_user", true)));
				$startdate = $this->input->post("startdate", true);
				$enddate = $this->input->post("enddate", true);
				$sts = $this->input->post("sts", true);
				//echo $startdate;
				//echo $enddate;
				$error = array();
				//var_dump($project_user);
			if($this->data['user_role'] & 8){	
			if (@$project_code && $project_code != "") {
				if (@$project_name && $project_name != "") {
					if ($startdate != "" || $enddate != "") {						
							if($this->project->isProjectCodeValid($project_code)){
								$this->project->editproject($project_code,$project_name,$sts,$startdate,$enddate,$pcontent);

								$this->data['success']=true;
							}else { $error[] = "该项目代码不存在！"; }						
					} else  {	$error[] = "起止日期不能为空"; }			
				} else {	$error[] = "项目名称不能为空"; }
			} else {	$error[] = "项目代码不能为空"; }
			}
			else {$error[] = "你没有该权限";}
			$this->data['error'] = $error;
			}
			//$this->data['all_usr']=$this->userinfo->Search_role(1);
			$this->data['all_project']=$this->project->SearchAllProject();
			$this->load->view("dashboard/editproject", $this->data);
		}
		public function editunit($method = "") {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;// if ($method == "password")
					// $this->data['inputpassword'] = true;
			} else {
				$bh = $this->input->post("unit_bh", true);
				$unit_name = $this->input->post("unit_name", true);
				$price = $this->input->post("price", true);
				$workunit = $this->input->post("workunit", true);

				//echo "123cc".$unit_name."455cc";
				$error = array();
			if($this->data['user_role'] & 8){					
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

			$this->data['all_unit']=$this->project->Search_Unit();	
			$this->load->view("dashboard/editunit", $this->data);
		}
		public function project_addusr() {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;
			} else {
				$project_code =$this->input->post("project_code", true);
				$add_view =$this->input->post("add_view", true);
				//echo $add_view."asdasfafadsf";
				$error = array();

				if(@$add_view && $add_view != ""){
					;
					//echo "1fafasdfasdf";
				}
				else{

			if($this->data['user_role'] & 8){
					$error = array();
					$project_user = array_filter(array_unique($this->input->post("project_user", true)));
					//var_dump($project_user);
					if (@$project_user && $project_user != "") {
						$has_usr=$this->project->project_find_usr($project_code);
						$this->data['addsuccess']=true;
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
					}else {$error[] = "你没有该权限";}
					$this->data['error'] = $error;
				}

				$this->data['project_code']=$project_code;
			}
			$this->data['all_usr']=$this->userinfo->Search_role(1);
			$this->load->view("dashboard/project_addusr", $this->data);
		}

		public function newproject($method = "") {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;
				// if ($method == "password")
					// $this->data['inputpassword'] = true;
			} else {
				$project_code = $this->input->post("project_code", true);
				$project_name = $this->input->post("project_name", true);
				$pcontent = $this->input->post("pcontent", true);
				$project_user = array_filter(array_unique($this->input->post("project_user", true)));
				$startdate = $this->input->post("startdate", true);
				$enddate = $this->input->post("enddate", true);
				//echo $startdate;
				//echo $enddate;
				$error = array();
				//var_dump($project_user);
			if($this->data['user_role'] & 8){	
				if (@$project_code && $project_code != "") {
					if (@$project_name && $project_name != "") {
						if ($startdate != "" || $enddate != "") {
							if (@$project_user && $project_user != "") {
								if(!$this->project->isProjectCodeValid($project_code)){
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
			}
			else {$error[] = "你没有该权限";}
			$this->data['error'] = $error;
			}
			$this->data['all_usr']=$this->userinfo->Search_role(1);
			$this->load->view("dashboard/newproject", $this->data);
		}
		public function project_cancel() {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;
			} else {
				$error = array();
				$project_code = $this->input->post("project_code", true);
				$r=$this->project->SearchProject_by_code($project_code);
				$r=$r->row_array(0);
				//print_r($r);
				//echo "cccchenejiweie";
				if($this->data['user_role'] & 8){
					if($r['sts']==1) {
						$this->project->CancelProject_by_code($project_code);
						$this->data['success']=true;
					}
					else { $error[]="该项目已经被取消或者不存在";}
				$this->data['Search_result']=$this->project->SearchAllProject();
			} else {$error[] = "你没有该权限";}
				$this->data['error'] = $error;
			}
			$this->load->view("dashboard/BossSearchProject", $this->data);
		}

		public function BossSearchProject() {
			if ($_SERVER['REQUEST_METHOD'] == "POST") {
				;
			} else {
				$error = array();
				
				if($this->data['user_role'] & 8){
					$this->data['Search_result']=$this->project->SearchAllProject();
				}
				else {$error[] = "你没有该权限";}

				$this->data['error'] = $error;
			}
			$this->load->view("dashboard/BossSearchProject", $this->data);
		}
		public function UsrSearchProject() {
			if ($_SERVER['REQUEST_METHOD'] == "POST") {
				;
			} else {
				$error = array();
				//echo "123cc";
				if($this->data['user_role'] & 1){
					$this->data['Search_result']=$this->project->Search_Project_byUser($this->username);
				}
				else {$error[] = "你没有该权限";}

				$this->data['error'] = $error;
			}
			$this->load->view("dashboard/UsrSearchProject", $this->data);
		}
		
		public function project_report() {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;
			} else {
				$error = array();
				$project_code =$this->input->post("project_code", true);
				$project_id =$this->input->post("project_id", true);
				$report_view =$this->input->post("report_view", true);
				if(@$report_view && $report_view != ""){
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
			}
			$this->data['error'] = $error;
			$this->data['all_shr']=$this->userinfo->Search_role(2);
			$this->data['all_unit']=$this->project->Search_Unit();			
			$this->load->view("dashboard/UsrProjectReport", $this->data);
		}
		public function SHProject(){
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				
				;
			} else {
				$project_id = $this->input->post("project_id", true);
				$SH_result = $this->input->post("SH_result", true);
				//$sts=$this->input->post("sts", true);
				$work_log_id=$this->input->post("work_log_id", true);
				$t=$this->project->get_sts($work_log_id);
				$sts=$t['sts'];
				//echo "asdfgh".$SH_result."\n";
				$error = array();
				//echo $work_log_id."cce".$sts."dsafsadf";
				if($sts==2){
					//echo "dsafsadf";
					$this->project->update_work_log($work_log_id,$sts,$SH_result);
					$this->data['addsuccess']=$SH_result+1;
					//var_dump($SH_result);
				}else { $error[]="项目目前不处于待审核状态";}
				$this->data['error'] = $error;
			}
			$this->data['SHSearch_res']=$this->project->Search_Result_By_role($this->username);
					
			$this->load->view("dashboard/SHProject", $this->data);
		}
		public function ProjectJZ(){
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				
				;
			} else {
				$project_id = $this->input->post("project_id", true);
				$JZ_result = $this->input->post("JZ_result", true);
				//$sts=$this->input->post("sts", true);
				$work_log_id=$this->input->post("work_log_id", true);
				$t=$this->project->get_sts($work_log_id);
				$sts=$t['sts'];
				//echo "asdfgh".$SH_result."\n";
				$error = array();
				if($sts==3){
					//echo "dsafsadf";
					$this->project->update_work_log($work_log_id,$sts,$JZ_result);
				}else { $error[]="项目目前不处于待结账状态";}
				$this->data['error'] = $error;
			}
			$this->data['JZ_Search_res']=$this->project->Search_Result_By_Sts(3);
					
			$this->load->view("dashboard/ProjectJZ", $this->data);
		}



	}
?>