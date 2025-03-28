<?php
require MODEL_PATH . 'BaseModel.php';

class TheaterModel extends BaseModel
{
     public function __construct($db)
     {
          parent::__construct($db, 'theaters');
     }

     public function addTheater($name, $address, $capacity)
     {
          $data = [
               'name' => $name,
               'address' => $address,
               'capacity' => $capacity
          ];

          return $this->add($data);
     }

     public function updateTheater($id, $name, $address, $capacity)
     {
          $data = [
               'name' => $name,
               'address' => $address,
               'capacity' => $capacity,
               'id' => $id
          ];
          return $this->update($id, $data);
     }

     public function deleteTheater($id)
     {
          return $this->delete($id);
     }

     public function searchTheater($keyword)
     {
          return $this->search('name', $keyword);
     }



     // User--------------------------------------------
     public function getRoomsByTheater($theaterId)
     {
          $query = "
               SELECT r.*
               FROM rooms r
               WHERE r.theater_id = :theater_id
               ORDER BY r.name ASC
               ";

          try {
               $stmt = $this->conn->prepare($query);
               $stmt->bindParam(':theater_id', $theaterId, PDO::PARAM_INT);
               $stmt->execute();
               $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

               return $rooms;

          } catch (Exception $e) {
               return [];
          }
     }
}
?>