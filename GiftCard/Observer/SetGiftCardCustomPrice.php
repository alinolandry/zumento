<?php
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */
namespace Zumento\GiftCard\Observer;


use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\Address;
use Magento\Quote\Model\Quote;
use Magento\Quote\Model\Quote\Item as QuoteItem;
use Zumento\GiftCard\Constants;
use Zumento\GiftCard\Model\Type\GiftCard;

class SetGiftCardCustomPrice implements ObserverInterface
{

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var Quote $quote */
        $quote = $observer->getData('quote');

        /** @var Address $address */
        foreach ($quote->getAllAddresses() as $address){
            /** @var QuoteItem $item */
            foreach ($address->getAllItems() as $item) {
                if($item->getProductType() !== GiftCard::TYPE_CODE
                    || !$item->getOptionByCode(Constants::OPTION_AMOUNT)
                    || !$item->getOptionByCode(Constants::OPTION_AMOUNT)->getValue()
                ) {
                    continue;
                }

                $item->setCustomPrice($item->getOptionByCode(Constants::OPTION_AMOUNT)->getValue());
                $item->setOriginalCustomPrice($item->getOptionByCode(Constants::OPTION_AMOUNT)->getValue());
            }
        }
    }
}
