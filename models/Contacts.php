<?php

namespace models;

use classes\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $value
 * @property string $updated_at
 */
class Contacts extends Model
{
    public static $table = 'contacts';

    public function __construct()
    {
        parent::__construct();
    }

    public static function getContactsAssoc(): array
    {
        $rows = self::findAll();
        $assoc = [];

        foreach ($rows as $row) {
            $assoc[$row['name']] = $row['value'];
        }
        return $assoc;
    }
}
