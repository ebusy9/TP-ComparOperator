<?php

namespace class;

class ScoreManager
{
    private \PDO $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function getAllScore(): array
    {
        $req = $this->db->query("SELECT * FROM score");
        $scores = $req->fetchAll();

        $scoreObjects = [];

        foreach ($scores as $score) {

            array_push($scoreObjects, new Score($this->transformDbArrayForHydrate($score)));
        }

        return $scoreObjects;
    }

    public function getScoreById(int $id): Score
    {
        $req = $this->db->prepare("SELECT * FROM score WHERE id = :id");
        $req->execute([
            ":id" => $id
        ]);
        $score = $req->fetch();

        $scoreObject = new Score($this->transformDbArrayForHydrate($score));

        return $scoreObject;
    }

    public function getScoreByOperatorId(int $id): array
    {
        $req = $this->db->prepare("SELECT * FROM score WHERE tour_operator_id = :tour_operator_id");
        $req->execute([
            ":tour_operator_id" => $id
        ]);
        $scores = $req->fetchAll();

        $scoreObjects = [];

        foreach ($scores as $score) {

            array_push($scoreObjects, new Score($this->transformDbArrayForHydrate($score)));
        }

        return $scoreObjects;
    }

    public function getScoreByAuthorId(int $id): array
    {
        $req = $this->db->prepare("SELECT * FROM score WHERE author_id = :author_id");
        $req->execute([
            ":author_id" => $id
        ]);
        $scores = $req->fetchAll();

        $scoreObjects = [];

        foreach ($scores as $score) {

            array_push($scoreObjects, new Score($this->transformDbArrayForHydrate($score)));
        }

        return $scoreObjects;
    }

    public function createScore(int $value, int $price, int $operatorId, string $authorId): Score
    {
        $id = $this->getRandomIdForNewScore();

        $req = $this->db->prepare("INSERT INTO score(id, value, tour_operator_id, author_id) VALUES(:id, :value, :tour_operator_id, :author_id)");
        $req->execute([
            ":id" => $id,
            ":value" => $value,
            ":tour_operator_id" => $operatorId,
            ":author_id" => $authorId,
        ]);

        $score = $this->getScoreById($id);

        return $score;
    }

    public function updatescore(Score $score): void
    {
        $req = $this->db->prepare("UPDATE score SET value = :value, tour_operator_id = :operatorId, author_id = :author_id  WHERE id = :id");
        $req->execute([
            ":id" => $score->getId(),
            ":value" => $score->getValue(),
            ":operatorId" => $score->getOperatorId(),
            ":author_id" => $score->getAuthor()
        ]);
    }

    public function deleteScoreById(int $id): void
    {
        $req = $this->db->prepare("DELETE FROM score WHERE id = :id");
        $req->execute([
            ":id" => $id
        ]);
    }

    private function getRandomIdForNewScore(): int
    {
        try {
            $getAllIds = $this->db->prepare('SELECT * FROM score');
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
