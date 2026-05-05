<?php

namespace HK2\AddBootstrap5\Block\Adminhtml\System\Config;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Store\Model\StoreManagerInterface;

class DemoLinkV4 extends Field
{
    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;

    /**
     * @param Context               $context
     * @param StoreManagerInterface $storeManager
     * @param array                 $data
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->storeManager = $storeManager;
    }

    /**
     * Return HTML representing the Bootstrap 4 Demo (Frontend).
     * This function first calls the parent constructor with the provided context and data.
     * The function then assigns the provided StoreManagerInterface to the class's protected "storeManager" property.
     * The function then returns the HTML representing the Bootstrap 4 Demo (Frontend).
     *
     * @param AbstractElement $element
     * @return string
     *
     * @throws NoSuchEntityException
     */
    protected function _getElementHtml(AbstractElement $element): string
    {
        $store = $this->storeManager->getDefaultStoreView()
            ?: $this->storeManager->getStore();

        $baseUrl = rtrim(
            $store->getBaseUrl(UrlInterface::URL_TYPE_LINK),
            '/'
        );

        $demoUrl = $baseUrl . '/addbootstrap5/demo/index?version=4';

        return $this->renderUi($demoUrl);
    }

    /**
     * Returns HTML representing the Bootstrap 4 Demo (Frontend).
     * This function first calls the parent constructor with the provided context and data.
     * The function then assigns the provided StoreManagerInterface to the class's protected "storeManager" property.
     * The function then returns the HTML representing the Bootstrap 4 Demo (Frontend).
     *
     * @param string $demoUrl
     * @return string
     */
    private function renderUi(string $demoUrl): string
    {
        return '
        <div style="
            padding:12px;
            background:#f8fafc;
            border:1px solid #e2e8f0;
            border-radius:6px;
            font-family:system-ui;
        ">
            <div style="font-weight:600;margin-bottom:6px;">
                🚀 Bootstrap 4 Demo (Frontend)
            </div>

            <div style="display:flex;gap:8px;align-items:center;">
                <input
                    type="text"
                    readonly
                    value="' . $demoUrl . '"
                    style="
                        flex:1;
                        padding:6px 8px;
                        border:1px solid #cbd5e1;
                        border-radius:4px;
                        background:#fff;
                        font-size:13px;
                    "
                    onclick="this.select()"
                />

                <a
                    href="' . $demoUrl . '"
                    target="_blank"
                    rel="noopener noreferrer"
                    style="
                        padding:6px 10px;
                        background:#2563eb;
                        color:#fff;
                        border-radius:4px;
                        text-decoration:none;
                        font-size:13px;
                    "
                >
                    Open
                </a>
            </div>

            <div style="margin-top:6px;font-size:12px;color:#64748b;">
                Bootstrap 4 Demo Url (admin-safe)
            </div>
        </div>';
    }
}
