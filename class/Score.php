<?php

namespace class;

class Score
{
    private int $id;
    private int $value;
    private int $operatorId;
    private int $author;


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


    public function getValue(): int
    {
        return $this->value;
    }


    public function setValue(int $value): void
    {
        $this->value = $value;
    }


    public function getOperatorId(): int
    {
        return $this->operatorId;
    }


    public function setOperatorId(int $operatorId): void
    {
        $this->operatorId = $operatorId;
    }


    public function getAuthor(): int
    {
        return $this->author;
    }


    public function setAuthor(int $author): void
    {
        $this->author = $author;
    }
}
