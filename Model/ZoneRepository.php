<?php
declare(strict_types=1);

namespace Epam\Parking\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Epam\Parking\Api\Data\ZoneInterface;
use Epam\Parking\Api\ZoneRepositoryInterface;
use Epam\Parking\Model\ResourceModel\Zone as ZoneResource;
use Epam\Parking\Model\ZoneFactory;

class ZoneRepository implements ZoneRepositoryInterface
{
    public function __construct(
        private readonly ZoneFactory $zoneFactory,
        private readonly ZoneResource $resourceModel
    ) {}

    public function getById(int $id): ZoneInterface
    {
        $zone = $this->zoneFactory->create();
        $this->resourceModel->load($zone, $id);
        if (!$zone->getId()) {
            throw new NoSuchEntityException(__('Zone with id "%s" not found.', $id));
        }

        return $zone;
    }
}
