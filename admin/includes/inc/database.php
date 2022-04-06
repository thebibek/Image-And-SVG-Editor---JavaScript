<?php
	require_once("config.php");
	require_once("functions.php");
	$timestamp = date("Y-m-d H:i:s");
	class Database{
		public $conn;

		public function __construct(){
			$this->connect();
		}

		// Connect To Database
		private function connect(){
			$this->conn = @new mysqli(DB_HOST, DB_USER, DB_PASSWORD);
			if($this->conn->connect_error){
				die("Connection Error " . $this->conn->connect_error);
			}
			$this->conn->select_db(DB_NAME);
		}
		// Validation
		public function validText($data, $encodeHtml = true){
			$data = trim($data);
			$data = addslashes($data);
			if($encodeHtml){
				$data = htmlspecialchars($data);
			}
			return $data;
		}
		public function validPhone($data){
			$data = preg_replace("/[^0-9+]/", "", $data);
			return $data;
		}
		public function validNum($data){
			$data = preg_replace("/[^0-9]/", "", $data);
			return $data;
		}
		public function getTime($datetime){
	        return date("d F, Y", strtotime($datetime));
	    }
		// Select Function
		public function select($table, $condition = "", $limit = "", $orderBy = "",$returnQuery=""){
			$where = "";
			if($condition != ""){
				$where = "WHERE ";
				foreach($condition as $column => $data){
					$data = $this->validText($data);
					$where .= " $column='$data' AND";
				}
				$where = rtrim($where, "AND");
			}
			if($limit != ""){
				$limit = "LIMIT $limit";
			}
			if($orderBy != ""){
				$orderBy = "ORDER BY $orderBy";
			}
			$query = "SELECT * FROM $table $where $orderBy $limit";
			if($returnQuery != ""){
				return $query;
			}
			$select = $this->conn->query($query);
			if($select){
				if($select->num_rows > 0){
					$arr = array();
					while($record = $select->fetch_assoc()){
						array_push($arr, $record);
					}
					return $arr;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
		// Count Function
		public function count($table, $data = "*", $condition = "", $limit = "", $orderBy = "",$returnQuery=""){
			$where = "";
			if($condition != ""){
				$where = "WHERE ";
				foreach($condition as $column => $data){
					$data = $this->validText($data);
					$where .= " $column='$data' AND";
				}
				$where = rtrim($where, "AND");
			}
			if($limit != ""){
				$limit = "LIMIT $limit";
			}
			if($orderBy != ""){
				$orderBy = "ORDER BY $orderBy";
			}
			$query = "SELECT * FROM $table $where $orderBy $limit";
			if($returnQuery != ""){
				return $query;
			}
			$select = $this->conn->query($query);
			if($select){
				if($select->num_rows > 0){
					return $select->num_rows;
				} else {
					return 0;
				}
			} else {
				return false;
			}
		}
		// Select Single Record Function
		public function selectSingle($table, $condition = "", $limit = "", $orderBy = "",$returnQuery=""){
			$where = "";
			if($condition != ""){
				$where = "WHERE ";
				foreach($condition as $column => $data){
					$data = $this->validText($data);
					$where .= " $column='$data' AND";
				}
				$where = rtrim($where, "AND");
			}
			if($limit != ""){
				$limit = "LIMIT $limit";
			}
			if($orderBy != ""){
				$orderBy = "ORDER BY $orderBy";
			}
			$query = "SELECT * FROM $table $where $orderBy $limit";
			if($returnQuery != ""){
				return $query;
			}
			$select = $this->conn->query($query);
			if($select){
				if($select->num_rows > 0){
					return $select->fetch_assoc();
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
		public function query($query){
			$select = $this->conn->query($query);
			if($select){
				if($select->num_rows > 0){
					$arr = array();
					while($record = $select->fetch_assoc()){
						array_push($arr, $record);
					}
					return $arr;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	    public function update($table,$data="",$condition="", $returnQuery = ""){
			$where = "";
			if($condition != ""){
				$where = "WHERE ";
				foreach($condition as $column => $value){
					$value = $this->validText($value);
					$where .= "$column='$value' ";
				}
			}
			$updateData = '';
			// Don't Encode To html
			$dontEncode = false;
			if(array_key_exists("dontEncode", $data)){
				$dontEncode = $data['dontEncode'];
				unset($data['dontEncode']);
			}
			if($data != ""){
				foreach($data as $column => $value){
					$encodeHtml = true;
					if($dontEncode == $column){
						$encodeHtml = false;
					}
					$value = $this->validText($value, $encodeHtml);
					$updateData .= " $column='$value',";
				}
				$updateData = rtrim($updateData, ",");
			}
			$query = "UPDATE $table SET $updateData $where";
			if($returnQuery != ""){
				return $query;
			}
			$update = $this->conn->query($query);
			if($update){
				return true;
			} else {
				return false;
			}
		}
		public function insert($table, $data = "", $returnQuery = ""){
			$columns = "";
			$values = "";
			// Don't Encode To html
			$dontEncode = false;
			if(array_key_exists("dontEncode", $data)){
				$dontEncode = $data['dontEncode'];
				unset($data['dontEncode']);
			}
			if($data != ""){
				if(count($data) < 1) return false;
				foreach($data as $column_name => $value){
					$encodeHtml = true;
					if($dontEncode == $column_name){
						$encodeHtml = false;
					}
					$value = $this->validText($value, $encodeHtml);
					$columns .= "$column_name,";
					$values .= "'$value',";
				}
				$columns = rtrim($columns, ",");
				$values = rtrim($values, ",");
			}
			$query = "INSERT INTO $table ($columns) VALUES ($values)";
			if($returnQuery != ""){
				return $query;
			}
			$insert = $this->conn->query($query);
			if($insert){
				return true;
			} else {
				return false;
			}
		}
		public function delete($table, $condition = "", $returnQuery = ""){
			$where = "";
			if($condition != ""){
				$where = "WHERE ";
				foreach($condition as $column => $value){
					$value = $this->validText($value);
					$where .= "$column='$value' ";
				}
			}
			$query = "DELETE FROM $table $where";
			if($returnQuery != ""){
				return $query;
			}
			$delete = $this->conn->query($query);
			if($delete){
				return true;
			} else {
				return false;
			}
		}
	}
	$db = new Database();