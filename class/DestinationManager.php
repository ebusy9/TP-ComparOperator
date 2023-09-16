<?php

namespace class;

trait DestinationManager
{
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
                array_push($destinationObjects, new Destination($destination));
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
                        $uniqueDestinationList[$destination->getLocation()] = $destination;
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
            $destinationObject = new Destination($destination);

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
                array_push($destinationObjects, new Destination($destination));
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
                array_push($destinationObjects, new Destination($destination));
            }

            return $destinationObjects;
        } else {
            return null;
        }
    }


    public function createDestination(string $location, int $price, int $operatorId, string $img): ?Destination
    {
        $id = $this->getRandomIdForNewDbEntry("destination");

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
                ":operatorId" => $destination->getTourOperatorId(),
                ":img" => $destination->getImgDestination()
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
}
