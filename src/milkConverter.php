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
        self::ONEPERCENT => "1 % milk",
        self::SKIM => "skim milk",
    );

    private $targetVolume;
    private $whippingCreamVolume;
    private $onePercentVolume;
    private $targetType;
    
    function __construct($targetVolume = 0, $targetType = self::WHOLE) {
        $targetVolume = new Volume((int) $targetVolume, Units::Cups);

        if ($targetVolume->getQty() <= 0) {
            return;
        }
        
        $this->targetVolume = $targetVolume;

        if (!isset($this->fatContent[$targetType])) {
            return;
        }

        $targetFat = $this->fatContent[$targetType];
        $this->targetType = $targetType;

        $fatHigh = $this->fatContent[self::HEAVYWHIPPINGCREAM];
        $fatLow = $this->fatContent[self::ONEPERCENT];

        $fatHighVolume = new Volume(($targetFat - $fatLow) / ($fatHigh - $fatLow) * $targetVolume->getQty(), $targetVolume->getUnit());
        $fatLowVolume = new Volume($targetVolume->getQty() - $fatHighVolume->getQty(), $targetVolume->getUnit());

        $this->whippingCreamVolume = $fatHighVolume;
        $this->onePercentVolume = $fatLowVolume;
    }

    public function getTargetVolume() {
        return $this->targetVolume;
    }

    public function getTargetType() {
        return $this->targetType;
    }

    public function getInstructions() {
        if ($this->targetVolume->getQty() > 0) {
            return "To get " . $this->targetVolume->getQty() . " " . Units::toString($this->targetVolume->getUnit(), $this->targetVolume->getQty() == 1) .
                " of whole milk, use " . $this->whippingCreamVolume->toPrettyString() . 
                " of whipping cream and " . $this->onePercentVolume->toPrettyString() .
                " of 1% milk.";
        }

        return "";
    }
}

?>