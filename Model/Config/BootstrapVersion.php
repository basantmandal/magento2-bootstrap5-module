<?php

namespace HK2\AddBootstrap5\Model\Config;

use Magento\Framework\Option\ArrayInterface;

class BootstrapVersion implements ArrayInterface
{
    /**
     * Return array of options for bootstrap version
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => '4.4.1', 'label' => __('Bootstrap 4.4.1')],
            ['value' => '4.5.3', 'label' => __('Bootstrap 4.5.3')],
            ['value' => '4.6.2', 'label' => __('Bootstrap 4.6.2')],
            ['value' => '5.0.2', 'label' => __('Bootstrap 5.0.2')],
            ['value' => '5.1.3', 'label' => __('Bootstrap 5.1.3')],
            ['value' => '5.2.3', 'label' => __('Bootstrap 5.2.3')],
            ['value' => '5.3.8', 'label' => __('Bootstrap 5.3.8 (Latest)')]
        ];
    }
}
