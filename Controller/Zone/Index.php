<?php

namespace Epam\Parking\Controller\Zone;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Epam\Parking\Model\ResourceModel\Parking\Zone\CollectionFactory;

/**
 * Catalog index page controller.
 */
class Index implements HttpGetActionInterface
{

    public function __construct(
        private readonly JsonFactory $resultJsonFactory,
        private readonly CollectionFactory $zoneCollectionFactory
    ) {
    }

    public function execute()
    {
        $collection = $this->zoneCollectionFactory->create();
        $zones = [];

        foreach ($collection as $zone) {
            $zones[] = [
                'id' => $zone->getId(),
                'name' => $zone->getName(),
                'location' => $zone->getLocation(),
            ];
        }

        return $this->resultJsonFactory->create()->setData($zones);
    }
}
