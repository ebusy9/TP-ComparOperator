<?php

namespace Class;

class Review
{
    private int $reviewId;
    private ?string $message;
    private int $score;
    private int $tourOperatorId;
    private int $authorId;


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


    public function getReviewId(): int
    {
        return $this->reviewId;
    }


    private function setReviewId(int $reviewId): void
    {
        $this->reviewId = $reviewId;
    }


    public function getMessage(): ?string
    {
        return $this->message;
    }


    public function setMessage(?string $message): void
    {
        $this->message = $message;
    }

    public function getScore(): int
    {
        return $this->score;
    }


    public function setScore(int $score): void
    {
        $this->score = $score;
    }


    public function getAuthorId(): int
    {
        return $this->authorId;
    }


    public function setAuthorId(int $authorId): void
    {
        $this->authorId = $authorId;
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
