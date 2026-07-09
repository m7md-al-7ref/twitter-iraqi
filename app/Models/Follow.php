<?php

class Follow
{
    public static function toggle(int $followerId, int $followingId): bool
    {
        if ($followerId === $followingId) return false;

        $stmt = db()->prepare("SELECT id FROM follows WHERE follower_id = ? AND following_id = ?");
        $stmt->execute([$followerId, $followingId]);
        $existing = $stmt->fetch();

        if ($existing) {
            db()->prepare("DELETE FROM follows WHERE id = ?")->execute([$existing['id']]);
            return false;
        }

        db()->prepare("INSERT INTO follows (follower_id, following_id) VALUES (?, ?)")
            ->execute([$followerId, $followingId]);
        return true;
    }

    public static function isFollowing(int $followerId, int $followingId): bool
    {
        $stmt = db()->prepare("SELECT id FROM follows WHERE follower_id = ? AND following_id = ?");
        $stmt->execute([$followerId, $followingId]);
        return (bool) $stmt->fetch();
    }

    public static function suggestions(int $userId, int $limit = 5): array
    {
        $stmt = db()->prepare(
            "SELECT * FROM users
             WHERE id != ?
               AND id NOT IN (SELECT following_id FROM follows WHERE follower_id = ?)
             ORDER BY RAND() LIMIT ?"
        );
        $stmt->bindValue(1, $userId, PDO::PARAM_INT);
        $stmt->bindValue(2, $userId, PDO::PARAM_INT);
        $stmt->bindValue(3, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
