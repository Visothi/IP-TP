<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Array (Numberic Array)</title>
</head>
<body>
    <?php
        $age = array("Peter"=>"35", "Ben"=>"37", "Joe"=>"43");

        foreach($age as $x => $val) {
            echo "$x = $val<br>";
        }
    ?>
</body>
</html>