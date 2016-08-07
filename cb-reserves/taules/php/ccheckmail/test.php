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
include ("CCheckMail.php");

$checkmail = new CCheckMail ();

$emails = array ("info@yahoo.com", "invalid#email.com", "setec@freemail.it", "thisdoesentexist@google.com",$_GET['email']);
foreach ($emails as $email)
{
	if ($checkmail->execute ($email))
	{ print ("The email address $email exists!<br>"); }
	else
	{ print ("The email address $email <strong>doesn't</strong> exists!<br>"); }
}
?>
