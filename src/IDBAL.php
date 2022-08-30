<?php
namespace EntitiesLibrary;
interface IDBAL {
    function get(int $id,string $table):array;
    function insert(string $table,array $payload) : int;
    function delete(string $table , array $condition) : bool;
    function update(string $table , array $payload , array $condition) : bool;
}