<?php

namespace Class;

class Author
{
    private int $authorId;
    private string $authorName;
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


    private function transformToSetter(string $arrayKey): string
    {
        $words = explode('_', $arrayKey);
        $camelCaseName = implode('', array_map('ucfirst', $words));
        return 'set' . $camelCaseName;
    }


    public function getAuthorId(): int
    {
        return $this->authorId;
    }


    private function setAuthorId(int $authorId): void
    {
        $this->authorId = $authorId;
    }


    public function getAuthorName(): string
    {
        return ucwords($this->authorName);
    }


    public function setAuthorName(string $authorName): void
    {
        $this->authorName = $authorName;
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
