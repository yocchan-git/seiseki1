<?php
require_once(__DIR__ . '/../db/dbconnection.php');

class Student{
    private ?PDO $db;

    public function __construct(){
        $this->db = Database::dbConnect();
    }

    public function update(array $params)
    {
        $statement = $this->db->prepare('update students set class_id=?, number=?, name=?, create_at=NOW() where id=?');
        $statement->execute(array(
            $params['class_id'],
            $params['number'],
            $params['name'],
            $params['id']
        ));
    }

    public function delete($params)
    {
        $statement = $this->db->prepare('DELETE from students where id=?');
        $statement->execute(array(
            $params['id']
        ));
    }
}
?>