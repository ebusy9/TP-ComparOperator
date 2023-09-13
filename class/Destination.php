<?php

namespace class;

class Destination
{
    private int $id;
    private string $location;
    private int $price;
    private int $operatorId;
    private string $img;


    public function __construct(array $data)
    {
        $this->hydrate($data);
    }


    public function hydrate(array $data): void
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
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


    public function getOperatorId(): int
    {
        return $this->operatorId;
    }


    public function setOperatorId(int $OperatorId): void
    {
        $this->operatorId = $OperatorId;
    }


    public function getImg(): string
    {
        return $this->img;
    }


    public function setImg(string $img): void
    {
        $this->img = $img;
    }
}
