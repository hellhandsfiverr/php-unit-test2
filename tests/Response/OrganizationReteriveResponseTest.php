<?php

namespace AllDigitalRewards\Tests;

use AllDigitalRewards\RewardStack\Auth\AuthProxy;
use AllDigitalRewards\RewardStack;
use AllDigitalRewards\RewardStack\Organization\OrganizationReteriveResponse;
use \AllDigitalRewards\RewardStack\Organization;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class OrganizationReteriveResponseTest extends TestCase
{
    public function testRequest()
    {
        $jsonData = file_get_contents(__DIR__ . "/../fixtures/organization_reterive_response.json");

        $authProxy = $this->createMock(AuthProxy::class);

        $authProxy->method('request')
            ->willReturn(new Response(
                200,
                [],
                $jsonData
            ));

        $client = new RewardStack\Client($authProxy);

        $organizationReteriveRequest = new Organization\OrganizationReteriveRequest('sharecare');
        $response = $client->request($organizationReteriveRequest);

        $expectedResponse = new OrganizationReteriveResponse(json_decode($jsonData));

        $this->assertInstanceOf(
            OrganizationReteriveResponse::class,
            $response
        );

        $this->assertEquals(
            $expectedResponse->getUniqueId(),
            $response->getUniqueId()
        );

        $this->assertEquals(
            $expectedResponse->getActive(),
            $response->getActive()
        );

        $this->assertEquals(
            $expectedResponse->getCreatedAt(),
            $response->getCreatedAt()
        );

        $this->assertEquals(
            $expectedResponse->getUpdatedAt(),
            $response->getUpdatedAt()
        );

        $this->assertEquals(
            $expectedResponse->getParent(),
            $response->getParent()
        );

        $this->assertEquals(
            $expectedResponse->getDomains(),
            $response->getDomains()
        );

        $this->assertEquals(
            $expectedResponse->getCompanyContact(),
            $response->getCompanyContact()
        );

        $this->assertEquals(
            $expectedResponse->getAccountsPayableContact(),
            $response->getAccountsPayableContact()
        );
    }
}
