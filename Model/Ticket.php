<?php
declare(strict_types=1);

namespace Epam\Parking\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Epam\Parking\Model\ResourceModel\Ticket as ResourceModel;

class Ticket extends AbstractExtensibleModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    public function getCustomAttributesCodes()
    {
        return array('entity_id', 'parking_zone_id', 'car_plate_number', 'start_time', 'end_time', 'status');
    }
}
