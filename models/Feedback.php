<?php

namespace models;

use classes\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $message
 * @property string $created_at
 */
class Feedback extends Model
{
    public static $table = 'feedback';

    public function __construct()
    {
        parent::__construct();
    }
}
