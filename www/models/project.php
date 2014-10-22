<?php
	class Project extends CI_Model {
		public function __construct() {
			$this->load->database();
		}

		public function isBhExist($bh) {
			$q = $this->db->select("bh")
						  ->where("bh", $bh)
						  ->get("t_project_workunit");
			return $q->num_rows() > 0;
		}
		public function AddWorkUnit($unit_name,$price,$workunit,$bh) {
			//echo "mysql".$unit_name."mysql";
			$data = array("unitname"=>$unit_name,
			              "price"=>$price,
			              "workunit"=>$workunit,
			              "bh"=>$bh);//"pcontent"=>$pcontent);
			$this->db->insert("t_project_workunit", $data);
			return ;
		}

		public function isProjectCodeValid($project_code) {
			$q = $this->db->select("project_code")
						  ->where("project_code", $project_code)
						 // ->where("accountId", $stockaccount)
						  ->get("t_project");
			return $q->num_rows() > 0;
		}

		public function AddProject($project_code, $project_name,$startdate,$enddate,$pcontent) {
			$data = array("project_code"=>$project_code,
			              "project_name"=>$project_name,
			              "startdate"=>$startdate,
			              "sts"=>1,
			              "enddate"=>$enddate,
			              "pcontent"=>$pcontent);
			$this->db->insert("t_project", $data);
			return ;
		}
		public function Search_Project_byUser($uname) {
			$p = $this->db->select("project_id")
							->where("uname",$uname)
							->get("t_project_user");
			$pid=$p->row_array(0);
			if(!$pid)
				return ;
			$q = $this->db->select("id,project_code,project_name,startdate,enddate,sts,pcontent")
						  ->where("id", $pid['project_id'])
						  ->get("t_project");
					//	 echo '1231231';
			//var_dump($q);
			return $q->result_array();
		}
		public function Search_role($role){
			$q = $this->db->query("select name from t_user where role &".$role);
			return $q->result_array();
		}
		public function SearchAllProject() {
			$q = $this->db->select("project_code,project_name,startdate,enddate,sts,pcontent")
						  ->get("t_project");

			return $q->result_array();
		}
		public function Search_Unit() {
			$q = $this->db->select("unitname,price,workunit,bh")
						  ->get("t_project_workunit");

			return $q->result_array();
		}
		public function SearchProject_by_code($project_code) {
			$q = $this->db->select("sts")
						  ->where("project_code", $project_code)
						  ->get("t_project");
					//	 echo '1231231';
			//var_dump($q);
			return $q  ;
		}
		public function CancelProject_by_code($project_code) {
			$this->db->where("project_code", $project_code);
			$this->db->set("sts", 0);
			$this->db->update("t_project");
		}	
		public function project_find_usr($project_code){
			$p = $this->db->select("id")
						  ->where("project_code", $project_code)
						  ->get("t_project");
			$pid=$p->row_array(0);
			if(!$pid) return ;
			$q = $this->db->select("uname")
						  ->where("project_id", $pid['id'])
						  ->get("t_project_user");		
			return 	$q->result_array();	

		}
		public function usr_report_project($project_id,$hourcount,$uname,
		$project_unit_amount,$worklogproject,$shr,$project_unit_bh,$shr){

				$r = $this->db->select("id")
				  	->where("name", $uname)
				  	->get("t_user");
				$uid=$r->row_array(0);

				$p =$this->db->select("id")
				  	->where("name", $shr)
				  	->get("t_user");
				$shid=$p->row_array(0);
				for($i=0;$i<count($project_unit_bh);$i++){
					$q=$this->db->select("unitname,price,workunit,id")
						->where("bh",$project_unit_bh[$i])
						->get("t_project_workunit");
					$unit_r=$q->row_array(0);
					//insert begin
					$data = array("project_id"=>$project_id,
					              "hourcount"=>$hourcount,
					              "logdate"=>gmdate("Y-m-d H:i:s", mktime() + 8 * 3600),
					              "hourcount"=>$hourcount,
					              "uname"=>$uname,
					              "userid"=>$uid['id'],
					              "projectsum"=>$project_unit_amount[$i],
					              "worklogproject"=>$worklogproject,
					              "sts"=>2,
					              "unitname"=>$unit_r['unitname'],
					              "price"=>$unit_r['price'],
					              "je"=>$unit_r['price']*$project_unit_amount[$i],
					              "shr"=>$shr,
					              "shr_uid"=>$shid['id'],
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
						  ->get("t_project");
			$pid=$p->row_array(0);
			//echo $pid['id']."adfafsadf";				
			$q = $this->db->select("id")
				  	->where("name", $name)
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

		public function setMoneyAccout($stockaccount, $moneyaccount) {
			$this->db->where("accountId", $stockaccount);
			$this->db->set("moneyAccountId", $moneyaccount);
			$this->db->update("StockAccount");
		}

		public function getStockAccountId($moneyaccount) {
			$q = $this->db->select("accountId")
						  ->where("moneyAccountId", $moneyaccount)
						  ->get("StockAccount");
			$r = $q->num_rows();
			return $r['accountId'];
		}
	}
?>