<?php
/**
 * PHP version 7.3
 * @author    Alain Landry Noutchomwo
 * @package    Zumento
 * @email    alinolandry@gmail.com
 * */

namespace Zumento\OrderExport\Service;

use Magento\Framework\App\RequestInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

/**
 * Service Order Provider Class
 */
class Order
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @param RequestInterface $request
     * @param OrderRepositoryInterface $orderRepository
     */
    public function __construct(RequestInterface $request, OrderRepositoryInterface $orderRepository)
    {
        $this->request = $request;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @return \Magento\Sales\Api\Data\OrderInterface
     */
    public function get(): OrderInterface
    {
        return $this->orderRepository->get(
            (int)$this->request->getParam('order_id')
        );
    }
}
