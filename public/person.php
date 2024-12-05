<?php

class person {
    // Attributes
    public $name;
    public $age;
    
    // Method
    public function __construct($name) {
        $this->name = $name;
       
    }

    // Method
    public function sayHello(){
        echo "Hello $this->name";
    }  
} 
    // object 
    $person = new person("John");
    $person->sayHello();
     

