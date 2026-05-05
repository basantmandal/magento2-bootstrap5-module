<?php

namespace HK2\AddBootstrap5\Model\Config;

use Magento\Framework\Option\ArrayInterface;

class CdnProvider implements ArrayInterface
{
    /**
     * Return array of options for Bootstrap 5 CDN provider
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => 'jsdelivr', 'label' => __('jsDelivr CDN')]
        ];
    }
}
