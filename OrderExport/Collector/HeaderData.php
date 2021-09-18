<?php
declare(strict_types=1);
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 */

namespace Zumento\OrderExport\Collector;


use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Sales\Api\Data\OrderAddressInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderAddressRepositoryInterface;
use Zumento\OrderExport\Api\DataCollectorInterface;
use Zumento\OrderExport\Model\HeaderData as HeaderDataModel;

class HeaderData implements DataCollectorInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    private OrderAddressRepositoryInterface $orderAddressRepository;
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param OrderAddressRepositoryInterface $orderAddressRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        OrderAddressRepositoryInterface $orderAddressRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->orderAddressRepository = $orderAddressRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }
    public function collect(OrderInterface $order, HeaderDataModel $headerData): array
    {
        $output = [
            'password' => $this->scopeConfig->getValue('sales/order_export/password'),
            'id' => $order->getIncrementId(),
            'currency' => $order->getBaseCurrencyCode(),
            'customer_notes' => 'Customer note',
            'merchant_notes' => $headerData->getMerchantNotes(),
            'discount' => $order->getBaseDiscountAmount(),
            'total' => $order->getBaseGrandTotal()
        ];

        $address = $this->getShippingAddress($order);
        if ($address) {
            $output['shipping'] = [
                'name' => $address->getFirstname(). ' ' . $address->getLastname(),
                'address' => $address->getStreet(),
                'city' => $address->getCity(),
                'state' => $address->getRegionCode(),
                'postcode' => $address->getPostcode(),
                'country' => $address->getCountryId(),
                'amount' => $order->getBaseShippingAmount(),
                'method' => $order->getShippingDescription(),
                'ship_on' => $headerData->getShipDate()->format('Y-m-d')
            ];
        }


        return $output;
    }

    private function getShippingAddress(OrderInterface $order): ?OrderAddressInterface
    {
        $searchCritera = $this->searchCriteriaBuilder
            ->addFilter('parent_id', $order->getEntityId())
            ->addFilter('address_type', 'shipping')
            ->create();
        $addresses = $this->orderAddressRepository->getList($searchCritera)->getItems();

        return count($addresses) ? reset($addresses) : null;
    }
}
