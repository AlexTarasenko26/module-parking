<?php
declare(strict_types=1);

namespace Epam\Parking\Api\Data;

interface ZoneInterface
{
    public function getId(): int;

    public function getName(): string;

    public function getLocation(): ?string;

    public function getMaxCapacity(): ?int;
}
