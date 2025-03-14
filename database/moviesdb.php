<?php
class Database
{
    public $dbconnection;
    public function __construct()
    {
        $this->dbconnection = new mysqli("localhost", "root", "", "movies_db");
        if ($this->dbconnection->connect_error) {
            die("Connection failed: " . $this->dbconnection->connect_error);
        }
    }
}
