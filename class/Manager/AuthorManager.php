<?php

namespace Class\Manager;

use Class\Author;

trait AuthorManager //reviews manquants, finir
{
    protected string $tableAuthor = "author";


    public function readAuthorAll(): ?array
    {
        return $this->dbGetAll($this->tableAuthor);
    }


    public function readAuthorById(int $id): ?Author
    {
        return $this->dbGetObjectById($this->tableAuthor, $id);
    }


    public function readAuthorByName(string $name): ?Author
    {
        $name = htmlspecialchars(strtolower($name));
        return $this->dbGetObjectBy($this->tableAuthor, "author_name", $name);
    }


    public function createAuthor(string $name): ?Author
    {
        return $this->dbInsert($this->tableAuthor, [
            ":author_id" => $this->getRandomIdForNewDbEntry($this->tableAuthor), 
            ":author_name" => htmlspecialchars(strtolower($name))
        ]);
    }


    public function updateAuthor(Author $author): ?Author
    {
        return $this->dbUpdate($this->tableAuthor, "author_id", [
            ":author_id" => $author->getAuthorId(), 
            ":author_name" => htmlspecialchars(strtolower($author->getAuthorName()))
        ]);
    }


    public function deleteAuthorById(int $id): bool
    {
        return $this->dbDeleteBy($this->tableAuthor, "author_id", $id);
    }


    public function deleteAuthorByName(string $name): bool
    {
        return $this->dbDeleteBy($this->tableAuthor, "author_name", htmlspecialchars(strtolower($name)));
    }
}
