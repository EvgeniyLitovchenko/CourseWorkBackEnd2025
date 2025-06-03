<?php

namespace models;

use classes\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $type_id
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string $created_at
 */
class Exhibitions extends Model
{
    public static $table = 'exhibitions';

    public function __construct()
    {
        parent::__construct();
    }

    public static function getExhibitions($typeId, $search, $page = 0, $limit = 10, $fromDate = null, $toDate = null)
    {
        $offset = $page * $limit;
        $condition = '';

        if (!empty($typeId)) {
            $condition .= "type_id = " . $typeId . " AND ";
        }

        if (!empty($search)) {
            $condition .= "title LIKE '%" . $search . "%' AND ";
        }

        if (!empty($fromDate)) {
            $condition .= "start_date >= '" . $fromDate . "' AND ";
        }
        if (!empty($toDate)) {
            $condition .= "end_date <= '" . $toDate . "' AND ";
        }
        if (!empty($condition)) {
            $condition = rtrim($condition, ' AND ');
        }
        if (empty($condition)) {
            return self::findAll($offset, $limit);
        }

        return self::findByCondition($condition, $offset, $limit);
    }

    public static function countExhibitions($typeId = null, $search = null, $fromDate = null, $toDate = null)
    {
        $condition = [];
        if (!empty($typeId)) {
            $condition['type_id'] = $typeId;
        }
        if (!empty($search)) {
            $condition['title'] = '%' . $search . '%';
        }
        if (!empty($fromDate)) {
            $condition['start_date'] = $fromDate;
        }
        if (!empty($toDate)) {
            $condition['end_date'] = $toDate;
        }

        if (!empty($condition)) {
            return self::countByCondition($condition);
        }
        return self::countAll();
    }
    public function fill(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    public static function deleteWithImages($id): void
    {
        $images = ExhibitionImages::findByCondition(['exhibition_id' => $id]);
        foreach ($images as $image) {
            ExhibitionImages::deleteWithFile($image['id']);
        }
        self::deleteById($id);
    }
}
