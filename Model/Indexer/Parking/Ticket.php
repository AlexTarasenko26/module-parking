<?php
declare(strict_types=1);

namespace Epam\Parking\Model\Indexer\Parking;

use Magento\Framework\Indexer\ActionInterface;
use Magento\Framework\Mview\ActionInterface as MviewActionInterface;

class Ticket implements ActionInterface, MviewActionInterface
{
    public function execute($ids)
    {
        //TODO: Reindex specific entities
        // Example: Update zone usage or aggregate per zone
        // You can log $ids to verify
    }

    public function executeFull()
    {
        //TODO: Full reindex logic
    }

    public function executeList(array $ids): void
    {
        $this->execute($ids);
    }

    public function executeRow($id)
    {
        $this->execute([$id]);
    }
}
