<?php

namespace App\Model\Vehicle;

/**
 * Interface VehicleGenerationInterface
 */
interface VehicleGenerationInterface
{
    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @return VehicleModelInterface|null
     */
    public function getModel(): ?VehicleModelInterface;
}
