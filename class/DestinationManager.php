<?php

namespace class;

class DestinationManager
{
    private \PDO $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function getAllDestinations(): array
    {
        $req = $this->db->query("SELECT * FROM destination");
        $destinations = $req->fetchAll();

        $destinationObjects = [];

        foreach ($destinations as $destination) {

            array_push($destinationObjects, new Destination($destination));
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

        $destinationObject = new Destination($destination);

        return $destinationObject;
    }

    public function getDestinationByLocation(string $location): Destination
    {
        $req = $this->db->prepare("SELECT * FROM destination WHERE location = :location");
        $req->execute([
            ":location" => $location
        ]);
        $destination = $req->fetch();
        $destinationObject = new Destination($destination);

        return $destinationObject;
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

            array_push($destinationObjects, new Destination($destination));
        }

        return $destinationObjects;
    }

    public function createDestination(string $location, int $price, int $operatorId, string $img): Destination
    {
        $id = $this->getRandomIdForNewDestination();
        $data = [
            ":id" => $id,
            ":location" => $location,
            ":price" => $price,
            ":operatorId" => $operatorId,
            ":img" => $img
        ];

        $req = $this->db->prepare("INSERT INTO destination(id, location, price, tour_operator_id, img_destination) VALUES(:id, :location, :price, :operatorId, :img)");
        $req->execute($data);

        return new Destination($data);
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
}
