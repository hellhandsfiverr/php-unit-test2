<?php

namespace AllDigitalRewards\RewardStack\Request;

use AllDigitalRewards\RewardStack\Common\Entity\AbstractEntity;
use AllDigitalRewards\RewardStack\Response\AbstractApiResponse;
use AllDigitalRewards\RewardStack\Response\ParticipantResponse;

class ParticipantRequest extends AbstractApiRequest
{
    /**
     * @var string
     */
    private $uniqueId;

    /**
     * GetParticipantRequest constructor.
     * @param string $uniqueId
     */
    public function __construct(string $uniqueId)
    {
        $this->uniqueId = $uniqueId;
    }

    public function getHttpEndpoint(): string
    {
        return '/api/user/' . $this->uniqueId;
    }

    public function getResponseObject(): AbstractEntity
    {
        return new ParticipantResponse();
    }

    public function jsonSerialize()
    {
        return [];
    }
}