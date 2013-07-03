<?php
// provides a set of functions abstracting over
// the mysql functions in case
// we ever decide to switch databases or
// implement error logging etc

class db_functions
{

	var $server;
	var $user;
	var $pass;
	var $link;
	var $db;

	function db_functions()
	{
		require($_SERVER['DOCUMENT_ROOT']."Private/creds.php");
		$this->server = $db_server;
		$this->user   = $db_user;
		$this->pass   = $db_pass;
		$this->db     = $db;
	}

	function db_connect()
	{
		mysql_connect($this->server, $this->user, $this->pass) or die ("Unable to connect!"); 
		mysql_select_db($this->db) or die ("Unable to select database!");  
	}

	function db_close()
	{
		return mysql_close($this->link);
	}

	function db_query($query)
	{
		return mysql_query($query);
	}

	function db_fetch_row($response)
	{
		return mysql_fetch_row($response);
	}

	function db_num_rows($response)
	{
		return mysql_num_rows($response);
	}
}
?>