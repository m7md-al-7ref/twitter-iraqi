<?php

class UploadService
{
    private static array $allowedImages = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    /** يرفع صورة ويرجع المسار النسبي، أو null إذا ماكو ملف */
    public static function uploadImage(?array $file, string $folder): ?string
    {
        if (!$file || $file['error'] === UPLOAD_ERR_NO_FILE) return null;
        if ($file['error'] !== UPLOAD_ERR_OK) return null;

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, self::$allowedImages, true)) return null;

        // 5MB حد أقصى
        if ($file['size'] > 5 * 1024 * 1024) return null;

        $filename = uniqid('img_', true) . '.' . $ext;
        $destDir = __DIR__ . "/../../public/uploads/{$folder}/";
        if (!is_dir($destDir)) mkdir($destDir, 0755, true);

        $dest = $destDir . $filename;
        if (!move_uploaded_file($file['tmp_name'], $dest)) return null;

        return "uploads/{$folder}/{$filename}";
    }
}
