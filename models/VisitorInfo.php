<?php

namespace models;

use classes\Model;

/**
 * @property int $id
 * @property string $category
 * @property string $content
 * @property string $updated_at
 */
class VisitorInfo extends Model
{
    public static $table = 'visitor_info';

    public function __construct()
    {
        parent::__construct();
    }
}
