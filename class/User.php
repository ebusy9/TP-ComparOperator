<?php

namespace Class;

class User
{
    private int $userId;
    private string $login;
    private string $password;
    private string $username;
    private string $registrationDate;
    private bool $isAdmin;


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


    public function getUserId(): int
    {
        return $this->userId;
    }


    private function setUserId(int $userId): void
    {
        $this->userId = $userId;        
    }


    public function getLogin(): string
    {
        return $this->login;
    }


    public function setLogin(string $login): void
    {
        $this->login = $login;
    }


    public function getPassword(): string
    {
        return $this->password;
    }


    public function setPassword(string $password): void
    {
        $this->password = $password;
    }


    public function getUsername(): string
    {
        return $this->username;
    }


    public function setUsername(string $username): void
    {
        $this->username = $username;
    }


    public function getRegistrationDate(): string
    {
        return $this->registrationDate;
    }


    private function setRegistrationDate(string $registrationDate): void
    {
        $this->registrationDate = $registrationDate; 
    }


    public function getIsAdmin(): bool
    {
        return $this->isAdmin;
    }


    public function setIsAdmin(bool $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
    }
}
