<?php

namespace AllDigitalRewards\Tests;

use AllDigitalRewards\RewardStack\Sso\SsoTokenRequest;
use AllDigitalRewards\RewardStack\Sso\SsoTokenResponse;
use PHPUnit\Framework\TestCase;

class SsoTokenRequestTest extends TestCase
{
    protected $uniqueId;
    protected $ssoTokenRequest;

    protected function setUp(): void
    {
        $this->uniqueId = uniqid();
        $this->ssoTokenRequest = new SsoTokenRequest($this->uniqueId);
    }

    public function testGetHttpEndpoint()
    {
        $expectedUrl = '/api/user/' . $this->uniqueId . '/sso';
        $this->assertEquals($expectedUrl, $this->ssoTokenRequest->getHttpEndpoint());
    }

    public function testGetResponseObject()
    {
        $this->assertInstanceOf(
            SsoTokenResponse::class,
            $this->ssoTokenRequest->getResponseObject()
        );
    }
}
