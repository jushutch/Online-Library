<?php
require_once __DIR__ . "/../database/UserDbGateway.php";

class User {

    public $firstName;
    public $lastName;
    public $email;
    public $password;

    private $userDbGateway;

    public function __construct() {
        $this->userDbGateway = new UserDbGateway();
    }

    public function createUser() {
        $this->firstName = $_POST['firstName'];
        $this->lastName = isset($_POST['lastName']) && $_POST['lastName'] ? $_POST['lastName'] : null;
        $this->email = strtolower($_POST['email']);
        $this->password = $_POST['password'];
        $_POST = array();
        return $this->userDbGateway->insertNewUser($this);
    }

    public function isEmailTaken($email) {
        return $this->userDbGateway->selectAccountFromEmail($email);
    }

    public function isValidLogin($accountNumber, $password) {
        if (!$this->doesAccountNumberExist($accountNumber)) return false;
        $accountPassword = $this->userDbGateway->getPasswordForAccount($accountNumber);
        if (!$accountPassword) return false;
        return password_verify($password, $accountPassword);
    }

    public function isAdmin($accountNumber) {
        return $this->userDbGateway->selectAdminNumberFromAccount($accountNumber) ? true : false;
    }

    private function doesAccountNumberExist($accountNumber) {
        if (!isset($accountNumber)) return false;
        return $this->userDbGateway->getAccountInfo($accountNumber);
    }

}