<?php

namespace Class;

class TourOperator
{
    private int $tourOperatorId;
    private string $name;
    private string $link;
    private string $tourOperatorImg;
    private ?Certificate $certificate;
    private mixed $offerDestination;
    private ?array $review;


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

    
    public function getCertificateStatus(): string
    {
        $certificate = $this->getCertificate();
        if ($certificate === null) {
            return "basic";
        } else {
            $expirationTimestamp = strtotime($certificate->getExpiresAt());
            $currentTimestamp = time();
            if ($expirationTimestamp <= $currentTimestamp) {
                return "expired";
            } elseif ($expirationTimestamp > $currentTimestamp) {
                return "premium";
            }
        }
    }


    private function transformToSetter(string $arrayKey): string
    {
        $words = explode('_', $arrayKey);
        $camelCaseName = implode('', array_map('ucfirst', $words));
        return 'set' . $camelCaseName;
    }


    public function getTourOperatorId(): int
    {
        return $this->tourOperatorId;
    }


    private function setTourOperatorId(int $tourOperatorId): void
    {
        $this->tourOperatorId = $tourOperatorId;
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


    public function getTourOperatorImg(): string
    {
        return $this->tourOperatorImg;
    }


    public function setTourOperatorImg(string $tourOperatorImg): void
    {
        $this->tourOperatorImg = $tourOperatorImg;
    }


    public function setCertificate(?Certificate $certificate): void
    {
        $this->certificate = $certificate;
    }


    public function getOfferDestination(): mixed
    {
        return $this->offerDestination;
    }


    public function setOfferDestination(mixed $offerDestination): void
    {
        $this->offerDestination = $offerDestination;
    }


    public function getReview(): ?array
    {
        return $this->review;
    }


    public function setReview(?array $review): void
    {
        $this->review = $review;
    }
}
