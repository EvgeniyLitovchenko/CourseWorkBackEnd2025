<?php

namespace classes;

class Model
{
    protected $fieldsArray;
    protected static $primaryKey = 'id';
    protected static $table = '';
    public function __construct()
    {
        $this->fieldsArray = [];
    }
    public function save(): int
    {
        $value = $this->{static::$primaryKey} == null;
        if ($value) {
            return Core::getInstance()->db->insert(static::$table, $this->fieldsArray);
        } else {
            Core::getInstance()->db->update(static::$table, $this->fieldsArray,  [static::$primaryKey => $this->{static::$primaryKey}]);
            return $this->{static::$primaryKey};
        }
    }
    public static function deleteById(int $id)
    {
        Core::getInstance()->db->delete(static::$table, [static::$primaryKey => $id]);
    }
    public static function deleteByCondition($conditionAssocArray)
    {
        Core::getInstance()->db->delete(static::$table, $conditionAssocArray);
    }
    public static function findAll($offset = null, $limit = null)
    {
        $arr = Core::getInstance()->db->select(static::$table, '*', null, null, $limit, $offset);
        return $arr ?: [];
    }

    public static function findById(int $id)
    {
        $arr = Core::getInstance()->db->select(static::$table, '*', [static::$primaryKey => $id]);
        if (count($arr) > 0) {
            return $arr[0];
        } else {
            return null;
        }
    }
    public static function findByCondition($conditionAssocArray, $offset = null, $limit = null, $sort = null)
    {
        $arr = Core::getInstance()->db->select(static::$table, '*', $conditionAssocArray, $sort, $limit, $offset);
        return $arr ?: [];
    }
    public static function countAll()
    {
        return Core::getInstance()->db->count(static::$table);
    }
    public static function countByCondition($conditionAssocArray)
    {
        $count = Core::getInstance()->db->count(static::$table, $conditionAssocArray);
        return $count ?: 0;
    }
    public function __set($name, $value)
    {
        $this->fieldsArray[$name] = $value;
    }

    public function __get($name)
    {
        return $this->fieldsArray[$name] ?? null;
    }
}
