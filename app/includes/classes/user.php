<?php

class User {

    public $first_name;
    public $last_name;
    public $id;
    public $role;
    public $email;
    public $profile_image;

    public function __construct($sqlRow) {
        $this->first_name = $sqlRow["First_name"];
        $this->last_name = $sqlRow["Last_name"];
        $this->id = $sqlRow["ID"];
        $this->role = $sqlRow["user_type_id"];
        $this->email = $sqlRow["email"];
        $this->profile_image = !empty($sqlRow["has_profile_image"]) || !empty($sqlRow["profile_image_data"]);
    }

    public function echoit() {
        echo $this->id . "<br>";
        echo $this->role . "<br>";
        echo $this->last_name . "<br>";
        echo $this->first_name . "<br>";
        echo $this->email . "<br>";
    }
}
