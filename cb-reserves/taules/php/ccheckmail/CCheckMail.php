<?php 
/*
*	This script was writed by Setec Astronomy - setec@freemail.it
*
*	This script is distributed  under the GPL License
*
*	This program is distributed in the hope that it will be useful,
*	but WITHOUT ANY WARRANTY; without even the implied warranty of
*	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* 	GNU General Public License for more details.
*
*	http://www.gnu.org/licenses/gpl.txt
*
*/
define ('DEBUG_OK', false);
class CCheckMail
{
	var $timeout = 10;
	var $domain_rules = array ("aol.com", "bigfoot.com", "brain.net.pk", "breathemail.net",
						 	   "compuserve.com", "dialnet.co.uk", "glocksoft.com", "home.com",
						 	   "msn.com", "rocketmail.com", "uu.net", "yahoo.com", "yahoo.de");
							  
	function _is_valid_email ($email = "") 
	{ return preg_match('/^[.\w-]+@([\w-]+\.)+[a-zA-Z]{2,6}$/', $email); }	
	
	function _check_domain_rules ($domain = "")
	{ return in_array (strtolower ($domain), $this->domain_rules); }

	function execute ($email = "")
	{
		if (!$this->_is_valid_email ($email))
		{ return false; }
				
		$host = substr (strstr ($email, '@'), 1);

		if ($this->_check_domain_rules ($host))
		{ return false; }

		$host .= ".";

		if (getmxrr ($host, $mxhosts[0],  $mxhosts[1]) == true) 
		{ array_multisort ($mxhosts[1],  $mxhosts[0]); }
		else
		{
			$mxhosts[0] = $host;
			$mxhosts[1] = 10;
		} 
		if (DEBUG_OK) { print_r ($mxhosts); }
		
		$port = 25;
		$localhost = $_SERVER['HTTP_HOST'];
		$sender = 'info@' . $localhost;
		
		$result = false;
		$id = 0;
		while (!$result && $id < count ($mxhosts[0]))
		{
			if (function_exists ("fsockopen"))
			{
				if (DEBUG_OK) { print_r ($id . " " . $mxhosts[0][$id]); }
				if ($connection = fsockopen ($mxhosts[0][$id], $port, $errno, $error, $this->timeout))
				{
					fputs ($connection,"HELO $localhost\r\n"); // 250
					$data = fgets ($connection,1024);
					$response = substr ($data,0,1);
					if (DEBUG_OK) { print_r ($data); }
					
					if ($response == '2') // 200, 250 etc.
					{ 
						fputs ($connection,"MAIL FROM:<$sender>\r\n");
						$data = fgets($connection,1024);
						$response = substr ($data,0,1);
						if (DEBUG_OK) { print_r ($data); }
						
						if ($response == '2') // 200, 250 etc.
						{ 
							fputs ($connection,"RCPT TO:<$email>\r\n");
							$data = fgets($connection,1024);
							$response = substr ($data,0,1);
							if (DEBUG_OK) { print_r ($data); }
							
							if ($response == '2') // 200, 250 etc.
							{ 
								fputs ($connection,"data\r\n");
								$data = fgets($connection,1024);
								$response = substr ($data,0,1);
								if (DEBUG_OK) { print_r ($data); }
								
								if ($response == '2') // 200, 250 etc.
								{ $result = true; }
							}
						}
					}
					
					fputs ($connection,"QUIT\r\n"); 
					fclose ($connection);
					if ($result) { return true; }
				}
			}
			else
			{ break; } 
			$id++;
		}  
		return false;
	}
}
?>