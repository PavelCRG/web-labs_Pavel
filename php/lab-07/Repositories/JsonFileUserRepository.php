<?php
namespace App\Repositories;

use App\Contracts\Repository;

class JsonFileUserRepository implements Repository 
{
    private string $filePath;

    public function __construct(string $filePath = 'users.json') 
    {
        $this->filePath = $filePath;
        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, json_encode([]));
        }
    }

    private function loadFromFile(): array 
    {
        $content = file_get_contents($this->filePath);
        return json_decode($content, true) ?? [];
    }

    private function saveToFile(array $users): void 
    {
        file_put_contents($this->filePath, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function find(int $id): ?array 
    {
        $users = $this->loadFromFile();
        return $users[$id] ?? null;
    }

    public function findAll(): array 
    {
        return $this->loadFromFile();
    }

    public function save(array $data): void 
    {
        if (!isset($data['id']) || !is_int($data['id']) || $data['id'] <= 0) {
            throw new \InvalidArgumentException("ID must be a positive integer");
        }
        if (empty($data['name'])) {
            throw new \InvalidArgumentException("Name cannot be empty");
        }

        $users = $this->loadFromFile();
        $users[$data['id']] = $data;
        $this->saveToFile($users);
    }

    public function delete(int $id): bool 
    {
        $users = $this->loadFromFile();
        if (isset($users[$id])) {
            unset($users[$id]);
            $this->saveToFile($users);
            return true;
        }
        return false;
    }
}
