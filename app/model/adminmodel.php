<?php
namespace APP\MODEL;

class AdminModel extends AbstractModel
{


    public $id;
    public $name;
    public $age;

    protected static $tableName = 'admin';
    
    protected static $tableSchema = array(
        'name'      => self::DATA_TYPE_STR,
        'age'       => self::DATA_TYPE_INT,
    );

    protected static $primaryKey = 'id';


    public function __construct($name, $age){

        $this->name = $name;
        $this->age = $age;
    }
}