<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require('milkConverter.php');

    $milkConverter;
    $targetQtyId = "targetQty";
    $targetTypeId = "targetType";

    if (isset($_GET[$targetQtyId]) && isset($_GET[$targetTypeId])) {
        $targetQty = (int)$_GET[$targetQtyId];
        $targetType = $_GET[$targetTypeId];
        $milkConverter = new MilkConverter($targetQty, $targetType);
    }
    else if (isset($_GET[$targetQtyId])) {
        $milkConverter = new MilkConverter((int)$_GET[$targetQtyId]);
    }
    else if (isset($_GET[$targetTypeId])) {
        $milkConverter = new MilkConverter(0, $_GET[$targetTypeId]);
    }
    else {
        $milkConverter = new MilkConverter();
    }
    
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie-edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    </head>
    <body>
        <form method="GET">
            <p>I have heavy whipping cream and 1% milk. I want
                <input type="number" id="<?php echo $targetQtyId ?>" name="<?php echo $targetQtyId ?>" value="<?php echo $milkConverter->getTargetQty() ?>" /> cups of 
                <select name="<?php echo $targetTypeId ?>">
                    <option <?php if ($milkConverter->getTargetType() === $milkConverter::WHOLE) echo 'selected' ?> value="<?php echo $milkConverter::WHOLE ?>"><?php echo $milkConverter->dairyTypeDisplayNames[$milkConverter::WHOLE] ?></option>
                    <option <?php if ($milkConverter->getTargetType() === $milkConverter::TWOPERCENT) echo 'selected' ?> value="<?php echo $milkConverter::TWOPERCENT ?>"><?php echo $milkConverter->dairyTypeDisplayNames[$milkConverter::TWOPERCENT] ?></option>
                </select>.
            <p><input type="submit" />
        </form>

        <p id="instructions"><?php echo $milkConverter->getInstructions() ?></p>

        <script>
            /*
            function setInstructions(s) {
                instructions.innerHTML = s;
            }

            function calculateInstructions(event) {
                console.log('qty1', qty1.value);
                console.log('qty2', qty2.value);
                console.log('qty3', qty3.value);

                console.log('unit1', unit1.value);
                console.log('unit2', unit2.value);
                console.log('unit3', unit3.value);

                console.log('type1', type1.value);
                console.log('type2', type2.value);
                console.log('type3', type3.value);

                let q1 = parseFloat(qty1.value);
                let q2 = parseFloat(qty2.value);
                let q3 = parseFloat(qty3.value);

                if (isNaN(q1) || isNaN(q2) || isNaN(q3)) {
                    setInstructions('');
                    return;
                }

                let qCream = (.0325 - .01) / (.36 - .01) * q3;
                let q1percent = q3 - qCream;

                setInstructions(`Combine ${Math.floor(qCream * 100) / 100} cups of ${type2.value} with ${Math.floor(q1percent * 100) / 100} cups of ${type1.value} to get ${Math.floor(q3 * 100) / 100} cups of ${type3.value}.`);  
            }

            let qty1 = document.getElementById('qty1');
            let qty2 = document.getElementById('qty2');
            let qty3 = document.getElementById('qty3');

            let unit1 = document.getElementById('unit1');
            let unit2 = document.getElementById('unit2');
            let unit3 = document.getElementById('unit3');

            let type1 = document.getElementById('type1');
            let type2 = document.getElementById('type2');
            let type3 = document.getElementById('type3');

            let instructions = document.getElementById('instructions');

            [qty1,qty2,qty3,unit1,unit2,unit3,type1,type2,type3].forEach((value, index) => {
                value.addEventListener('change', calculateInstructions, false)
            });*/
        </script>
    </body>
</html>