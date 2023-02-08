<?php

class UserGateway
{
    private PDO $conn;
    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function register(array $data): string
    {
        $sql = "INSERT INTO users (email, password, firstName, middleName, lastName, contactNo) 
                VALUES (:email, :password, :firstName, :middleName, :lastName, :contactNo)";
        $res = $this->conn->prepare($sql);

        $password = md5($data["password"]);

        $res->bindValue(":email", $data["email"], PDO::PARAM_STR);
        $res->bindValue(":password", $password, PDO::PARAM_STR);
        $res->bindValue(":firstName", $data["firstName"], PDO::PARAM_STR);
        $res->bindValue(":middleName", $data["middleName"], PDO::PARAM_STR);
        $res->bindValue(":lastName", $data["lastName"], PDO::PARAM_STR);
        $res->bindValue(":contactNo", $data["contactNo"], PDO::PARAM_STR);

        $res->execute();
        return $this->conn->lastInsertId();
    }

    public function login(string $email, string $password)
    {
        $sql = "SELECT * FROM users WHERE email = :email AND password = :password";
        $res = $this->conn->prepare($sql);
        $res->bindValue(":email", $email, PDO::PARAM_STR);
        $res->bindValue(":password", md5($password), PDO::PARAM_STR);

        $res->execute();
        $data = $res->fetch(PDO::FETCH_ASSOC);
        unset($data['password']);
        return $data;
    }

    public function changePassword(array $current, array $new): int
    {
        $sql = "UPDATE users SET password = :password";
        $res = $this->conn->prepare($sql);
        $res->bindValue(":password", md5($new["password"]) ?? md5($current["password"]), PDO::PARAM_STR);

        $res->execute();

        return $res->rowCount();
    }

}