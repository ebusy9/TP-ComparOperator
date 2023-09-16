<?php

namespace class;


trait TourOperatorManager 
{
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
                array_push($tourOperatorObjects, new TourOperator($tourOperator));
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
            $destinationsWithLowestPriceList = [];

            foreach ($destinationList as $destination) {
                $operatorId = $destination->getOperatorId();

                if (isset($destinationsWithLowestPriceList[$operatorId])) {
                    $currentPrice = $destinationsWithLowestPriceList[$operatorId]->getPrice();
                    $potentialPrice = $destination->getPrice();

                    if ($currentPrice > $potentialPrice) {
                        $destinationsWithLowestPriceList[$operatorId] = $destination;
                    }
                } else {
                    $destinationsWithLowestPriceList[$operatorId] = $destination;
                }
            }

            $destinationsWithLowestPriceList = array_values($destinationsWithLowestPriceList);

            $operatorList = [];

            foreach ($destinationsWithLowestPriceList as $destination) {
                $operator = $this->getTourOperatorById($destination->getOperatorId());
                $_SESSION["R"] = $operator;
                $operator->setDestinations($destination);
                array_push($operatorList, $operator);
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

            return new TourOperator($tourOperator);
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

            return new TourOperator($tourOperator);
        } else {
            return null;
        }
    }


    public function createTourOperator(string $name, string $link, string $img): ?TourOperator
    {
        $id = $this->getRandomIdForNewDbEntry("tour_operator");

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
}