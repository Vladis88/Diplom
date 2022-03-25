<?php

namespace App\Model\Vehicle;

/**
 * Interface VehicleModelInterface
 */
interface VehicleModelInterface
{
    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @return VehicleMarkInterface|null
     */
    public function getMark(): ?VehicleMarkInterface;
}
