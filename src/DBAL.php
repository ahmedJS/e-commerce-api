<?php 
namespace EntitiesLibrary;
use Envms\FluentPDO\Query;
use PDO;

class DBAL {
    private  $queryBuilder;
    function __construct()
    {
    }
    
    function createConnection(){
        $pdo_con = new PDO("mysql:host=localhost;dbname=ecommerce","root","root");
        $this->queryBuilder = new Query($pdo_con);
    }

    function get($id){}
    function getBy($payloads){}
    function insert(string $table,array $payload){}
    function delete(string $table , array $condition){}
    function update(string $table , array $payloads){}
    
}
