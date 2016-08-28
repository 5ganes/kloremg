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
			$this->host = "localhost";
			$this->uname = "krishwt5_ghar"; 		
			$this->psw = "kR%is5#hi_gh1ar";					
			$this->dbname = "krishwt5_ghar";
			
			$this->links = ($GLOBALS["___mysqli_ston"] = mysqli_connect($this->host, $this->uname, $this->psw)) or die("Sorry, couldnot connect to MySQL Server");
			//mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $this->links);
			mysql_set_charset('utf8',$this->links);
			$this->db = ((bool)mysqli_query($this->links, "USE " . $this->dbname)) or die("Sorry, couldnot find database");			
		}
		
		function fetchArray($result)
		{
			return mysqli_fetch_array($result);
		}	
		
		function Dbclose()
		{
			((is_null($___mysqli_res = mysqli_close($this->links))) ? false : $___mysqli_res);
		}			
	}	//Dbconn ends
?>