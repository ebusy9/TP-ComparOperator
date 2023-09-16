<?php

namespace class;

trait ScoreManager
{
    public function getAllScore(): ?array
    {
        try {
            $req = $this->db->query("SELECT * FROM score");
            $scores = $req->fetchAll();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($scores !== []) {
            $scoreObjects = [];

            foreach ($scores as $score) {
                array_push($scoreObjects, new Score($score));
            }

            return $scoreObjects;
        } else {
            return null;
        }
    }


    public function getScoreByOperatorAndAuthorId(TourOperator $operator, int $authorId): ?Score
    {
        $operatorId = $operator->getId();

        try {
            $req = $this->db->prepare("SELECT * FROM score WHERE tour_operator_id = :tour_operator_id AND author_id = :author_id");
            $req->execute([
                "tour_operator_id" => $operatorId,
                "author_id" => $authorId,
            ]);
            $score = $req->fetch();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($score !== false) {
            return new Score($score);
        } else {
            return null;
        }
    }


    public function getScoreById(int $id): ?Score
    {
        try {
            $req = $this->db->prepare("SELECT * FROM score WHERE id = :id");
            $req->execute([
                ":id" => $id
            ]);
            $score = $req->fetch();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($score !== false) {
            return new Score($score);
        } else {
            return null;
        }
    }


    public function getScoreByOperatorId(int $id): ?array
    {
        try {
            $req = $this->db->prepare("SELECT * FROM score WHERE tour_operator_id = :tour_operator_id");
            $req->execute([
                ":tour_operator_id" => $id
            ]);
            $scores = $req->fetchAll();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($scores !== []) {
            $scoreObjects = [];

            foreach ($scores as $score) {
                array_push($scoreObjects, new Score($score));
            }

            return $scoreObjects;
        } else {
            return null;
        }
    }


    public function getScoreByAuthorId(int $id): ?array
    {
        try {
            $req = $this->db->prepare("SELECT * FROM score WHERE author_id = :author_id");
            $req->execute([
                ":author_id" => $id
            ]);
            $scores = $req->fetchAll();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($scores !== []) {
            $scoreObjects = [];

            foreach ($scores as $score) {
                array_push($scoreObjects, new Score($score));
            }

            return $scoreObjects;
        } else {
            return null;
        }
    }


    public function createScore(int $value, int $operatorId, string $authorId): ?Score
    {
        $id = $this->getRandomIdForNewDbEntry("score");

        try {
            $req = $this->db->prepare("INSERT INTO score(id, value, tour_operator_id, author_id) VALUES(:id, :value, :tour_operator_id, :author_id)");
            $req->execute([
                ":id" => $id,
                ":value" => $value,
                ":tour_operator_id" => $operatorId,
                ":author_id" => $authorId,
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        return $this->getScoreById($id);
    }


    public function updateScore(Score $score): ?Score
    {
        try {
            $req = $this->db->prepare("UPDATE score SET value = :value, tour_operator_id = :operatorId, author_id = :author_id  WHERE id = :id");
            $req->execute([
                ":id" => $score->getId(),
                ":value" => $score->getValue(),
                ":operatorId" => $score->getTourOperatorId(),
                ":author_id" => $score->getAuthorId()
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        return $this->getScoreById($score->getId());
    }


    public function deleteScoreById(int $id): bool
    {
        try {
            $req = $this->db->prepare("DELETE FROM score WHERE id = :id");
            $req->execute([
                ":id" => $id
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        $scoreAfterDelete = $this->getScoreById($id);

        if ($scoreAfterDelete === null) {
            return true;
        } else {
            return false;
        }
    }


    public function deleteScoreByAuthorId(int $id): bool
    {
        try {
            $req = $this->db->prepare("DELETE FROM score WHERE author_id = :author_id");
            $req->execute([
                ":author_id" => $id
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        $scoreAfterDelete = $this->getScoreByAuthorId($id);

        if ($scoreAfterDelete === null) {
            return true;
        } else {
            return false;
        }
    }
}