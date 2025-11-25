<?php
class TaskModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(Task $task): ?int
    {
        $stmt = $this->pdo->prepare("INSERT INTO tasks (user_id, title, content, status_id, ended_at, created_at) VALUES (:user_id,:title,:content,:status_id,:ended_at, NOW())");
        $ok = $stmt->execute([
            ':user_id' => $task->getUserId(),
            ':title' => $task->getTitle(),
            ':content' => $task->getContent(),
            ':status_id' => $task->getStatusId(),
            ':ended_at' => $task->getEndedAt(),
        ]);

        if (!$ok)
            return null;
        return (int) $this->pdo->lastInsertId();
    }

    public function update(Task $task): bool
    {
        if ($task->getId() === null)
            return false;
        $stmt = $this->pdo->prepare("UPDATE tasks SET title = :title, content = :content, status_id = :status_id, ended_at = :ended_at WHERE id = :id AND user_id = :user_id");
        return $stmt->execute([
            ':title' => $task->getTitle(),
            ':content' => $task->getContent(),
            ':status_id' => $task->getStatusId(),
            ':ended_at' => $task->getEndedAt(),
            ':id' => $task->getId(),
            ':user_id' => $task->getUserId(),
        ]);
    }

    public function delete(int $id, int $userId): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM tasks WHERE id = :id AND user_id = :user_id");
        return $stmt->execute([':id' => $id, ':user_id' => $userId]);
    }

    public function findById(int $id, int $userId): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM tasks WHERE id = :id AND user_id = :user_id LIMIT 1");
        $stmt->execute([':id' => $id, ':user_id' => $userId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function findAllByUser(int $userId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM tasks WHERE user_id = :user_id ORDER BY created_at DESC");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}