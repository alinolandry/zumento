<?php
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */
namespace Zumento\OrderExport\Plugin;


use Magento\Backend\Model\Auth\Session as AdminSession;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Integration\Model\Oauth\TokenFactory;
use Zumento\OrderExport\ViewModel\OrderDetails;

class InjectAdminToken
{
    /** @var TokenFactory */
    private $tokenFactory;

    /** @var AdminSession */
    private $adminSession;

    /** @var UrlInterface */
    private $urlBuilder;

    /** @var RequestInterface */
    private $request;

    public function __construct(
        TokenFactory $tokenFactory,
        AdminSession $adminSession,
        UrlInterface $urlBuilder,
        RequestInterface $request
    ) {
        $this->tokenFactory = $tokenFactory;
        $this->adminSession = $adminSession;
        $this->urlBuilder = $urlBuilder;
        $this->request = $request;
    }

    public function afterGetConfig(OrderDetails $subject, $details): array
    {
        $details['upload_url'] = $this->getAPIUrl();
        $details['token'] = $this->getToken();

        return $details;
    }

    private function getToken()
    {
        $token = $this->tokenFactory->create()
            ->createAdminToken($this->adminSession->getUser()->getId());

        return $token->getToken();
    }

    private function getAPIUrl(): string
    {
        return $this->urlBuilder->getBaseUrl()
            . '/rest/V1/order/export/'
            . (int)$this->request->getParam('order_id');
    }
}
