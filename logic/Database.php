<?php

class Database {
	
	protected $table = 'record_log';
	protected $default_column = '*'; 
	
	function __construct() {
		$config = new Config();
		$db_param = $config->getDbParam();
		$server_connected = mysql_connect($db_param['server'], $db_param['user'], $db_param['pass']);
		if (!$server_connected) {
			error_log('mysql_connect : ' . mysql_error());
		}
		$db_selected = mysql_select_db($db_param['select'], $server_connected);
		if (!$db_selected) {
			error_log('mysql_select_db : ' . mysql_error());
		}
	}
	
	public function insertLog($param = array()) {
		if (empty($param)) {
			return;
		}
		
		$insert_key_array = array();
		$inser_value_array = array();
		$insert_key = '';
		$inser_value = '';
		foreach ($param as $key => $value) {
			$insert_key_array[] = $key;
			$tmp_value = "null";
			if (!empty($value) || is_numeric($value)) {
					$tmp_value = "'" . $value . "'";
			}
			$insert_value_array[] = $tmp_value;
		}
		$insert_key = implode(', ', $insert_key_array);
		$insert_value = implode(', ', $insert_value_array);
	
		$sql = "INSERT INTO " . $this->table . " ( " . $insert_key . ") VALUES ( " . $insert_value . " )";
		$result = mysql_query($sql);
		
		return $result;
	}
	
	//insert_date降順で1件取得
	public function getLogOne($param = array()) {
		if (!$param) {
			return;
		}
		
		$tmp_where_value = array();
		foreach($param as $key => $value) {
			$tmp_where_value[] = $key . '=' . $value;
		}
		$where_value = implode(' and ', $tmp_where_value);
		$sql = 'SELECT ' . $this->default_column . ' FROM ' . $this->table . ' WHERE ' . $where_value . ' ORDER BY create_date DESC LIMIT 1;';
		$tmp_result = mysql_query($sql);
		$result = mysql_fetch_assoc($tmp_result);
		
		return $result;
	}
	
	//register_flag=1にする
	public function updateRegisterFlag($param) {
		if (!$param){
			return;
		}
		
		$tmp_where_value = array();
		foreach($param as $key => $value) {
			if ($key !== 'register_flag') {
				$tmp_where_value[] = $key . '=' . $value;
			}
		}
		$where_value = implode(' and ', $tmp_where_value);
		
		if (empty($param['register_flag'])) {
			$set = 'register_flag=0';
		} else {
			$set = 'register_flag=1';
		}
		
		$sql = 'UPDATE ' . $this->table . ' SET ' . $set . ' WHERE ' . $where_value . ' ORDER BY create_date DESC LIMIT 1;';		
		$tmp_result = mysql_query($sql);

		return $result;
	}
	
	
	
}
