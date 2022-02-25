<?php
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */
namespace Zumento\GiftCard\Observer;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Api\Data\InvoiceInterface;
use Magento\Sales\Api\Data\InvoiceItemInterface;
use Magento\Sales\Api\Data\OrderItemInterface;
use Magento\Sales\Api\OrderItemRepositoryInterface;
use Zumento\GiftCard\Constants;
use Zumento\GiftCard\Model\GiftCardFactory;
use Zumento\GiftCard\Model\Repository\GiftCardRepository;
use Zumento\GiftCard\Model\Type\GiftCard;

class RegisterGiftCard implements ObserverInterface
{
    /**
     * @var ProductCollectionFactory
     */
    private $productCollectionFactory;

    /** @var ProductInterface[] */
    private $productCache;
    /**
     * @var OrderItemRepositoryInterface
     */
    private $orderItemRepository;

    /** @var OrderItemInterface[]  */
    private $orderItemCache = [];
    /**
     * @var GiftCardFactory
     */
    private $giftCardFactory;
    /**
     * @var GiftCardRepository
     */
    private $giftCardRepository;

    public function __construct(
        ProductCollectionFactory $productCollectionFactory,
        OrderItemRepositoryInterface $orderItemRepository,
        GiftCardFactory $giftCardFactory,
        GiftCardRepository $giftCardRepository
    ) {

        $this->productCollectionFactory = $productCollectionFactory;
        $this->orderItemRepository = $orderItemRepository;
        $this->giftCardFactory = $giftCardFactory;
        $this->giftCardRepository = $giftCardRepository;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var InvoiceInterface $invoice */
        $invoice = $observer->getData('invoice');

        $giftcards = array_filter($invoice->getItems(), function (InvoiceItemInterface $invoiceItem) {
           if (!$invoiceItem->getProductId()) {
               return false;
           }

           $product = $this->getProduct((int)$invoiceItem->getProductId());
           return $product->getTypeId() === GiftCard::TYPE_CODE;
        });

        if (!count($giftcards)) {
           return;
        }

        foreach ($giftcards as $giftCardInvoiceItem) {
            $this->createGiftCard($giftCardInvoiceItem);
        }
    }

    private function createGiftCard(InvoiceItemInterface $invoiceItem)
    {
        $giftCard = $this->giftCardFactory->create();

        $orderItem = $this->getOrderItem($invoiceItem);

        $recipientEmail = $orderItem->getProductOptionByCode(Constants::OPTION_RECIPIENT_EMAIL);
        $recipientName = $orderItem->getProductOptionByCode(Constants::OPTION_RECIPIENT_NAME);

        if (!$recipientEmail) {
            throw new NoSuchEntityException(__('The recipient email was not set here.'));
        }

    }

    private function getOrderItem(InvoiceItemInterface $invoiceItem): OrderItemInterface
    {
        if (method_exists($invoiceItem, 'getOrderItem') && $invoiceItem->getOrderItem()) {
            return $invoiceItem->getOrderItem();
        }

        $orderItemId = $invoiceItem->getOrderItemId();

        if (isset($this->orderItemCache[$orderItemId])) {
           return $this->orderItemCache[$orderItemId];
        }

        $this->orderItemCache[$orderItemId] = $this->orderItemRepository->get($invoiceItem->getOrderItemId());

        return $this->orderItemCache[$orderItemId];
    }

    private function getProduct(int $productId): ProductInterface
    {
        if (isset($this->productCache[$productId])) {
            return $this->productCache[$productId];
        }

        $collection = $this->productCollectionFactory->create();
        $collection->addFieldToFilter('entity_id', $productId);
        $collection->setPageSize(1);

        $this->productCache[$productId] = $collection->getFirstItem();

        return $this->productCache[$productId];
    }
}
