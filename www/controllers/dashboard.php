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
            $this->data['user_type'] = $this->user_type;
			$this->data['copyright'] = COPYRIGHT;
			define("NORMAL", '0');
			define("CANNTFIND", '1');
			define("DEAD", '2');
        }


		public function index() {
			//echo 123;
			$this->load->view("dashboard/newuser", $this->data);
			// header("location: /dashboard/viewactivitystateone");
		}

		public function newuser($method = "") {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;// if ($method == "password")
					// $this->data['inputpassword'] = true;
			} else {
				$username = $this->input->post("username", true);
				$passwd = $this->input->post("passwd", true);
				$passwdagain = $this->input->post("passwdagain", true);
				$type1 = $this->input->post("type1", true);
				$type2 = $this->input->post("type2", true);
				$type3 = $this->input->post("type3", true);
				$type4 = $this->input->post("type4", true);
				//echo ($type1+$type2+$type3+$type4);
				$type=$type1+$type2+$type3+$type4;
				$error = array();
			if( $this->userinfo->SearchAuthority($this->username) & 0b1000){
				if (@$username && $username != "") {
					if (@$passwd && $passwd != "") {
						if (@$passwdagain && $passwdagain != "") {
							if ($passwd==$passwdagain)  {
								if (@$type && $type != "") {
									
									$this->userinfo->adduser($username,$passwd,$type);
									$this->data['addsuccess']=true;
								} else { $error[] = "未选择员工类型"; }
							} else { $error[] = "两次密码输入不一致";}
						} else { $error[] = "请再次输入密码";}
					} else {	$error[] = "密码不为空"; }
				} else 	{	$error[] = "用户名不为空";}
			}
			else {$error[] = "你没有该权限";}
			$this->data['error'] = $error;
			}
			$this->load->view("dashboard/newuser", $this->data);
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
			if($this->userinfo->SearchAuthority($this->username)& 0b1000){					
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
			}
			else {$error[] = "你没有该权限";}
			$this->data['error'] = $error;
			}
			$this->load->view("dashboard/newunit", $this->data);
		}
		public function project_addusr() {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;
			} else {
				$project_code =$this->input->post("project_code", true);
				$add_view =$this->input->post("add_view", true);
				//echo $add_view."asdasfafadsf";
				if(@$add_view && $add_view != ""){
					;
					//echo "1fafasdfasdf";
				}
				else{
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
									$this->data['addsuccess']=false;
									$error[] = $each_usr['uname']."已经存在于这个项目中，其余员工添加成功";
									$flag=0;
								}
							}
							if($flag==1)
								$this->project->AddProjectUser($project_code,$each_add_user);							
						}
						
					} else { $error[] = "至少选择一名员工"; }
					$this->data['error'] = $error;
				}

				$this->data['project_code']=$project_code;
			}
			$this->data['all_usr']=$this->project->Search_role(0b0001);
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
			if($this->userinfo->SearchAuthority($this->username) & 0b1000){	
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
			$this->data['all_usr']=$this->project->Search_role(0b0001);
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
				print_r($r);
				//echo "cccchenejiweie";
				if($r['sts']==1) {
					$this->project->CancelProject_by_code($project_code);
					$this->data['addsuccess']=true;
				}
				else { $error[]="该项目已经被取消或者不存在";}
				$this->data['error'] = $error;
			}
			if($this->userinfo->SearchAuthority($this->username) & 0b1000){
				$this->data['Search_result']=$this->project->SearchAllProject();
			}
			else {$error[] = "你没有该权限";}
			$this->load->view("dashboard/BossSearchProject", $this->data);
		}

		public function BossSearchProject() {
			if ($_SERVER['REQUEST_METHOD'] == "POST") {
				;
			} else {
				$error = array();
				
				if($this->userinfo->SearchAuthority($this->username) & 0b1000){
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
				
				if($this->userinfo->SearchAuthority($this->username) & 0b0001){
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
				//$project_unit_name=$this->input->post("project_unit_name", true);
				//$project_unit_price=$this->input->post("project_unit_price", true);
				
				//echo $add_view."asdasfafadsf";
				//echo $report_view."   hahxidsfadfasf";
				//var_dump($project_unit_name);
				if(@$report_view && $report_view != ""){
					;
					//echo "1fafasdfasdf";
				}
				else{
					//var_dump($project_unit_bh);//."   hahxidsfadfasf";
					//foreach($project_unit_name as $u)
					//	echo $u."   hahxidsfadfasf";
					
					$shr=$this->input->post("shr", true);
					$hourcount=$this->input->post("hourcount", true);
					$worklogproject=$this->input->post("worklogproject", true);
					$project_unit_amount=$this->input->post("project_unit_amount", true);
					$project_unit_bh=$this->input->post("project_unit_bh", true);
					
					if(@$project_unit_bh && $project_unit_bh!="")
						$project_unit_bh=array_filter($project_unit_bh);
					
					if(@$project_unit_amount && $project_unit_amount!="")
						$project_unit_amount=array_filter($project_unit_amount);

					var_dump($project_unit_bh);
					var_dump($project_unit_amount);
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
			$this->data['all_shr']=$this->project->Search_role(0b0010);
			$this->data['all_unit']=$this->project->Search_Unit();			
			$this->load->view("dashboard/UsrProjectReport", $this->data);
		}
		public function addmoney() {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;
			} else {
				$error = array();
				$moneyaccount = $this->input->post("moneyaccount", true);
				$withdrawpass = $this->input->post("withdrawpass", true);
				$withdrawmoney = $this->input->post("withdrawmoney", true);
				$dealtype = $this->input->post("dealtype", true);
				if ($moneyaccount && $withdrawpass && $withdrawmoney && $dealtype != "") {
					if($this->moneyaccount->getState($moneyaccount)==NORMAL){
						if ($this->moneyaccount->isMoneyAccountValid($moneyaccount, $withdrawpass)) {
							$re = "操作成功";
							if ($dealtype == "1") {
								if (!$this->moneyaccount->addmoney($moneyaccount, $withdrawmoney))
									$re = "增加存款失败";
							} else {
								if (!$this->moneyaccount->submoney($moneyaccount, $withdrawmoney)) {
									$re = "取款失败";
								}
							}
							$error[] = $re;
						} else {
							$error[] = "账户密码不匹配";
	 					}
	 				} else if($this->moneyaccount->getState($moneyaccount)==DEAD){
	 					$error[] = "账户已被注销";
	 				} else if($this->moneyaccount->getState($moneyaccount)==CANNTFIND){
	 					$error[] = "账户挂失中";
	 				}
	 			} else {
					$error[] = "所有都为必填项";
	 			}
				$this->data['error'] = $error;
			}
			$this->load->view("dashboard/money/changemoney", $this->data);
		}

		public function cantfind() {
			$this->data['method'] = "cantfind";
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;
			} else {
				$error = array();
				$nationalid = $this->input->post("nationalid", true);
				$moneyaccount = $this->input->post("moneyaccount", true);
				$withdrawpass = $this->input->post("withdrawpass", true);
				if ($nationalid && $moneyaccount && $withdrawpass) {
					if ($this->moneyaccount->isMoneyAccountValid($moneyaccount, $withdrawpass)) {
						if ($this->stockaccount->isNationalIdValid($nationalid, $moneyaccount)) {
							$this->moneyaccount->changeState($moneyaccount, CANNTFIND);
							$this->data['state'] = "挂失中";
						} else {
							$error[] = "账户密码不匹配";
						}
					} else {
						$error[] = "账户密码不匹配";
	 				}
	 			} else {
					$error[] = "所有都为必填项";
	 			}
				$this->data['error'] = $error;
			}
			$this->load->view("dashboard/cantfind/cantfind", $this->data);
		}

		public function atlastfind() {
			$this->data['method'] = "atlastfind";
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;
			} else {
				$error = array();
				$nationalid = $this->input->post("nationalid", true);
				$moneyaccount = $this->input->post("moneyaccount", true);
				$withdrawpass = $this->input->post("withdrawpass", true);
				if ($nationalid && $moneyaccount && $withdrawpass) {
					if ($this->moneyaccount->isMoneyAccountValid($moneyaccount, $withdrawpass)) {
						if ($this->stockaccount->isNationalIdValid($nationalid, $moneyaccount)) {
							$this->moneyaccount->changeState($moneyaccount, NORMAL);
							$this->data['state'] = "正常";
						} else {
							$error[] = "账户密码不匹配";
						}
					} else {
						$error[] = "账户密码不匹配";
	 				}
	 			} else {
					$error[] = "所有都为必填项";
	 			}
				$this->data['error'] = $error;
			}
			$this->load->view("dashboard/cantfind/cantfind", $this->data);
		}

		public function atlastnotfind() {
			$this->data['method'] = "atlastnotfind";
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;
			} else {
				$error = array();
				$nationalid = $this->input->post("nationalid", true);
				$moneyaccount = $this->input->post("moneyaccount", true);
				$withdrawpass = $this->input->post("withdrawpass", true);
				if ($nationalid && $moneyaccount && $withdrawpass) {
					if ($this->moneyaccount->isMoneyAccountValid($moneyaccount, $withdrawpass)) {
						if ($this->stockaccount->isNationalIdValid($nationalid, $moneyaccount)) {
							$this->moneyaccount->changeState($moneyaccount, DEAD);
							$stock_detail = $this->stockaccount->getStockAccountId($moneyaccount);
							$this->data['state'] = "死亡";
							$this->data['stockaccount'] = $stock_detail['stockaccount'];
							$thisp->data['inputpassword'] = true;
							$this->data['nationalid'] = $nationalid;
							$this->load->view("dashboard/useraccount/newuser", $this->data);
							return;
						} else {
							$error[] = "账户身份证不匹配";
						}
					} else {
						$error[] = "账户密码不匹配";
	 				}
	 			} else {
					$error[] = "所有都为必填项";
	 			}
				$this->data['error'] = $error;
			}
			$this->load->view("dashboard/cantfind/cantfind", $this->data);
		}

		public function cancelaccount() {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;
			} else {
				$error = array();
				$nationalid = $this->input->post("nationalid", true);
				$moneyaccount = $this->input->post("moneyaccount", true);
				$withdrawpass = $this->input->post("withdrawpass", true);
				if ($moneyaccount && $withdrawpass) {
					if ($this->moneyaccount->isMoneyAccountValid($moneyaccount, $withdrawpass)) {
						if ($this->stockaccount->isNationalIdValid($nationalid, $moneyaccount)) {
							if ($this->moneyaccount->getMoneyLeft($moneyaccount) > 0) {
								$error[] = "请取完余额再进行操作";
							} else {
								$this->moneyaccount->changeState($moneyaccount, DEAD);
								//$this->moneyaccount->delete_Moneyaccount($moneyaccount);
								$this->data['success'] = true;
							}
						} else {
							$error[] = "账户身份证不匹配";
						}
					} else {
						$error[] = "账户密码不匹配";
	 				}
	 			} else {
					$error[] = "所有都为必填项";
	 			}
				$this->data['error'] = $error;
			}
			$this->load->view("dashboard/destroy/cancelaccount", $this->data);
		}



		public function change_deal_psd($method = "") {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;// if ($method == "password")
					// $this->data['inputpassword'] = true;
			} else {
				$moneyaccount = $this->input->post("moneyaccount", true);
				$dealpasswdold = $this->input->post("passwdold", true);
				$dealpasswdnew = $this->input->post("passwdnew", true);
				$dealpassagain = $this->input->post("passwdnewagain", true);
				$error = array();

				if ($moneyaccount && $dealpasswdold && $dealpasswdnew && $dealpassagain) {
					
					 if ($this->moneyaccount->isdealMoneyAccountValid($moneyaccount,$dealpasswdold)){
					 	
						if($dealpasswdnew==$dealpassagain){
							//to be continue
							$this->moneyaccount->update_deal_passwd($moneyaccount,$dealpasswdnew);
							$this->data['moneyaccount'] = $moneyaccount;
							$this->data['inputpassword'] = true;
							$this->data['success'] = true;
						}
						else{
							$error[] = "两次输入交易密码不一样";
						}

					}
					else{
						$error[] = "账号密码不匹配";	
					}
				}
				else {
					$error[] = "所有都为必填项";
	 			}
				$this->data['error'] = $error;
			}
			$this->load->view("dashboard/useraccount/change_deal_psd", $this->data);
		}


		public function change_withdraw_psd($method = "") {
			if ($_SERVER['REQUEST_METHOD'] == "GET") {
				;// if ($method == "password")
					// $this->data['inputpassword'] = true;
			} else {
				$moneyaccount = $this->input->post("moneyaccount", true);
				$withdraw_passwdold = $this->input->post("passwdold", true);
				$withdraw_passwdnew = $this->input->post("passwdnew", true);
				$withdraw_passagain = $this->input->post("passwdnewagain", true);
				$error = array();

				if ($moneyaccount && $withdraw_passwdold && $withdraw_passwdnew && $withdraw_passagain) {
					
					 if ($this->moneyaccount->isMoneyAccountValid($moneyaccount,$withdraw_passwdold)){
						if($withdraw_passwdnew==$withdraw_passagain){
							//to be continue
							$this->moneyaccount->update_withdraw_passwd($moneyaccount,$withdraw_passwdnew);
							$this->data['moneyaccount'] = $moneyaccount;
							$this->data['inputpassword'] = true;
							$this->data['success'] = true;
						}
						else{
							$error[] = "两次输入取款密码不一样";
						}

					}
					else{
						$error[] = "账号密码不匹配";	
					}
				}
				else {
					$error[] = "所有都为必填项";
	 			}
				$this->data['error'] = $error;
			}
				
			$this->load->view("dashboard/useraccount/change_withdraw_psd", $this->data);
		}

	}
?>