<?php

class ReviewGateway
{
    private PDO $conn;
    public function __construct(Database $database)
    {
        $this->conn = $database->getConnection();
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM reviews";
        $res = $this->conn->query($sql);
        $data = [];

        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }

    public function create(array $data): string
    {
        $sql = "INSERT INTO reviews (name, content, rate) 
                VALUES (:name, :content, :rate)";
        $res = $this->conn->prepare($sql);
        $res->bindValue(":productid", (bool) $data["productid"], PDO::PARAM_INT);
        $res->bindValue(":name", $data["name"], PDO::PARAM_STR);
        $res->bindValue(":content", $data["content"], PDO::PARAM_STR_CHAR);
        $res->bindValue(":rate", (bool) $data["rate"], PDO::PARAM_INT);

        $res->execute();
        return $this->conn->lastInsertId();
    }

    public function get(string $id)
    {
        $sql = "SELECT * FROM reviews WHERE id = :id";
        $res = $this->conn->prepare($sql);
        $res->bindValue(":id", $id, PDO::PARAM_INT);
        $res->execute();
        $data = $res->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function getByProductId(string $productid)
    {
        $sql = "SELECT * FROM reviews WHERE productid = :productid";
        $res = $this->conn->prepare($sql);
        $res->bindValue(":productid", $productid, PDO::PARAM_INT);
        $res->execute();
        $data = [];

        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }

        return $data;
    }

    public function update(array $current, array $new): int
    {
        $sql = "UPDATE reviews SET name = :name, content = :content, rate = :rate WHERE id =:id";
        $res = $this->conn->prepare($sql);
        $res->bindValue(":name", $new["name"] ?? $current["name"], PDO::PARAM_STR);
        $res->bindValue(":content", $new["content"] ?? $current["content"], PDO::PARAM_STR_CHAR);
        $res->bindValue(":rate", $new["rate"] ?? $current["rate"], PDO::PARAM_INT);
        $res->bindValue(":id", $current["id"], PDO::PARAM_INT);

        $res->execute();

        return $res->rowCount();
    }

    public function delete(string $id): int
    {
        $sql = "DELETE FROM reviews WHERE id = :id";
        $res = $this->conn->prepare($sql);
        $res->bindValue(":id", $id, PDO::PARAM_INT);
        $res->execute();

        return $res->rowCount();
    }
}