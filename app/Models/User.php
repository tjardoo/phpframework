<?php

declare(strict_types=1);

namespace App\Models;

use App\Model;

class User extends Model
{
    public function all(): array
    {
        return $this->db->createQueryBuilder()
            ->select('id', 'email', 'first_name', 'last_name', 'is_active', 'created_at')
            ->from('users')
            ->fetchAllAssociative();
    }

    public function create(...$data): int
    {
        $this->db->insert('users', $data[0]);

        return (int) $this->db->lastInsertId();
    }

    // public function create(string $email, string $firstName, string $lastName, bool $isActive = true): int
    // {
    //     $statement = $this->db->prepare(
    //         'INSERT INTO users
    //         (email, first_name, last_name, is_active)
    //         VALUES (?, ?, ?, ?)'
    //     );

    //     $statement->execute([$email, $firstName, $lastName, (int) $isActive]);

    //     return (int) $this->db->lastInsertId();
    // }

    public function find(int $userId): array
    {
        $user = $this->db->createQueryBuilder()
            ->select('id', 'email', 'first_name', 'last_name', 'is_active', 'created_at')
            ->from('users')
            ->where('id = ?')
            ->setParameter(0, $userId)
            ->fetchAssociative();

        return $user ?? [];
    }
}
