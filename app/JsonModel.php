<?php
/**
 * JSON Model file
 * 
 * @category Models
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */
namespace App;

/**
 * JSON Model class
 * 
 * @category Models
 * @author   Pieterjan Fiers <pjfiers@gmail.com>
 * @version  0.1
 */
abstract class JsonModel
{
    /**
     * JSON file name
     *
     * @var string
     */
    protected static $filename = '';

    /**
     * Read json file and return as collection
     *
     * @return void
     */
    final protected static function collection()
    {
        $json = file_get_contents(
            __DIR__ . '/../database/data/' . static::$filename . '.json'
        );
        $data = json_decode($json);
        $collection = array();
        foreach ($data->items as $entry) {
            $entity = new static();
            foreach ($entry as $key => $value) {
                $entity->{$key} = $value;
            }
            $collection[] = $entity;
        }
        
        return $collection;
    }

    /**
     * Return complete collection
     *
     * @return void
     */
    final public static function all()
    {
        return static::collection();
    }

    /**
     * Find one entity by ID
     *
     * @param [type] $id Entity-ID
     * 
     * @return object|bool
     */
    final public static function find($id)
    {
        $collection = static::collection();
        foreach ($collection as $entity) {
            if ($entity->id === $id) {
                return $entity;
            }
        }

        return false;
    }
}
