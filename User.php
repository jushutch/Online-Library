<?php
require_once "UserDbGateway.php";

class User {

    private $firstName;
    private $lastName;
    private $email;
    private $password;
    private $userDbGateway;

    public function __construct() {
        $this->userDbGateway = new UserDbGateway();
    }

    public function createNewAccount() {
        $this->firstName = $_POST['firstName'];
        $this->lastName = $_POST['lastName'];
        $this->email = $_POST['email'];
        $this->password = $_POST['password'];
        return $this->userDbGateway->insertNewUser($this->firstName, $this->lastName, $this->email, $this->password);
    }

    public function isEmailTaken($email) {
        $rows = $this->userDbGateway->selectEmail($email);
        return $rows->num_rows > 0;
    }

    public function isValidLogin($accountNumber, $password) {
        if (!$this->doesAccountNumberExist($accountNumber)) return false;
        $accountPassword = $this->userDbGateway->getPasswordForAccount($accountNumber);
        if (!$accountPassword) return false;
        return password_verify($password, $accountPassword);
    }

    private function doesAccountNumberExist($accountNumber) {
        if (!isset($accountNumber)) return false;
        return $this->userDbGateway->getAccountInfo($accountNumber)->num_rows > 0;
    }

}