<?php
declare(strict_types=1);
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 */

namespace Zumento\OrderExport\Collector;

use Magento\Sales\Api\Data\OrderInterface;
use Zumento\Api\DataCollectorInterface;
use Zumento\OrderExport\Model\HeaderData as HeaderDataModel;

class HeaderData implements DataCollectorInterface
{
    public function collect(OrderInterface $order, HeaderDataModel $headerData): array
    {
        return [
            'order_id' => $order->getIncrementId(),
            'ship_date' => $headerData->getShipDate()->format('Y-m-d')
        ];
    }
}
