<?php

require_once "Gateway.php";

class UserDbGateway extends Gateway {

    public function insertNewUser($user) {
        $hashedPassword = password_hash($user->password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user(first_name, last_name, email, password)
                VALUES ( ? , ? , ? , ? )";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssss", $user->firstName, $user->lastName, $user->email, $hashedPassword);
        $stmt->execute();
        $stmt->close();
        return $this->conn->insert_id;
    }

    public function selectAccountFromEmail($email) {
        $sql = "SELECT account_number FROM user WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row["account_number"];
    }

    public function getAccountInfo($accountNumber) {
        $sql = "SELECT account_number, first_name, last_name, email, password, created FROM user WHERE account_number = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $accountNumber);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row;
    }

    public function getPasswordForAccount($accountNumber) {
        $sql = "SELECT password FROM user WHERE account_number = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $accountNumber);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row["password"];
    }

    public function selectAdminNumberFromAccount($accountNumber) {
        $sql = "SELECT admin_number FROM admin WHERE account_number = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $accountNumber);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        return $row["admin_number"];
    }

}