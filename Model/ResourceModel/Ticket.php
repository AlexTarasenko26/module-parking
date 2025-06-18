<?php
declare(strict_types=1);

namespace Epam\Parking\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Ticket extends AbstractDb
{
    private const string TABLE_NAME = 'parking_tickets';
    private const string PRIMARY_KEY = 'entity_id';
    protected function _construct()
    {
        $this->_init(self::TABLE_NAME, self::PRIMARY_KEY);
    }
}
