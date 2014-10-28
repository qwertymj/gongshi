<?php
	class Project extends CI_Model {
		public function __construct() {
			$this->load->database();
		}

		public function isBhExist($bh) {
			$q = $this->db->select("bh")
						  ->where("bh", $bh)
						  ->where("sts", 1)
						  ->get("t_project_workunit");
			return $q->num_rows() > 0;
		}
		public function AddWorkUnit($unit_name,$price,$workunit,$bh) {
			//echo "mysql".$unit_name."mysql";
			$data = array("unitname"=>$unit_name,
			              "price"=>$price,
			              "sts"=>1,
			              "workunit"=>$workunit,
			              "bh"=>$bh);//"pcontent"=>$pcontent);
			$this->db->insert("t_project_workunit", $data);
			return ;
		}



		public function AddProject($project_code, $project_name,$startdate,$enddate,$pcontent) {
			$data = array("project_code"=>$project_code,
			              "project_name"=>$project_name,
			              "startdate"=>$startdate,
			              "sts"=>1,
			              "isavailable"=>1,
			              "enddate"=>$enddate,
			              "pcontent"=>$pcontent);
			$this->db->insert("t_project", $data);
			return ;
		}
		public function Search_Project_byUser($uname) {
			$q=$this->db->query("select r.id,r.project_code,r.project_name,r.startdate,r.enddate,r.sts,r.pcontent
					from t_project_user as t join t_project as r
					where t.sts=1 and r.isavailable=1 and t.uname='".$uname."' and t.project_id = r.id;");
			return $q->result_array();
		}

		/////////
		public function Search_worklog_byid($work_log_id){
			$q = $this->db->select("work_log_id")
						  ->where("work_log_id", $work_log_id)
						  ->where("isavailable", 1)
						  ->get("t_work_log_project");
			return $q->num_rows() > 0;	
		}
		public function delete_worklog($work_log_id) {
			$this->db->where("work_log_id", $work_log_id);
			$this->db->set("isavailable", 0);
			$this->db->update("t_work_log_project");
			//$q = $this->db->query("delete from t_work_log_project where work_log_id='".$work_log_id."'");
			return ;
		}
		public function Search_Work_byUser($uname) {
			$q=$this->db->query("select t.work_log_id,r.project_code,r.project_name,t.logdate,t.sts,t.shcontent,t.workunit,t.price,t.je,t.projectsum,t.bh
					from t_work_log_project as t join t_project as r
					where t.isavailable=1 and t.uname='".$uname."' and t.project_id = r.id;");
			return $q->result_array();
		}
		public function Search_All_Work(){
			$q=$this->db->query("select r.project_code,r.project_name,t.work_log_id,t.logdate,t.sts,t.shcontent,t.workunit,t.price,t.je,t.projectsum,t.username,t.shrname,t.bh
					from t_work_log_project as t join t_project as r
					where t.isavailable=1 and t.project_id = r.id;");
			return $q->result_array();
		}
		//public function Search_user_not_boss()
		public function SearchAllProject() {
			$q = $this->db->select("project_code,project_name,startdate,enddate,sts,pcontent")
						  ->where("isavailable",1)
						  ->get("t_project");

			return $q->result_array();
		}
		public function SearchUsrAllProject($uname) {
			$q = $this->db->query("select r.id,r.project_code,r.project_name,r.startdate,r.enddate,r.sts,r.pcontent
				from t_project_user as t join t_project as r
				where r.isavailable=1 and t.sts=1 and t.uname='".$uname."' and t.project_id=r.id and r.sts=1");
			return $q->result_array();
		}
		public function Search_Unit() {
			$q = $this->db->select("unitname,price,workunit,bh")
						  ->where("sts",1)
						  ->get("t_project_workunit");

			return $q->result_array();
		}
		public function Search_Unit_by_Bh($bh) {
			$q = $this->db->select("unitname,price,workunit,bh")
						  ->where("bh",$bh)
						  ->where("sts",1)
						  ->get("t_project_workunit");

			$r=$q->row_array(0);
			return $r  ;
		}
		public function EditWorkUnit($unit_name,$price,$workunit,$bh) {
			$this->db->where("bh", $bh);
			$this->db->where("sts", 1);
			$this->db->set("unitname",$unit_name);
			$this->db->set("price",$price);
			$this->db->set("workunit",$workunit);
			$this->db->update("t_project_workunit");
			return ;
		}
		public function editproject($project_code,$project_name,$sts,$startdate,$enddate,$pcontent) {
			$this->db->where("project_code", $project_code);
			$this->db->where("isavailable", 1);
			$this->db->set("project_name",$project_name);
			$this->db->set("sts",$sts);
			$this->db->set("pcontent",$pcontent);
			$this->db->set("startdate",$startdate);
			$this->db->set("enddate",$enddate);
			$this->db->update("t_project");
			return ;
		}

		public function deleteunit($bh) {
			$this->db->where("bh", $bh);
			$this->db->set("sts", 0);
			$this->db->update("t_project_workunit");
			//$q = $this->db->query("delete from t_project_workunit where bh='".$bh."'");
			return ;
		}
		public function deleteproject($project_code) {
			$this->db->where("project_code", $project_code);
			$this->db->set("isavailable", 0);
			$this->db->update("t_project");			
			//$q = $this->db->query("delete from t_project where project_code='".$project_code."'");
			return ;
		}
		
		public function SearchProject_by_code($project_code) {
			$q = $this->db->select("project_code,project_name,sts,pcontent,startdate,enddate")
						  ->where("project_code", $project_code)
						  ->where("isavailable", 1)
						  ->get("t_project");
					//	 echo '1231231';
			//var_dump($q);
			$r=$q->row_array(0);
			return $r  ;
		}
		public function CancelProject_by_code($project_code) {
			$this->db->where("project_code", $project_code);
			$this->db->set("sts", 0);
			$this->db->update("t_project");
		}	
		public function project_find_usr($project_code){
			$p = $this->db->select("id")
						  ->where("project_code", $project_code)
						  ->where("isavailable", 1)
						  ->get("t_project");
			$pid=$p->row_array(0);
			if(!$pid) return ;
			$q = $this->db->select("uname")
						  ->where("project_id", $pid['id'])
						  ->where("sts", 1)
						  ->get("t_project_user");		
			return 	$q->result_array();	

		}
		public function Search_JZResult_By_Sts($sts){
			$q="select t.id,t.project_code,t.project_name,r.sts,r.work_log_id,
				r.uname,r.projectsum,r.price,r.je,r.bh,r.workunit
				from t_work_log_project as r join t_project as t
				where r.isavailable=1 and r.sts = '".$sts."' and t.id=r.project_id";
				// select t.project_code,t.project_name,t.sts
				// r.uname,r.projectsum,r.price,r.je,r.bh,r.workunit
				// from t_work_log_project as r join t_project as t
				// where r.shr = "admin" and t.id=r.project_id;
			$r = $this->db->query($q);
			return 	$r->result_array();
		}
		
		public function Search_SHResult_By_role($uname){
			$q="select t.id,t.project_code,t.project_name,r.sts,r.work_log_id,
				r.uname,r.projectsum,r.price,r.je,r.bh,r.workunit
				from t_work_log_project as r join t_project as t
				where r.isavailable=1 and r.shr = '".$uname."' and t.id=r.project_id";
				// select t.project_code,t.project_name,t.sts
				// r.uname,r.projectsum,r.price,r.je,r.bh,r.workunit
				// from t_work_log_project as r join t_project as t
				// where r.shr = "admin" and t.id=r.project_id;
			$r = $this->db->query($q);
			return 	$r->result_array();
		}
		public function get_sts($work_log_id){
			$p = $this->db->select("sts")
						  ->where("work_log_id", $work_log_id)
						  ->where("isavailable", 1)
						  ->get("t_work_log_project");
			return $p->row_array(0);	
			//return 		
		}
		public function update_work_log($work_log_id,$sts,$result){
			if($sts==2){
				if($result==1){	
					$update_sts=3;
					$shcontent="审核通过";
				}
				else if($result==0){
					$update_sts=0;
					$shcontent="提交被拒绝";
				}
				$this->db->where("work_log_id", $work_log_id);
				$this->db->where("isavailable", 1);
				$this->db->set("sts", $update_sts);
				$this->db->set("shcontent", $shcontent);
				$this->db->update("t_work_log_project");

			}
			else if ($sts==3){
				if($result==1){	
					$update_sts=4;
				}
				else if($result==0){
					$update_sts=0;
				}
				$this->db->where("work_log_id", $work_log_id);
				$this->db->where("isavailable", 1);
				$this->db->set("sts", $update_sts);
				$this->db->update("t_work_log_project");
			}
			return ;
		}
		public function usr_report_project($project_id,$hourcount,$uname,
		$project_unit_amount,$worklogproject,$shr,$project_unit_bh,$shr){

				$r = $this->db->select("username")
				  	->where("name", $uname)
				  	->where("sts", 1)
				  	->get("t_user");
				$usrname=$r->row_array(0);

				$p =$this->db->select("username")
				  	->where("name", $shr)
				  	->where("sts", 1)
				  	->get("t_user");
				$shname=$p->row_array(0);
				for($i=0;$i<count($project_unit_bh);$i++){
					$q=$this->db->select("unitname,price,workunit,id")
						->where("bh",$project_unit_bh[$i])
						->where("sts", 1)
						->get("t_project_workunit");
					$unit_r=$q->row_array(0);
					//insert begin
					$data = array("project_id"=>$project_id,
					              "hourcount"=>$hourcount,
					              "logdate"=>gmdate("Y-m-d H:i:s", mktime() + 8 * 3600),
					              "hourcount"=>$hourcount,
					              "uname"=>$uname,
					              "username"=>$usrname['username'],
					              "projectsum"=>$project_unit_amount[$i],
					              "worklogproject"=>$worklogproject,
					              "sts"=>2,
					              "isavailable"=>1,
					              "unitname"=>$unit_r['unitname'],
					              "price"=>$unit_r['price'],
					              "je"=>$unit_r['price']*$project_unit_amount[$i],
					              "shr"=>$shr,
					              "shrname"=>$shname['username'],
					              "bh"=>$project_unit_bh[$i],
					              "workunit"=>$unit_r['workunit'],
					              "workunitid"=>$unit_r['id']
					              );
					$this->db->insert("t_work_log_project", $data);

				}		
				return ;
		}
		public function AddProjectUser($project_code,$name) {
			$p = $this->db->select("id")
						  ->where("project_code", $project_code)
						  ->where("isavailable", 1)
						  ->get("t_project");
			$pid=$p->row_array(0);
			//echo $pid['id']."adfafsadf";				
			$q = $this->db->select("id")
				  	->where("name", $name)
				  	->where("sts", 1)
				  	->get("t_user");
			//if(! $q->result_array() )return false;
			if(!$q || !$p ) return ;
			$uid=$q->row_array(0);
			$data = array("project_id"=>$pid['id'],
					      "uid"=>$uid['id'],
					      "sts"=>1,
					      "uname"=>$name);
			$this->db->insert("t_project_user", $data);
			return ;
		}

	}
?>