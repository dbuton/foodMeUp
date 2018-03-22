<?php

namespace App\Helper;

use App\Entity\Unit;

/**
 * Class UnitHelper
 */
class UnitHelper
{
    /**
     * @param Unit $unit1
     * @param Unit $unit2
     *
     * @return string|null
     */
    public function getCommonUnit(Unit $unit1, Unit $unit2) : ? string
    {
        $unit1Ids = [];

        while($unit1 !== null) {
            $unit1Ids[] = $unit1->getId();

            $unit1 = $unit1->getReferenceUnit();
        }

        while ($unit2 !== null) {
            if (in_array($unit2->getId(), $unit1Ids) === true) {
                return $unit2->getId();
            }

            $unit2 = $unit2->getReferenceUnit();
        }

        return null;

    }

    /**
     * @param Unit   $unit1
     * @param string $commonUnitId
     *
     * @return int
     * @throws \Exception
     */
    public function getUnitsFactor(Unit $unit1, string $commonUnitId) : ? int
    {
        $factor = 1;

        while($unit1 !== null) {
            if ($unit1->getId() === $commonUnitId) {
                return $factor;
            }

            $factor = $factor * $unit1->getQuantity();
            $unit1 = $unit1->getReferenceUnit();
        }

        throw new \Exception('No common unit');
    }
}
