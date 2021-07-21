<?php
namespace Catalyst;

/**
 * To store the information of the table
 */
class MYSQLTableDef{
    private string $DBName;
    private string $tableName;
    private array $fieldDef;

    /**
     * Bunch of getter/setter
     */
    public function getDBName():string
    {
        return $this->DBName;
    }
    public function getTableName():string
    {
        return $this->tableName;
    }
    public function getFieldDef():array
    {
        return $this->fieldDef;
    }
    public function getHeader():array
    {
        return array_keys($this->fieldDef);
    }
    public function setDBName(string $DBName)
    {
        $this->DBName = $DBName;
    }
    public function setTableName(string $tableName)
    {
        $this->tableName = $tableName;
    }
    public function setFieldDef(array $fieldDef)
    {
        $this->fieldDef = $fieldDef;
    }
    
}
?>