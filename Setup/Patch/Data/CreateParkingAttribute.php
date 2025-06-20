<?php
declare(strict_types=1);

namespace Epam\Parking\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Catalog\Model\Product;
use Magento\Eav\Api\AttributeSetRepositoryInterface;
use Magento\Eav\Model\Config as EavConfig;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

class CreateParkingAttribute implements DataPatchInterface
{
    public function __construct(
        private readonly ModuleDataSetupInterface $moduleDataSetup,
        private readonly EavSetupFactory $eavSetupFactory,
        private readonly AttributeSetRepositoryInterface $attributeSetRepository,
        private readonly EavConfig $eavConfig
    ) {}

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();

        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $entityType = Product::ENTITY;
        $entityTypeId = $eavSetup->getEntityTypeId($entityType);

        try {
            $eavSetup->addAttribute(
                $entityType,
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
                    'visible_on_front' => false,
                    'used_in_product_listing' => true,
                    'user_defined' => true,
                    'group' => 'General',
                    'apply_to' => 'virtual',
                ]
            );

            $eavSetup->addAttribute(
                $entityType,
                'zone_id',
                [
                    'type' => 'int',
                    'label' => 'Parking Zone',
                    'input' => 'select',
                    'source' => \Epam\Parking\Model\Attribute\Source\Parking\Zone::class,
                    'required' => false,
                    'default' => '',
                    'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
                    'visible' => true,
                    'visible_on_front' => true,
                    'used_in_product_listing' => true,
                    'user_defined' => true,
                    'group' => 'General',
                    'apply_to' => 'virtual',
                ]
            );


            $defaultAttributeSetId = $eavSetup->getDefaultAttributeSetId($entityTypeId);
            $defaultGroupId = $this->attributeSetRepository->get($defaultAttributeSetId)->getDefaultGroupId();

            foreach (['is_parking_ticket', 'zone_id'] as $attributeCode) {
                $attribute = $this->eavConfig->getAttribute($entityType, $attributeCode);
                $attribute->setAttributeSetId($defaultAttributeSetId);
                $attribute->setAttributeGroupId($defaultGroupId);
                $attribute->save();
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

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
