<?php
/*
sql类
*/
class mysql {
	var $linkid=null;

    function __construct($dbhost, $dbuser, $dbpw, $dbname = '', $dbcharset = 'utf8', $connect = 1) {
    	$this -> connect($dbhost, $dbuser, $dbpw, $dbname, $dbcharset, $connect);
    }

    function connect($dbhost, $dbuser, $dbpw, $dbname = '', $dbcharset = 'utf8', $connect=1){
    	$func = empty($connect) ? 'mysql_pconnect' : 'mysql_connect';
    	if(!$this->linkid = @$func($dbhost, $dbuser, $dbpw, true)){
			$this->dbshow('Can not connect to Mysql!');
    	} else {
    		if($this->dbversion() > '4.1'){
    			mysql_query( "SET NAMES utf8");
    			if($this->dbversion() > '5.0.1'){
    				mysql_query("SET sql_mode = ''",$this->linkid);
					mysql_query("SET character_set_connection=".$dbcharset.", character_set_results=".$dbcharset.", character_set_client=binary", $this->linkid);
    			}
    		}
    	}
    	if($dbname){
    		if(mysql_select_db($dbname, $this->linkid)===false){
    			$this->dbshow("Can't select MySQL database($dbname)!");
    		}
    	}
    }

    function select_db($dbname){
    	return mysql_select_db($dbname, $this->linkid);
    }

    function query($sql){
    	if(!$query=@mysql_query($sql, $this->linkid)){
    		//$this->dbshow("Query error:$sql");
			return false;
    	}else{
    		return $query;
    	}
    }

	function insetbb($sql){
		$id=$this->query($sql);
		if($id){
			return $this->insert_id();
		}else{
			return 0;
		}
	}
	
	/*----------------------------------------------------------------------------*/
	//插入 insert("表名",array数据)
	function insert($tablename, $insertsqlarr) {
		$insertkeysql = $insertvaluesql = $comma = '';
		foreach ($insertsqlarr as $insert_key => $insert_value) {
			$insertkeysql .= $comma.'`'.$insert_key.'`';
			$insertvaluesql .= $comma.'\''.$insert_value.'\'';
			$comma = ', ';
		}
		$sql = "INSERT INTO $tablename ($insertkeysql) VALUES ($insertvaluesql)";
		$id=$this->query($sql);
		if($id){
			return $this->insert_id();
		}else{
			return 0;
		}
	}
	
	//修改 update("表名", "内容", "条件");
	function update($tablename, $neirong, $where){
		$upsql="UPDATE `$tablename` SET $neirong WHERE $where";
		$id=$this->query($upsql);
		if($id){
			return 1;
		}else{
			return 0;
		}
	}
	
	//删除 del("表名", "条件");
	function del($tablename,$where){
		echo $delsql="DELETE FROM `$tablename` WHERE $where";
		$id=$this->query($delsql);
		if($id){
			return 1;
		}else{
			return 0;
		}
	}
	/*----------------------------------------------------------------------------*/
	
    function getall($sql, $type=MYSQL_ASSOC){
    	$query = $this->query($sql);
    	while($row = mysql_fetch_array($query,$type)){
    		$rows[] = $row;
    	}
    	return $rows;
    }

    function getone($sql, $type=MYSQL_ASSOC){
    	$query = $this->query($sql,$this->linkid);
    	$row = mysql_fetch_array($query, $type);
    	return $row;
    }
	function get_total($sql)
	{
		$row = $this->getall($sql);
		$v=0;
		if (!empty($row) && is_array($row))
		{			
			foreach($row as $n)
			{			
			$v=$v+1;
			}			
		}
		return $v;
 	}
    function getfirst($sql, $type=MYSQL_NUM) {
    	$query = $this->query($sql, $this->linkid);
    	$row = mysql_fetch_array($query, $type);
    	return $row[0];
    }
	function fetch_array($result,$type = MYSQL_ASSOC){
		return mysql_fetch_array($result,$type);
	}

    function affected_rows(){
    	return mysql_affected_rows($this->linkid);
    }

    function num_rows(){
    	return mysql_num_rows($this->linkid);
    }

    function num_fields($result){
    	return mysql_num_fields($result);
    }

    function insert_id(){
    	return mysql_insert_id($this->linkid);
    }

    function free_result(){
    	return mysql_free_result($this->linkid);
    }
	
	function escape_string($string)
    {
        if (PHP_VERSION >= '4.3')
        {
            return mysql_real_escape_string($string, $this->linkid);
        }
        else
        {
            return mysql_escape_string($string, $this->linkid);
        }
    }
    function error(){
    	return mysql_error($this->linkid);
    }

    function errno(){
    	return mysql_errno($this->linkid);
    }

    function close(){
    	return mysql_close($this->linkid);
    }

    function dbversion(){
    	return mysql_get_server_info($this->linkid);
    }

    function dbshow($err)
	{
    	if($err){
    		$info = "Error：".$err;			
    	}else{
    		$info = "Errno：".$this->errno()." Error：".$this->error();
    	}
    	exit($info);
    }

}
?>