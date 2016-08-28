<?php
	//error_reporting(0);
	class Dbconn{
		var $host;
		var $uname;
		var $psw;
		var $dbname;
		var $links;
		var $db;
		
		function Dbconn(){
			/*$this->host = "localhost";
			$this->uname = "krishs61_ghar"; 		
			$this->psw = "krishs61_ghar123";					
			$this->dbname = "krishs61_ghar";*/
			$this->host = "localhost";
			$this->uname = "krishwt5_ghar"; 		
			$this->psw = "kR%is5#hi_gh1ar";					
			$this->dbname = "krishwt5_ghar";
			
			$this->links = ($GLOBALS["___mysqli_ston"] = mysqli_connect($this->host, $this->uname, $this->psw)) or die("Sorry, couldnot connect to MySQL Server");
			mysql_set_charset('utf8',$this->links);
			$this->db = ((bool)mysqli_query($this->links, "USE " . $this->dbname)) or die("Sorry, couldnot find database");			
		}
		
		function exec($sqlMain){
			//echo $sqlMain;
			//$result = mysql_query($sqlMain,$this->links) or die("You have some problem with your data");
			$result = mysqli_query($this->links, $sqlMain) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
			//$result = mysql_query($sqlMain,$this->links);
			return $result;
		}
		
		function exec2($sqlMain){
			//echo $sqlMain;
			$result = @mysqli_query($this->links, $sqlMain);
			return $result;
		}
		
		function numRows($result)
		{
			return mysqli_num_rows($result);			
		}
		
		function affRows()
		{
			return mysqli_affected_rows($GLOBALS["___mysqli_ston"]);			
		}
		
		function insertId()
		{
			return ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
		}
		
		function fetchArray($result)
		{
			return mysqli_fetch_array($result);
		}	
		
		function fetchObject($result)
		{
			return mysqli_fetch_object($result);
		}	
		
		function fetchAssoc($result)
		{
			return mysqli_fetch_assoc($result);
		}
		
		function resetFetchCounter($result)
		{
			return mysqli_data_seek($result,  0);
		}
		
		function commit()
		{
			return ($this -> exec("Commit"));
		}
		
		function begin()
		{
			return ($this -> exec("Begin"));
		}
		
		function rollback()
		{
			return ($this -> exec("Rollback"));
		}
		
		function Dbclose()
		{
			((is_null($___mysqli_res = mysqli_close($this->links))) ? false : $___mysqli_res);
		}			
	}	//Dbconn ends
