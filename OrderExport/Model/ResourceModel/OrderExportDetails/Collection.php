<?php
declare(strict_types=1);
/**
 * @by Alain Landry Noutchomwo
 * @alias Zumento
 * */

namespace Zumento\OrderExport\Model\ResourceModel\OrderExportDetails;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Zumento\OrderExport\Model\OrderExportDetails as OrderExportDetailsModel;
use Zumento\OrderExport\Model\ResourceModel\OrderExportDetails as OrderExportDetailsResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(OrderExportDetailsModel::class, OrderExportDetailsResourceModel::class);
    }

}
