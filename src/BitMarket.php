<?php

namespace Boot\Stock;

class BitMarket extends \Boot\Stock\Api {

    protected $url = 'https://www.bitmarket.pl/json/BTCPLN/orderbook.json';

    const ORDER_BOOK_PRICE = 0;
    const ORDER_BOOK_COUNT = 1;

    public function realnaCena($BTC = 1) {
        
        $iloscBTC = 0;
        $wartoscTranzakcji = 0;
        foreach ($this->getOrderBook()->asks as $orderBookRow) {
            $wartoscTranzakcji +=
                    $orderBookRow[self::ORDER_BOOK_PRICE] *
                    $orderBookRow[self::ORDER_BOOK_COUNT];
            $iloscBTC += $orderBookRow[self::ORDER_BOOK_COUNT];
            if ($iloscBTC >= $BTC) {
                break;
            }
        }
        if ($iloscBTC < $BTC) {
            throw new \Exception('Nieudało się wyliczyć realnej ceny zamało ofert spzedarzy dla BTC=' . $BTC);
        }
        return ($wartoscTranzakcji / $iloscBTC);
    }
}
