<?php

class ProductGateway
{
    private PDO $conn;
    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM product";
        $res = $this->conn->query($sql);
        $data = [];

        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $row["is_available"] = (bool) $row["is_available"];
            $data[] = $row;
        }

        return $data;
    }

    public function create(array $data): string
    {
        $sql = "INSERT INTO product (name, size, is_available) 
                VALUES (:name, :size, :is_available)";
        $res = $this->conn->prepare($sql);
        $res->bindValue(":name", $data["name"], PDO::PARAM_STR);
        $res->bindValue(":size", $data["size"] ?? 0, PDO::PARAM_INT);
        $res->bindValue(":is_available", (bool) $data["is_available"] ?? false, PDO::PARAM_BOOL);

        $res->execute();
        return $this->conn->lastInsertId();
    }

    public function get(string $id)
    {
        $sql = "SELECT * FROM product WHERE id = :id";
        $res = $this->conn->prepare($sql);
        $res->bindValue(":id", $id, PDO::PARAM_INT);
        $res->execute();
        $data = $res->fetch(PDO::FETCH_ASSOC);

        if ($data !== false) {
            $data["is_available"] = (bool) $data["is_available"];
        }

        return $data;
    }

    public function update(array $current, array $new): int
    {
        $sql = "UPDATE product SET name = :name, size = :size, is_available = :is_available WHERE id =:id";
        $res = $this->conn->prepare($sql);
        $res->bindValue(":name", $new["name"] ?? $current["name"], PDO::PARAM_STR);
        $res->bindValue(":size", $new["size"] ?? $current["size"], PDO::PARAM_INT);
        $res->bindValue(":is_available", $new["is_available"] ?? $current["is_available"], PDO::PARAM_BOOL);
        $res->bindValue(":id", $current["id"], PDO::PARAM_INT);

        $res->execute();

        return $res->rowCount();
    }

    public function delete(string $id): int
    {
        $sql = "DELETE FROM product WHERE id = :id";
        $res = $this->conn->prepare($sql);
        $res->bindValue(":id", $id, PDO::PARAM_INT);
        $res->execute();

        return $res->rowCount();
    }
}