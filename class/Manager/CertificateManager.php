<?php

namespace Class\Manager;

use Class\Certificate;

trait CertificateManager
{
    protected string $tableCertificate = "certificate";


    public function readCertificateAll(): ?array
    {
        return $this->dbGetAll($this->tableCertificate);
    }


    public function readCertificateByTourOperatorId(int $tourOperatorId): ?Certificate
    {
        return $this->dbGetObjectBy($this->tableCertificate, "tour_operator_id", $tourOperatorId);
    }


    public function readCertificateBySignatory(string $signatory): ?array
    {
        return $this->dbGetArrayBy($this->tableCertificate, "signatory", $signatory);
    }


    public function createCertificate(int $tourOperatorId, string $expireAt, string $signatory): ?Certificate
    {
        return $this->dbInsert($this->tableCertificate, [
            ":tour_operator_id" => $tourOperatorId,
            ":expires_at" => $expireAt,
            ":signatory" => $signatory
        ]);
    }


    public function updateCertificate(Certificate $certificate): ?Certificate
    {
        return $this->dbUpdate($this->tableCertificate, "tour_operator_id", [
            ":tour_operator_id" => $certificate->getTourOperatorId(),
            ":expires_at" => $certificate->getExpiresAt(),
            ":signatory" => $certificate->getSignatory()
        ]);
    }


    public function deleteCertificateByTourOperatorId(int $id): bool
    {
        return $this->dbDeleteBy($this->tableCertificate, "tour_operator_id", $id);
    }


    public function deleteCertificateBySignatory(string $signatory): bool
    {
        return $this->dbDeleteBy($this->tableCertificate, "signatory", $signatory);
    }
}
