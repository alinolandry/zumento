<?php
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */
namespace Zumento\GiftCard\Model\Type;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\Product\Type\Virtual;
use Magento\Framework\DataObject;
use Zumento\GiftCard\Constants;

class GiftCard extends Virtual
{
    const TYPE_CODE = 'zumento_giftcard';

    /**
     * Check is product available for sale
     *
     * @param Product $product
     * @return bool
     */
    public function isSalable($product)
    {
        $salable = $product->getStatus() == \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED;
        $product->setData('is_salable', $salable);

        return (bool)(int)$salable;
    }

    /**
     * Initialize product(s) for add to cart process.
     *
     * Advanced version of func to prepare product for cart - processMode can be specified there.
     *
     * @param DataObject $buyRequest
     * @param Product $product
     * @param null|string $processMode
     * @return array|string
     */
    public function prepareForCartAdvanced(DataObject $buyRequest, $product, $processMode = null)
    {
        $products = parent::prepareForCartAdvanced($buyRequest, $product, $processMode);

        if (is_string($products)) {
            return $products;
        }

        foreach ($products as $product) {
            $this->assignProductOptions($buyRequest, $product);
        }

        return $products;
    }

    /**
     * @param DataObject $buyRequest
     * @param Product $product
     * @return void
     */
    private function assignProductOptions(DataObject $buyRequest, Product $product): void
    {
        foreach (Constants::OPTION_LIST as $option) {
            if (!$buyRequest->getData($option)) {
                continue;
            }

            $product->addCustomOption($option, $buyRequest->getData($option));
        }
    }


}
