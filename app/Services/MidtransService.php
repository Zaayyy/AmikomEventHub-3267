<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction as MidtransTransaction;

class MidtransService
{
    public function createSnapToken(array $params): string
    {
        $this->configure();

        return Snap::getSnapToken($params);
    }

    public function getTransactionStatus(string $orderId): ?string
    {
        $this->configure();

        $status = MidtransTransaction::status($orderId);

        return is_array($status)
            ? ($status['transaction_status'] ?? null)
            : ($status->transaction_status ?? null);
    }

    private function configure(): void
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = (bool) config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }
}
