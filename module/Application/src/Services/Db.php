<?php

namespace Application\Services;

use Zend\Db\Adapter\Adapter;

class Db
{
    private static $instance = null;
    private $adapter;

    public function __construct()
    {
        $this->adapter = new Adapter([
            'driver' => 'Pdo_Sqlite',
            'database' => getcwd() . '/data/data.db'
        ]);
    }

    public static function inst()
    {
        if (self::$instance == null) {
            self::$instance = new Db();
        }

        return self::$instance;
    }

    public function getAdapter()
    {
        return $this->adapter;
    }
}