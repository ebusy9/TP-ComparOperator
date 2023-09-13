<?php

namespace class;

class ReviewManager
{
    private \PDO $db;
    
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

}
