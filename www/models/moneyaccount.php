<?php
	class Moneyaccount extends CI_Model {
		public function __construct() {
			$this->load->database();
		}
		public function addaccount($dealpass, $withdrawpass) {
			$q = $this->db->select("maxMoneyAccountId")
						  ->get("global");
			$r = $q->row_array();
			$id = $r['maxMoneyAccountId'] + 1;
			$this->db->set("maxMoneyAccountId", $id);
			$this->db->update("global");
			$data = array("accountId"=>$id,
			              "dealPassword"=>md5($dealpass),
						  "withDrawPassword"=>md5($withdrawpass));
			$this->db->insert("MoneyAccount", $data);
			return $id;
		}
		public function isMoneyAccountValid($moneyaccount, $withdrawpass) {
			$q = $this->db->select("accountId")
						  ->where("accountId", $moneyaccount)
						  ->where("withDrawPassword", md5($withdrawpass))
						  ->get("MoneyAccount");
			return $q->num_rows() > 0;
		}
		
		//add after push not sure
		/*
		public function Exist_Moneyaccount($nationalId) {
			$q = $this->db->select("accountId")
						  ->where("accountId", $moneyaccount)
						  ->get("MoneyAccount");
			return $q->num_rows() > 0;
		}*/
		public function delete_Moneyaccount($moneyaccount){
			$this->db->where("accountId", $moneyaccount);
			$this->db->delete("MoneyAccount");
		}

		//add by chenke
		public function isdealMoneyAccountValid($moneyaccount, $dealpass) {
			$q = $this->db->select("accountId")
						  ->where("accountId", $moneyaccount)
						  ->where("dealPassword", md5($dealpass))
						  ->get("MoneyAccount");
			return $q->num_rows() > 0;
		}
		//there should be a update sql 
		public function update_deal_passwd($moneyaccount,$dealpasswd){
			$this->db->where("accountId", $moneyaccount);
			$this->db->set("dealPassword",md5($dealpasswd));
			$this->db->update("MoneyAccount");

		}
		public function update_withdraw_passwd($moneyaccount,$withdraw_passwd){
			$this->db->where("accountId", $moneyaccount);
			$this->db->set("withDrawPassword",md5($withdraw_passwd));
			$this->db->update("MoneyAccount");

		}
		public function getMoneyLeft($moneyaccount){
			$q = $this->db->select("moneyLeft")
					      ->where("accountId", $moneyaccount)
					      ->get("MoneyAccount");
			$r = $q->row_array();
			return $r['moneyLeft'];
		}
		public function getState($moneyaccount){
			$q = $this->db->select("accountState")
					      ->where("accountId", $moneyaccount)
					      ->get("MoneyAccount");
			$r = $q->row_array();
			return $r['accountState'];		
		}
		//end
		public function addmoney($moneyaccount, $withdrawmoney) {
			$q = $this->db->select("moneyLeft")
					      ->where("accountId", $moneyaccount)
					      ->get("MoneyAccount");
			$r = $q->row_array();
			$withdrawmoney += $r['moneyLeft'];
			$this->db->where("accountId", $moneyaccount);
			$this->db->set("moneyLeft", $withdrawmoney);
			$this->db->update("MoneyAccount");
			return true;
		}
		public function submoney($moneyaccount, $withdrawmoney) {
			$q = $this->db->select("moneyLeft")
					      ->where("accountId", $moneyaccount)
					      ->get("MoneyAccount");
			$r = $q->row_array();
			$r['moneyLeft'] -= $withdrawmoney;
			if ($r['moneyLeft'] < 0) {
				return false;
			}
			$this->db->where("accountId", $moneyaccount);
			$this->db->set("moneyLeft", $r['moneyLeft']);
			$this->db->update("MoneyAccount");
			return true;
		}
		public function changeState($moneyaccount, $state) {
			$this->db->where("accountId", $moneyaccount);
			$this->db->set("accountState", $state);
			$this->db->update("MoneyAccount");
		}
	}
?>