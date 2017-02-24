<?php
class Menjador {
    var $name;
    var $x;
    var $y;
	var $x2;
	var $y2;
	var $bloquejat=false;
	var $ordrePunts=0;
    // explicit actionscript package
    
    /**
    * Constructor with default values
    */
    function __construct($name, $x, $y, $x2, $y2,$punts=0) {
        $this->name = $name;
        $this->x = $x;
        $this->y= $y;
        $this->x2 = $x2;      
		$this->y2 = $y2;
		$this->ordrePunts=$punts;
   }
   
   function Menjador($name, $x, $y, $x2, $y2,$punts=0) {
     self::__construct($name, $x, $y, $x2, $y2,$punts);
   }
    /**
    * Load person data from a textfile
    */
    public function solapa($tx, $ty) {
		return ($tx >= $this->x && $ty >= $this->y && $tx < $this->x2 && $ty < $this->y2);
    }
}

?>