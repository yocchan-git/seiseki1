<?php
class Database
{
    public static function dbConnect(){
        $dbName = 'rkmcl_school';
        $host = 'mysql93.conoha.ne.jp';
        $user = 'rkmcl_school';
        $password = 'school&2525';
        $dsh = "mysql:dbname=$dbName;host=$host;charset=utf8mb4";

        try{
            $db = new PDO($dsh, $user, $password);
        }catch(PDOException $e){
            echo 'DB接続エラー' . $e->getMessage();
            exit();
        }
        return $db;
    }
}

?>