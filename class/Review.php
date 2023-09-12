<?php

namespace class;

class Review {

    private int $id;
    private string $message;
    private int $author;
    private int $operatorId;

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

    
    
    public function getMessage(): string
    {
        return $this->message;
    }

    
    
    public function setMessage(string $message): void
    {
        $this->message = $message;

    }

   
    
    public function getAuthor(): int
    {
        return $this->author;
    }

    
    public function setAuthor(int $author): void
    {
        $this->author = $author;

    }


    public function getOperatorId(): int
    {
        return $this->operatorId;
    }

   
    public function setOperatorId(int $operatorId): void
    {
        $this->operatorId = $operatorId;

    }
}