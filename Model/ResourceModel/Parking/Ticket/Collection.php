<?php
declare(strict_types=1);

namespace Epam\Parking\Model\ResourceModel\Parking\Ticket;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    protected function _construct()
    {
        $this->_init(\Epam\Parking\Model\Ticket::class, \Epam\Parking\Model\ResourceModel\Ticket::class);
    }
}
