<?php
declare(strict_types=1);

namespace Epam\Parking\Model\Attribute\Source\Parking;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Epam\Parking\Model\ResourceModel\Parking\Zone\CollectionFactory;

class Zone extends AbstractSource
{
    public function __construct(private readonly CollectionFactory $zoneCollectionFactory)
    {
    }

    public function getAllOptions()
    {
        if ($this->_options === null) {
            $collection = $this->zoneCollectionFactory->create();
            $this->_options = [];

            foreach ($collection as $zone) {
                $this->_options[] = [
                    'label' => $zone->getName(),
                    'value' => $zone->getId()
                ];
            }
        }

        return $this->_options;
    }
}
