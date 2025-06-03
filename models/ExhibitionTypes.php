<?php

namespace models;

use classes\Model;

/**
 * @property int $id
 * @property string $name
 */
class ExhibitionTypes extends Model
{
    public static $table = 'exhibition_types';

    public function __construct()
    {
        parent::__construct();
    }
}
