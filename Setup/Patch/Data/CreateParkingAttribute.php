<?php
declare(strict_types=1);

namespace Epam\Parking\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Catalog\Model\Product;
use Magento\Eav\Api\AttributeSetRepositoryInterface;
use Magento\Eav\Api\AttributeSetManagementInterface;
use Magento\Eav\Api\Data\AttributeSetInterfaceFactory;
use Magento\Eav\Model\Config;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class CreateParkingAttribute implements DataPatchInterface
{
    public function __construct(
        private ModuleDataSetupInterface $moduleDataSetup,
        private EavSetupFactory $eavSetupFactory,
        private AttributeSetRepositoryInterface $attributeSetRepository,
        private AttributeSetManagementInterface $attributeSetManagement,
        private AttributeSetInterfaceFactory $attributeSetFactory,
        private Config $eavConfig
    ) {}

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $entityTypeCode = Product::ENTITY;
        $entityTypeId = $eavSetup->getEntityTypeId($entityTypeCode);

        // Add attribute
        $eavSetup->addAttribute(
            $entityTypeCode,
            'is_parking_ticket',
            [
                'type' => 'int',
                'label' => 'Is Parking Ticket',
                'input' => 'boolean',
                'source' => \Magento\Eav\Model\Entity\Attribute\Source\Boolean::class,
                'required' => false,
                'default' => 0,
                'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                'visible' => true,
                'visible_on_front' => true,
                'used_in_product_listing' => true,
                'user_defined' => true,
                'group' => 'General',
                'apply_to' => 'virtual',
            ]
        );

        // Assign attribute to attribute set and group
        $defaultAttributeSetId = $eavSetup->getDefaultAttributeSetId($entityTypeId);
        $attributeSet = $this->attributeSetRepository->get($defaultAttributeSetId);
        $defaultGroupId = $attributeSet->getDefaultGroupId();

        $attribute = $this->eavConfig->getAttribute($entityTypeCode, 'is_parking_ticket');
        $attribute->setAttributeSetId($defaultAttributeSetId);
        $attribute->setAttributeGroupId($defaultGroupId);
        $attribute->save();

        $this->moduleDataSetup->getConnection()->endSetup();
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
