<?php

namespace class;

class Manager {

    private \PDO $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function getAllDestinations()
    {
      
        $destinations = [];

        
        $query = "SELECT * FROM destination";
        $result = $this->db->query($query);

        if ($result) {
            $rows = $result->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                $DestinationsData = [
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'hunger' => $row['hunger'],
                    'species_id' => $row['species_id'],
                    'energy' => $row['energy'],
                    'age' => $row['age'],
                    'height' => $row['height'],
                    'weight' => $row['weight'],
                ];

                $destination = new Destination($DestinationsData);
                $destinations[] = $animal;
            }

    } 

    public function getOperatorByDestination()
    {

    } 

    public function createReview()
    {

    }

    public function getReviewsByOperator()
    {

    }

    public function getAllOperators()
    {

    }

    public function updateOperatorToPrenium()
    {

    }

    public function createTourOperator()
    {

    }

    public function createDestination()
    {
        
    }

    
}