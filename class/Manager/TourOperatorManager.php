<?php

namespace Class\Manager;

use Class\TourOperator;

trait TourOperatorManager 
{
    protected string $tableTourOperator = "tour_operator";


    public function readTourOperatorAll(): ?array
    {
        return $this->dbGetAll($this->tableTourOperator);
    }


    public function readTourOperatorById(int $id): ?TourOperator
    {
        return $this->dbGetObjectById($this->tableTourOperator, $id);
    }


    public function readTourOperatorByName(string $name): ?TourOperator
    {
        return $this->dbGetObjectBy($this->tableTourOperator, "name", $name);
    }


    public function createTourOperator(string $name, string $link, string $img): ?TourOperator
    {
        return $this->dbInsert($this->tableTourOperator, [
            ":tour_operator_id" => $this->getRandomIdForNewDbEntry($this->tableTourOperator),
            ":name" => htmlspecialchars($name),
            ":link" => $link,
            ":tour_operator_img" => $img,
        ]);
    }


    public function updateTourOperator(TourOperator $tourOperator): ?TourOperator
    {
        return $this->dbUpdate($this->tableTourOperator, "tour_operator_id", [
            ":tour_operator_id" => $tourOperator->getTourOperatorId(),
            ":name" => htmlspecialchars($tourOperator->getName()),
            ":link" => $tourOperator->getLink(),
            ":tour_operator_img" => $tourOperator->getTourOperatorImg(),
        ]);
    }


    public function deleteTourOperatorById(int $id): bool
    {
        return $this->dbDeleteBy($this->tableTourOperator, "tour_operator_id", $id);
    }


    public function deleteTourOperatorByName(string $name): bool
    {
        return $this->dbDeleteBy($this->tableTourOperator, "name", $name);
    }
}