<?php

namespace Class\Manager;

use Class\User;

trait UserManager
{
    protected string $tableUser = "user";
    

    public function readUserAll(): ?array
    {
        return $this->dbGetAll($this->tableUser);
    }


    public function readUserById(int $id): ?User
    {
        return $this->dbGetObjectById($this->tableUser, $id);
    }


    public function readUserByUsername(string $username): ?User
    {
        $username = htmlspecialchars(strtolower($username));
        return $this->dbGetObjectBy($this->tableUser, "username", $username);
    }


    public function readUserByLogin(string $login): ?User
    {
        $login = htmlspecialchars(strtolower($login));
        return $this->dbGetObjectBy($this->tableUser, "login", $login);
    }


    public function readUserByIsAdmin(bool $isAdmin): ?array
    {
        $isAdmin = htmlspecialchars(strtolower($isAdmin));
        return $this->dbGetArrayBy($this->tableUser, "is_admin", $isAdmin);
    }


    public function createUser(string $login, string $password, string $username, bool $isAdmin = false): ?User
    {
        if ($isAdmin) {
            $isAdmin = 1;
        } else {
            $isAdmin = 0;
        }
        
        return $this->dbInsert($this->tableUser, [
            ":user_id" => $this->getRandomIdForNewDbEntry($this->tableUser), 
            ":login" => $login, 
            ":password" => password_hash($password, PASSWORD_DEFAULT), 
            ":username" => $username,
            ":registration_date" => date('Y-m-d H:i:s'),
            ":is_admin" => $isAdmin
        ]);
    }


    public function updateUser(User $user): ?User
    {
        if ($user->getIsAdmin()) {
            $isAdmin = 1;
        } else {
            $isAdmin = 0;
        }
        return $this->dbUpdate($this->tableUser, "user_id", [
            ":user_id" => $user->getUserId(), 
            ":login" => htmlspecialchars(strtolower($user->getLogin())), 
            ":password" => $user->getPassword(), 
            ":username" => htmlspecialchars(strtolower($user->getUsername())),
            ":registration_date" => $user->getRegistrationDate(),
            ":is_admin" => $isAdmin
        ]);
    }


    public function deleteUserById(int $id): bool
    {
        return $this->dbDeleteBy($this->tableUser, "user_id", $id);
    }
    

    public function deleteUserByLogin(string $login): bool
    {
        return $this->dbDeleteBy($this->tableUser, "login", htmlspecialchars(strtolower($login)));
    }


    public function deleteUserByUsername(string $username): bool
    {
        return $this->dbDeleteBy($this->tableUser, "username", htmlspecialchars(strtolower($username)));
    }
}