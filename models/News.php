<?php

namespace models;

use classes\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $excerpt
 * @property string $content
 * @property string|null $image
 * @property string $published_at
 * @property string $created_at
 */
class News extends Model
{
    public static $table = 'news';

    public function __construct()
    {
        parent::__construct();
    }

    public static function getNews($page = 0, $limit = 10, $sort = 'published_at DESC')
    {
        $offset = $page * $limit;
        return self::findByCondition(null, $offset, $limit, $sort);
    }
    public static function countNews()
    {
        return self::countAll();
    }
    public function fill(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }
}
