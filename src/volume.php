<?php

require_once('units.php');

class Volume {
    private $ounces;
    private $unit;

    private $teaspoonsPerOunce = 6;
    private $tablespoonsPerOunce = 2;
    private $ouncesPerCup = 8;

    function __construct ($qty, $unit) {
        $this->unit = $unit;

        switch($unit) {
            case Units::Ounces:
                $this->ounces = $qty;
                break;
            case Units::Teaspoons:
                $this->ounces = $qty / $this->teaspoonsPerOunce;
                break;
            case Units::Tablespoons:
                $this->ounces = $qty / $this->tablespoonsPerOunce;
                break;
            case Units::Cups:
                $this->ounces = $qty * $this->ouncesPerCup;
                break;
            default:
                throw new Exception('unknown unit');
                break;
        }
    }

    public function getQty() {
        return $this->to($this->unit);
    }

    public function getUnit() {
        return $this->unit;
    }

    public function to($unit) {
        switch($unit) {
            case Units::Ounces:
                return $this->ounces;
            case Units::Teaspoons:
                return $this->ounces * $this->teaspoonsPerOunce;
            case Units::Tablespoons:
                return $this->ounces * $this->tablespoonsPerOunce;
                break;
            case Units::Cups:
                return $this->ounces / $this->ouncesPerCup;
                break;
            default:
                throw new Exception('unknown unit');
                break;
        }
    }

    public function toPrettyString() {
        $str = "";
        $workingOunces = $this->ounces;
        $workingUnits = [];

        if ($workingOunces >= $this->ouncesPerCup / 4) {
            $cups = floor($workingOunces * 4 / $this->ouncesPerCup) / 4;
            $workingUnits[] = "$cups " . Units::toString(Units::Cups, $cups == 1);
            $workingOunces -= $cups * $this->ouncesPerCup;
        }

        if ($workingOunces >= 1 / $this->tablespoonsPerOunce) {
            $tbsp = floor($workingOunces * $this->tablespoonsPerOunce);
            $workingUnits[] = "$tbsp " . Units::toString(Units::Tablespoons, $tbsp == 1);
            $workingOunces -= $tbsp / $this->tablespoonsPerOunce;
        }

        if ($workingOunces >= 1 / $this->teaspoonsPerOunce) {
            $tsp = floor($workingOunces * 4 * $this->teaspoonsPerOunce) / 4;
            $workingUnits[] = "$tsp " . Units::toString(Units::Teaspoons, $tsp == 1);
        }

        if (count($workingUnits) === 0) {
            return 0;
        }

        if (count($workingUnits) ===1) {
            return $workingUnits[0];
        }

        if (count($workingUnits) === 2) {
            return join(" and ", $workingUnits);
        }

        $workingUnits[count($workingUnits) - 1] = "and " . $workingUnits[count($workingUnits) - 1];

        return join(", ", $workingUnits);
    }
}

?>