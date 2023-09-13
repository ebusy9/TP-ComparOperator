<?php

namespace class;

class TourOperatorManager
{
    private \PDO $db;
    
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

}
