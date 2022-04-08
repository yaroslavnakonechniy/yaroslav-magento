<?php
declare(strict_types=1);

namespace Yaroslav\LayoutDebug\Model;

class Options implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * Get example select options for usage in models, templates, whatever
     *
     * @return \string[][]
     */
    public function toOptionArray(): array
    {
        return [
            [
                'label' => 'Option 1',
                'value' => 'option_1'
            ], [
                'label' => 'Option 2',
                'value' => 'option_2'
            ], [
                'label' => 'Option 3',
                'value' => 'option_3'
            ]
        ];
    }
}
