<?php
class Task
{
    private ?int $id = null;
    private int $userId;
    private string $title;
    private string $content;
    private int $statusId;
    private ?string $endedAt;

    public function __construct(string $title = '', string $content = '', int $statusId = 1, ?int $userId = null, ?int $id = null, ?string $endedAt = null)
    {
        $this->title = $title;
        $this->content = $content;
        $this->statusId = $statusId;
        $this->userId = $userId ?? 0;
        $this->id = $id;
        $this->endedAt = $endedAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getContent(): string
    {
        return $this->content;
    }
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    public function getStatusId(): int
    {
        return $this->statusId;
    }
    public function setStatusId(int $statusId): void
    {
        $this->statusId = $statusId;
    }

    public function getEndedAt(): ?string
    {
        return $this->endedAt;
    }
    public function setEndedAt(?string $endedAt): void
    {
        $this->endedAt = $endedAt;
    }

    public function validate(int $minTitleLength = 1): array
    {
        $errors = [];
        if (trim($this->title) === '' || mb_strlen(trim($this->title)) < $minTitleLength) {
            $errors[] = "Le titre est requis.";
        }

        if (!in_array($this->statusId, [1, 2, 3], true)) {
            $errors[] = "Statut invalide.";
        }

        if (!empty($this->endedAt) && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $this->endedAt)) {
            $errors[] = "Date de fin invalide (format YYYY-MM-DD).";
        }

        return $errors;
    }
}
