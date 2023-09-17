<?php

namespace Class\Manager;

use Class\OfferDestination;

trait OfferDestinationManager
{
    protected string $tableOfferDestination = "offer_destination";


    public function readOfferDestinationAll(): ?array
    {
        return $this->dbGetAll($this->tableOfferDestination);
    }


    public function readOfferDestinationById(int $id): ?OfferDestination
    {
        return $this->dbGetObjectById($this->tableOfferDestination, $id);
    }


    public function readOfferDestinationByDestinationId(int $destinationId): ?array
    {
        return $this->dbGetArrayBy($this->tableOfferDestination, "destination_id", $destinationId);
    }


    public function readOfferDestinationByTourOperatorId(int $tourOperatorId): ?array
    {
        return $this->dbGetArrayBy($this->tableOfferDestination, "tour_operator_id", $tourOperatorId);
    }


    public function createOfferDestination(int $destinationId, int $price, int $tourOperatorId): ?OfferDestination
    {
        return $this->dbInsert($this->tableOfferDestination, [
            ":offer_destination_id" => $this->getRandomIdForNewDbEntry($this->tableOfferDestination),
            ":destination_id" => $destinationId,
            ":price" => $price,
            ":tour_operator_id" => $tourOperatorId
        ]);
    }


    public function updateOfferDestination(OfferDestination $offerDestination): ?OfferDestination
    {
        return $this->dbUpdate($this->tableOfferDestination, "offer_destination_id", [
            ":offer_destination_id" => $offerDestination->getOfferDestinationId(),
            ":destination_id" => $offerDestination->getDestinationId(),
            ":price" => $offerDestination->getPrice(),
            ":tour_operator_id" => $offerDestination->getTourOperatorId()
        ]);
    }


    public function deleteOfferDestinationById(int $id): bool
    {
        return $this->dbDeleteBy($this->tableOfferDestination, "offer_destination_id", $id);
    }


    public function deleteOfferDestinationByDestinationId(int $destinationId): bool
    {
        return $this->dbDeleteBy($this->tableOfferDestination, "destination_id", $destinationId);
    }


    public function deleteOfferDestinationByTourOperatorId(string $tourOperatorId): bool
    {
        return $this->dbDeleteBy($this->tableOfferDestination, "tour_operator_id", $tourOperatorId);
    }
}
