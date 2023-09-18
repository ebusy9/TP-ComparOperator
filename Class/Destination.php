<?php

namespace Class;

class Destination
{
    private int $destinationId;
    private string $destinationName;
    private string $destinationImg;


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


    public function getDestinationId(): int
    {
        return $this->destinationId;
    }


    private function setDestinationId(int $destinationId)
    {
        $this->destinationId = $destinationId;
    }


    public function getDestinationName(): string
    {
        return ucwords($this->destinationName);
    }


    public function setDestinationName(string $destinationName)
    {
        $this->destinationName = $destinationName;
    }


    public function getDestinationImg(): string
    {
        return $this->destinationImg;
    }


    public function setDestinationImg(string $destinationImg)
    {
        $this->destinationImg = $destinationImg;
    }
}
