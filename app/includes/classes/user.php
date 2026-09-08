<?php
class User {
    public $first_name;
    public $last_name;
    public $id;
    public $role;

    public function __construct($sqlRow) {
        $this->first_name = $sqlRow["first_name"];
        $this->role = $sqlRow["user_type"];
        $this->last_name = $sqlRow["last_name"];
        $this->id = $sqlRow["id"];
    }
    public function echoit() {
        echo $this->id . "<br>";
        echo $this->role . "<br>";
        echo $this->last_name . "<br>";
        echo $this->first_name . "<br>";
    }
}
?>