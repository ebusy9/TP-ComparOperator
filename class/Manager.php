<?php

namespace class;

class Manager
{
    private \PDO $db;


    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }


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


    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////CERTIFICATE MANAGER/////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function getAllCertificate(): array
    {
        $req = $this->db->query("SELECT * FROM certificate");
        $certificates = $req->fetchAll();

        $certificateObjects = [];

        foreach ($certificates as $certificate) {

            array_push($certificateObjects, new Certificate($this->transformDbArrayForHydrate($certificate)));
        }

        return $certificateObjects;
    }


    public function getCertificateByOperatorId(int $id): ?Certificate
    {
        $req = $this->db->prepare("SELECT * FROM certificate WHERE tour_operator_id = :tour_operator_id");
        $req->execute([
            ":tour_operator_id" => $id
        ]);
        $certificate = $req->fetch();

        if ($certificate !== false) {
            return new Certificate($certificate = $this->transformDbArrayForHydrate($certificate));
        } else {
            return null;
        }
    }


    public function getCertificateBySignatory(string $signatory): array
    {
        $req = $this->db->prepare("SELECT * FROM certificate WHERE signatory = :signatory");
        $req->execute([
            ":signatory" => $signatory
        ]);
        $certificates = $req->fetchAll();

        $certificateObjects = [];

        foreach ($certificates as $certificate) {

            array_push($certificateObjects, new Certificate($this->transformDbArrayForHydrate($certificate)));
        }

        return $certificateObjects;
    }


    public function createCertificate(int $operatorId, string $expireAt, string $signatory): Certificate
    {
        $req = $this->db->prepare("INSERT INTO certificate(tour_operator_id, expires_at, price, tour_operator_id, img_destination) VALUES(:operatorId, :expiresAt, :signatory)");
        $req->execute([
            ":operatorId" => $operatorId,
            ":expiresAt" => $expireAt,
            ":signatory" => $signatory,
        ]);

        return $this->getCertificateByOperatorId($operatorId);
    }


    public function updateCertificate(Certificate $certificate): void
    {
        $req = $this->db->prepare("UPDATE certificate SET expires_at = :expires_at, signatory = :signatory, WHERE tour_operator_id = :tour_operator_id");
        $req->execute([
            ":tour_operator_id" => $certificate->getOperatorId(),
            ":expires_at" => $certificate->getExpiresAt(),
            ":signatory" => $certificate->getSignatory(),
        ]);
    }


    public function deleteCertificateByOperatorId(int $id): void
    {
        $req = $this->db->prepare("DELETE FROM certificate WHERE tour_operator_id = :tour_operator_id");
        $req->execute([
            ":tour_operator_id" => $id
        ]);
    }


    public function deleteCertificateSignatory(string $signatory): void
    {
        $req = $this->db->prepare("DELETE FROM certificate WHERE signatory = :signatory");
        $req->execute([
            ":signatory" => $signatory
        ]);
    }
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////END CERTIFICATE MANAGER/////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////DESTINATION MANAGER/////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function getAllDestinations(): array
    {
        $req = $this->db->query("SELECT * FROM destination");
        $destinations = $req->fetchAll();

        $destinationObjects = [];

        foreach ($destinations as $destination) {

            array_push($destinationObjects, new Destination($this->transformDbArrayForHydrate($destination)));
        }

        return $destinationObjects;
    }


    public function getDestinationById(int $id): Destination
    {
        $req = $this->db->prepare("SELECT * FROM destination WHERE id = :id");
        $req->execute([
            ":id" => $id
        ]);
        $destination = $req->fetch();

        $destinationObject = new Destination($this->transformDbArrayForHydrate($destination));

        return $destinationObject;
    }


    public function getDestinationByLocation(string $location): array
    {
        $req = $this->db->prepare("SELECT * FROM destination WHERE location = :location");
        $req->execute([
            ":location" => $location
        ]);
        $destinations = $req->fetchAll();

        $destinationObjects = [];

        foreach ($destinations as $destination) {
            array_push($destinationObjects, new Destination($this->transformDbArrayForHydrate($destination)));
        }

        return $destinationObjects;
    }


    public function getDestinationsByOperatorId(int $id): array
    {
        $req = $this->db->prepare("SELECT * FROM destination WHERE tour_operator_id = :tour_operator_id");
        $req->execute([
            ":tour_operator_id" => $id
        ]);
        $destinations = $req->fetchAll();

        $destinationObjects = [];

        foreach ($destinations as $destination) {

            array_push($destinationObjects, new Destination($this->transformDbArrayForHydrate($destination)));
        }

        return $destinationObjects;
    }


    public function createDestination(string $location, int $price, int $operatorId, string $img): Destination
    {
        $id = $this->getRandomIdForNewDestination();

        $req = $this->db->prepare("INSERT INTO destination(id, location, price, tour_operator_id, img_destination) VALUES(:id, :location, :price, :operatorId, :img)");
        $req->execute([
            ":id" => $id,
            ":location" => $location,
            ":price" => $price,
            ":operatorId" => $operatorId,
            ":img" => $img
        ]);

        return $this->getDestinationById($id);
    }


    public function updateDestination(Destination $destination): void
    {
        $req = $this->db->prepare("UPDATE destination SET location = :location, price = :price, tour_operator_id = :operatorId, img_destination = :img  WHERE id = :id");
        $req->execute([
            ":id" => $destination->getId(),
            ":location" => $destination->getLocation(),
            ":price" => $destination->getPrice(),
            ":operatorId" => $destination->getOperatorId(),
            ":img" => $destination->getImg()
        ]);
    }


    public function deleteDestinationsById(int $id): void
    {
        $req = $this->db->prepare("DELETE FROM destination WHERE tour_operator_id = :tour_operator_id");
        $req->execute([
            ":tour_operator_id" => $id
        ]);
    }


    public function deleteDestinationsByLocation(string $location): void
    {
        $req = $this->db->prepare("DELETE FROM destination WHERE location = :location");
        $req->execute([
            ":location" => $location
        ]);
    }


    public function deleteDestinationByOperatorId(int $id): void
    {
        $req = $this->db->prepare("DELETE FROM destination WHERE id = :id");
        $req->execute([
            ":id" => $id
        ]);
    }


    private function getRandomIdForNewDestination(): int
    {
        try {
            $getAllIds = $this->db->prepare('SELECT * FROM destination');
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
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////END DESTINATION MANAGER/////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////REVIEW MANAGER//////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function getAllReview(): array
    {
        $req = $this->db->query("SELECT * FROM review");
        $reviews = $req->fetchAll();

        $reviewObjects = [];

        foreach ($reviews as $review) {
            array_push($reviewObjects, new Review($this->transformDbArrayForHydrate($review)));
        }

        return $reviewObjects;
    }


    public function getReviewById(int $id): Review
    {
        $req = $this->db->prepare("SELECT * FROM review WHERE id = :id");
        $req->execute([
            ":id" => $id
        ]);
        $review = $req->fetch();
        return new Review($this->transformDbArrayForHydrate($review));
    }


    public function getReviewByAuthorId(int $id): array
    {
        $req = $this->db->prepare("SELECT * FROM review WHERE author_id = :author_id");
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
        $req = $this->db->prepare("SELECT * FROM review WHERE tour_operator_id = :tour_operator_id");
        $req->execute([
            ":tour_operator_id" => $id
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
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////END REVIEW MANAGER//////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////SCORE MANAGER///////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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

        return new Score($this->transformDbArrayForHydrate($score));
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


    public function createScore(int $value, int $operatorId, string $authorId): Score
    {
        $id = $this->getRandomIdForNewScore();

        $req = $this->db->prepare("INSERT INTO score(id, value, tour_operator_id, author_id) VALUES(:id, :value, :tour_operator_id, :author_id)");
        $req->execute([
            ":id" => $id,
            ":value" => $value,
            ":tour_operator_id" => $operatorId,
            ":author_id" => $authorId,
        ]);

        return $this->getScoreById($id);
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
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////END SCORE MANAGER///////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////TOUROPERATOR MANAGER////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function getAllTourOperator(): array
    {
        $req = $this->db->query("SELECT * FROM tour_operator");
        $tourOperators = $req->fetchAll();

        $tourOperatorObjects = [];

        foreach ($tourOperators as $tourOperator) {

            $tourOperator['certificate'] = $this->getCertificateByOperatorId($tourOperator['id']);
            $tourOperator['destinations'] = $this->getDestinationsByOperatorId($tourOperator['id']);
            $tourOperator['reviews'] = $this->getReviewByOperatorId($tourOperator['id']);
            $tourOperator['scores'] = $this->getScoreByOperatorId($tourOperator['id']);
            array_push($tourOperatorObjects, new TourOperator($this->transformDbArrayForHydrate($tourOperator)));
        }

        return $tourOperatorObjects;
    }


    public function getTourOperatorById(int $id): TourOperator
    {
        $req = $this->db->prepare("SELECT * FROM tour_operator WHERE id = :id");
        $req->execute([
            ":id" => $id
        ]);
        $tourOperator = $req->fetch();
        $tourOperator['certificate'] = $this->getCertificateByOperatorId($tourOperator['id']);
        $tourOperator['destinations'] = $this->getDestinationsByOperatorId($tourOperator['id']);
        $tourOperator['reviews'] = $this->getReviewByOperatorId($tourOperator['id']);
        $tourOperator['scores'] = $this->getScoreByOperatorId($tourOperator['id']);

        return new TourOperator($this->transformDbArrayForHydrate($tourOperator));
    }


    public function getTourOperatorByName(string $name): TourOperator
    {
        $req = $this->db->prepare("SELECT * FROM tour_operator WHERE name = :name");
        $req->execute([
            ":name" => $name
        ]);
        $tourOperator = $req->fetch();
        $tourOperator['certificate'] = $this->getCertificateByOperatorId($tourOperator['id']);
        $tourOperator['destinations'] = $this->getDestinationsByOperatorId($tourOperator['id']);
        $tourOperator['reviews'] = $this->getReviewByOperatorId($tourOperator['id']);
        $tourOperator['scores'] = $this->getScoreByOperatorId($tourOperator['id']);

        return new TourOperator($this->transformDbArrayForHydrate($tourOperator));
    }


    public function createTourOperator(string $name, string $link, string $img): TourOperator
    {
        $id = $this->getRandomIdForNewTourOperator();

        $req = $this->db->prepare("INSERT INTO tour_operator(id, name, link, img) VALUES (:id, :name, :link, :img)");
        $req->execute([
            ":id" => $id,
            ":name" => $name,
            ":link" => $link,
            ":img" => $img
        ]);

        return $this->getTourOperatorById($id);
    }


    public function updateTourOperator(TourOperator $tourOperator): void
    {
        $req = $this->db->prepare("UPDATE tour_operator SET name = :name, link = :link, img = :img  WHERE id = :id");
        $req->execute([
            ":id" => $tourOperator->getId(),
            ":name" => $tourOperator->getName(),
            ":link" => $tourOperator->getLink(),
            ":img" => $tourOperator->getImg()
        ]);
    }


    public function deleteTourOperatorById(int $id): void
    {
        $req = $this->db->prepare("DELETE FROM tour_operator WHERE id = :id");
        $req->execute([
            ":id" => $id
        ]);
    }


    public function deleteTourOperatorByName(string $name): void
    {
        $req = $this->db->prepare("DELETE FROM tour_operator WHERE name = :name");
        $req->execute([
            ":name" => $name
        ]);
    }


    private function getRandomIdForNewTourOperator(): int
    {
        try {
            $getAllIds = $this->db->prepare('SELECT * FROM tour_operator');
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
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////END TOUROPERATOR MANAGER////////////////////////////////////////////////////////////
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 

}
