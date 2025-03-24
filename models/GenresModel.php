<?php
require_once MODEL_PATH . 'BaseModel.php';

class GenresModel extends BaseModel
{
     public function __construct($db)
     {
          parent::__construct($db, 'genres');
     }


     public function addGenres($name)
     {
          $data = [
               'name' => $name
          ];

          return $this->add($data);
     }
     public function updateGenres($id, $name)
     {
          $currentGenre = $this->getById($id);
          $data = [
               'name' => $name
          ];
          return $this->update($id, $data);
     }

     public function deleteGenres($id)
     {
          return $this->delete($id);
     }


     public function searchGenres($keyword)
     {
          return $this->search('name', $keyword);
     }
}



?>