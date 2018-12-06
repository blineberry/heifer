<?php

require('volume.php');
require_once('units.php');

class MilkConverter {
    const HEAVYWHIPPINGCREAM = 'heavywhippingcream';
    const WHOLE = 'whole';
    const TWOPERCENT = 'twopercent';
    const ONEPERCENT = 'onepercent';
    const SKIM = 'skim';

    public $fatContent = array(
        self::HEAVYWHIPPINGCREAM => .36,
        self::WHOLE => .0325, 
        self::TWOPERCENT => .02,
        self::ONEPERCENT => .01,
        self::SKIM => 0,
    );

    public $dairyTypeDisplayNames = array(
        self::HEAVYWHIPPINGCREAM => "heavy whipping cream",
        self::WHOLE => "whole milk", 
        self::TWOPERCENT => "2% milk",
        self::ONEPERCENT => "1% milk",
        self::SKIM => "skim milk",
    );

    private $targetVolume;
    private $starter1Volume;
    private $starter2Volume;
    private $targetType;
    private $starter1Type;
    private $starter2Type;

    
    function __construct($targetVolume = 0, $targetType = self::WHOLE, $starter1Type = self::HEAVYWHIPPINGCREAM, $starter2Type = self::ONEPERCENT) {
        $targetVolume = new Volume((int) $targetVolume, Units::Cups);
        $this->targetVolume = $targetVolume;
        $this->starter1Type = $starter1Type;
        $this->starter2Type = $starter2Type;

        if ($targetVolume->getQty() <= 0) {
            return;
        }        

        if (!isset($this->fatContent[$targetType])) {
            return;
        }

        $targetFat = $this->fatContent[$targetType];
        $this->targetType = $targetType;

        $fat1 = $this->fatContent[$starter1Type];
        $fat2 = $this->fatContent[$starter2Type];

        $fatHigh;
        $fatLow;

        if ($fat1 > $fat2) {
            $fatHigh = $fat1;
            $fatLow = $fat2;
        }
        else {
            $fatHigh = $fat2;
            $fatLow = $fat1;
        }

        if ($fat1 < $targetFat) {
            return;
        }

        $fatHighVolume = new Volume(($targetFat - $fatLow) / ($fatHigh - $fatLow) * $targetVolume->getQty(), $targetVolume->getUnit());
        $fatLowVolume = new Volume($targetVolume->getQty() - $fatHighVolume->getQty(), $targetVolume->getUnit());

        $this->starter1Volume = $fatHighVolume;
        $this->starter2Volume = $fatLowVolume;
    }

    public function getTargetVolume() {
        return $this->targetVolume;
    }

    public function getTargetType() {
        return $this->targetType;
    }

    public function getInstructions() {
        if ($this->fatContent[$this->starter1Type] < $this->fatContent[$this->targetType] && $this->fatContent[$this->starter2Type] < $this->fatContent[$this->targetType]) {
            return "Can't make " . $this->dairyTypeDisplayNames[$this->targetType] . " from " . 
            $this->dairyTypeDisplayNames[$this->starter1Type] . " and " . 
            $this->dairyTypeDisplayNames[$this->starter2Type] . "!";
        }

        if ($this->targetVolume->getQty() > 0) {
            return "To get " . $this->targetVolume->getQty() . " " . Units::toString($this->targetVolume->getUnit(), $this->targetVolume->getQty() == 1) .
                " of " . $this->dairyTypeDisplayNames[$this->targetType] . ", use " . $this->starter1Volume->toPrettyString() . 
                " of " . $this->dairyTypeDisplayNames[$this->starter1Type] . " and " . $this->starter2Volume->toPrettyString() .
                " of " . $this->dairyTypeDisplayNames[$this->starter2Type] . ".";
        }

        return "";
    }

    public function getStarterTypes($selected) {
        $values = array(
            self::HEAVYWHIPPINGCREAM,
            self::WHOLE, 
            self::TWOPERCENT,
            self::ONEPERCENT,
            self::SKIM
        );

        $types = Array();

        foreach($values as $value) {
            $types[] = Array(
                "value" => $value,
                "text" => $this->dairyTypeDisplayNames[$value],
                "isSelected" => $selected == $value
            );
        }
        
        return $types;
    }

    public function getStarter1Types() {
        return $this->getStarterTypes($this->starter1Type);
    }

    public function getStarter2Types() {
        return $this->getStarterTypes($this->starter2Type);
    }

    public function getTargetTypes() {
        return $this->getStarterTypes($this->targetType);
    }
}

?>