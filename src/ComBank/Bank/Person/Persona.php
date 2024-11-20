<?php namespace ComBank\Bank\Person;
use ComBank\Support\Traits\ApiTrait;

class Persona{
    use ApiTrait;
    private $name;
    private $idCard;
    private $email;

     public function __construct($name, $idCard, $email) {
        $this->name = $name;
        $this->idCard = $idCard;
        if ($this->validateEmail($email)) {
            $this->email = $email;
            echo"Validating email: $email <br>";
            echo"Email is valid.";
        }else{
            echo"Validating email: $email <br>";
            echo"Error: Invalid email addres: $email";
        }
    }
    
}
