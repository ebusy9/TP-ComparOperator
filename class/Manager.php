<?php

namespace class;

class Manager {

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
        $result->execute([':tour_operator_id'=>$id]);
        $rows = $result->fetchAll();

       return $rows;
    } 

    public function createReview(Review $review)
    {
        $req = $this->db->prepare("INSERT INTO review (message, tour_operator_id, author_id) VALUES (:message, :tour_operator_id, :author_id)");
        $req->execute([
            ':message'=>$review->getMessage(),
            ':tour_operator_id'=>$review->getId(),
            ':author_id'=>$review->getId(),

    ]);
        $review->setId($this->db->lastInsertId());
    }

    public function getReviewsByOperator(int $id): array
    {
        $result = $this->db->prepare("SELECT * FROM review WHERE tour_operator_id = :tour_operator_id");
        $result->execute([':tour_operator_id'=>$id]);
        $rows = $result->fetchAll();

       return $rows;
    }

    public function getAllOperators()
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

    public function createTourOperator()
    {

    }

    public function createDestination()
    {
        
    }

    
}