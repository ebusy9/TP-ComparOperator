<?php

namespace class;

class Review
{
    private int $id;
    private string $message;
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


    public function getId(): int
    {
        return $this->id;
    }


    public function setId(int $id): void
    {
        $this->id = $id;
    }


    public function getMessage(): string
    {
        return $this->message;
    }


    public function setMessage(string $message): void
    {
        $this->message = $message;
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
