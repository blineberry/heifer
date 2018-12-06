<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    require('milkConverter.php');

    $targetQtyId = "targetQty";
    $targetTypeId = "targetType";
    $starter1TypeId = "starter1Type";
    $starter2TypeId = "starter2Type";

    $targetVolume = isset($_GET[$targetQtyId]) ? $_GET[$targetQtyId] : 0;
    $targetType = isset($_GET[$targetTypeId]) ? $_GET[$targetTypeId] : MilkConverter::WHOLE;
    $starter1Type = isset($_GET[$starter1TypeId]) ? $_GET[$starter1TypeId] : MilkConverter::HEAVYWHIPPINGCREAM;
    $starter2Type = isset($_GET[$starter2TypeId]) ? $_GET[$starter2TypeId] : MilkConverter::ONEPERCENT;

    $milkConverter = new MilkConverter($targetVolume, $targetType, $starter1Type, $starter2Type);
    
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
            <p>I have <select name="<?php echo $starter1TypeId ?>">
            <?php foreach($milkConverter->getStarter1Types() as $type): ?> 
                <option value="<?php echo $type["value"] ?>" <?php if ($type["isSelected"]) echo "selected" ?>><?php echo $type["text"] ?></option>
            <?php endforeach; ?>
            </select> and <select name="<?php echo $starter2TypeId ?>">
            <?php foreach($milkConverter->getStarter2Types() as $type): ?> 
                <option value="<?php echo $type["value"] ?>" <?php if ($type["isSelected"]) echo "selected" ?>><?php echo $type["text"] ?></option>
            <?php endforeach; ?>                
            </select>. I want
                <input type="number" id="<?php echo $targetQtyId ?>" name="<?php echo $targetQtyId ?>" value="<?php echo $milkConverter->getTargetVolume()->getQty() ?>" /> cups of 
                <select name="<?php echo $targetTypeId ?>">
                <?php foreach($milkConverter->getTargetTypes() as $type): ?> 
                    <option value="<?php echo $type["value"] ?>" <?php if ($type["isSelected"]) echo "selected" ?>><?php echo $type["text"] ?></option>
                <?php endforeach; ?>   
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