<?php
function llegir_dies($fitxer)
{
   for ($i=0;$i<12;$i++) $dies[$i]= array();

	$gestor = @fopen($fitxer, "r");
	if ($gestor) {
		while (!feof($gestor)) {
			$bufer = fgets($gestor, 4096);
			 /*
			$d=substr($bufer,0,2);
			$m=(int) substr($bufer,3,2);  
			$y=substr($bufer,6,4);
			 */
             
            $d=strtok($bufer, "-/");
            $m=strtok( "-/");
            $y=strtok( "\n\t\r");
 
			if (checkdate($m,$d,$y)) array_push($dies[$m-1],$d);
			
			
		//    echo "--->".$d."  ".$m."  ".$y;
		}
		fclose ($gestor);	
		return $dies;
    }
    else
    {
        
		return $dies;       
    }
}  

function guarda_dies($fitxer, $dies,$any)
{
	$gestor = @fopen($fitxer, "w");
	if ($gestor) {    
       for ($i=0;$i<12;$i++)
        {    
          //asort($dies[$i]);    
          $k=0;
          while (isset($dies[$i][$k])) 
          {
                $d=$dies[$i][$k];
                $m=$i+1;
                $y=$any;
                $dat=$d."-".$m."-".$y."\n";
               
/*                $ara=getdate();
                // $ara=microtime();
                $dd=mktime(0, 0, 0, $m, $d, $y);
                if ($dd<$ara[0]) $d=0;
 */
                if ($d!=0) fputs($gestor,$dat);
                $k++;
          }      
        }  
    }    


}  



function crea_llista_js($dies)
{
    echo "var SPECIAL_DAYS = {";
    for ($i=0;$i<12;$i++)
    {
     if ($i<11) $coma=",\n";
     else $coma="\n";  
        
      echo $i." : [";
      
      $k=0;$q=0; 
      while (isset($dies[$i][$k])) 
      {
            
			//echo $i." - ".$dies[$i][$k]." --> ".((int)date("m")-1)." - ".date("d");
			if (  (((int)date("m")-1)!=$i)  ||  (($dies[$i][$k])!=((int)date("d")))   ) 
			{	
				if ($q>0)echo ",";
				echo $dies[$i][$k];
				$q++;
			}				
		
			$k++;			

      }      
      echo "]".$coma;
    }  
    
    echo "};";
} 
?>