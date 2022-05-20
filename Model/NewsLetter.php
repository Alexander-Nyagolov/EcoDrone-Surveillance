<?php
namespace Phppot;

use \Phppot\DataSource;

class NewsLetter
{

    private $ds;

    function __construct()
    {
        require_once __DIR__ . './../lib/DataSource.php';
        $this->ds = new DataSource();
    }

    public function getAllRecords()
    {
        $query = 'select * from Language';
        $result = $this->ds->select($query);
        return $result;
    }
}
