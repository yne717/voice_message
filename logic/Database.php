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
			if (!empty($value)) {
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
	
	public function getLogOne($param = array()) {
		if (!$param) {
			return;
		}
		
		$tmp_where_value = array();
		foreach($param as $key => $value) {
			$tmp_where_value[] = $key . '=' . $value;
		}
		$where_value = implode(' and ', $tmp_where_value);
		$sql = 'SELECT ' . $this->default_column . ' FROM ' . $this->table . ' WHERE ' . $where_value . ';';
		$tmp_result = mysql_query($sql);
		$result = mysql_fetch_assoc($tmp_result);
		
		return $result;
	}
	
	
	
}
