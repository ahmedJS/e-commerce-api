<?php

use EntitiesLibrary\DBAL;
use PHPUnit\Framework\TestCase;
require_once __DIR__."/../vendor/sergeytsalkov/meekrodb/db.class.php";

class DbalTest extends TestCase{

    public $initilizing = true;
    public MeekroDB $dbalCore;
    public DBAL $dbal;

    function setUp(): void
    {
        // here must have users table to test
        // its have only name and address and id
        if($this->initilizing)
        {
            $this->dbal = new DBAL([
                "host" => "localhost",
                "user" => "root",
                "password" => "root",
                "dbName" => "ecommerce"
            ]);

            $this->dbalCore = $this->dbal->getDeps()["dbLib"];
            $this->dbalCore->query("ALTER TABLE users AUTO_INCREMENT = 1");
    
            $this->table = "users";
            $this->initilizing = false;
        }
        
    }
    function testInsertData(){
        $inserted_id = $this->dbal->insert("users",["name"=>"ahmed","address"=>"karbala"]);
        $this->dbal->delete($this->table,["id"=>$inserted_id]);
        $this->assertNotNull($inserted_id);
    }

    function testGetDataBy(){
        $inserted_id = $this->dbal->insert("users",["name"=>"ahmed","address"=>"karbala"]);
        $result = $this->dbal->getBy(
            ["conditions"=>["id" => $inserted_id],"columns"=>array("address","name")]
            ,"users"
        );
        $this->dbal->delete($this->table,["id"=>$inserted_id]);
        $this->assertNotEmpty($result);
    }

    function testGettingDataById(){

        $inserted_id = $this->dbal->insert("users",["name"=>"ahmed","address"=>"karbala"]);

        $outcome = $this->dbal->get($inserted_id,$this->table);

        $this->dbal->delete($this->table,["id"=>$inserted_id]);

        $this->assertNotEmpty($outcome);

    }

    function testDeleteEntry(){
        $inserted_id = $this->dbal->insert("users",["name"=>"ahmed","address"=>"karbala"]);

        $condition = [
            "id" => $inserted_id
        ];
        $result = $this->dbal->delete($this->table,$condition);
        $this->assertTrue($result);
     }

     function testUpdateEntry(){
        $inserted_id = $this->dbal->insert("users",["name"=>"ahmed","address"=>"karbala"]);
        $condition = [
            "id" => $inserted_id
        ];
        $result = $this->dbal->update(
            $this->table,
            ["name"=>"abbas","address"=>"hulla"],
            $condition
        );
        $this->assertTrue($result);

        $this->dbal->delete($this->table,$condition);
     }
    function tearDown(): void
    {

    }
}



        // $this->dbalCore =  $this->dbal->getDeps()["dbLib"];
        

        // // create table
        // $this->dbalCore->query(
        //     "CREATE TABLE users(id int(10) primary key AUTO_INCREMENT,name varchar(20) , address varchar(20))"
        // );

                // $this->dbalCore->query(
        //     "DROP TABLE users"
        // );