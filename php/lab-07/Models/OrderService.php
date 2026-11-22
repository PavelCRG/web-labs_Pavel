<?php
namespace App\Models;

use App\Traits\Loggable;
use App\Traits\Cacheable;

class OrderService 
{
    use Loggable, Cacheable; 

    public function processOrder(int $orderId, float $amount): string 
    {
        if ($orderId <= 0 || $amount <= 0) {
            $this->log("Failed order attempt ID: $orderId, Amount: $amount");
            throw new \InvalidArgumentException("Order ID and amount must be greater than zero");
        }

        $cacheKey = "order_" . $orderId;
        $cachedResult = $this->getFromCache($cacheKey);

        if ($cachedResult !== null) {
            $this->log("Order $orderId hit cache");
            return $cachedResult;
        }

        $result = "Order #{$orderId} processed successfully";
        $this->log("Processed order ID: $orderId");
        $this->setCache($cacheKey, $result);

        return $result;
    }
}
