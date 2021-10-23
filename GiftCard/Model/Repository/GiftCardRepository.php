<?php
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */

namespace Zumento\GiftCard\Model\Repository;

use Magento\Framework\Api\SearchCriteriaInterface;
use Zumento\GiftCard\Api\Data\GiftCardInterface;
use Zumento\GiftCard\Api\Data\GiftCardSearchResultsInterface;
use Zumento\GiftCard\Model\GiftCardFactory;
use Zumento\GiftCard\Model\ResourceModel\GiftCard as GiftCardResourceModel;
use Zumento\GiftCard\Model\ResourceModel\GiftCard\CollectionFactory as GiftCardCollectionFactory;
use Zumento\GiftCard\Api\Data\GiftCardSearchResultsInterfaceFactory as SearchResultsFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;


class GiftCardRepository
{
    /**
     * @var GiftCardResourceModel
     */
    protected $resource;

    /**
     * @var GiftCardFactory
     */
    protected $modelFactory;

    /**
     * @var GiftCardCollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var SearchResultsFactory
     */
    protected $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;


    public function __construct(
        GiftCardResourceModel $resource,
        GiftCardFactory $giftCardFactory,
        GiftCardCollectionFactory $giftCardCollectionFactory,
        SearchResultsFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->modelFactory = $giftCardFactory;
        $this->collectionFactory = $giftCardCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }


    public function save(GiftCardInterface $giftCard)
    {
        try {
            $this->resource->save($giftCard);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $giftCard;
    }

    public function getById(int $giftCardId): GiftCardInterface
    {
        $gitfCard = $this->modelFactory->create();
        $this->resource->load($gitfCard, $giftCardId);
        if (!$gitfCard->getId()) {
            throw new NoSuchEntityException(__('The gift card with the "%1" ID doesn\'t exist.', $giftCardId));
        }
        return $gitfCard;
    }

    public function getByCode(string $code): GiftCardInterface
    {
        $gitfCard = $this->modelFactory->create();
        $this->resource->load($gitfCard, $code, 'code');
        if (!$gitfCard->getId()) {
            throw new NoSuchEntityException(__('The gift card with the code "%1" ID doesn\'t exist.', $code));
        }
        return $gitfCard;
    }


    public function getList(SearchCriteriaInterface $criteria)
    {
        /** @var \Zumento\GiftCard\Model\ResourceModel\GiftCard\Collection */
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var GiftCardSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    public function delete(GiftCardInterface $giftCard)
    {
        try {
            $this->resource->delete($giftCard);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    public function deleteById($giftCardId)
    {
        return $this->delete($this->getById($giftCardId));
    }
}
