<?php

namespace Class\Manager;

use Class\Author;
use Class\Certificate;
use Class\Destination;
use Class\Review;
use Class\TourOperator;
use Class\User;
use Class\OfferDestination;

class Manager
{
    use AuthorManager, CertificateManager, DestinationManager, OfferDestinationManager, ReviewManager, TourOperatorManager, UserManager;

    protected \PDO $db;


    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }


    public function verifyLoginStatus(): void
    {
        if (!isset($_SESSION['userId'])) {
            header('Location: login.php?err=userNotLoggedIn');
            exit();
        } else {
            if (($this->readUserById($_SESSION['userId']))->getIsAdmin() === false) {
                header('Location: index.php?err=userIsNotAdmin');
                exit();
            }
        }
    }

    
    public function validateLogin(string $login): ?string
    {
        if (empty($login)) {
            return "Login is required.";
        } elseif (!preg_match('/^[a-zA-Z0-9]{6,15}$/', $login)) {
            return "The login does not meet the requirements!";
        }
        return null;
    }


    public function validatePassword(string $password, string $confirmPassword): ?string
    {
        if (empty($password)) {
            return "Password is required.";
        } elseif (!preg_match('/^(?=.*\d)(?=.*[A-Za-z])(?=.*[^0-9A-Za-z])[0-9A-Za-z!@#$%]{6,15}$/', $password)) {
            return 'The password does not meet the requirements!';
        } elseif ($password !== $confirmPassword) {
            return "Password confirmation does not match!";
        }
        return null;
    }


    public function validateUsername(string $username, string $login): ?string
    {
        if (empty($username)) {
            return "Username is required.";
        } elseif (!preg_match('/^[a-zA-Z0-9\s]{2,15}$/', $username)) {
            return "The username does not meet the requirements!";
        } elseif (strtolower($username) === $login) {
            return "The username must be different from the login!";
        }
        return null;
    }


    public function userSignup(string $username, string $login, string $password): ?User
    {
        $username = htmlspecialchars(strtolower($username));
        $login = htmlspecialchars(strtolower($login));

        $usernameTaken = $this->readUserByUsername($username);
        $loginTaken = $this->readUserByLogin($login);

        if ($usernameTaken === null && $loginTaken === null) {
            return $this->createUser($login, $password, $username);
        } else {
            return null;
        }
    }


    public function readOfferDestinationByDestinationIdWithLowestPrice(int $destinationId): ?OfferDestination
    {
        $offerDestinationList = $this->readOfferDestinationByDestinationId($destinationId);

        if ($offerDestinationList !== null) {
            $offerDestinationWithLowestPrice = $offerDestinationList[0];
            foreach ($offerDestinationList as $offerDestination) {
                $currentPrice = $offerDestinationWithLowestPrice->getPrice();
                $newPrice = $offerDestination->getPrice();
                if ($currentPrice > $newPrice) {
                    $offerDestinationWithLowestPrice = $offerDestination;
                }
            }
        } else {
            return null;
        }
        return $offerDestinationWithLowestPrice;
    }


    public function publishReview(string $authorName, int $tourOperatorId, int $score, string $message): ?Review
    {
        $score = min($score, 5);
        $authorName = htmlspecialchars($authorName);
        $message = htmlspecialchars($message);

        $author = $this->readAuthorByName($authorName);

        if ($author === null) {
            $author = $this->createAuthor($authorName);
        }

        $sql = "SELECT * FROM review WHERE author_id = :author_id AND tour_operator_id = :tour_operator_id";

        try {
            $req = $this->db->prepare($sql);
            $req->execute([
                ":author_id" => $author->getAuthorId(),
                ":tour_operator_id" => $tourOperatorId
            ]);
            $review = $req->fetch();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($review === false) {
            return $this->createReview($message, $score, $tourOperatorId, $author->getAuthorId());
        } else {
            return null;
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
                $tableId = $table . "_id";
                array_push($takenIdList, $id[$tableId]);
            }

            $id = rand(1, 999999);

            while (in_array($id, $takenIdList, true)) {
                $id = rand(1, 999999);
            }
        }

        return $id;
    }


    private function dbGetAll(string $table): ?array
    {
        $sql = "SELECT * FROM $table";

        try {
            $req = $this->db->prepare($sql);
            $req->execute();
            $entries = $req->fetchAll();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($entries !== []) {
            return $this->returnObjectFromDbArray($table, $entries);
        } else {
            return null;
        }
    }


    private function dbGetObjectById(string $table, int $id): mixed
    {
        $column = $table . "_id";
        $varColumn = ":" . $table . "_id";
        $sql = "SELECT * FROM $table WHERE $column = $varColumn";

        try {
            $req = $this->db->prepare($sql);
            $req->execute([
                $varColumn => $id
            ]);
            $entry = $req->fetch();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($entry !== false) {
            return $this->returnObjectFromDbArray($table, $entry);
        } else {
            return null;
        }
    }


    private function dbGetArrayBy(string $table, string $column, mixed $columnValue): ?array
    {
        $varColumn = ":" . $column;
        $sql = "SELECT * FROM $table WHERE $column = $varColumn";

        try {
            $req = $this->db->prepare($sql);
            $req->execute([
                $varColumn => $columnValue
            ]);
            $entries = $req->fetchAll();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($entries !== []) {
            return $this->returnObjectFromDbArray($table, $entries);
        } else {
            return null;
        }
    }


    private function dbGetObjectBy(string $table, string $column, mixed $columnValue): mixed
    {
        $varColumn = ":" . $column;
        $sql = "SELECT * FROM $table WHERE $column = $varColumn";

        try {
            $req = $this->db->prepare($sql);
            $req->execute([
                $varColumn => $columnValue
            ]);
            $entry = $req->fetch();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($entry !== false) {
            return $this->returnObjectFromDbArray($table, $entry);
        } else {
            return null;
        }
    }


    private function dbInsert(string $table, array $data): mixed
    {
        $columnsValues = implode(", ", array_keys($data));
        $columns = str_replace(":", "", $columnsValues);

        $sqlInsert = "INSERT INTO $table ($columns) VALUES ($columnsValues)";

        try {
            $req = $this->db->prepare($sqlInsert);
            $req->execute($data);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        $whereClauseArray = [];

        foreach ($data as $key => $value) {
            array_push($whereClauseArray, str_replace(":", "", $key) . " = $key");
        }

        $whereClause = implode(" AND ", $whereClauseArray);

        $sqlSelect = "SELECT * FROM $table WHERE $whereClause";

        try {
            $reqTwo = $this->db->prepare($sqlSelect);
            $reqTwo->execute($data);
            $entryAfterInsert = $reqTwo->fetch();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($entryAfterInsert !== false) {
            return $this->returnObjectFromDbArray($table, $entryAfterInsert);
        } else {
            return null;
        }
    }


    private function dbUpdate(string $table, string $column, array $data): mixed
    {
        $setClauseArray = [];

        foreach ($data as $key => $value) {
            array_push($setClauseArray, str_replace(":", "", $key) . " = $key");
        }

        $setClause = implode(", ", $setClauseArray);

        $sqlUpdate = "UPDATE $table SET $setClause WHERE $column = :$column";

        try {
            $req = $this->db->prepare($sqlUpdate);
            $req->execute($data);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        $whereClause = implode(" AND ", $setClauseArray);

        $sqlSelect = "SELECT * FROM $table WHERE $whereClause";

        try {
            $reqTwo = $this->db->prepare($sqlSelect);
            $reqTwo->execute($data);
            $entryAfterInsert = $reqTwo->fetch();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($entryAfterInsert !== false) {
            return $this->returnObjectFromDbArray($table, $entryAfterInsert);
        } else {
            return null;
        }
    }


    private function dbDeleteBy(string $table, string $column, mixed $columnValue): bool
    {
        $varColumn = ":" . $column;
        $sql = "DELETE FROM $table WHERE $column = $varColumn";

        try {
            $req = $this->db->prepare($sql);
            $req->execute([
                $varColumn => $columnValue
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        $result = $this->dbGetObjectBy($table, $column, $columnValue);

        if ($result === null) {
            return true;
        } else {
            return false;
        }
    }


    private function returnObjectFromDbArray(string $table, ?array $arrayFromDb): mixed
    {
        if (array_key_first($arrayFromDb) === 0) {
            if ($arrayFromDb === null) {
                return null;
            } else {
                $objects = [];
                switch ($table) {
                    case 'author':
                        foreach ($arrayFromDb as $entry) {
                            $entry["review"] = $this->readReviewByAuthorId($entry["author_id"]);
                            array_push($objects, new Author($entry));
                        }
                        return $objects;
                    case 'certificate':
                        foreach ($arrayFromDb as $entry) {
                            array_push($objects, new Certificate($entry));
                        }
                        return $objects;
                    case 'destination':
                        foreach ($arrayFromDb as $entry) {
                            array_push($objects, new Destination($entry));
                        }
                        return $objects;
                    case 'offer_destination':
                        foreach ($arrayFromDb as $entry) {
                            array_push($objects, new OfferDestination($entry));
                        }
                        return $objects;
                    case 'review':
                        foreach ($arrayFromDb as $entry) {
                            array_push($objects, new Review($entry));
                        }
                        return $objects;
                    case 'tour_operator':
                        foreach ($arrayFromDb as $entry) {
                            $entry["certificate"] = $this->readCertificateByTourOperatorId($entry["tour_operator_id"]);
                            $entry["offerDestination"] = $this->readOfferDestinationByTourOperatorId($entry["tour_operator_id"]);
                            $entry["review"] = $this->readReviewByTourOperatorId($entry["tour_operator_id"]);
                            array_push($objects, new TourOperator($entry));
                        }
                        return $objects;
                    case 'user':
                        foreach ($arrayFromDb as $entry) {
                            array_push($objects, new User($entry));
                        }
                        return $objects;
                    default:
                        return "returnObjectIfArrayFromDbNotNull error";
                }
            }
        } else {
            if ($arrayFromDb === null) {
                return null;
            } else {
                switch ($table) {
                    case 'author':
                        $arrayFromDb["review"] = $this->readReviewByAuthorId($arrayFromDb["author_id"]);
                        return new Author($arrayFromDb);
                    case 'certificate':
                        return new Certificate($arrayFromDb);
                    case 'destination':
                        return new Destination($arrayFromDb);
                    case 'offer_destination':
                        return new OfferDestination($arrayFromDb);
                    case 'review':
                        return new Review($arrayFromDb);
                    case 'tour_operator':
                        $arrayFromDb["certificate"] = $this->readCertificateByTourOperatorId($arrayFromDb["tour_operator_id"]);
                        $arrayFromDb["offerDestination"] = $this->readOfferDestinationByTourOperatorId($arrayFromDb["tour_operator_id"]);
                        $arrayFromDb["review"] = $this->readReviewByTourOperatorId($arrayFromDb["tour_operator_id"]);
                        return new TourOperator($arrayFromDb);
                    case 'user':
                        return new User($arrayFromDb);
                    default:
                        return "returnObjectIfArrayFromDbNotNull error";
                }
            }
        }
    }
}
