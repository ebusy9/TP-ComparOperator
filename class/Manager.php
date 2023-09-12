<?php

namespace class;

class Manager
{

    private \PDO $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function getAllDestinations()
    {
        $result = $this->db->query("SELECT * FROM destination");
        $rows = $result->fetchAll();

        return $rows;
    }




    public function getOperatorByDestination(int $id): array
    {

        $result = $this->db->prepare("SELECT * FROM destination WHERE tour_operator_id = :tour_operator_id");
        $result->execute([':tour_operator_id' => $id]);
        $rows = $result->fetchAll();

        return $rows;
    }

    public function createReview(Review $review)
    {
        $req = $this->db->prepare("INSERT INTO review (message, tour_operator_id, author_id) VALUES (:message, :tour_operator_id, :author_id)");
        $req->execute([
            ':author_id' => $review->getAuthor(),
            ':tour_operator_id' => $review->getOperatorId(),
            ':message' => $review->getMessage(),

        ]);
        $review->setId($this->db->lastInsertId());
    }

    public function getReviewsByOperator(int $id): array
    {
        $result = $this->db->prepare("SELECT * FROM review WHERE tour_operator_id = :tour_operator_id");
        $result->execute([':tour_operator_id' => $id]);
        $rows = $result->fetchAll();

        return $rows;
    }

    public function getAllOperators(): array
    {
        $result = $this->db->query("SELECT * FROM tour_operator");
        $rows = $result->fetchAll();

        return $rows;
    }

    public function updateOperatorToPrenium(string $signatory, string $expire, int $id): void
    {

        $stmt = $this->db->prepare("UPDATE certificate SET expire_at = ?, signatory = ? WHERE tour_operator_id = ?");
        $stmt->execute([$expire, $signatory, $id]);
    }

    public function createTourOperator(TourOperator $operator)
    {

        $req = $this->db->prepare("INSERT INTO tour_operator (id, name, link) VALUES (:id, :name, :link)");
        $req->execute([
            ':id' => $operator->getId(),
            ':name' => $operator->getName(),
            ':link' => $operator->getLink(),

        ]);
        $operator->setId($this->db->lastInsertId());
    }

    public function createDestination(Destination $destination)
    {
        $req = $this->db->prepare("INSERT INTO destination (id, location, price, tour_operator_id) VALUES (:id, :location, :price, :tour_operator_id)");
        $req->execute([
            ':id' => $destination->getId(),
            ':location' => $destination->getLocation(),
            ':price' => $destination->getPrice(),

        ]);
        $destination->setId($this->db->lastInsertId());
    }

    public function getOperatorById(int $id): array
    {
        $result = $this->db->prepare("SELECT * FROM tour_operator WHERE id = :id");
        $result->execute([
            ":id" => $id
        ]);
        $rows = $result->fetch();
        return $rows;
    }

    public function getDestinationsByOperatorId(int $id): array
    {
        $result = $this->db->prepare("SELECT * FROM destination WHERE tour_operator_id = :tour_operator_id");
        $result->execute([
            ":tour_operator_id" => $id
        ]);
        $rows = $result->fetchAll();
        return $rows;
    }
}
