<?php

namespace class;

class Manager
{
    private \PDO $db;


    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }



    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////MISC////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    private function transformDbArrayForHydrate(array $data): array
    {
        if (isset($data['tour_operator_id'])) {
            $data['operatorId'] = $data['tour_operator_id'];
            unset($data['tour_operator_id']);
        }

        if (isset($data['expires_at'])) {
            $data['expiresAt'] = $data['expires_at'];
            unset($data['expires_at']);
        }

        if (isset($data['img_destination'])) {
            $data['img'] = $data['img_destination'];
            unset($data['img_destination']);
        }

        if (isset($data['author_id'])) {
            $data['author'] = $data['author_id'];
            unset($data['author_id']);
        }

        return $data;
    }


    public function publishOrUpdateReview(string $authorName, int $operatorId, int $scoreValue, string $message): bool
    {
        $authorId = $this->getAuthorIdbyNameOrCreateNewAuthor($authorName);

        $scoreList = $this->getAllScore();

        foreach ($scoreList as $score) {
            if ($score->getAuthor() === $authorId && $score->getOperatorId() === $operatorId) {
                $score = $this->updateScore($score);
            }
        }

        if (!isset($score)) {
            $score = $this->createScore($scoreValue, $operatorId, $authorId);
        }

        $reviewList = $this->getAllReview();

        foreach ($reviewList as $review) {
            if ($review->getAuthor() === $authorId && $review->getOperatorId() === $operatorId) {
                $review = $this->updateReview($review);
            }
        }

        if (!isset($review)) {
            $review = $this->createReview($message, $operatorId, $authorId);
        }

        if ($authorId !== null && $score !== null && $review !== null) {
            return true;
        } else {
            return false;
        }
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
            $id = $this->getRandomIdForNewAuthor();

            $req = $this->db->prepare("INSERT INTO author(id, name) VALUES(:id, :name)");
            $req->execute([
                ":id" => $id,
                ":name" => $name
            ]);

            $author = $this->getAuthorNameById($id);

            if ($author === null) {
                return $author;
            } else {
                return $author['id'];
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


    private function getRandomIdForNewAuthor(): int
    {
        try {
            $getAllIds = $this->db->prepare('SELECT * FROM author');
            $getAllIds->execute();
            $allIds = $getAllIds->fetchAll();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
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
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////AUTHOR//////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////CERTIFICATE MANAGER////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function getAllCertificate(): ?array
    {
        try {
            $req = $this->db->query("SELECT * FROM certificate");
            $certificates = $req->fetchAll();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($certificates !== []) {
            $certificateObjects = [];

            foreach ($certificates as $certificate) {
                array_push($certificateObjects, new Certificate($this->transformDbArrayForHydrate($certificate)));
            }

            return $certificateObjects;
        } else {
            return null;
        }
    }


    public function getCertificateByOperatorId(int $id): ?Certificate
    {
        try {
            $req = $this->db->prepare("SELECT * FROM certificate WHERE tour_operator_id = :tour_operator_id");
            $req->execute([
                ":tour_operator_id" => $id
            ]);
            $certificate = $req->fetch();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($certificate !== false) {
            return new Certificate($certificate = $this->transformDbArrayForHydrate($certificate));
        } else {
            return null;
        }
    }


    public function getCertificateBySignatory(string $signatory): ?array
    {
        try {
            $req = $this->db->prepare("SELECT * FROM certificate WHERE signatory = :signatory");
            $req->execute([
                ":signatory" => $signatory
            ]);
            $certificates = $req->fetchAll();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($certificates !== []) {
            $certificateObjects = [];

            foreach ($certificates as $certificate) {
                array_push($certificateObjects, new Certificate($this->transformDbArrayForHydrate($certificate)));
            }

            return $certificateObjects;
        } else {
            return null;
        }
    }


    public function createCertificate(int $operatorId, string $expireAt, string $signatory): ?Certificate
    {
        try {
            $req = $this->db->prepare("INSERT INTO certificate(tour_operator_id, expires_at, price, tour_operator_id, img_destination) VALUES(:operatorId, :expiresAt, :signatory)");
            $req->execute([
                ":operatorId" => $operatorId,
                ":expiresAt" => $expireAt,
                ":signatory" => $signatory,
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        return $this->getCertificateByOperatorId($operatorId);
    }


    public function updateCertificate(Certificate $certificate): ?Certificate
    {
        try {
            $req = $this->db->prepare("UPDATE certificate SET expires_at = :expires_at, signatory = :signatory, WHERE tour_operator_id = :tour_operator_id");
            $req->execute([
                ":tour_operator_id" => $certificate->getOperatorId(),
                ":expires_at" => $certificate->getExpiresAt(),
                ":signatory" => $certificate->getSignatory(),
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        return $this->getCertificateByOperatorId($certificate->getOperatorId());
    }


    public function deleteCertificateByOperatorId(int $id): bool
    {
        try {
            $req = $this->db->prepare("DELETE FROM certificate WHERE tour_operator_id = :tour_operator_id");
            $req->execute([
                ":tour_operator_id" => $id
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        $certificateAfterDelete = $this->getCertificateByOperatorId($id);

        if ($certificateAfterDelete === null) {
            return true;
        } else {
            return false;
        }
    }


    public function deleteCertificateSignatory(string $signatory): bool
    {
        try {
            $req = $this->db->prepare("DELETE FROM certificate WHERE signatory = :signatory");
            $req->execute([
                ":signatory" => $signatory
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        $certificateAfterDelete = $this->getCertificateBySignatory($signatory);

        if ($certificateAfterDelete === null) {
            return true;
        } else {
            return false;
        }
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////END CERTIFICATE MANAGER////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////DESTINATION MANAGER////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function getAllDestinations(): ?array
    {
        try {
            $req = $this->db->query("SELECT * FROM destination");
            $destinations = $req->fetchAll();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($destinations !== []) {
            $destinationObjects = [];

            foreach ($destinations as $destination) {
                array_push($destinationObjects, new Destination($this->transformDbArrayForHydrate($destination)));
            }

            return $destinationObjects;
        } else {
            return null;
        }
    }


    public function getAllUniqueDestinations(): ?array
    {
        $destinationList = $this->getAllDestinations();

        if ($destinationList !== null) {

            $uniqueDestinationList = [];

            foreach ($destinationList as $destination) {
                if (isset($uniqueDestinationList[$destination->getLocation()])) {
                    $currentPrice = $uniqueDestinationList[$destination->getLocation()]->getPrice();
                    $thisDestinationPrice = $destination->getPrice();

                    if ($currentPrice > $thisDestinationPrice) {
                        $currentPrice = $uniqueDestinationList[$destination->getLocation()]->setPrice($thisDestinationPrice);
                    }
                } else {
                    $uniqueDestinationList[$destination->getLocation()] = $destination;
                }
            }

            return array_values($uniqueDestinationList);
        } else {
            return $destinationList;
        }
    }


    public function getDestinationById(int $id): ?Destination
    {
        try {
            $req = $this->db->prepare("SELECT * FROM destination WHERE id = :id");
            $req->execute([
                ":id" => $id
            ]);
            $destination = $req->fetch();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($destination !== false) {
            $destinationObject = new Destination($this->transformDbArrayForHydrate($destination));

            return $destinationObject;
        } else {
            return null;
        }
    }


    public function getDestinationByLocation(string $location): ?array
    {
        try {
            $req = $this->db->prepare("SELECT * FROM destination WHERE location = :location");
            $req->execute([
                ":location" => $location
            ]);
            $destinations = $req->fetchAll();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($destinations !== []) {
            $destinationObjects = [];

            foreach ($destinations as $destination) {
                array_push($destinationObjects, new Destination($this->transformDbArrayForHydrate($destination)));
            }

            return $destinationObjects;
        } else {
            return null;
        }
    }


    public function getDestinationsByOperatorId(int $id): ?array
    {
        try {
            $req = $this->db->prepare("SELECT * FROM destination WHERE tour_operator_id = :tour_operator_id");
            $req->execute([
                ":tour_operator_id" => $id
            ]);
            $destinations = $req->fetchAll();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($destinations !== []) {
            $destinationObjects = [];

            foreach ($destinations as $destination) {
                array_push($destinationObjects, new Destination($this->transformDbArrayForHydrate($destination)));
            }

            return $destinationObjects;
        } else {
            return null;
        }
    }


    public function createDestination(string $location, int $price, int $operatorId, string $img): ?Destination
    {
        $id = $this->getRandomIdForNewDestination();

        try {
            $req = $this->db->prepare("INSERT INTO destination(id, location, price, tour_operator_id, img_destination) VALUES(:id, :location, :price, :operatorId, :img)");
            $req->execute([
                ":id" => $id,
                ":location" => $location,
                ":price" => $price,
                ":operatorId" => $operatorId,
                ":img" => $img
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        return $this->getDestinationById($id);
    }


    public function updateDestination(Destination $destination): ?Destination
    {
        try {
            $req = $this->db->prepare("UPDATE destination SET location = :location, price = :price, tour_operator_id = :operatorId, img_destination = :img  WHERE id = :id");
            $req->execute([
                ":id" => $destination->getId(),
                ":location" => $destination->getLocation(),
                ":price" => $destination->getPrice(),
                ":operatorId" => $destination->getOperatorId(),
                ":img" => $destination->getImg()
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        return $this->getDestinationById($destination->getId());
    }


    public function deleteDestinationsById(int $id): bool
    {
        try {
            $req = $this->db->prepare("DELETE FROM destination WHERE tour_operator_id = :tour_operator_id");
            $req->execute([
                ":tour_operator_id" => $id
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        $destinationAfterDelete = $this->getDestinationById($id);

        if ($destinationAfterDelete === null) {
            return true;
        } else {
            return false;
        }
    }


    public function deleteDestinationsByLocation(string $location): bool
    {
        try {
            $req = $this->db->prepare("DELETE FROM destination WHERE location = :location");
            $req->execute([
                ":location" => $location
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        $destinationAfterDelete = $this->getDestinationByLocation($location);

        if ($destinationAfterDelete === null) {
            return true;
        } else {
            return false;
        }
    }


    public function deleteDestinationByOperatorId(int $id): bool
    {
        try {
            $req = $this->db->prepare("DELETE FROM destination WHERE id = :id");
            $req->execute([
                ":id" => $id
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        $destinationAfterDelete = $this->getDestinationsByOperatorId($id);

        if ($destinationAfterDelete === null) {
            return true;
        } else {
            return false;
        }
    }


    private function getRandomIdForNewDestination(): int
    {
        try {
            $getAllIds = $this->db->prepare('SELECT * FROM destination');
            $getAllIds->execute();
            $allIds = $getAllIds->fetchAll();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
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
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////END DESTINATION MANAGER////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////REVIEW MANAGER/////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
                array_push($reviewObjects, new Review($this->transformDbArrayForHydrate($review)));
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
            return new Review($this->transformDbArrayForHydrate($review));
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
                array_push($reviewObjects, new Review($this->transformDbArrayForHydrate($review)));
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
                array_push($reviewObjects, new Review($this->transformDbArrayForHydrate($review)));
            }

            return $reviewObjects;
        } else {
            return null;
        }
    }


    public function createReview(string $message, int $operatorId, int $authorId): ?Review
    {
        $id = $this->getRandomIdForNewReview();

        try {
            $req = $this->db->prepare("INSERT INTO review(id, message, tour_operator_id, author_id) VALUES (:id, :message, :tour_operator_id, :author_id)");
            $req->execute([
                ":id" => $id,
                ":message" => $message,
                ":tour_operator_id" => $operatorId,
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
                ":tour_operator_id" => $review->getOperatorId(),
                ":author_id" => $review->getAuthor()
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


    private function getRandomIdForNewReview(): int
    {
        try {
            $getAllIds = $this->db->prepare('SELECT * FROM review');
            $getAllIds->execute();
            $allIds = $getAllIds->fetchAll();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
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
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////END REVIEW MANAGER//////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////SCORE MANAGER//////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
                array_push($scoreObjects, new Score($this->transformDbArrayForHydrate($score)));
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
            return new Score($this->transformDbArrayForHydrate($score));
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
            return new Score($this->transformDbArrayForHydrate($score));
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
                array_push($scoreObjects, new Score($this->transformDbArrayForHydrate($score)));
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
                array_push($scoreObjects, new Score($this->transformDbArrayForHydrate($score)));
            }

            return $scoreObjects;
        } else {
            return null;
        }
    }


    public function createScore(int $value, int $operatorId, string $authorId): ?Score
    {
        $id = $this->getRandomIdForNewScore();

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
                ":operatorId" => $score->getOperatorId(),
                ":author_id" => $score->getAuthor()
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


    private function getRandomIdForNewScore(): int
    {
        try {
            $getAllIds = $this->db->prepare('SELECT * FROM score');
            $getAllIds->execute();
            $allIds = $getAllIds->fetchAll();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
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
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////END SCORE MANAGER///////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////TOUROPERATOR MANAGER////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function getAllTourOperator(): ?array
    {
        try {
            $req = $this->db->query("SELECT * FROM tour_operator");
            $tourOperators = $req->fetchAll();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($tourOperators !== []) {
            $tourOperatorObjects = [];

            foreach ($tourOperators as $tourOperator) {
                $tourOperator['certificate'] = $this->getCertificateByOperatorId($tourOperator['id']);
                $tourOperator['destinations'] = $this->getDestinationsByOperatorId($tourOperator['id']);
                $tourOperator['reviews'] = $this->getReviewByOperatorId($tourOperator['id']);
                $tourOperator['scores'] = $this->getScoreByOperatorId($tourOperator['id']);
                array_push($tourOperatorObjects, new TourOperator($this->transformDbArrayForHydrate($tourOperator)));
            }

            return $tourOperatorObjects;
        } else {
            return null;
        }
    }


    public function getAllTourOperatorByDestinationLocation(string $location): ?array
    {
        $destinationList  = $this->getDestinationByLocation($location);

        if ($destinationList !== null) {
            $operatorList = [];

            foreach ($destinationList as $destination) {
                $tourOperator = $this->getTourOperatorById($destination->getOperatorId());
                $tourOperator->setDestinations($destination);
                array_push($operatorList, $tourOperator);
            }

            return $operatorList;
        } else {
            return $destinationList;
        }
    }


    public function getTourOperatorById(int $id): ?TourOperator
    {
        try {
            $req = $this->db->prepare("SELECT * FROM tour_operator WHERE id = :id");
            $req->execute([
                ":id" => $id
            ]);
            $tourOperator = $req->fetch();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($tourOperator !== false) {
            $tourOperator['certificate'] = $this->getCertificateByOperatorId($tourOperator['id']);
            $tourOperator['destinations'] = $this->getDestinationsByOperatorId($tourOperator['id']);
            $tourOperator['reviews'] = $this->getReviewByOperatorId($tourOperator['id']);
            $tourOperator['scores'] = $this->getScoreByOperatorId($tourOperator['id']);

            return new TourOperator($this->transformDbArrayForHydrate($tourOperator));
        } else {
            return null;
        }
    }


    public function getTourOperatorByName(string $name): ?TourOperator
    {
        try {
            $req = $this->db->prepare("SELECT * FROM tour_operator WHERE name = :name");
            $req->execute([
                ":name" => $name
            ]);
            $tourOperator = $req->fetch();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($tourOperator !== false) {
            $tourOperator['certificate'] = $this->getCertificateByOperatorId($tourOperator['id']);
            $tourOperator['destinations'] = $this->getDestinationsByOperatorId($tourOperator['id']);
            $tourOperator['reviews'] = $this->getReviewByOperatorId($tourOperator['id']);
            $tourOperator['scores'] = $this->getScoreByOperatorId($tourOperator['id']);

            return new TourOperator($this->transformDbArrayForHydrate($tourOperator));
        } else {
            return null;
        }
    }


    public function createTourOperator(string $name, string $link, string $img): ?TourOperator
    {
        $id = $this->getRandomIdForNewTourOperator();

        try {
            $req = $this->db->prepare("INSERT INTO tour_operator(id, name, link, img) VALUES (:id, :name, :link, :img)");
            $req->execute([
                ":id" => $id,
                ":name" => $name,
                ":link" => $link,
                ":img" => $img
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        return $this->getTourOperatorById($id);
    }


    public function updateTourOperator(TourOperator $tourOperator): ?TourOperator
    {
        try {
            $req = $this->db->prepare("UPDATE tour_operator SET name = :name, link = :link, img = :img  WHERE id = :id");
            $req->execute([
                ":id" => $tourOperator->getId(),
                ":name" => $tourOperator->getName(),
                ":link" => $tourOperator->getLink(),
                ":img" => $tourOperator->getImg()
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        return $this->getTourOperatorById($tourOperator->getId());
    }


    public function deleteTourOperatorById(int $id): bool
    {
        try {
            $req = $this->db->prepare("DELETE FROM tour_operator WHERE id = :id");
            $req->execute([
                ":id" => $id
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        $tourOperatorAfterDelete = $this->getTourOperatorById($id);

        if ($tourOperatorAfterDelete === null) {
            return true;
        } else {
            return false;
        }
    }


    public function deleteTourOperatorByName(string $name): bool
    {
        try {
            $req = $this->db->prepare("DELETE FROM tour_operator WHERE name = :name");
            $req->execute([
                ":name" => $name
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        $tourOperatorAfterDelete = $this->getTourOperatorByName($name);

        if ($tourOperatorAfterDelete === null) {
            return true;
        } else {
            return false;
        }
    }


    private function getRandomIdForNewTourOperator(): int
    {
        try {
            $getAllIds = $this->db->prepare('SELECT * FROM tour_operator');
            $getAllIds->execute();
            $allIds = $getAllIds->fetchAll();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
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
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////END TOUROPERATOR MANAGER////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
}
