<?php

namespace AllDigitalRewards\RewardStack\Transaction;

use AllDigitalRewards\RewardStack\Common\Entity\AbstractEntity;
use AllDigitalRewards\RewardStack\Common\AbstractApiRequest;
use AllDigitalRewards\RewardStack\Participant\AddressRequest;

class CreateTransactionRequest extends AbstractApiRequest
{
    /**
     * @var string
     */
    private $programId;
    /**
     * @var string
     */
    private $uniqueId;

    private $productCollection;

    /**
     * @var array
     */
    private $shippingAddress;
    /**
     * @var array
     */
    private $transactionConfig = [];

    protected $httpMethod = 'POST';

    /**
     * productRequestCollection is an associative array of sku/quantity pairs. HRA01 => 1
     * CreateTransactionRequest constructor.
     * @param string $programId
     * @param string $uniqueId
     * @param array $productRequestCollection
     * @param AddressRequest $shippingAddress
     * @param array $transactionConfig
     */
    public function __construct(
        string $programId,
        string $uniqueId,
        array $productRequestCollection,
        AddressRequest $shippingAddress,
        array $transactionConfig = []
    ) {
        $this->programId = $programId;
        $this->uniqueId = $uniqueId;
        $this->productCollection = $productRequestCollection;
        $this->shippingAddress = $shippingAddress;
        $this->transactionConfig = $transactionConfig;
    }

    public function getHttpEndpoint(): string
    {
        return "/api/program/{$this->programId}/participant/$this->uniqueId/transaction";
    }

    public function getResponseObject(): AbstractEntity
    {
        return new CreateTransactionResponse();
    }

    public function jsonSerialize()
    {
        if (empty($this->productCollection)) {
            throw new \Exception('A product list must be supplied to request a transaction');
        }

        return [
            "products" => $this->getMappedProductCollection(),
            "issue_points" => $this->transactionConfig['issue_points'] ?? true,
            "shipping" => $this->shippingAddress,
            "meta" => $this->transactionConfig['meta'] ?? [],
        ];
    }

    private function getMappedProductCollection()
    {
        $productCollection = [];
        foreach ($this->productCollection as $productRequest) {
            $product = [
                'sku' => $productRequest['sku'],
                'quantity' => $productRequest['quantity']
            ];

            if (!empty($productRequest['amount'])) {
                $product['amount'] = $productRequest['amount'];
            }

            $productCollection[] = $product;
        }

        return $productCollection;
    }
}
