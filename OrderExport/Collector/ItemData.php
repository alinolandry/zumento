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
use Zumento\OrderExport\Api\DataCollectorInterface;
use Zumento\OrderExport\Model\HeaderData;

class ItemData implements DataCollectorInterface
{

    /** @var string[] */
    private $allowedProductTypes;

    /**
     * @var ProductCollectionFactory
     */
    private $productCollectionFactory;

    /**
     * @param array $allowedProductTypes
     * @param ProductCollectionFactory $collectionFactory
     */
    public function __construct(array $allowedProductTypes, ProductCollectionFactory $productCollectionFactory)
    {

        $this->allowedProductTypes = $allowedProductTypes;
        $this->productCollectionFactory = $productCollectionFactory;
    }

    public function collect(OrderInterface $order, HeaderData $headerData): array
    {
        $items = $order->getItems();

        $items = array_filter($items, function (OrderInterface $orderItem) {
            return in_array(
                $this->getProductTypeFor((int)$orderItem->getProductId()),
                $this->allowedProductTypes
            );
        });

        /** @var OrderInterface $item */
        return array_map(function (OrderInterface $item) {
            return [
                "sku" => $item->getSku(),
                "qty" => $item->getQtyOrdered(),
                "item_price" => $item->getBasePrice(),
                "item_cost" => $item->getBaseCost(),
                "total" => $item->getRowTotal()
            ];
        }, $items);

    }

    private function getProductTypeFor(int $productId): string
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addFieldToFilter('entity_id', ['eq' => $productId]);

        /** @var Product $product */
        $product = $collection->getFirstItem();

        if (!$product->getId()) {
            throw new NoSuchEntityException(__('This product doesnt exist'));
        }

        return (string)$product->getTypeId();
    }
}
