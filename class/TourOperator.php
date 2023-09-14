<?php

namespace class;

class TourOperator
{
    private int $id;
    private string $name;
    private string $link;
    private string $img;
    private ?Certificate $certificate;
    private mixed $destinations;
    private ?array $reviews;
    private ?array $scores;


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


    public function getName(): string
    {
        return $this->name;
    }


    public function setName(string $name): void
    {
        $this->name = $name;
    }


    public function getLink(): string
    {
        return $this->link;
    }


    public function setLink(string $link): void
    {
        $this->link = $link;
    }


    public function getCertificate(): ?Certificate
    {
        return $this->certificate;
    }


    public function setCertificate(?Certificate $certificate): void
    {
        $this->certificate = $certificate;
    }


    public function getDestinations(): mixed
    {
        return $this->destinations;
    }


    public function setDestinations(mixed $destinations): void
    {
        $this->destinations = $destinations;
    }


    public function getReviews(): ?array
    {
        return $this->reviews;
    }


    public function setReviews(?array $reviews): void
    {
        $this->reviews = $reviews;
    }


    public function getScores(): ?array
    {
        return $this->scores;
    }


    public function setScores(?array $scores): void
    {
        $this->scores = $scores;
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
