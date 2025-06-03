<?php

namespace models;

use classes\Model;

/**
 * @property int $id
 * @property int $exhibition_id
 * @property string $image_path
 * @property string|null $caption
 * @property string $created_at
 */
class ExhibitionImages extends Model
{
    public static $table = 'exhibition_images';

    public function __construct()
    {
        parent::__construct();
    }

    public static function findByExhibitionId($exhibitionId)
    {
        return self::findByCondition(['exhibition_id' => $exhibitionId]) ?: [];
    }
    public static function uploadImages($exhibitionId, array $files): void
    {
        if (!isset($files['tmp_name'])) return;

        $uploadDir = __DIR__ . '/../public/images/exhibitions/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        foreach ($files['tmp_name'] as $index => $tmpName) {
            if ($files['error'][$index] !== UPLOAD_ERR_OK) continue;

            $originalName = basename($files['name'][$index]);
            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
            $uniqueName = uniqid('img_') . '.' . $extension;

            $destinationPath = $uploadDir . $uniqueName;
            $publicPath = '../public/images/exhibitions/' . $uniqueName;

            if (move_uploaded_file($tmpName, $destinationPath)) {
                $image = new self();
                $image->image_path = $publicPath;
                $image->exhibition_id = $exhibitionId;
                $image->save();
            }
        }
    }

    public static function deleteWithFile($id): void
    {
        $image = self::findById($id);
        if (!$image) return;

        $filePath = str_replace('../', '', $image['image_path']);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        self::deleteById($id);
    }
}
