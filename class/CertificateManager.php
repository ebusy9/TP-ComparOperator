<?php

namespace class;

trait CertificateManager
{
    public function getAllCertificate(): ?array
    {
        try {
            $req = $this->db->query("SELECT * FROM certificate");
            $certificates = $req->fetchAll();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($certificates !== []) {
            $certificateObjects = [];

            foreach ($certificates as $certificate) {
                array_push($certificateObjects, new Certificate($certificate));
            }

            return $certificateObjects;
        } else {
            return null;
        }
    }


    public function getCertificateByOperatorId(int $id): ?Certificate
    {
        try {
            $req = $this->db->prepare("SELECT * FROM certificate WHERE tour_operator_id = :tour_operator_id");
            $req->execute([
                ":tour_operator_id" => $id
            ]);
            $certificate = $req->fetch();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($certificate !== false) {
            return new Certificate($certificate);
        } else {
            return null;
        }
    }


    public function getCertificateBySignatory(string $signatory): ?array
    {
        try {
            $req = $this->db->prepare("SELECT * FROM certificate WHERE signatory = :signatory");
            $req->execute([
                ":signatory" => $signatory
            ]);
            $certificates = $req->fetchAll();
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        if ($certificates !== []) {
            $certificateObjects = [];

            foreach ($certificates as $certificate) {
                array_push($certificateObjects, new Certificate($certificate));
            }

            return $certificateObjects;
        } else {
            return null;
        }
    }


    public function createCertificate(int $operatorId, string $expireAt, string $signatory): ?Certificate
    {
        try {
            $req = $this->db->prepare("INSERT INTO certificate(tour_operator_id, expires_at, price, tour_operator_id, img_destination) VALUES(:operatorId, :expiresAt, :signatory)");
            $req->execute([
                ":operatorId" => $operatorId,
                ":expiresAt" => $expireAt,
                ":signatory" => $signatory,
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        return $this->getCertificateByOperatorId($operatorId);
    }


    public function updateCertificate(Certificate $certificate): ?Certificate
    {
        try {
            $req = $this->db->prepare("UPDATE certificate SET expires_at = :expires_at, signatory = :signatory, WHERE tour_operator_id = :tour_operator_id");
            $req->execute([
                ":tour_operator_id" => $certificate->getTourOperatorId(),
                ":expires_at" => $certificate->getExpiresAt(),
                ":signatory" => $certificate->getSignatory(),
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        return $this->getCertificateByOperatorId($certificate->getTourOperatorId());
    }


    public function deleteCertificateByOperatorId(int $id): bool
    {
        try {
            $req = $this->db->prepare("DELETE FROM certificate WHERE tour_operator_id = :tour_operator_id");
            $req->execute([
                ":tour_operator_id" => $id
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        $certificateAfterDelete = $this->getCertificateByOperatorId($id);

        if ($certificateAfterDelete === null) {
            return true;
        } else {
            return false;
        }
    }


    public function deleteCertificateSignatory(string $signatory): bool
    {
        try {
            $req = $this->db->prepare("DELETE FROM certificate WHERE signatory = :signatory");
            $req->execute([
                ":signatory" => $signatory
            ]);
        } catch (\PDOException $e) {
            $_SESSION[__METHOD__] = $e;
        }

        $certificateAfterDelete = $this->getCertificateBySignatory($signatory);

        if ($certificateAfterDelete === null) {
            return true;
        } else {
            return false;
        }
    }
}
