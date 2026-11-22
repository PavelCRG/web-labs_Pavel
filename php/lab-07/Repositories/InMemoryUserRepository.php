<?php
namespace App\Repositories;

use App\Contracts\Repository;

class InMemoryUserRepository implements Repository 
{
    private array $users = [];

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
        if (!isset($data['id']) || !is_int($data['id']) || $data['id'] <= 0) {
            throw new \InvalidArgumentException("ID must be a positive integer");
        }
        if (empty($data['name'])) {
            throw new \InvalidArgumentException("Name cannot be empty");
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
