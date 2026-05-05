<?php

declare(strict_types=1);

namespace HK2\AddBootstrap5\Block\Bootstrap;

use InvalidArgumentException;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Page\Config as PageConfig;
use Magento\Store\Model\ScopeInterface;

class BootstrapAssets extends Template
{
    private const XML_PATH_BASE = 'hk2_addbootstrap5_section1/hk2_addbootstrap5_section1_group2/';
    private const XML_PATH_ENABLE = self::XML_PATH_BASE . 'hk2_addbootstrap5_enable';
    private const XML_PATH_VERSION = self::XML_PATH_BASE . 'hk2_addBootstrap5_select_bootstrap_version';
    private const XML_PATH_CDN = self::XML_PATH_BASE . 'hk2_addbootstrap5_select_cdn';
    private const XML_PATH_DEBUG = self::XML_PATH_BASE . 'hk2_addbootstrap5_debug';

    /**
     * @var ScopeConfigInterface
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * Constructor
     *
     * @param Context              $context
     * @param ScopeConfigInterface $scopeConfig
     * @param PageConfig           $pageConfig
     * @param array                $data
     */
    public function __construct(
        Template\Context $context,
        ScopeConfigInterface $scopeConfig,
        PageConfig $pageConfig,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->scopeConfig = $scopeConfig;
        $this->pageConfig = $pageConfig;
    }

    /**
     * Checks if debug mode is enabled.
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
     * Gets the configured CDN provider.
     *
     * @return string The configured CDN provider.
     */
    public function getCdnProvider(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_CDN,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Calls this before rendering - Adding Bootstrap CSS
     *
     * @return AbstractBlock
     */
    protected function _prepareLayout(): AbstractBlock
    {
        if (!$this->isEnabled()) {
            return parent::_prepareLayout();
        }

        $urls = $this->getCdnUrls();

        // Add CSS
        $this->pageConfig->addRemotePageAsset($urls['css'], 'css');

        return parent::_prepareLayout();
    }

    /**
     * Checks if the Bootstrap 5 module is enabled.
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
     * Returns an array of Bootstrap CDN URLs.
     *
     * @param string|null $version The Bootstrap version to use. If not provided, the configured version will be used.
     *
     * @return array An associative array containing 'css' and 'js' keys, each pointing to a Bootstrap CDN URL.
     *
     * @throws InvalidArgumentException If the Bootstrap version is not configured.
     */
    public function getCdnUrls(?string $version = null): array
    {
        $version = trim($version ?: $this->getBootstrapVersion());

        if ($version === '') {
            throw new InvalidArgumentException('Bootstrap version is not configured.');
        }

        return [
            'css' => sprintf(
                'https://cdn.jsdelivr.net/npm/bootstrap@%s/dist/css/bootstrap.min.css',
                $version
            ),
            'js' => sprintf(
                'https://cdn.jsdelivr.net/npm/bootstrap@%s/dist/js/bootstrap.bundle.min.js',
                $version
            ),
        ];
    }

    /**
     * Returns the configured Bootstrap version.
     *
     * @return string The configured Bootstrap version.
     */
    public function getBootstrapVersion(): string
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_VERSION,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Returns the major version of the given Bootstrap version.
     *
     * @param string $version
     * @return int
     */
    private function getMajorVersion(string $version): int
    {
        return (int)explode('.', $version)[0];
    }
}
