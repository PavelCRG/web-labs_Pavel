<?php
require_once 'Repository.php';

class JsonFileUserRepository implements Repository
{
    private string $filePath;

    public function __construct(string $filePath = 'users.json')
    {
        $this->filePath = $filePath;
        if (!file_exists($this->filePath)) {
            $this->saveData([]);
        }
    }

    private function loadData(): array
    {
        if (!file_exists($this->filePath)) {
            return [];
        }
        return json_decode(file_get_contents($this->filePath), true) ?: [];
    }

    private function saveData(array $data): void
    {
        file_put_contents($this->filePath, json_encode(array_values($data), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function find(int $id): ?array
    {
        foreach ($this->loadData() as $user) {
            if (isset($user['id']) && (int)$user['id'] === $id) {
                return $user;
            }
        }
        return null;
    }

    public function findAll(): array
    {
        return $this->loadData();
    }

    public function save(array $data): void
    {
        $users = $this->loadData();

        if (!isset($data['id'])) {
            $maxId = 0;
            foreach ($users as $user) {
                if (isset($user['id']) && (int)$user['id'] > $maxId) {
                    $maxId = (int)$user['id'];
                }
            }
            $data['id'] = $maxId + 1;
            $users[] = $data;
        } else {
            $found = false;
            foreach ($users as $key => $user) {
                if (isset($user['id']) && (int)$user['id'] === (int)$data['id']) {
                    $users[$key] = $data;
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $users[] = $data;
            }
        }

        $this->saveData($users);
    }

    public function delete(int $id): bool
    {
        $users = $this->loadData();
        $initialCount = count($users);
        
        $users = array_filter($users, function($user) use ($id) {
            return isset($user['id']) && (int)$user['id'] !== $id;
        });

        $this->saveData($users);
        return count($users) < $initialCount;
    }
}
