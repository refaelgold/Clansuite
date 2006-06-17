<?php
  
//----------------------------------------------------------------
// Class session start
//----------------------------------------------------------------
class session
{
	//----------------------------------------------------------------
	// Init class session | set common session vars
	//----------------------------------------------------------------
	private $_session 				= array();    // clear array
	public $session_name 			= 'suiteSID'; // custom session_name
	public $session_expire_time 	= 30; 		  // expiretime minutes
	public $session_probability 	= 30;		  // clean up in 30 of 100 cases
	public $session_cookies 		= 1;       // cookies verwenden
	public $session_cookies_only 	= 0;       // nur Cookies verwenden
	public $session_security 		= array('check_ip' 		=> false,
											'check_browser' => false);
											
	//----------------------------------------------------------------
	// Overwrite php.ini settings
	// Start the session
	//----------------------------------------------------------------
	function create_session()
	{
		//----------------------------------------------------------------
		// Set the ini Vars
		//----------------------------------------------------------------
		ini_set("session.save_handler",    	"user"                   );
		ini_set("session.name",				$this->session_name       );
		ini_set("session.gc_maxlifetime",  	$this->session_expire_time );
		ini_set("session.gc_probability",  	$this->session_probability);

		//----------------------------------------------------------------
		// Check if cookies are allowed
		//----------------------------------------------------------------
		setcookie ( 'time', time(), time() + 31536000 );

		if ( !isset($_COOKIE['time']) or $this->session_cookies == false )
		{
			ini_set("session.use_cookies", '0');
			ini_set("url_rewriter.tags", '');
			ini_set("session.use_trans_sid", '1');
			ini_set("session.use_only_cookies",	'0');
		}
		else
		{
			ini_set("session.use_cookies", 	'1');
			ini_set("session.use_only_cookies",	'1');
			ini_set("session.use_trans_sid", '0');
		}

		//----------------------------------------------------------------
		// Set the hnadlers
		//----------------------------------------------------------------
		session_set_save_handler(
									array(&$this, "_session_open"   ),
									array(&$this, "_session_close"  ),
									array(&$this, "_session_read"   ),
									array(&$this, "_session_write"  ),
									array(&$this, "_session_destroy"),
									array(&$this, "_session_gc"     ));

		
		// Session wird gestartet ... or Error!
		if (!session_start())
		{ echo 'Session start failed!'; }
		
		// Debug: Session-�bergabe Test
		if (!isset($_SESSION["test"]))
		{
		       $_SESSION["test"] = 'erster eintrag';
		       print_r($_SESSION);
		}
		else
		{ $_SESSION["test"] = 'zweiter eintrag'; }
		
		// Session assigned to Class-Var for easy handling (Globalisierung)
		$this->_session =&$_SESSION;
		
		if ( !$this->_session_check_security() )
		{ $this->_session = array(); }

	}
	
	//----------------------------------------------------------------
	// Open a session
	//----------------------------------------------------------------
	function _session_open($save_path, $sess_name)
	{	
		return true; 
	}

	//----------------------------------------------------------------
	// Close a session
	//----------------------------------------------------------------
	function _session_close()
	{
		//session::_session_gc(0);
		return true;
	}

	//----------------------------------------------------------------
	// Read a session
	//----------------------------------------------------------------
	function _session_read ( $id )
	{ 
		global $Db;
		
		# assign false, if there was an error, we can info the user about it
		$return_value = "";
		# get the session_data from database
		$table 	= "SELECT session_data FROM " . DB_PREFIX . "session ";
		$where	= "WHERE session_name='$this->session_name' AND session_id='$id'";
		$result	= //$Db->exec($table.$where);
		# return the session_data, if it is not null
		var_dump($result);
		if($result!=0)
		{ $return_value = $result; }
		return $return_value;
	}

	//----------------------------------------------------------------
	// Write a session
	//----------------------------------------------------------------
	function _session_write( $id, $data )
	{ 
		global $Db;
		echo 'WRITE';
		// adjust ExpireTime
		$seconds	= $this->session_expire_time * 60;
		$expires	= time() + $seconds; // d.h. jetzt + expire*60
		// SELECT WHERE | session_id
		$table = "SELECT session_id FROM ". DB_PREFIX ."session ";
		$where = "WHERE session_id='$id'";
		$session_id = 0;//$Db->exec($table.$where);

		if ( $session_id )
		{ // UPDATE | aktualisiert die jeweilige Session

			$table 	= "UPDATE " . DB_PREFIX . "session ";
			$set	= "SET session_expire = ?, session_data= ? WHERE session_id= ?";
			//$Db->exec($table.$set, $expires, $data, $id);

			// 	Session::SessionControl();

		}
		else
		{
			$table 		= "INSERT INTO ".DB_PREFIX."session ";
			$values 	= "(session_id, session_name, session_expire, session_data, session_visibility,user_id) VALUES ($id, $this->session_name, $expires, $data, 1, 0)";
			//$Db->exec($table.$values);
    	}
		return true;
	}

