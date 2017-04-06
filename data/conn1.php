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
			$this->uname = "root"; 		
			$this->psw = "";					
			$this->dbname = "krishighar";
			
   			//$this->host = "localhost";
			// $this->uname = "krishwt5_ghar"; 		
			// $this->psw = "q}?2QC*AQ&[P";					
			// $this->dbname = "krishwt5_ghar";
			
			$this->links = mysql_connect($this->host,$this->uname,$this->psw) or die("Sorry, couldnot connect to MySQL Server");
			//mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $this->links);
			mysql_set_charset('utf8',$this->links);
			$this->db = mysql_select_db($this->dbname,$this->links) or die("Sorry, couldnot find database");			
		}
		
		function fetchArray($result)
		{
			return mysql_fetch_array($result);
		}	
		
		function Dbclose()
		{
			mysql_close($this->links);
		}			
	}	//Dbconn ends
?>