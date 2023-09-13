<?php

namespace class;

class CertificateManager
{
    private \PDO $db;
    
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

}
