<?php
declare(strict_types=1);
/**
 * @By Alain Landry Noutchomwo
 * @alias Zumento
 *
 */

namespace Zumento\OrderExport\ViewModel;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\AuthorizationInterface;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * This class help to export details of Order
 */
class OrderDetails implements ArgumentInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    private $formKey;

    private $urlBuilder;

    private $request;

    //private $authorization;
    private $authorization;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct( ScopeConfigInterface $scopeConfig,
                                  FormKey $formKey,
                                  UrlInterface $urlBuilder,
                                  RequestInterface $request,
                                AuthorizationInterface $authorization
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->formKey = $formKey;
        $this->urlBuilder = $urlBuilder;
        $this->request = $request;
        $this->authorization = $authorization;
    }

    /**
     * @return bool
     */
    public function isAllowed(): bool
    {

        return $this->scopeConfig->isSetFlag("sales/order_export/enabled") && $this->authorization->isAllowed('Zumento_OrderExport::OrderExport');
    }

    public function getButtonMessage(): string
    {
        return (string)__('Send Order to Fulfillment');
    }

    public function getConfig(): array
    {
        return [
            'sending_message' => __('Sending...'),
            'original_message' => $this->getButtonMessage(),
            'form_key' => $this->formKey->getFormKey(),
            'upload_url' => $this->urlBuilder->getUrl(
                'order_export/export/run',
                [
                    'order_id' => (int)$this->request->getParam('order_id')
                ]
            )
        ];
    }
}
