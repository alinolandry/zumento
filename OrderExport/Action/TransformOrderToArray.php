<?php
declare(strict_types=1);
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 */

namespace Zumento\OrderExport\Action;

use Magento\Sales\Api\OrderRepositoryInterface;
use Zumento\OrderExport\Api\DataCollectorInterface;
use Zumento\OrderExport\Model\HeaderData;

class TransformOrderToArray
{
    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var DataCollectorInterface[]
     */
    private $dataCollectors;

    /**
     * @param OrderRepositoryInterface $orderRepository
     * @param array $dataCollectors
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        array $dataCollectors
    ) {
        $this->orderRepository = $orderRepository;
        $this->dataCollectors = $dataCollectors;
    }

    public function execute(
       int $orderId,
        HeaderData $headerData
    ) {
        $order = $this->orderRepository->get($orderId);
        $output = [];

        foreach ($this->dataCollectors as $collector) {
            if (!($collector instanceof DataCollectorInterface)) {
                throw new \Exception('Collectors must implement DataCollectorInterface');
            }

            $output = array_merge($output, $collector->collect($order, $headerData));
        }

        return $output;
    }
}
