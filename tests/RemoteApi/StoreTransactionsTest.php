<?php

declare(strict_types = 1);
namespace Techworker\IOTA\Test\RemoteApi;

use Techworker\IOTA\RemoteApi\Commands\StoreTransactions\Request;
use Techworker\IOTA\RemoteApi\Commands\StoreTransactions\Response;
use Techworker\IOTA\RemoteApi\Node;
use Techworker\IOTA\Type\Trytes;

class StoreTransactionsTest extends AbstractApiTestCase
{
    protected function initValidRequest()
    {
        $this->request = new Request(
            new Trytes($this->generateStaticTryte(3, 0)),
            new Trytes($this->generateStaticTryte(3, 1))
        );
    }

    public function testRequestSerialization()
    {
        $expected = [
            'command' => 'storeTransactions',
            'trytes' => [
                $this->generateStaticTryte(3, 0),
                $this->generateStaticTryte(3, 1)
            ]
        ];
        static::assertEquals($expected, $this->request->jsonSerialize());
    }

    public function testResponse()
    {
        $fixture = $this->loadFixture(__DIR__ . '/fixtures/StoreTransactions.json');
        $this->httpClient->setResponseFromFixture(200, $fixture['decoded']);

        /** @var Response $response */
        $response = $this->httpClient->commandRequest($this->request, new Node());
        static::assertInstanceOf(Response::class, $response);
    }

    public function provideResponseMissing()
    {
        return [];
    }

}