	//----------------------------------------------------------------
	// Destroy a session
	//----------------------------------------------------------------
	function _session_destroy( $id )
	{
		global $Db;

		// unset cookiesvar

		if(isset($_COOKIE[$this->session_name]))
		{ unset($_COOKIE[$this->session_name]); }

		// delete the session from the database
		$table = "DELETE FROM " . DB_PREFIX . "session ";
		$where = "session_name='$this->session_name' AND session_id = '$id'";
		$row_count = 0;//$Db->exec($table.$where);

		// if there are Sessions left optimize them

		if ( $row_count > 0)
		{ $this->_session_optimize(); }

	}

	//----------------------------------------------------------------
	// Session garbage collector
	//----------------------------------------------------------------
	function _session_gc ( $max_lifetime )
	{
		global $Db;

		$table = "DELETE FROM " . DB_PREFIX . "session ";
		$where = "session_name ='$this->session_name' and session_expire < '" . time() . "'";
		$row_count = 0;//$Db->exec($table.$where);

		// if there are Sessions left optimize them

		if ( $row_count > 0)
		{ $this->_session_optimize(); }
	}

	//----------------------------------------------------------------
	// Optimize the session table
	//----------------------------------------------------------------
	function _session_optimize()
	{
		global $Db;

		//$Db->exec('OPTIMIZE TABLE ' . DB_PREFIX . 'session');
	}

	//----------------------------------------------------------------
	// Check for a secure session 
	//----------------------------------------------------------------
	function _session_check_security()
	{
		//----------------------------------------------------------------
		// Check for IP
		//----------------------------------------------------------------
		if(in_array("check_ip", $this->session_security))
		{
			
			// get the clientip
			$ip	= $_SESSION[ClientIP];
			// if it is null, than set it
			if($ip === null)
		    {
    			$_SESSION[ClientIP] = $_SERVER['REMOTE_ADDR'];
		    }
				// else check, if it is right or not and return false on a mess
  			else if($_SERVER['REMOTE_ADDR'] !== $ip)
		    {
    			return false;
		    }
		}

		//----------------------------------------------------------------
		// Check for Browser
		//----------------------------------------------------------------
		if(in_array("check_browser", $this->session_security))
		{
			// get the client browserinfo
			$browser = $_Session[Client-Browser];
			// if it is null, than set it
			if($browser === null)
    		{
    			$_SESSION['Client-Browser'] = $_SERVER["HTTP_USER_AGENT"];
    		}
    		// else check, if it is right or not and return false on a mess
	        else if($_SERVER["HTTP_USER_AGENT"] !== $browser)
    		{
    			return false;
    		}
		}
		// Debug :
		// echo 'SessionSecurity says: This Guy is ok!';
		// return true if everything is O.K.
		return true;
	}

	//----------------------------------------------------------------
	// Session control
	// - delete old users
	// - prune timeouts 
	//----------------------------------------------------------------
	function session_control()
	{
		global $Db;
		// 2 Tage alte registrierte, aber nicht aktivierte User löschen!
		$table = "DELETE FROM " . DB_PREFIX . "users ";
		$where = "disabled = 1 AND (joined + INTERVAL 2 DAY)<Now() AND (timestamp + INTERVAL 2 DAY)<Now()";
		//$Db->exec($table.$where);

		// Zeitstempel in users-table setzen
		$table 	= 'UPDATE ' . DB_PREFIX . 'users ';
		$set	= "SET timestamp = NOW() WHERE user_id = $_SESSION[User][user_id]";
		//$Db->exec($table.$set);

		if(isset($_SESSION['authed']))
		{
			if(!isset($_SESSION['lastmove']) || (time() - $_SESSION['lastmove'] > 350))
			{
				$_SESSION['lastmove'] = time();
			}
			else
			{ // todo: a. you forgot to logout b. send user back
				die(header("location:logout.php"));
			}
		}
	}
}
$session = new session;
$session->create_session();
?>