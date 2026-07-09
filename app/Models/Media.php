<?php

class Media
{
    public static function attach(int $postId, string $file, string $type = 'image'): int
    {
        $stmt = db()->prepare("INSERT INTO media (post_id, file, type) VALUES (?, ?, ?)");
        $stmt->execute([$postId, $file, $type]);
        return (int) db()->lastInsertId();
    }

    public static function forPost(int $postId): array
    {
        $stmt = db()->prepare("SELECT * FROM media WHERE post_id = ?");
        $stmt->execute([$postId]);
        return $stmt->fetchAll();
    }
}
