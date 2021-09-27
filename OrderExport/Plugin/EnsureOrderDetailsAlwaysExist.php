<?php
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */
namespace Zumento\OrderExport\Plugin;

use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderInterfaceFactory;

class EnsureOrderDetailsAlwaysExist
{

    public function afterCreate(OrderInterfaceFactory $subject, OrderInterface $order)
    {
        $extensionAttributes = $order->getExtensionAttributes() ?? $this->extensionFactory->create();
        $extensionAttributes->setOrderExportDetails($this->detailsFactory->create());

        $order->setExtensionAttributes($extensionAttributes);
        return $order;
    }
}
