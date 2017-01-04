<?php

require './src/helper.php';


class Habit {
    public $name;
    protected $age;
    private $city;
}

class Profile {
    public $name;
    protected $age;
    private $city;
    private $habit;

    public function __construct() {
        $this->habit = new Habit;
    }
}

class Tom {
    public $name;
    protected $age;
    private $city;
    private $profile;

    public function __construct() {
        $this->profile = new Profile;
    }
}

$tom = new Tom;

printf("\n");
$json = json_encode(object_array($tom));
print_r($json);
printf("\n");
print_r(json_decode($json, true));
printf("\n-------------------------\n");
print_r(json_encode($tom));
printf("\n");
