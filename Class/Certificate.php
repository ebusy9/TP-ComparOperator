<?php

namespace Class;

class Certificate
{
    private int $tourOperatorId;
    private string $expiresAt;
    private string $signatory;


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


    public function getTourOperatorId(): int
    {
        return $this->tourOperatorId;
    }


    public function setTourOperatorId(int $tourOperatorId): void
    {
        $this->tourOperatorId = $tourOperatorId;
    }


    public function getExpiresAt(): string
    {
        return $this->expiresAt;
    }


    public function setExpiresAt(string $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }


    public function getSignatory(): string
    {
        return $this->signatory;
    }


    public function setSignatory(string $signatory): void
    {
        $this->signatory = $signatory;
    }
}
