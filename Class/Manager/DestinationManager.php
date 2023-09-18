<?php

namespace Class\Manager;

use Class\Destination;

trait DestinationManager
{
    protected string $tableDestination = "destination";


    public function readDestinationAll(): ?array
    {
        return $this->dbGetAll($this->tableDestination);
    }


    public function readDestinationById(int $id): ?Destination
    {
        return $this->dbGetObjectById($this->tableDestination, $id);
    }


    public function readDestinationByName(string $name): ?Destination
    {
        return $this->dbGetObjectBy($this->tableDestination, "destination_name", htmlspecialchars(strtolower($name)));
    }


    public function createDestination(string $name, string $img): ?Destination
    {
        return $this->dbInsert($this->tableDestination, [
            ":destination_id" => $this->getRandomIdForNewDbEntry($this->tableDestination), 
            ":destination_name" => htmlspecialchars(strtolower($name)), 
            ":destination_img" => $img
        ]);
    }


    public function updateDestination(Destination $destination): ?Destination
    {
        return $this->dbUpdate($this->tableDestination, "destination_id", [
            ":destination_id" => $destination->getDestinationId(), 
            ":destination_name" =>  htmlspecialchars(strtolower($destination->getDestinationName())), 
            ":destination_img" => $destination->getDestinationImg()
        ]);
    }


    public function deleteDestinationById(int $id): bool
    {
        return $this->dbDeleteBy($this->tableDestination, "destination_id", $id);
    }


    public function deleteDestinationByName(string $name): bool
    {
        return $this->dbDeleteBy($this->tableDestination, "destination_name", $name);
    }
}
