<?php

require_once 'Repository.php';

class InMemoryUserRepository implements Repository
{
    private array $users = [];
    private int $nextId = 1;

    public function find(int $id): ?array
    {
        return $this->users[$id] ?? null;
    }

    public function findAll(): array
    {
        return $this->users;
    }

    public function save(array $data): void
    {
        if (!isset($data['id'])) {
            $data['id'] = $this->nextId++;
        }
        $this->users[$data['id']] = $data;
    }

    public function delete(int $id): bool
    {
        if (isset($this->users[$id])) {
            unset($this->users[$id]);
            return true;
        }
        return false;
    }
}
