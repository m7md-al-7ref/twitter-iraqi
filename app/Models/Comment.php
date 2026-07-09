<?php

class Comment
{
    public static function create(int $postId, int $userId, string $text): int
    {
        $stmt = db()->prepare(
            "INSERT INTO comments (post_id, user_id, comment) VALUES (?, ?, ?)"
        );
        $stmt->execute([$postId, $userId, $text]);
        return (int) db()->lastInsertId();
    }

    public static function forPost(int $postId): array
    {
        $stmt = db()->prepare(
            "SELECT comments.*, users.name, users.username, users.avatar
             FROM comments JOIN users ON users.id = comments.user_id
             WHERE post_id = ? ORDER BY comments.created_at ASC"
        );
        $stmt->execute([$postId]);
        return $stmt->fetchAll();
    }

    public static function delete(int $id, int $userId): bool
    {
        $stmt = db()->prepare("DELETE FROM comments WHERE id = ? AND user_id = ?");
        return $stmt->execute([$id, $userId]);
    }
}
