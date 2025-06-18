<?php
declare(strict_types=1);

namespace Epam\Parking\Setup\Patch\Data;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Catalog\Model\Product;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Eav\Api\AttributeSetManagementInterface;
use Magento\Eav\Api\Data\AttributeSetInterfaceFactory;
use Magento\Eav\Api\AttributeSetRepositoryInterface;
use Magento\Eav\Model\Config;

class CreateParkingAttributeSet implements DataPatchInterface
{
    public function __construct(
        private ModuleDataSetupInterface $moduleDataSetup,
        private EavSetupFactory $eavSetupFactory,
        private AttributeSetInterfaceFactory $attributeSetFactory,
        private AttributeSetManagementInterface $attributeSetManagement,
        private AttributeSetRepositoryInterface $attributeSetRepository,
        private Config $eavConfig
    ) {}

    public function apply()
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        $entityTypeCode = Product::ENTITY;
        $entityTypeId = $eavSetup->getEntityTypeId($entityTypeCode);
        $defaultSetId = $eavSetup->getDefaultAttributeSetId($entityTypeId);

        // Create the attribute set from skeleton (default)
        $attributeSet = $this->attributeSetFactory->create();
        $attributeSet->setAttributeSetName('Parking Ticket')
            ->setEntityTypeId($entityTypeId);

        $attributeSet = $this->attributeSetManagement->create(
            $entityTypeCode,
            $attributeSet,
            $defaultSetId
        );

        $attributeSetId = $attributeSet->getAttributeSetId();
        $defaultGroupId = $this->attributeSetRepository->get($attributeSetId)->getDefaultGroupId();

        // Define parking-related attributes
        $attributes = [
            'car_plate_number' => [
                'type' => 'varchar',
                'label' => 'Car Plate Number',
                'input' => 'text',
            ],
            'parking_zone' => [
                'type' => 'varchar',
                'label' => 'Parking Zone',
                'input' => 'select',
                'source' => \Epam\Parking\Model\Attribute\Source\Parking\Zone::class,
            ],
            'start_time' => [
                'type' => 'datetime',
                'label' => 'Start Time',
                'input' => 'date',
                'backend' => \Magento\Eav\Model\Entity\Attribute\Backend\Datetime::class,
            ],
            'end_time' => [
                'type' => 'datetime',
                'label' => 'End Time',
                'input' => 'date',
                'backend' => \Magento\Eav\Model\Entity\Attribute\Backend\Datetime::class,
            ],
        ];

        // Add attributes to entity and assign to the new attribute set/group
        foreach ($attributes as $code => $data) {
            $eavSetup->addAttribute(
                $entityTypeCode,
                $code,
                array_merge([
                    'group' => 'General',
                    'required' => false,
                    'user_defined' => true,
                    'global' => ScopedAttributeInterface::SCOPE_STORE,
                    'visible_on_front' => false,
                    'used_in_product_listing' => true,
                    'searchable' => false,
                    'filterable' => false,
                    'comparable' => false,
                    'is_used_in_grid' => true,
                    'is_visible_in_grid' => true,
                    'is_filterable_in_grid' => true,
                ], $data)
            );

            $attribute = $this->eavConfig->getAttribute($entityTypeCode, $code);
            $attribute->setAttributeSetId($attributeSetId)
                ->setAttributeGroupId($defaultGroupId)
                ->save();
        }

        $this->moduleDataSetup->getConnection()->endSetup();
    }

    public function getAliases()
    {
        return [];
    }

    public static function getDependencies()
    {
        return [];
    }
}
