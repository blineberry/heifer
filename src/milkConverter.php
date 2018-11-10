<?php

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

    private $targetQty;
    private $whippingCreamQty;
    private $onePercentQty;
    private $targetType;
    
    function __construct($targetQty = 0, $targetType = self::WHOLE) {
        $targetQty = (int) $targetQty;

        if ($targetQty <= 0) {
            return;
        }
        
        $this->targetQty = $targetQty;

        if (!isset($this->fatContent[$targetType])) {
            return;
        }

        $targetFat = $this->fatContent[$targetType];
        $this->targetType = $targetType;

        $fatHigh = $this->fatContent[self::HEAVYWHIPPINGCREAM];
        $fatLow = $this->fatContent[self::ONEPERCENT];

        $fatHighQty = ($targetFat - $fatLow) / ($fatHigh - $fatLow) * $targetQty;
        $fatLowQty = $targetQty - $fatHighQty;

        $this->whippingCreamQty = $fatHighQty;
        $this->onePercentQty = $fatLowQty;
    }

    public function getTargetQty() {
        return $this->targetQty;
    }

    public function getTargetType() {
        return $this->targetType;
    }

    public function getInstructions() {
        if ($this->targetQty > 0) {
            return "To get $this->targetQty cups of whole milk, use $this->whippingCreamQty cups of whipping cream and $this->onePercentQty cups of 1% milk.";
        }

        return "";
    }
}

?>