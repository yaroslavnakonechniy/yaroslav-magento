<?php

declare(strict_types=1);

namespace Yaroslav\RegularCustomer\Ui\Component;

use Yaroslav\RegularCustomer\Model\ResourceModel\DiscountRequest\CollectionFactory as DiscountRequestCollectionFactory;

class DiscountFormDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * DiscountFormDataProvider constructor.
     * @param DiscountRequestCollectionFactory $discountRequestCollectionFactory
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        DiscountRequestCollectionFactory $discountRequestCollectionFactory,
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $discountRequestCollectionFactory->create();
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array
    {
        $data = [];

        foreach (parent::getData()['items'] as $item) {
            $data[$item['request_id']] = $item;
        }

        return $data;
    }
}
