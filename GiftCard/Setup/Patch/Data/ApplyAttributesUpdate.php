<?php
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */

namespace Zumento\GiftCard\Setup\Patch\Data;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Zumento\GiftCard\Model\Type\GiftCard;

/**
 * Class \Zumento\GiftCard\Setup\Patch\ApplyAttributesUpdate
 */
class ApplyAttributesUpdate implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    const PRICE_ATTR = 'price';

    /**
     * ApplyAttributesUpdate constructor.
     *
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface           $moduleDataSetup,
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
    )
    {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @inheritdoc
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function apply()
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);


        $applyTo = explode(
            ',',
            $eavSetup->getAttribute(\Magento\Catalog\Model\Product::ENTITY, self::PRICE_ATTR, 'apply_to')
        );
        if (!in_array(GiftCard::TYPE_CODE, $applyTo)) {
            $applyTo[] = GiftCard::TYPE_CODE;
            $eavSetup->updateAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                self::PRICE_ATTR,
                'apply_to',
                implode(',', $applyTo)
            );
        }

    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }
}

