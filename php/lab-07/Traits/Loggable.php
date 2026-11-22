<?php
namespace App\Traits;

trait Loggable 
{
    protected array $logs = [];

    public function log(string $message): void 
    {
        $this->logs[] = sprintf("[%s] %s", date('Y-m-d H:i:s'), $message);
    }

    public function getLogs(): array 
    {
        return $this->logs;
    }
}
