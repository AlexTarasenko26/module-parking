<?php
declare(strict_types=1);

namespace Epam\Parking\Model\ResourceModel\Parking\Zone;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(\Epam\Parking\Model\Zone::class, \Epam\Parking\Model\ResourceModel\Zone::class);
    }
}
