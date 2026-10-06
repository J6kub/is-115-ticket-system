
<?php

class User {

    public $first_name;
    public $last_name;
    public $id;
    public $role;

    public function __construct($sqlRow) {
        $this->first_name = $sqlRow["First_name"];
        $this->last_name = $sqlRow["Last_name"];
        $this->id = $sqlRow["ID"];
        $this->role = $sqlRow["user_type_id"];
    }

    public function echoit() {
        echo $this->id . "<br>";
        echo $this->role . "<br>";
        echo $this->last_name . "<br>";
        echo $this->first_name . "<br>";
    }
}


?>
```
