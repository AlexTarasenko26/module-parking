<?php
declare(strict_types=1);

namespace Epam\Parking\Api;

use Epam\Parking\Api\Data\ZoneInterface;
interface ZoneRepositoryInterface
{
    public function getById(int $id): ZoneInterface;

}
