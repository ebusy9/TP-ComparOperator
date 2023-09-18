<?php

namespace Class\Manager;

use Class\Review;

trait ReviewManager
{
    protected string $tableReview = "review";


    public function readReviewAll(): ?array
    {
        return $this->dbGetAll($this->tableReview);
    }


    public function readReviewById(int $id): ?Review
    {
        return $this->dbGetObjectById($this->tableReview, $id);
    }


    public function readReviewByAuthorId(int $authorId): ?array
    {
        return $this->dbGetArrayBy($this->tableReview, "author_id", $authorId);
    }


    public function readReviewByTourOperatorId(int $tourOperatorId): ?array
    {
        return $this->dbGetArrayBy($this->tableReview, "tour_operator_id", $tourOperatorId);
    }


    public function createReview(string $message, int $score, int $tourOperatorId, int $authorId): ?Review
    {
        return $this->dbInsert($this->tableReview, [
            ":review_id" => $this->getRandomIdForNewDbEntry($this->tableReview),
            ":message" => htmlspecialchars($message),
            ":score" => $score,
            ":tour_operator_id" => $tourOperatorId,
            ":author_id" => $authorId
        ]);
    }


    public function updateReview(Review $review): ?Review
    {
        return $this->dbUpdate($this->tableReview, "review_id", [
            ":review_id" => $review->getReviewId(),
            ":message" => htmlspecialchars($review->getMessage()),
            ":score" => $review->getScore(),
            ":tour_operator_id" => $review->getTourOperatorId(),
            ":author_id" => $review->getAuthorId()
        ]);
    }


    public function deleteReviewById(int $id): bool
    {
        return $this->dbDeleteBy($this->tableReview, "review_id", $id);
    }


    public function deleteReviewByAuthorId(int $authorId): bool
    {
        return $this->dbDeleteBy($this->tableReview, "author_id", $authorId);
    }


    public function deleteReviewByTourOperatorId(int $tourOperatorId): bool
    {
        return $this->dbDeleteBy($this->tableReview, "tour_operator_id", $tourOperatorId);
    }
}
