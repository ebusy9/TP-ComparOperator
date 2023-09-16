<?php

namespace class;

class Manager
{
    use CertificateManager, DestinationManager, ReviewManager, ScoreManager, TourOperatorManager;

    protected \PDO $db;


    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////MISC////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function publishOrUpdateReview(string $authorName, int $operatorId, int $scoreValue, string $message): bool
    {
        $scoreValue = min($scoreValue, 5);
        $authorName = htmlspecialchars($authorName);
        $message = htmlspecialchars($message);

        $authorId = $this->getAuthorIdbyNameOrCreateNewAuthor($authorName);

        $scoreList = $this->getAllScore();

        foreach ($scoreList as $score) {
            if ($score->getAuthor() === $authorId && $score->getOperatorId() === $operatorId) {
                $score->setValue($scoreValue);
                $scoreObjectAfterDb = $this->updateScore($score);
            }
        }

        if (!isset($scoreObjectAfterDb)) {
            $scoreObjectAfterDb = $this->createScore($scoreValue, $operatorId, $authorId);
        }

        $reviewList = $this->getAllReview();

        foreach ($reviewList as $review) {
            if ($review->getAuthor() === $authorId && $review->getOperatorId() === $operatorId) {
                $review->setMessage($message);
                $reviewObjectAfterDb = $this->updateReview($review);
            }
        }

        if (!isset($reviewObjectAfterDb)) {
            $reviewObjectAfterDb = $this->createReview($message, $operatorId, $authorId);
        }

        if ($authorId !== null && $scoreObjectAfterDb !== null && $reviewObjectAfterDb !== null) {
            return true;
        } else {
            return false;
        }
    }


    public function getUniqueIdForImgUpload(int $lenght = 13): string
    {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new \Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
    }


    private function getRandomIdForNewDbEntry(string $table): int
    {
        $sql = "SELECT * FROM $table";

        try {
            $req = $this->db->prepare($sql);
            $req->execute();
            $allIds = $req->fetchAll();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($allIds === []) {
            $id = rand(1, 999999);
        } else {
            $takenIdList = [];

            foreach ($allIds as $id) {
                array_push($takenIdList, $id['id']);
            }

            $id = rand(1, 999999);

            while (in_array($id, $takenIdList, true)) {
                $id = rand(1, 999999);
            }
        }

        return $id;
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////END MISC////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////AUTHOR//////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function getAuthorIdbyNameOrCreateNewAuthor(string $name): ?int
    {
        $name = strtolower($name);

        try {
            $req = $this->db->prepare("SELECT * FROM author WHERE name = :name");
            $req->execute([
                ":name" => $name
            ]);
            $author = $req->fetch();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($author !== false) {
            return $author['id'];
        } else {
            $id = $this->getRandomIdForNewDbEntry("author");

            $req = $this->db->prepare("INSERT INTO author(id, name) VALUES(:id, :name)");
            $req->execute([
                ":id" => $id,
                ":name" => $name
            ]);

            $author = $this->getAuthorNameById($id);

            if ($author === null) {
                return $author;
            } else {
                return $id;
            }
        }
    }

    public function getAuthorNameById(int $id): ?string
    {
        try {
            $req = $this->db->prepare('SELECT * FROM author WHERE id = :id');
            $req->execute([
                ":id" => $id
            ]);
            $author = $req->fetch();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($author !== false) {
            return ucfirst($author['name']);
        } else {
            return null;
        }
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////AUTHOR//////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
