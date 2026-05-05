<?php

namespace HK2\AddBootstrap5\Block\Demo;

use Magento\Framework\View\Element\Template;

class Index extends Template
{
    /**
     * Return an array containing demo content
     *
     * @return array
     * @api
     */
    public function getDemoContent(): array
    {
        $version = $this->getRequest()->getParam('version', '5');

        return [
            'version' => $version,
            'title' => $version == '4' ? 'Bootstrap 4' : 'Bootstrap 5',
            'demo_url' => $this->getUrl('addbootstrap5/demo/index', ['version' => $version])
        ];
    }
}
