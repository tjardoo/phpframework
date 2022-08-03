<?php

declare(strict_types=1);

namespace App\Models;

use App\Model;

class User extends Model
{
    public function create(string $email, string $firstName, string $lastName, bool $isActive = true): int
    {
        $statement = $this->db->prepare(
            'INSERT INTO users
            (email, first_name, last_name, is_active)
            VALUES (?, ?, ?, ?)'
        );

        $statement->execute([$email, $firstName, $lastName, $isActive]);

        return (int) $this->db->lastInsertedId();
    }

    public function find(int $userId): array
    {
        $statement = $this->db->prepare('SELECT * from users WHERE id=?');

        $statement->execute([$userId]);

        $user = $statement->fetch();

        return $user ?? [];
    }
}
