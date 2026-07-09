<?php

class Post
{
    public static function create(int $userId, ?string $content, ?string $image = null, ?string $video = null): int
    {
        $stmt = db()->prepare(
            "INSERT INTO posts (user_id, content, image, video) VALUES (?, ?, ?, ?)"
        );
        $stmt->execute([$userId, $content, $image, $video]);
        return (int) db()->lastInsertId();
    }

    public static function find(int $id): ?array
    {
        $stmt = db()->prepare(
            "SELECT posts.*, users.name, users.username, users.avatar
             FROM posts JOIN users ON users.id = posts.user_id
             WHERE posts.id = ?"
        );
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function delete(int $id, int $userId): bool
    {
        $stmt = db()->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
        return $stmt->execute([$id, $userId]);
    }

    /** التغريدات لصفحة الرئيسية: تغريدات المستخدم + تغريدات اللي يتابعهم */
    public static function feedFor(int $userId, int $limit = 30, int $offset = 0): array
    {
        $sql = "SELECT posts.*, users.name, users.username, users.avatar,
                    (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id) AS likes_count,
                    (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count,
                    (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id AND likes.user_id = ?) AS liked_by_me
                FROM posts
                JOIN users ON users.id = posts.user_id
                WHERE posts.user_id = ?
                   OR posts.user_id IN (SELECT following_id FROM follows WHERE follower_id = ?)
                ORDER BY posts.created_at DESC
                LIMIT ? OFFSET ?";
        $stmt = db()->prepare($sql);
        $stmt->bindValue(1, $userId, PDO::PARAM_INT);
        $stmt->bindValue(2, $userId, PDO::PARAM_INT);
        $stmt->bindValue(3, $userId, PDO::PARAM_INT);
        $stmt->bindValue(4, $limit, PDO::PARAM_INT);
        $stmt->bindValue(5, $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /** كل التغريدات (صفحة استكشاف) */
    public static function explore(int $viewerId, int $limit = 30): array
    {
        $sql = "SELECT posts.*, users.name, users.username, users.avatar,
                    (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id) AS likes_count,
                    (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count,
                    (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id AND likes.user_id = ?) AS liked_by_me
                FROM posts
                JOIN users ON users.id = posts.user_id
                ORDER BY posts.created_at DESC
                LIMIT ?";
        $stmt = db()->prepare($sql);
        $stmt->bindValue(1, $viewerId, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function byUser(int $userId, int $viewerId): array
    {
        $sql = "SELECT posts.*, users.name, users.username, users.avatar,
                    (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id) AS likes_count,
                    (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) AS comments_count,
                    (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id AND likes.user_id = ?) AS liked_by_me
                FROM posts
                JOIN users ON users.id = posts.user_id
                WHERE posts.user_id = ?
                ORDER BY posts.created_at DESC";
        $stmt = db()->prepare($sql);
        $stmt->execute([$viewerId, $userId]);
        return $stmt->fetchAll();
    }
}
