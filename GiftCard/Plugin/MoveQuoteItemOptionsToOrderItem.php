<?php
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */
namespace Zumento\GiftCard\Plugin;

use Magento\Quote\Api\Data\CartItemInterface;
use Magento\Quote\Model\Quote\Address\Item as AddressItem;
use Magento\Quote\Model\Quote\Item;
use Magento\Quote\Model\Quote\Item\ToOrderItem;
use Magento\Quote\Model\ResourceModel\Quote\Item\Option\CollectionFactory as QuoteItemOptionCollectionFactory;
use Magento\Sales\Api\Data\OrderItemInterface;
use Zumento\GiftCard\Constants;
use Zumento\GiftCard\Model\Type\GiftCard;

class MoveQuoteItemOptionsToOrderItem
{
    private $collectionFactory;


    public function __construct(QuoteItemOptionCollectionFactory $collectionFactory )
    {
        $this->collectionFactory = $collectionFactory;
    }


    /**
     * @param \Magento\Quote\Model\Quote\Item\ToOrderItem $subject
     * @param \Magento\Sales\Api\Data\OrderItemInterface $orderItem
     * @param \Magento\Quote\Api\Data\CartItemInterface $cartItem
     * @param $data
     * @return \Magento\Sales\Api\Data\OrderItemInterface
     */
    public function afterConvert(ToOrderItem $subject, OrderItemInterface $orderItem, CartItemInterface $cartItem, $data = [])
    {
        if($cartItem->getProductType() !== GiftCard::TYPE_CODE) {
            return $orderItem;
        }

        $orderItemOptions = $orderItem->getProductOptions();

        $quoteItemOptions = $this->collectionFactory->create()
            ->addFieldToFilter('item_id', $cartItem->getId());

        /** @var Item\Option $option */
        foreach ($quoteItemOptions as $option) {
            if(!in_array($option->getData('code'), Constants::OPTION_LIST)) {
                continue;
            }

            $orderItemOptions[$option->getData('code')] = $option->getData('value');

        }

        $orderItem->setProductOptions($orderItemOptions);

        return $orderItem;
    }
}
