<?php 
Class buildDB{
	//Class properties and methods using OOP for cleaner code in large project
	//Variables for connecting to the database 
	var $host;
	var $Username;
	var $Password;
	//provide path and access to database on the server
	var $table; 
	
	public function connect(){
		mysql_connect($this->host, $this->Username, $this->Password) or die("Could not Connect". mysql_error());// connect to database
		mysql_select_db($this->table) or die("could not select database" .mysql_error()); // select database table
		
			return $this->buildDB();
	}
	//private function for creating blacklightDB table if it does not exist 
	public function buildDB(){
		$sql = 
		"CREATE TABLE IF NOT EXISTS Article (
				id smallint NOT NULL auto_increment,
				PublicationDate Date NOT NULL,
				title VARCHAR(250) NOT NULL,
				summary TEXT NOT NULL,
				content mediumtext NOT NULL,
				
				
		)"; 
		return mysql_query($sql);
		
	}
}
?>