<?php
declare(strict_types=1);

namespace Epam\Parking\Model;

use Magento\Framework\Model\AbstractModel;
use Epam\Parking\Model\ResourceModel\Zone as ResourceModel;
use Epam\Parking\Api\Data\ZoneInterface;

class Zone extends AbstractModel implements ZoneInterface
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    public function getId(): int
    {
        return (int) $this->_getData('entity_id');
    }

    public function getName(): string
    {
        return (string) $this->_getData('name');
    }

    public function getLocation(): ?string
    {
        return $this->_getData('location');
    }

    public function getMaxCapacity(): ?int
    {
        $val = $this->_getData('max_capacity');
        return $val !== null ? (int)$val : null;
    }
}
