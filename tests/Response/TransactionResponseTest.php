<?php

namespace AllDigitalRewards\Tests;

use AllDigitalRewards\RewardStack\Auth\AuthProxy;
use AllDigitalRewards\RewardStack;
use AllDigitalRewards\RewardStack\Transaction\TransactionRequest;
use AllDigitalRewards\RewardStack\Transaction\TransactionResponse;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class TransactionResponseTest extends TestCase
{
    public function testRequest()
    {
        $jsonData = file_get_contents(__DIR__ . "/../fixtures/transaction.json");

        $authProxy = $this->createMock(AuthProxy::class);

        $authProxy->method('request')
            ->willReturn(new Response(
                200,
                [],
                $jsonData
            ));

        $client = new RewardStack\Client($authProxy);

        $transactionCollection = new TransactionRequest('TESTPARTICIPANT1');
        $response = $client->request($transactionCollection);

        $expectedResponse = new TransactionResponse(json_decode($jsonData));

        $this->assertInstanceOf(
            TransactionResponse::class,
            $response
        );

        $this->assertEquals(
            $expectedResponse->count(),
            $response->count()
        );
    }
}
