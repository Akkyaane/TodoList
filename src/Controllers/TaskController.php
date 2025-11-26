<?php

require_once __DIR__ . '/../Models/TaskModel.php';
require_once __DIR__ . '/../Classes/Task.php';

class TaskController
{
    private TaskModel $model;

    public function __construct(PDO $pdo)
    {
        $this->model = new TaskModel($pdo);
    }

    public function create(Task $task): array
    {
        $errors = $task->validate();
        if (!empty($errors)) {
            return ['success' => false, 'messages' => $errors];
        }

        $now = date('Y-m-d H:i:s');

        if ($task->getStatusId() === 3 && empty($task->getEndedAt())) {
            $task->setEndedAt($now);
        }

        $ended = $task->getEndedAt();
        if (!empty($ended) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $ended)) {
            $task->setEndedAt($ended . ' 00:00:00');
        }

        $id = $this->model->create($task);
        if ($id === null) {
            return ['success' => false, 'messages' => ['Erreur lors de la création.']];

        }

        $task->setId($id);
        return ['success' => true, 'messages' => ['Tâche créée.'], 'task' => $task];
    }

    public function update(Task $task): array
    {
        $errors = $task->validate();
        if (!empty($errors)) {
            return ['success' => false, 'messages' => $errors];
        }

        $prev = $this->model->findById((int) $task->getId(), $task->getUserId());
        $now = date('Y-m-d H:i:s');

        if ($prev) {
            $newStatus = $task->getStatusId();

            if ($newStatus === 3) {
                if (!empty($task->getEndedAt())) {
                } elseif (!empty($prev['ended_at'])) {
                    $task->setEndedAt($prev['ended_at']);
                } else {
                    $task->setEndedAt($now);
                }
            }
        }

        $ended = $task->getEndedAt();
        if (!empty($ended) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $ended)) {
            $task->setEndedAt($ended . ' 00:00:00');
        }

        $ok = $this->model->update($task);
        return $ok ? ['success' => true, 'messages' => ['Tâche mise à jour.']] : ['success' => false, 'messages' => ['Impossible de mettre à jour.']];

    }

    public function delete(int $id, int $userId): array
    {
        $ok = $this->model->delete($id, $userId);
        return $ok ? ['success' => true, 'messages' => ['Tâche supprimée.']] : ['success' => false, 'messages' => ['Échec suppression.']];

    }

    public function findById(int $id, int $userId): ?array
    {
        return $this->model->findById($id, $userId);
    }

    public function findAllByUser(int $userId): array
    {
        return $this->model->findAllByUser($userId);
    }
}