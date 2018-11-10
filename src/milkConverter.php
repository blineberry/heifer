<?php

class MilkConverter {
    public static $heavyWhippingCreamFatPercent = .36;
    public static $wholeMilkFatPercent = .0325;
    public static $onePercentFatPercent = .01;

    private $targetQty;
    private $whippingCreamQty;
    private $onePercentQty;
    
    function __construct($targetQty) {
        $this->targetQty = (int) $targetQty;

        if ($this->targetQty > 0) {
            $this->whippingCreamQty = (self::$wholeMilkFatPercent - self::$onePercentFatPercent) / (self::$heavyWhippingCreamFatPercent - self::$onePercentFatPercent) * $this->targetQty;
            $this->onePercentQty = $this->targetQty - $this->whippingCreamQty;
        }
    }

    public function getTargetQty() {
        return $this->targetQty;
    }

    public function getInstructions() {
        if ($this->targetQty > 0) {
            return "To get $this->targetQty cups of whole milk, use $this->whippingCreamQty cups of whipping cream and $this->onePercentQty cups of 1% milk.";
        }

        return "";
    }
}

?>