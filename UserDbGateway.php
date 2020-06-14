<?php


class UserDbGateway {

    private $hostname;
    private $database;
    private $username;
    private $password;

    public function __construct() {
        $this->hostname = "localhost";
        $this->database = "library";
        $this->username = "root";
        $this->password = "mysql";
    }

    public function insertNewUser($firstName, $lastName, $email, $password) {
        $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);
        if ($conn->connect_error) die("Fatal error");
        $this->sanitizeArrayOfInputs($conn, func_get_args());
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user(first_name, last_name, email, password)
                VALUES ('$firstName', '$lastName', '$email', '$hashedPassword')";
        $result = $conn->query($sql);
        $accountId = $conn->insert_id;
        $conn->close();
        return $accountId;
    }

    public function selectEmail($email) {
        $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);
        $this->fixMySQLStringEntities($conn, $email);
        $sql = "SELECT account_number FROM user WHERE email = '$email'";
        $rows = $conn->query($sql);
        $conn->close();
        return $rows;
    }

    public function getAccountInfo($accountNumber) {
        $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);
        $this->fixMySQLStringEntities($conn, $accountNumber);
        $sql = "SELECT account_number, password FROM user WHERE account_number = $accountNumber";
        $rows = $conn->query($sql);
        $conn->close();
        return $rows;
    }

    public function getPasswordForAccount($accountNumber) {
        $conn = new mysqli($this->hostname, $this->username, $this->password, $this->database);
        $this->fixMySQLStringEntities($conn, $accountNumber);
        $sql = "SELECT password FROM user WHERE account_number = $accountNumber";
        $result= $conn->query($sql);
        $row = $result->fetch_assoc();
        $conn->close();
        return isset($row['password']) ? $row['password'] : null;
    }

    private function sanitizeArrayOfInputs($conn, $strings) {
        $returnStrings = [];
        foreach ($strings as $string) {
            if ($string) $returnStrings[] = $this->fixMySQLStringEntities($conn, $string);
        }
        return $returnStrings;
    }

    private function fixMySQLStringEntities(&$conn, &$string) {
        return htmlentities($this->fixMySQLString($conn, $string));
    }

    private function fixMySQLString(&$conn, &$string) {
        if (get_magic_quotes_gpc()) $string = stripslashes($string);
        return $conn->real_escape_string($string);
    }

    private function printMySQLError() {
        echo "Something went wrong, please try again later.";
    }
}