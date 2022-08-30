<?php 
namespace EntitiesLibrary;
use DB;
use MeekroDB;
use mysqli_sql_exception;

require_once __DIR__."/../vendor/sergeytsalkov/meekrodb/db.class.php";
class DBAL implements IDBAL,IGetDBALInfo {
    private  MeekroDB $dbLib;
    function __construct(array $connection_options)
    {
        $this->getConnection(
            $connection_options["host"],
            $connection_options["user"],
            $connection_options["password"],
            $connection_options["dbName"]
        );
    }
    
    function getConnection($host, $user, $password, $dbName) : void{
        $this->dbLib = new MeekroDB($host, $user, $password, $dbName);
    }

    /**
     * @return array one dimintional array contains columns and its value
     */
    function get(int $id,string $table) : array{
        $outcome = array();
        $outcome = $this->dbLib->query(
            "SELECT * FROM %l WHERE id = %i",
            $table,
            $id
        );
        return $outcome;
    }


    function insert(string $table,array $payload) : int{
        $this->dbLib->insert($table,$payload);
        return (int) $this->dbLib->insert_id;
    }

    function delete(string $table , array $condition) : bool {
        $condition = $this->arrayToConditionLine($condition);
        return (bool) $this->dbLib->delete($table,$condition);
        
    }

    function update(string $table , array $payload , array $condition) : bool 
    {
        $condition = $this->arrayToConditionLine($condition);
        $result = $this->dbLib->update($table,$payload,$condition);
        return (bool) $result;
        
    }

    /**
     * @param array $payload `must` contain these keys as a mandatory
     * key `conditions` which is associative array contain `field` => `to be`
     * key `columns` which is numerical array contain columns `that required`
     * @deprecated 
     */
    function getBy(array $payloads,string $table) : array {

        $conditions = $this->arrayToConditionLine($payloads["conditions"]);
        $columns = $this->arrayToStrSepartedHyphen($payloads["columns"]);

        return $this->dbLib->query
            (
            "SELECT %l FROM %l WHERE %l",
            $columns,
            $table,
            $conditions
            );
    }

    private function arrayToStrSepartedHyphen($array) : string{
        return implode(",",$array);
    }

    /**
     * @param array $array an `associative array` contains condition => value pairs
     * @return string the processed array into literal mysql literal
     */
    private function arrayToConditionLine(array $array) : string{
        $result = "";
        $first_loop = true;
            foreach($array as $key => $val)
            {
                // its must val be sanitized well

                if(!$first_loop){
                    $result .= "and";
                }else {
                    $first_loop = false;
                }
                $result .= $key."="."'".$val."'";
            }
        return $result;
    }

    function getDeps() : array{

        /**
         * @var MeekroDB
         */
        $db_lib = $this->dbLib;

        return [
            "dbLib" => $db_lib
        ];
    }
}

