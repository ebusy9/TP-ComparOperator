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

            array_push($certificateObjects, new Certificate($this->transformDbArrayForHydrate($certificate)));
        }

        return $certificateObjects;
    }

    public function getCertificateByOperatorId(int $id): Certificate
    {
        $req = $this->db->prepare("SELECT * FROM certificate WHERE tour_operator_id = :tour_operator_id");
        $req->execute([
            ":tour_operator_id" => $id
        ]);
        $certificate = $req->fetch();

        $certificateObject = new Certificate($this->transformDbArrayForHydrate($certificate));

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

            array_push($certificateObjects, new Certificate($this->transformDbArrayForHydrate($certificate)));
        }

        return $certificateObjects;
    }

    public function createCertificate(int $operatorId, string $expireAt, string $signatory): Certificate
    {
        $data = [
            ":operatorId" => $operatorId,
            ":expiresAt" => $expireAt,
            ":signatory" => $signatory,
        ];
        $req = $this->db->prepare("INSERT INTO certificate(tour_operator_id, expires_at, price, tour_operator_id, img_destination) VALUES(:operatorId, :expiresAt, :signatory)");
        $req->execute($data);

        return new Certificate($data);
    }


    private function transformDbArrayForHydrate(array $data): array
    {

        $data['operatorId'] = $data['tour_operator_id'];
        unset($arr['tour_operator_id']);
        $data['expiresAt'] = $data['expires_at'];
        unset($arr['expires_at']);

        return $data;
    }
}
