<?php

interface Repository
{
    public function find(int $id): ?array;
    public function findAll(): array;
    public function save(array $data): void;
    public function delete(int $id): bool;
}
