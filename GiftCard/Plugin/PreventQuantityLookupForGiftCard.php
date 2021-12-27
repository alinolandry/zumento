<?php
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */
namespace Zumento\GiftCard\Plugin;

use Magento\CatalogInventory\Model\Quote\Item\QuantityValidator;
use Magento\Framework\Event\Observer;
use Magento\Quote\Model\Quote\Item;
use Zumento\GiftCard\Model\Type\GiftCard;

class PreventQuantityLookupForGiftCard
{
    public function aroundValidate(QuantityValidator $sobject, callable $proceed, Observer $observer)
    {
        /* @var $quoteItem Item */
        $quoteItem = $observer->getEvent()->getItem();
        if (!$quoteItem ||
            !$quoteItem->getProductId() ||
            !$quoteItem->getQuote()
        ) {
            return;
        }

        $product = $quoteItem->getProduct();
        if ($product->getTypeId() === GiftCard::TYPE_CODE) {
            return;
        }


        return $proceed($observer);
    }

}
