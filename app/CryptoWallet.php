<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CryptoWallet extends Model
{
    use HasFactory;

    public function getBalance($currency) {
        $currencies = json_decode($this->currencies, true);

        return isset($currencies[$currency]) ? $currencies[$currency] : 0;
    }

    public function addBalance($currency, $value) {
        $wallet_currencies = json_decode($this->currencies, true);
        if(!isset($wallet_currencies[$currency])) $wallet_currencies[$currency] = 0;
        $wallet_currencies[$currency] += floor($value * 10000) / 10000;
        $this->currencies = json_encode($wallet_currencies);

        return $wallet_currencies[$currency];
    }

    public function takeBalance($currency, $value) {
        $wallet_currencies = json_decode($this->currencies, true);
        if (!isset($wallet_currencies[$currency])) $wallet_currencies[$currency] = 0;
        $wallet_currencies[$currency] -= floor($value * 10000) / 10000;
        $this->currencies = json_encode($wallet_currencies);

        return $wallet_currencies[$currency];
    }
}
