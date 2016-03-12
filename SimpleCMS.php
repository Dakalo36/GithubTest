<?php 
class SimpleCMS {
	//Class properties and methods using OOP for cleaner code in large project
	//Variables for connecting to the database 
	var $host;
	var $Username;
	var $Password
	//provide path and access to database on the server
	var $table; 
	public function display_public(){
		$q = "SELECT * FROM blacklightDB ORDER BY created DESC LIMIT 3";
		$r = mysql_query($q);
		
		if ($r !== false && mysql_num_rows($r) > 0){
			while ($a = mysql_fetch_assoc($r)) {
				$title = stripslashes($a['title']);
				$bodytext = stripslashes($a['bodytext']);
				
					$entry_display .= <<<ENTRY_DISPLAY

    <h2>$title</h2>
    <p>
      $bodytext
    </p>

ENTRY_DISPLAY;
      }
    } else {
      $entry_display = <<<ENTRY_DISPLAY

    <h2>This Page Is Under Construction</h2>
    <p>
      No entries have been made on this page. 
      Please check back soon, or click the
      link below to add an entry!
    </p>

ENTRY_DISPLAY;
    }
    $entry_display .= <<<ADMIN_OPTION

    <p class="admin_link">
      <a href="{$_SERVER['PHP_SELF']}?admin=1">Add a New Entry</a>
    </p>

ADMIN_OPTION;

    return $entry_display;
  }

	public function display_admin(){
		return <<<ADMIN_FORM 
		<form action = "{$_SERVER['PHP_SELF']}" method = "post">
		<label for = "title">Title:</label>
		<input name="title" id="title" type="text" maximumlength="150"/>
		<label for="bodytext">Bodytext:</label>
		<textarea name="bodytext" id="bodytext" ></textarea>
		<input type="submit" value="Create this Entry!"/>
		</form>
		ADMIN_FORM;
	}
	public function write($P){
		if ($P['title'])
			$title = mysql_real_escape_string($P['title']);
			if ($P['bodytext'])
				$bodytext = mysql_real_escape_string($p['bodytext']);
			if ($title && $bodytext){
				$created = time();
				$sql = "INSERT INTO blacklightDB VALUES('$title', '$bodytext', '$created')";
				return mysql_query($sql)
				
			}else{
				return false;
			}
	}
	public function connect(){
		mysql_connect($this->$host, $this->$Username, $this->$Password) or die("Could not Connect". mysql_error());// connect to database
		mysql_select_db($this->table) or die("could not select database" .mysql_error()); // select database table
		
			return $this->buildDB();]
	}
	//private function for creating blacklightDB table if it does not exist 
	private function buildDB(){
		$sql = <<< MySQL_QUERY 
		CREATE TABLE IF NOT EXISTS blacklightDB (
				title VARCHAR(150),
				bodytext TEXT,
				created VARCHAR(100)
		)
		MySQL_QUERY; 
		return mysql_query($sql);
		
	}
} 
?>