<?php

namespace class;

class TourOperatorManager
{
    private \PDO $db;
    
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function getAllTourOperator(): array
    {
        $req = $this->db->query("SELECT * FROM tour_operator");
        $tourOperators = $req->fetchAll();

        $tourOperatorObjects = [];

        foreach ($tourOperators as $tourOperator) {

            array_push($tourOperatorObjects, new TourOperator($tourOperator));
        }

        return $tourOperatorObjects;
    }

    private function getRandomIdForNewTourOperator(): int
    {
        try {
            $getAllIds = $this->db->prepare('SELECT * FROM tour_operator');
            $getAllIds->execute();
            $allIds = $getAllIds->fetchAll();
        } catch (\PDOException $ex) {
            $_SESSION['ex_Manager_getAllIds'] = $ex;
        }

        $takenIdList = [];

        foreach ($allIds as $id) {
            array_push($takenIdList, $id['id']);
        }

        $id = rand(1, 99999);

        while (in_array($id, $takenIdList, true)) {
            $id = rand(1, 99999);
        }

        return $id;
    }

    // private function transformDbArrayForHydrate(array $data): array
    // {

    //     $data['operatorId'] = $data['tour_operator_id'];
    //     unset($data['tour_operator_id']);
    //     $data['img'] = $data['img_destination'];
    //     unset($data['img_destination']);

    //     return $data;
    // }
}
