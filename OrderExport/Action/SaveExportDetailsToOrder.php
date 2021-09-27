<?php
declare(strict_types=1);
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */
namespace Zumento\OrderExport\Action;

use Magento\Sales\Api\OrderRepositoryInterface;
use Zumento\OrderExport\Model\HeaderData;
use Zumento\OrderExport\Model\OrderExportDetailsRepository;

class SaveExportDetailsToOrder
{

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;
    /**
     * @var OrderExportDetailsRepository
     */
    private $exportDetailsRepository;

    /**
     * @param OrderRepositoryInterface $orderRepository
     * @param OrderExportDetailsRepository $exportDetailsRepository
     */
    public function __construct (
        OrderRepositoryInterface $orderRepository,
        OrderExportDetailsRepository $exportDetailsRepository
    )
    {

        $this->orderRepository = $orderRepository;
        $this->exportDetailsRepository = $exportDetailsRepository;
    }

    public function execute(int $orderId, array $results, HeaderData $headerData): void
    {
        $order = $this->orderRepository->get($orderId);
        $details = $order->getExtensionAttributes()->getOrderExportDetails();

        if (isset($results['success']) && $results['success'] === true) {
            $details->setExportedAt((new \DateTime())->setTimezone(new \DateTimeZone('UTC')));
        }

        $details->setOrderId($orderId);
        $details->setMerchantNotes($headerData->getMerchantNotes());
        $details->setShipOn($headerData->getShipDate());

        $this->exportDetailsRepository->save($details);
    }
}
