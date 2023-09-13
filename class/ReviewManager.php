<?php

namespace class;

class ReviewManager
{
    private \PDO $db;


    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }


    public function getAllReview(): array
    {
        $req = $this->db->query("SELECT * FROM reviews");
        $reviews = $req->fetchAll();

        $reviewObjects = [];

        foreach ($reviews as $review) {
            array_push($reviewObjects, new Review($this->transformDbArrayForHydrate($review)));
        }

        return $reviewObjects;
    }


    public function getReviewById(int $id): Review
    {
        $req = $this->db->query("SELECT * FROM reviews WHERE id = :id");
        $req->execute([
            ":id" => $id
        ]);
        $review = $req->fetch();
        return new Review($this->transformDbArrayForHydrate($review));
    }


    public function getReviewByAuthorId(int $id): array
    {
        $req = $this->db->query("SELECT * FROM reviews WHERE author_id = :author_id");
        $req->execute([
            ":author_id" => $id
        ]);
        $reviews = $req->fetchAll();

        $reviewObjects = [];

        foreach ($reviews as $review) {
            array_push($reviewObjects, new Review($this->transformDbArrayForHydrate($review)));
        }

        return $reviewObjects;
    }


    public function getReviewByOperatorId(int $id): array
    {
        $req = $this->db->query("SELECT * FROM reviews WHERE operator_id = :operator_id");
        $req->execute([
            ":operator_id" => $id
        ]);
        $reviews = $req->fetchAll();

        $reviewObjects = [];

        foreach ($reviews as $review) {
            array_push($reviewObjects, new Review($this->transformDbArrayForHydrate($review)));
        }

        return $reviewObjects;
    }


    public function createReview(string $message, int $operatorId, int $author): Review
    {
        $id = $this->getRandomIdForNewReview();

        $req = $this->db->prepare("INSERT INTO review(id, message, tour_operator_id, author_id) VALUES (:id, :message, :tour_operator_id, :author_id)");
        $req->execute([
            ":id" => $id,
            ":message" => $message,
            ":tour_operator_id" => $operatorId,
            ":author_id" => $author
        ]);

        return $this->getReviewById($id);
    }


    public function updateReview(Review $review): void
    {
        $req = $this->db->prepare("UPDATE review SET message = :message, tour_operator_id = :tour_operator_id, author_id = :author_id WHERE id = :id");
        $req->execute([
            ":id" => $review->getId(),
            ":message" => $review->getMessage(),
            ":tour_operator_id" => $review->getOperatorId(),
            ":author_id" => $review->getAuthor()
        ]);
    }


    public function deleteReviewById(int $id): void
    {
        $req = $this->db->prepare("DELETE FROM review WHERE id = :id");
        $req->execute([
            ":id" => $id
        ]);
    }


    public function deleteReviewByAuthorId(int $id): void
    {
        $req = $this->db->prepare("DELETE FROM review WHERE author_id = :author_id");
        $req->execute([
            ":author_id" => $id
        ]);
    }


    public function deleteReviewByOperatorId(int $id): void
    {
        $req = $this->db->prepare("DELETE FROM review WHERE tour_operator_id = :tour_operator_id");
        $req->execute([
            ":tour_operator_id" => $id
        ]);
    }


    private function getRandomIdForNewReview(): int
    {
        try {
            $getAllIds = $this->db->prepare('SELECT * FROM review');
            $getAllIds->execute();
            $allIds = $getAllIds->fetchAll();
        } catch (\PDOException $ex) {
            $_SESSION['ex_Manager_getAllIds'] = $ex;
        }

        $takenIdList = [];

        foreach ($allIds as $id) {
            array_push($takenIdList, $id['id']);
        }

        $id = rand(1, 99999);

        while (in_array($id, $takenIdList, true)) {
            $id = rand(1, 99999);
        }

        return $id;
    }


    private function transformDbArrayForHydrate(array $data): array
    {
        $data['operatorId'] = $data['tour_operator_id'];
        unset($data['tour_operator_id']);
        $data['author'] = $data['author_id'];
        unset($data['author_id']);

        return $data;
    }
}
