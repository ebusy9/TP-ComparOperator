<?php

namespace Class;

class OfferDestination
{
    private int $offerDestinationId;
    private int $destinationId;
    private int $price;
    private int $tourOperatorId;


    public function __construct(array $data)
    {
        $this->hydrate($data);
    }


    public function hydrate(array $data): void
    {
        foreach ($data as $key => $value) {
            $method = $this->transformToSetter($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }


    private function transformToSetter(string $arrayKey): string
    {
        $words = explode('_', $arrayKey);
        $camelCaseName = implode('', array_map('ucfirst', $words));
        return 'set' . $camelCaseName;
    }


    public function getOfferDestinationId(): int
    {
        return $this->offerDestinationId;
    }


    private function setOfferDestinationId(int $offerDestinationId): void
    {
        $this->offerDestinationId = $offerDestinationId;
    }


    public function getDestinationId(): int
    {
        return $this->destinationId;
    }


    public function setDestinationId(int $destinationId): void
    {
        $this->destinationId = $destinationId;
    }


    public function getPrice(): int
    {
        return $this->price;
    }


    public function setPrice(int $price): void
    {
        $this->price = $price;
    }


    public function getTourOperatorId(): int
    {
        return $this->tourOperatorId;
    }


    public function setTourOperatorId(int $tourOperatorId): void
    {
        $this->tourOperatorId = $tourOperatorId;
    }
}
