<?php

declare(strict_types=1);

namespace HK2\AddBootstrap5\Block\Bootstrap;

use InvalidArgumentException;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\ScopeInterface;

class BootstrapAssets extends Template
{
    private const XML_PATH_BASE = 'hk2_addbootstrap5_section1/hk2_addbootstrap5_section1_group2/';
    private const XML_PATH_ENABLE = self::XML_PATH_BASE . 'hk2_addbootstrap5_enable';
    private const XML_PATH_VERSION = self::XML_PATH_BASE . 'hk2_addbootstrap5_select_bootstrap_version';
    private const XML_PATH_CDN = self::XML_PATH_BASE . 'hk2_addbootstrap5_select_cdn';
    private const XML_PATH_DEBUG = self::XML_PATH_BASE . 'hk2_addbootstrap5_debug';

    /**
     * @param Template\Context $context
     * @param ScopeConfigInterface $scopeConfig
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        private readonly ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Check if debug mode is enabled
     *
     * @return bool
     */
    public function isDebugEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_DEBUG,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get the selected CDN provider
     *
     * @return string
     */
    public function getCdnProvider(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_CDN,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Prepare the layout by adding the Bootstrap CSS from the CDN if the module is enabled
     *
     * @return AbstractBlock
     */
    protected function _prepareLayout(): AbstractBlock
    {
        if (!$this->isEnabled()) {
            return parent::_prepareLayout();
        }

        $urls = $this->getCdnUrls();

        $this->pageConfig->addRemotePageAsset($urls['css'], 'css');

        return parent::_prepareLayout();
    }

    /**
     * Check if the module is enabled
     *
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_ENABLE,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get the CDN URLs for the selected Bootstrap version
     *
     * @param string|null $version
     * @return array
     */
    public function getCdnUrls(?string $version = null): array
    {
        $version = trim($version ?: $this->getBootstrapVersion());

        if ($version === '') {
            throw new InvalidArgumentException('Bootstrap version is not configured.');
        }

        $provider = $this->getCdnProvider();
        $templates = $this->getCdnUrlTemplates($provider);

        return [
            'css' => sprintf($templates['css'], $version),
            'js' => sprintf($templates['js'], $version),
        ];
    }

    /**
     * Get the CDN URL templates for the specified provider
     *
     * @param string $provider
     * @return string[]
     */
    private function getCdnUrlTemplates(string $provider): array
    {
        $templates = [
            'jsdelivr' => [
                'css' => 'https://cdn.jsdelivr.net/npm/bootstrap@%s/dist/css/bootstrap.min.css',
                'js' => 'https://cdn.jsdelivr.net/npm/bootstrap@%s/dist/js/bootstrap.bundle.min.js',
            ],
            'cdnjs' => [
                'css' => 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/%s/css/bootstrap.min.css',
                'js' => 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/%s/js/bootstrap.bundle.min.js',
            ],
            'unpkg' => [
                'css' => 'https://unpkg.com/bootstrap@%s/dist/css/bootstrap.min.css',
                'js' => 'https://unpkg.com/bootstrap@%s/dist/js/bootstrap.bundle.min.js',
            ],
        ];

        return $templates[$provider] ?? $templates['jsdelivr'];
    }

    /**
     * Get the selected Bootstrap version
     *
     * @return string
     */
    public function getBootstrapVersion(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_VERSION,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get the major version number from a version string
     *
     * @param string $version
     * @return int
     */
    private function getMajorVersion(string $version): int
    {
        return (int)explode('.', $version)[0];
    }
}
