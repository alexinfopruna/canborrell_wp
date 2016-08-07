<?php
class PersonVO {
    var $name;
    var $age;
    var $address;
    // explicit actionscript package
    var $_explicitType = "com.canBorrell.PersonVO";
    
    /**
    * Constructor with default values
    */
    function PersonVO($name="", $age=0, $address=""){
        $this->name = $name;
        $this->age = $age;
        $this->address = $address;      
		$this->arrai = array(0 => "a", 1 => "b", 2 => "c", 3 => "d");
    }
    /**
    * Load person data from a textfile
    */
    function loadData(){
        $fp = fopen("person.txt", "r");
        $contents = fread($fp, filesize("person.txt"));
        fclose($fp);
        $data = explode("|", $contents);
        $this->name = $data[0];
        $this->age = $data[1];
        $this->address = $data[2];        
    }
    /*
    * Saves person data to a textfile
    * @return Boolean on succes
    */
    function logData(){
        $fp = fopen("person.txt", "w");
        if(fwrite($fp, $this->name."|".$this->age."|".$this->address)){
            fclose($fp);
            return true;
        };
        return false;
    }
}
?>