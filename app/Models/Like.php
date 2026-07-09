<?php

class Like
{
    /** @return bool true إذا صار لايك، false إذا انشال اللايك */
    public static function toggle(int $postId, int $userId): bool
    {
        $stmt = db()->prepare("SELECT id FROM likes WHERE post_id = ? AND user_id = ?");
        $stmt->execute([$postId, $userId]);
        $existing = $stmt->fetch();

        if ($existing) {
            db()->prepare("DELETE FROM likes WHERE id = ?")->execute([$existing['id']]);
            return false;
        }

        db()->prepare("INSERT INTO likes (post_id, user_id) VALUES (?, ?)")->execute([$postId, $userId]);
        return true;
    }

    public static function isLiked(int $postId, int $userId): bool
    {
        $stmt = db()->prepare("SELECT id FROM likes WHERE post_id = ? AND user_id = ?");
        $stmt->execute([$postId, $userId]);
        return (bool) $stmt->fetch();
    }

    public static function count(int $postId): int
    {
        $stmt = db()->prepare("SELECT COUNT(*) FROM likes WHERE post_id = ?");
        $stmt->execute([$postId]);
        return (int) $stmt->fetchColumn();
    }
}
