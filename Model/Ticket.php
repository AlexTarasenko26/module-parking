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

}
