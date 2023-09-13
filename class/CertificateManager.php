<?php

namespace class;

class CertificateManager
{
    private \PDO $db;
    
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function getAllCertificate(): array
    {
        $req = $this->db->query("SELECT * FROM certificate");
        $certificates = $req->fetchAll();

        $certificateObjects = [];

        foreach ($certificates as $certificate) {

            array_push($certificateObjects, new Certificate($certificate));
        }

        return $certificateObjects;
    }

    public function getCertificateById(int $id): Certificate
    {
        $req = $this->db->prepare("SELECT * FROM certificate WHERE id = :id");
        $req->execute([
            ":id" => $id
        ]);
        $certificate = $req->fetch();

        $certificateObject = new Certificate($certificate);

        return $certificateObject;
    }

    public function getCertificateBySignatory(string $signatory): array
    {
        $req = $this->db->prepare("SELECT * FROM certificate WHERE signatory = :signatory");
        $req->execute([
            ":signatory" => $signatory
        ]);
        $certificates = $req->fetchAll();

        $certificateObjects = [];

        foreach ($certificates as $certificate) {

            array_push($certificateObjects, new Certificate($certificate));
        }

        return $certificateObjects;
    }

    public function createDestination(string $location, int $price, int $operatorId, string $img): Destination
    {
        $id = $this->getRandomIdForNewDestination();
        $data = [
            ":id" => $id,
            ":location" => $location,
            ":price" => $price,
            ":operatorId" => $operatorId,
            ":img" => $img
        ];

        $req = $this->db->prepare("INSERT INTO destination(id, location, price, tour_operator_id, img_destination) VALUES(:id, :location, :price, :operatorId, :img)");
        $req->execute($data);

        return new Destination($data);
    }



}
