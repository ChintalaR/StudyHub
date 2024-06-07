<?php

namespace Modifier;
require_once('db.class.php');

use Db;

class Modify
{
    public $conn;

    public function __construct()
    {
        $this->conn = new Db();
    }

    public function modify()
    {
        $years = glob('../Materials/*', GLOB_ONLYDIR);
        $data = [];
        foreach ($years as $y) {
            $year=array_push($data, explode('/', $y)[2]);
            $sems = glob($y . '/*', GLOB_ONLYDIR);
            $data[$year]= [];
            foreach ($sems as $sem) {
                array_push($data[$year],explode('/', $sem)[3]);
            }
        }
        return $data;
//        $images = glob($song . '/*.{jpeg,jpg,png,bmp}', GLOB_BRACE);
//        $directories = glob('../Categories/*', GLOB_ONLYDIR);
    }
}