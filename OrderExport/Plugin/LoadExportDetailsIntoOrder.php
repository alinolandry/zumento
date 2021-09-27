<?php
declare(strict_types=1);
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */

namespace Zumento\OrderExport\Plugin;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Zumento\OrderExport\Model\OrderExportDetailsFactory;
use Zumento\OrderExport\Model\OrderExportDetailsRepository;

class LoadExportDetailsIntoOrder
{
    /**
     * @var OrderExtensionFactory
     */
    private OrderExtensionFactory $extensionFactory;

    /**
     * @var OrderExportDetailsRepository
     */
    private OrderExportDetailsRepository $exportDetailsRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    /**
     * @var OrderExportDetailsFactory
     */
    private OrderExportDetailsFactory $detailsFactory;

    public function __construct (
        OrderExtensionFactory $extensionFactory,
        OrderExportDetailsRepository $exportDetailsRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        OrderExportDetailsFactory $detailsFactory
    ) {

        $this->extensionFactory = $extensionFactory;
        $this->exportDetailsRepository = $exportDetailsRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->detailsFactory = $detailsFactory;
    }

    public function afterGet (OrderRepositoryInterface $subject, OrderInterface $order): OrderInterface
    {
        return $this->injectDetails($order);
    }

    public function afterGetList (
        OrderRepositoryInterface $subject,
        OrderSearchResultInterface $results): OrderSearchResultInterface
    {
        foreach ($results->getItems() as $order) {
            $this->injectDetails($order);
        }

        return $results;
    }

    /**
     * @param OrderInterface $order
     * @return OrderInterface
     */
    public function injectDetails(OrderInterface $order): OrderInterface
    {
        $extensionAttributes = $order->getExtensionAttributes() ?? $this->extensionFactory->create();

        $details = $this->exportDetailsRepository->getList(
            $this->searchCriteriaBuilder->addFilter(
                'order_id',
                $order->getEntityId()
            )->create()
        )->getItems();

        if (count($details)) {
            $extensionAttributes->setOrderExportDetails(reset($details));
        } else {
            $extensionAttributes->setOrderExportDetails($this->detailsFactory->create());
        }

        $order->setExtensionAttributes($extensionAttributes);
        return $order;
    }
}

