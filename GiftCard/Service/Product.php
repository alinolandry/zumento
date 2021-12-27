<?php
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */
namespace Zumento\GiftCard\Service;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class Product
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var RequestInterface
     */
    private $request;

    public function __construct(ProductRepositoryInterface $productRepository, RequestInterface $request)
    {

        $this->productRepository = $productRepository;
        $this->request = $request;
    }

    public function get()
    {
        if (!$this->request->getParam('id')) {
            throw new NoSuchEntityException(__("Product ID not specified"));
        }

        return $this->productRepository->getById($this->request->getParam('id'));
    }

}
