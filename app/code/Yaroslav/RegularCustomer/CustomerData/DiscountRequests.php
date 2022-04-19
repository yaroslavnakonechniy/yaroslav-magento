<?php

declare(strict_types=1);

namespace Yaroslav\RegularCustomer\CustomerData;

class DiscountRequests implements \Magento\Customer\CustomerData\SectionSourceInterface
{
    /**
     * @inheritDoc
     */
    public function getSectionData(): array
    {
        return [
            'sectionData' => 'It works!'
        ];
    }
}
