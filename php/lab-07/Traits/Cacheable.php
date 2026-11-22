<?php
namespace App\Traits;

trait Cacheable 
{
    private array $cache = [];

    public function setCache(string $key, mixed $value): void 
    {
        $this->cache[$key] = $value;
    }

    public function getFromCache(string $key): mixed 
    {
        return $this->cache[$key] ?? null;
    }

    public function clearCache(): void 
    {
        $this->cache = [];
    }
}
