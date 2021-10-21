<?php
declare(strict_types=1);
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 */

namespace Zumento\OrderExport\Collector;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderItemInterface;
use Zumento\OrderExport\Api\DataCollectorInterface;
use Zumento\OrderExport\Model\HeaderData;

class ItemData implements DataCollectorInterface
{
    /**
     * @var array
     */
    private $allowedTypes;

    public function __construct(array $allowedTypes)
    {
        $this->allowedTypes = $allowedTypes;
    }

    public function collect(OrderInterface $order, HeaderData $headerData): array
    {
        $items = [];

        foreach ($order->getItems() as $item) {
            if (!in_array($item->getProductType(), $this->allowedTypes)) {
                continue;
            }

            $items[] = $this->transform($item);
        }

        return [
            'items' => $items
        ];
    }

    private function transform(OrderItemInterface $orderItem)
    {
        return [
            'sku' => $orderItem->getSku(),
            'qty' => $orderItem->getQtyOrdered(),
            'item_price' => $orderItem->getBasePrice(),
            'item_cost' => $orderItem->getBaseCost(),
            'total' => $orderItem->getRowTotal()
        ];
    }}
