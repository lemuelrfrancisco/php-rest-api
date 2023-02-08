<?php
class ReviewController
{
    public function __construct(private ReviewGateway $gateway)
    {
    }
    public function processRequest(string $method, ?string $id, ?string $productid): void
    {
        if ($id) {
            $this->processResourceRequest($method, $id, $productid);
        } else {
            $this->processCollectionRequest($method);

        }
    }


    private function processResourceRequest(string $method, string $id, ?string $productid): void
    {
        if ($productid) {
            $review = $this->gateway->getByProductId($productid);
        } else {
            $review = $this->gateway->get($id);
        }
        if (!$review) {
            http_response_code(404);
            echo json_encode(["message" => "Review not found"]);
            return;
        }

        switch ($method) {
            case "GET":
                echo json_encode($review);
                break;

            case "PATCH":
                $data = (array) json_decode(file_get_contents("php://input"), true);
                $errors = $this->getValidationErrors($data, false);

                if (!empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                $rows = $this->gateway->update($review, $data);

                echo json_encode([
                    "message" => "Review $id updated",
                    "rows" => $rows
                ]);
                break;

            case "DELETE":
                $rows = $this->gateway->delete($id);
                echo json_encode([
                    "message" => "Review $id deleted",
                    "rows" => $rows
                ]);
                break;

            default:
                http_response_code(405);
                header("Allow: GET, PATCH, DELETE");

        }
    }

    private function processCollectionRequest(string $method): void
    {
        switch ($method) {
            case "GET":
                echo json_encode($this->gateway->getAll());
                break;

            case "POST":
                $data = (array) json_decode(file_get_contents("php://input"), true);
                $errors = $this->getValidationErrors(($data));

                if (!empty($errors)) {
                    http_response_code(422);
                    echo json_encode(["errors" => $errors]);
                    break;
                }

                $id = $this->gateway->create($data);

                http_response_code(201);
                echo json_encode([
                    "message" => "Review created",
                    "id" => $id
                ]);
                break;

            default:
                http_response_code(405);
                header("Allow: GET, POST");
        }
    }

    private function getValidationErrors(array $data, bool $is_new = true): array
    {
        $errors = [];
        if ($is_new && empty($data["name"])) {
            $errors[] = "name is requred";
        }

        if ($is_new && empty($data["content"])) {
            $errors[] = "content is requred";
        }

        if ($is_new && empty($data["productid"])) {
            $errors[] = "productId is requred";
        }

        if (array_key_exists("rate", $data)) {
            if (filter_var($data["rate"], FILTER_VALIDATE_INT) === false) {
                $errors[] = "rate must be an integer";
            }
        }

        return $errors;
    }
}