<?php

namespace App\Model\Filter;

/**
 * Class SimpleFilterModel
 */
class SimpleFilterModel
{
    /**
     * @var integer
     */
    private $mark;

    /**
     * @var integer
     */
    private $model;

    /**
     * @var integer
     */
    private $generation;

    /**
     * @return array
     */
    public function getConditions()
    {
         return [
            'mark' => $this->mark,
            'model' => $this->model,
            'generation' => $this->generation
        ];
    }

    /**
     * @return int
     */
    public function getMark(): ?int
    {
        return $this->mark;
    }

    /**
     * @param int $mark
     * @return SimpleFilterModel
     */
    public function setMark(int $mark): SimpleFilterModel
    {
        $this->mark = $mark;
        return $this;
    }

    /**
     * @return int
     */
    public function getModel(): ?int
    {
        return $this->model;
    }

    /**
     * @param int $model
     * @return SimpleFilterModel
     */
    public function setModel(int $model): SimpleFilterModel
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return int
     */
    public function getGeneration(): ?int
    {
        return $this->generation;
    }

    /**
     * @param int $generation
     * @return SimpleFilterModel
     */
    public function setGeneration(int $generation): SimpleFilterModel
    {
        $this->generation = $generation;
        return $this;
    }
}
