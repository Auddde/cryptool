<?php

namespace tests\Services;

use App\Entity\Transaction;
use App\Services\TransactionService;
use PHPunit\Framework\TestCase;

class TransactionServiceTest extends TestCase {


    /**
     * @dataProvider calculateValoTransactionProvider
     */
    public function testCalculateValoTransaction($currentSolde, $originalSolde, $expected)
    {
        $transactionService = new TransactionService();
        $this->assertSame($expected, $transactionService->calculateValoTransaction($currentSolde, $originalSolde));
    }

    public function calculateValoTransactionProvider()
    {
        return [
            ["1000", "2000", "-50"],
            ["1000", "1000", "0"],
            ["1000", "500", "100"],
        ];
    }

    /**
     * @dataProvider calculateGainTransactionProvider
     */
    public function testCalculateGainTransaction($currentSolde, $originalSolde, $expected)
    {
        $transactionService = new TransactionService();
        $this->assertSame($expected, $transactionService->calculateGainTransaction($currentSolde, $originalSolde));
    }

    public function calculateGainTransactionProvider()
    {
       return [
           [1000, 2500, -1500],
           [1000, 1000, 0],
           [3980.44, 1932.89, 2048],
       ] ;
    }

    /**
     * @dataProvider calculateCurrentSoldeProvider
     */
    public function testCalculateCurrentSolde($transactions, $expected)
    {
        $transactionService = new TransactionService();
        $this->assertSame($expected, $transactionService->calculateCurrentSolde($transactions));
    }

    public function calculateCurrentSoldeProvider()
    {
        $transaction1 = new Transaction();
        $transaction2 = new Transaction();
        $transaction3 = new Transaction();

        $transaction1->setDaylyvalue("123.44");
        $transaction2->setDaylyvalue("18933.53");
        $transaction3->setDaylyvalue("0.05");

        return [
            [[$transaction1, $transaction2, $transaction3], 19057.02],
        ];
    }



}