<?php

namespace APP\MODEL;
use APP\LIB\DATABASE\PDODatabaseHandler;

class AbstractModel
{
    const DATA_TYPE_BOOL        = \PDO::PARAM_BOOL;
    const DATA_TYPE_STR         = \PDO::PARAM_STR;
    const DATA_TYPE_INT         = \PDO::PARAM_INT;
    const DATA_TYPE_DECIMAL     = 4;

    private function prepareValue(\PDOStatement &$stm) {
        foreach (static::viewTableSchema() as $column => $type) {

            if($type == 4) {
                $sanitizeF = filter_var($this->$column, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $stm->bindValue(":{$column}", $sanitizeF);
            } else {
                $stm->bindValue(":{$column}", $this->$column, $type); // ربط الاعمدة مع المتغيرات و تحديد نوعه
            }
        }
    }

    public static function viewTableSchema(){
        return static::$tableSchema;
    }

    // Column Data Base
    private static function columnDataBase() {
        $col = '';
        foreach(static::viewTableSchema() as $column => $type) {
            $col .= $column . ' = :' . $column . ', ';
        }
        return trim($col, ', ');
    }

    // Create
    private function create(){
        
        $sql = 'INSERT INTO ' . static::$tableName . ' SET ' . static::columnDataBase();
        $stm = PDODatabaseHandler::factory()->prepare($sql);
        $this->prepareValue($stm);

        if($stm->execute())
        {
            $this->{static::$primaryKey} = PDODatabaseHandler::factory()->lastInsertId();
            return true;
        }

        return false;
    }

    // Update
    private function update(){
       
        $sql = 'UPDATE ' . static::$tableName . ' SET ' . static::columnDataBase() . ' WHERE ' . static::$primaryKey . ' =' . $this->{static::$primaryKey};
        $stm = PDODatabaseHandler::factory()->prepare($sql);
        $this->prepareValue($stm);
        return $stm->execute();
    }

    // Delete
    public function delete() {

        $sql = 'DELETE FROM '. static::$tableName . ' WHERE ' . static::$primaryKey . ' = ' . $this->{static::$primaryKey};
        
        $stm = PDODatabaseHandler::factory()->prepare($sql);
        return $stm->execute();
    }


    // Get All Data Of DATABASE
    public static function getAll() {
               
        $sql = 'SELECT * FROM ' . static::$tableName;
        $stm = PDODatabaseHandler::factory()->prepare($sql);

        if($stm->execute() === true) {
            $ob = $stm->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class(), array_keys(static::viewTableSchema()));
            return $ob;
        } else {
            return false;
        }
    }

    // Get All Data Of DATABASE
    public static function pKey($pk) {

        $sql = 'SELECT * FROM ' . static::$tableName . ' WHERE ' . static::$primaryKey . ' = "' . $pk . '"';
        $stm = PDODatabaseHandler::factory()->prepare($sql);
        if($stm->execute() === true)
        {
            $ob = $stm->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, get_called_class(), array_keys(static::viewTableSchema()));
            return !empty($ob) ? array_shift($ob) : false;
        } 
            return false;
    }

    public function save() {
        return $this->{static::$primaryKey} == null ? $this->create() : $this->update();
    }
    
    
    
}