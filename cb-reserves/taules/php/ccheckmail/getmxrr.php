<?php 
/*
*	This script was writed by Setec Astronomy - setec@freemail.it
*
*	On row 41 of CCheckMail.php substitute the following line
*
*   if (getmxrr ($host, $mxhosts[0],  $mxhosts[1]) == true) 
*
*	with
*
*	if (getmxrr_portable ($host, $mxhosts[0],  $mxhosts[1]) == true) 
*
*	to have a fully working portable (*nix and Windows) CCheckMail class
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
function getmxrr_win ($hostname = "", &$mxhosts, &$weight)
{
 $weight = array();
 $mxhosts = array();
 $result = false;
 
 
 $command = "nslookup -type=mx " . escapeshellarg ($hostname);
 exec ($command, $result);
 $i = 0;
 while (list ($key, $value) = each ($result)) 
 {
    if (strstr ($value, "mail exchanger")) 
    { $nslookup[$i] = $value; $i++; }
 }
 
 while (list ($key, $value) = each ($nslookup)) 
 {
    $temp = explode ( " ", $value );
    $mx[$key][0] = substr($temp[3],0,-1);
    $mx[$key][1] = $temp[7];
    $mx[$key][2] = gethostbyname ( $temp[7] );
 }
 
 array_multisort ($mx);
 
 foreach ($mx as $value) 
 { 
  $mxhosts[] = $value[1];
  $weight[] = $value[0];
 } 
 
 $result = count ($mxhosts) > 0;
 return $result;
}

function getmxrr_portable ($hostname = "", &$mxhosts, &$weight)
{
 if (function_exists ("getmxrr"))
 { $result = getmxrr ($hostname, $mxhosts, $weight); }
 else
 { $result = getmxrr_win ($hostname, $mxhosts, $weight); }
 return $result; 
}
?>
