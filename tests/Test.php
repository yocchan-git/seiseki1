<?php
require_once(__DIR__ . '/../db/dbconnection.php');

class Test{
    private ?PDO $db;

    public function __construct(){
        $this->db = Database::dbConnect();
    }

    public function update(array $params)
    {
        $statement = $this->db->prepare('update tests set year=?, name=?, create_at=NOW() where id=?');
        $statement->execute(array(
            $params['year'],
            $params['name'],
            $params['id']
        ));
    }

    public function delete($params)
    {
        $statement = $this->db->prepare('DELETE from tests where id=?');
        $statement->execute(array(
            $params['id']
        ));
    }
}
?>
