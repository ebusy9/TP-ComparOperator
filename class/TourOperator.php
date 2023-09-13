<?php

namespace class;

class TourOperator {

    private int $id;
    private string $name;
    private string $link;
    private string $img;
    private bool $certificate;
    private array $destinations;
    private array $reviews;
    private array $scores;
    

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this,$method)) {
                $this->$method($value);
            }
        }
    }


   
    public function getId(): int
    {
        return $this->id;
    }

 
    public function setId($id): void 
    {
        $this->id = $id;

    }

   
    public function getName(): string
    {
        return $this->name;
    }

 
    public function setName($name): void 
    {
        $this->name = $name;

       
    }

   
    public function getLink(): string
    {
        return $this->link;
    }

    
    public function setLink($link): void
    {
        $this->link = $link;

       
    }

   
    public function getCertificate(): bool
    {
        return $this->certificate;
    }

    
    public function setCertificate($certificate): void
    {
        $this->certificate = $certificate;

       
    }

   
    public function getDestinations(): array
    {
        return $this->destinations;
    }

    
    public function setDestinations($destinations): void
    {
        $this->destinations = $destinations;

        
    }

  
    public function getReviews(): array
    {
        return $this->reviews;
    }

   
    public function setReviews($reviews): void
    {
        $this->reviews = $reviews;

        
    }

   
    public function getScores(): array
    {
        return $this->scores;
    }

   
    public function setScores($scores): void
    {
        $this->scores = $scores;

        
    }
}