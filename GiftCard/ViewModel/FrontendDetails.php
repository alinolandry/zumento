<?php
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */
namespace Zumento\GiftCard\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Zumento\GiftCard\Attributes;
use Zumento\GiftCard\Service\Product as ProductService;

class FrontendDetails implements ArgumentInterface
{
    /**
     * @var ProductService
     */
    private $productService;

    public function __construct(ProductService $productService)
    {

        $this->productService = $productService;
    }

    public function getIsCustomAllowed(): bool
    {
        $product = $this->productService->get();

        if ($value = $product->getData(Attributes::IS_CUSTOM_ALLOWED)) {
            return (bool)$value;
        } elseif ($product->getCustomAttribute(Attributes::IS_CUSTOM_ALLOWED)) {
            return $product->getCustomAttribute(Attributes::IS_CUSTOM_ALLOWED)->getValue();
        }

        return false;
    }

}
