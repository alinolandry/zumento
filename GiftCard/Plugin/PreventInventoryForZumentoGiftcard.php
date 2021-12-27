<?php
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */
namespace Zumento\GiftCard\Plugin;


use Magento\InventoryCatalogApi\Model\GetProductTypesBySkusInterface;
use Magento\InventorySales\Model\IsProductSalableForRequestedQtyCondition\IsProductSalableForRequestedQtyConditionChain;
use Magento\InventorySalesApi\Api\Data\ProductSalableResultInterface;
use Magento\InventorySalesApi\Api\Data\ProductSalableResultInterfaceFactory;
use Zumento\GiftCard\Model\Type\GiftCard;


class PreventInventoryForZumentoGiftcard
{
    private $productSalableResultInterfaceFactory;
    private $getProductTypesBySkus;

    public function __construct (
        ProductSalableResultInterfaceFactory $productSalableResultInterfaceFactory,
        GetProductTypesBySkusInterface $getProductTypesBySkus
    ) {
        $this->productSalableResultInterfaceFactory = $productSalableResultInterfaceFactory;
        $this->getProductTypesBySkus = $getProductTypesBySkus;
    }

    public function aroundExecute(
        IsProductSalableForRequestedQtyConditionChain $subject,
        callable $proceed,
        string $sku,
        ...$args
    ): ProductSalableResultInterface
    {
        if ($this->getProductTypesBySkus->execute([$sku])[$sku] === GiftCard::TYPE_CODE) {
            return $this->productSalableResultFactory->create(['errors' => []]);
        }

        return $proceed($sku, ...$args);
    }

}
