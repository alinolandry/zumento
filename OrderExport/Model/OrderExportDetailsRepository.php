<?php
declare(strict_types=1);
/**
 * @by Alain Landry Noutchomwo
 * @alias Zumento
 */


namespace Zumento\OrderExport\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Zumento\OrderExport\Api\Data\OrderExportDetailsInterface;
use Zumento\OrderExport\Api\Data\OrderExportDetailsSearchResultInterface;
use Zumento\OrderExport\Api\Data\OrderExportDetailsSearchResultInterfaceFactory;
use Zumento\OrderExport\Model\ResourceModel\OrderExportDetails as OrderExportDetailsResource;
use Zumento\OrderExport\Model\ResourceModel\OrderExportDetails\Collection as OrderExportDetailsCollection;
use Zumento\OrderExport\Model\ResourceModel\OrderExportDetails\CollectionFactory as DetailsCollectionFactory;


class OrderExportDetailsRepository
{
    /**
     * @var OrderExportDetailsResource
     */
    protected $resource;

    /**
     * @var OrderExportDetailsFactory
     */
    protected $detailsFactory;

    /**
     * @var DetailsCollectionFactory
     */
    protected $detailsCollectionFactory;

    /**
     * @var OrderExportDetailsSearchResultInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;


    public function __construct(
        OrderExportDetailsResource                     $resource,
        OrderExportDetailsFactory                      $detailsFactory,
        DetailsCollectionFactory                       $detailsCollectionFactory,
        OrderExportDetailsSearchResultInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface                   $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->detailsFactory = $detailsFactory;
        $this->detailsCollectionFactory = $detailsCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    public function save (OrderExportDetailsInterface $orderExportDetails)
    {
        try {
            $this->resource->save($orderExportDetails);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $orderExportDetails;
    }

    public function getById ($detailsId)
    {
        $details = $this->detailsFactory->create();
        $this->resource->load($details, $detailsId);
        if (!$details->getId()) {
            throw new NoSuchEntityException(__('The details with the "%1" ID doesn\'t exist.', $detailsId));
        }
        return $details;
    }

    public function getList (SearchCriteriaInterface $criteria)
    {
        /** @var OrderExportDetailsCollection $collection */
        $collection = $this->detailsCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var OrderExportDetailsSearchResultInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    public function delete (OrderExportDetailsInterface $orderExportDetails)
    {
        try {
            $this->resource->delete($orderExportDetails);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    public function deleteById ($detailsId)
    {
        return $this->delete($this->getById($detailsId));
    }

}
