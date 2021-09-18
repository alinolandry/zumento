<?php
declare(strict_types=1);
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 */

namespace Zumento\OrderExport\Api;

use Magento\Sales\Api\Data\OrderInterface;
use Zumento\OrderExport\Model\HeaderData;

interface DataCollectorInterface
{
    public function collect(OrderInterface $order, HeaderData $headerData): array;
}
