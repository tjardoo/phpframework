<?php

declare(strict_types=1);

namespace App\Models;

use App\Model;

class Task extends Model
{
    public function all(): array
    {
        return $this->db->createQueryBuilder()
            ->select('id', 'user_id', 'description', 'completed_at')
            ->from('tasks')
            ->fetchAllAssociative();
    }

    public function create(...$data): int
    {
        $this->db->insert('tasks', $data[0]);

        return (int) $this->db->lastInsertId();
    }

    public function find(int $taskId): array
    {
        $task = $this->db->createQueryBuilder()
            ->select('id', 'user_id', 'description', 'completed_at')
            ->from('tasks')
            ->where('id = ?')
            ->setParameter(0, $taskId)
            ->fetchAssociative();

        return $task ?? [];
    }
}
