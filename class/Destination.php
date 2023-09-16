<?php

namespace class;

class Destination
{
    private int $id;
    private string $location;
    private int $price;
    private int $tourOperatorId;
    private string $imgDestination;


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


    public function getId(): int
    {
        return $this->id;
    }


    public function setId(int $id): void
    {
        $this->id = $id;
    }


    public function getLocation(): string
    {
        return $this->location;
    }


    public function setLocation(string $location): void
    {
        $this->location = $location;
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


    public function getImgDestination(): string
    {
        return $this->imgDestination;
    }


    public function setImgDestination(string $imgDestination): void
    {
        $this->imgDestination = $imgDestination;
    }
}
