<?php
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */
namespace Zumento\GiftCard\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Quote\Model\Quote\Item as CartItem;
use Zumento\GiftCard\Constants;

class CartDetails implements ArgumentInterface
{
    public function getCartDetails(CartItem $item)
    {
        $codes = [
            (string)__('Recipient Name') => Constants::OPTION_RECIPIENT_NAME,
            (string)__('Recipient Email') => Constants::OPTION_RECIPIENT_EMAIL
        ];

        $output = array_map(function ($value) use ($item) {
            return $item->getOptionByCode($value)
                ? $item->getOptionByCode($value)->getValue()
                : '';
        }, $codes);

        return array_filter($output);
    }

}
