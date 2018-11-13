<?php
class Units {
    const Ounces = 1;
    const Teaspoons = 2;
    const Tablespoons = 3;
    const Cups = 4;

    public static function toString($unit, $singular = true) {
        $str;

        switch ($unit) {
            case Units::Ounces:
                $str = "ounce";
                break;
            case Units::Teaspoons:
                $str = "teaspoon";
                break;
            case Units::Tablespoons:
                $str = "tablespoon";
                break;
            case Units::Cups:
                $str = "cup";
                break;
            default:
                throw new Exception('unknown unit');
                break;
        }

        if ($singular) {
            return $str;
        }

        return $str . "s";
    }
}
?>