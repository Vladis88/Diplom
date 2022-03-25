<?php

namespace App\Service;

/**
 * Class CarPostOptions
 * @package App\Service
 */
class CarPostOptions
{
    /**
     * @var array
     */
    public static $carInfoData = array(
        'Год выпуска' => 'year',
        'Состояние' => 'shape',
        'Пробег' => 'mileage',
        'Тип топлива' => 'engine.type',
        'Объем' => 'engine.engineCapacity',
        'Цвет' => 'color',
        'Тип кузова' => 'bodyType',
        'Трансмиссия' => 'transmission',
        'Привод' => 'driveType',
        'Запас хода' => 'powerReserve'
    );
}
