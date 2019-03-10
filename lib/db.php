<?php


// Veritabani baglanti
if(!defined("rs")) {  die("Sorun Olustu!"); }

require ("configuration.php");

/**
* Veri tabani baglanti
*/
class db
{
	private $db_host;
	private $db_name;
	private $db_username;
	private $db_password;
	public  $dbc;


	// Baslangic
	public function __construct()
	{
		$this->db_host 		= $GLOBALS['dbc_host'];
		$this->db_name 		= $GLOBALS['dbc_name'];
		$this->db_username 	= $GLOBALS['dbc_username'];
		$this->db_password 	= $GLOBALS['dbc_password'];
		
	}

	public function connection(){
		$this->dbc = new mysqli ($this->db_host, $this->db_username, $this->db_password);

		if($this->dbc->connect_error){
			die("Baglanti hatasi");
		} else {

			// Veri tabanini ac
			$this->dbc->select_db($this->db_name);
			
		}
	}


	public function query($sql){

		$result = $this->dbc->query($sql);

		if ($result->num_rows > 0) {

			return $result->fetch_assoc();

		} else {

			return false;

		}

	}


	public function query_array($sql){

		$result = $this->dbc->query($sql);

		if ($result->num_rows > 0) {

			while($row = $result->fetch_array())
			{
				$rows[] = $row;
			}
			return $rows;

		} else {

			return false;

		}

	}

	public function query_insert($sql){

		$result = $this->dbc->query($sql);

		if ($result === true) {

			return true;

		} else {

			return false;

		}

	}

}