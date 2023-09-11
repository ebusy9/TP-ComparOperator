<?php

namespace class;

class Score {

    private int $id;
    private int $value;
    private int $author;

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



    public function getAuthor(): int
    {
        return $this->author;
    }



    public function setAuthor(int $author): void
    {
        $this->author = $author;

    }
}