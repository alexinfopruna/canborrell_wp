<?php
class UsuariVO {
    var $id;
    var $nom;
    var $perm;
    // explicit actionscript package
    var $_explicitType = "com.canBorrell.UsuariVO";
    
    /**
    * Constructor with default values
    */
    function UsuariVO($id=0, $nom="", $perm=""){
        $this->id = $id;
        $this->nom = $nom;
        $this->perm = $perm;      
    }
}
?>