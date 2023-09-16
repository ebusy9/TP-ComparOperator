<?php

namespace class;

trait ReviewManager
{
    public function getAllReview(): ?array
    {
        try {
            $req = $this->db->query("SELECT * FROM review");
            $reviews = $req->fetchAll();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($reviews !== []) {
            $reviewObjects = [];

            foreach ($reviews as $review) {
                array_push($reviewObjects, new Review($review));
            }

            return $reviewObjects;
        } else {
            return null;
        }
    }


    public function getReviewById(int $id): ?Review
    {
        try {
            $req = $this->db->prepare("SELECT * FROM review WHERE id = :id");
            $req->execute([
                ":id" => $id
            ]);
            $review = $req->fetch();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($review !== false) {
            return new Review($review);
        } else {
            return null;
        }
    }


    public function getReviewByAuthorId(int $id): ?array
    {
        $req = $this->db->prepare("SELECT * FROM review WHERE author_id = :author_id");
        $req->execute([
            ":author_id" => $id
        ]);
        $reviews = $req->fetchAll();

        if ($reviews !== []) {
            $reviewObjects = [];

            foreach ($reviews as $review) {
                array_push($reviewObjects, new Review($review));
            }

            return $reviewObjects;
        } else {
            return null;
        }
    }


    public function getReviewByOperatorId(int $id): ?array
    {
        $req = $this->db->prepare("SELECT * FROM review WHERE tour_operator_id = :tour_operator_id");
        $req->execute([
            ":tour_operator_id" => $id
        ]);
        $reviews = $req->fetchAll();

        if ($reviews !== []) {
            $reviewObjects = [];

            foreach ($reviews as $review) {
                array_push($reviewObjects, new Review($review));
            }

            return $reviewObjects;
        } else {
            return null;
        }
    }


    public function createReview(string $message, int $tourOperatorId, int $authorId): ?Review
    {
        $id = $this->getRandomIdForNewDbEntry("review");

        try {
            $req = $this->db->prepare("INSERT INTO review(id, message, tour_operator_id, author_id) VALUES (:id, :message, :tour_operator_id, :author_id)");
            $req->execute([
                ":id" => $id,
                ":message" => $message,
                ":tour_operator_id" => $tourOperatorId,
                ":author_id" => $authorId
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        return $this->getReviewById($id);
    }


    public function updateReview(Review $review): ?Review
    {
        try {
            $req = $this->db->prepare("UPDATE review SET message = :message, tour_operator_id = :tour_operator_id, author_id = :author_id WHERE id = :id");
            $req->execute([
                ":id" => $review->getId(),
                ":message" => $review->getMessage(),
                ":tour_operator_id" => $review->getTourOperatorId(),
                ":author_id" => $review->getAuthorId()
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        return $this->getReviewById($review->getId());
    }


    public function deleteReviewById(int $id): bool
    {
        try {
            $req = $this->db->prepare("DELETE FROM review WHERE id = :id");
            $req->execute([
                ":id" => $id
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        $reviewAfterDelete = $this->getReviewById($id);

        if ($reviewAfterDelete === null) {
            return true;
        } else {
            return false;
        }
    }


    public function deleteReviewByAuthorId(int $id): bool
    {
        try {
            $req = $this->db->prepare("DELETE FROM review WHERE author_id = :author_id");
            $req->execute([
                ":author_id" => $id
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        $reviewAfterDelete = $this->getReviewByAuthorId($id);

        if ($reviewAfterDelete === null) {
            return true;
        } else {
            return false;
        }
    }


    public function deleteReviewByOperatorId(int $id): bool
    {
        try {
            $req = $this->db->prepare("DELETE FROM review WHERE tour_operator_id = :tour_operator_id");
            $req->execute([
                ":tour_operator_id" => $id
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        $reviewAfterDelete = $this->getReviewByOperatorId($id);

        if ($reviewAfterDelete === null) {
            return true;
        } else {
            return false;
        }
    }
}