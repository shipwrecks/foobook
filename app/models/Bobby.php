<?php

class Bobby {

    // Properties
    public $name;
    public $email;
    public $logged_in = false;


    // Methods

    function __construct() {
        echo 'You just created a new user!';
    }

    public function getName() {
        return $this->name;
    }   
    public function setName($new_name) {
        $this->name = $new_name;
    }

}