<?php

namespace App;

class JsonModel
{
    protected static $filename = '';

    protected static function collection()
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

    public static function all()
    {
        return static::collection();
    }

    public static function find($id)
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
