<?php

class User
{
    public static function find(int $id): ?array
    {
        $stmt = db()->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    public static function findByUsername(string $username): ?array
    {
        $stmt = db()->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch() ?: null;
    }

    public static function findByEmail(string $email): ?array
    {
        $stmt = db()->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() ?: null;
    }

    public static function create(array $data): int
    {
        $stmt = db()->prepare(
            "INSERT INTO users (name, username, email, password, bio) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $data['name'],
            $data['username'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['bio'] ?? null,
        ]);
        return (int) db()->lastInsertId();
    }

    public static function update(int $id, array $fields): void
    {
        $set = [];
        $values = [];
        foreach ($fields as $col => $val) {
            $set[] = "{$col} = ?";
            $values[] = $val;
        }
        $values[] = $id;
        $sql = "UPDATE users SET " . implode(', ', $set) . " WHERE id = ?";
        db()->prepare($sql)->execute($values);
    }

    public static function search(string $q): array
    {
        $stmt = db()->prepare(
            "SELECT * FROM users WHERE name LIKE ? OR username LIKE ? LIMIT 20"
        );
        $term = "%{$q}%";
        $stmt->execute([$term, $term]);
        return $stmt->fetchAll();
    }

    public static function followersCount(int $userId): int
    {
        $stmt = db()->prepare("SELECT COUNT(*) FROM follows WHERE following_id = ?");
        $stmt->execute([$userId]);
        return (int) $stmt->fetchColumn();
    }

    public static function followingCount(int $userId): int
    {
        $stmt = db()->prepare("SELECT COUNT(*) FROM follows WHERE follower_id = ?");
        $stmt->execute([$userId]);
        return (int) $stmt->fetchColumn();
    }

    public static function postsCount(int $userId): int
    {
        $stmt = db()->prepare("SELECT COUNT(*) FROM posts WHERE user_id = ?");
        $stmt->execute([$userId]);
        return (int) $stmt->fetchColumn();
    }
}
