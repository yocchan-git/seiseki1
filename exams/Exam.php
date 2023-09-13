<?php
require_once(__DIR__ . '/../db/dbconnection.php');

class Exam{
    private ?PDO $db;

    public function __construct(){
        $this->db = Database::dbConnect();
    }

    public function update(array $params)
    {
        $statement = $this->db->prepare('update exams set kokugo=?, sugaku=?,eigo=?,rika=?,shakai=?,goukei=?, create_at=NOW() where id=?');
        $statement->execute(array(
            $params['kokugo'],
            $params['sugaku'],
            $params['eigo'],
            $params['rika'],
            $params['shakai'],
            $params['goukei'],
            $params['id']
        ));
    }

    public function delete($params)
    {
        $statement = $this->db->prepare('DELETE from exams where id=?');
        $statement->execute(array(
            $params['id']
        ));
    }
}
?>