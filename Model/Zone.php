<?php
declare(strict_types=1);

namespace Epam\Parking\Model;

use Magento\Framework\Model\AbstractModel;
use Epam\Parking\Model\ResourceModel\Zone as ResourceModel;

class Zone extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

}
