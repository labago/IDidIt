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
		require($_SERVER['DOCUMENT_ROOT']."IDidIt/Private/creds.php");
		$this->server = $db_server;
		$this->user   = $db_user;
		$this->pass   = $db_pass;
		$this->db     = $db;
	}

	function db_connect()
	{
		$this->mysqli = mysqli_connect($this->server, $this->user, $this->pass, $this->db) or die ("Unable to connect!"); 
	}

	function db_close()
	{
		$this->mysqli->close();
	}

	function db_query($query)
	{
		try
		{
			return $this->mysqli->query($query);
		}
		catch (Exception $e) 
		{
  	 		 echo $db->mysqli->error;
		}
	}

	function db_fetch_row($response)
	{
		return $response->fetch_row();
	}

	function db_num_rows($response)
	{
		return $response->num_rows;
	}
}
?>