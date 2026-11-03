<?php

require_once 'functions.php';
require_once 'data.php';

$err_data = [];
$vards = "";
$epasts = "";
$skaits = "";
$course = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") { // for debugging SET TO GET!!!
    $vards = trim($_POST["vards"] ?? "");
    $epasts = trim($_POST["epasts"] ?? "");
    $skaits = trim($_POST["skaits"] ?? "");
    $course = trim($_POST["course"] ?? "");


    if ($vards === "") {
        $err_data["vards"] = "Name MUST be entered!";
    }

    if (!filter_var($epasts, FILTER_VALIDATE_EMAIL)) {
        $err_data["epasts"] = "E-mail not valid!";
    }

    if (!filter_var($skaits, FILTER_VALIDATE_INT) || $skaits > 5 || $skaits < 0) {
        $err_data["skaits"] = "Grupā nevar būt vairāk pār 5 cilv. un mazak par 0";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>PRAKTISKAIS DARBS — PHP PAMATI</title>
</head>

<body>
    <h1>PRAKTISKAIS DARBS 4 — FORMAS UN VALIDĀCIJA</h1>
    <h2>Kursu pieteikuma kalkulators</h2>

    <table border="1">
        <tr>
            <th>Kursa kods</th>
            <th>Kursa nosaukums</th>
            <th>Cena 1 dalībniekam</th>
        </tr>
        <?php
        foreach ($kursi as $i => $val) {
            echo "<tr><td> $i </td><td>" . $val[0] . "</td><td>" . $val[1] . ".00 EUR</td></tr>";
            // var_dump($val[0][1]);
        }
        ?>
    </table>
    <hr>
    <h2>Lūdzu, aizpildiet formu</h2>
    <div>
        <form action="" method="POST">
            <div class="formElmt">
                <label for="vards">Name:</label>
                <input type="text" id="vards" name="vards" value="<?= safe_txt_cut($vards) ?>">
                <?php if (isset($err_data["vards"])):
                    echo "<b>" . $err_data["vards"] . "</b>";
                endif;
                ?>
            </div>
            <div class="formElmt">

                <label for="epasts">Email:</label>
                <input type="email" id="epasts" name="epasts" value="<?= safe_txt_cut($epasts) ?>">
                <?php if (isset($err_data["epasts"])):
                    echo "<b>" . $err_data["epasts"] . "</b>";
                endif;
                ?>
            </div>
            <div class="formElmt">
                <label for="course">Course</label>
                <select name="course" id="course">
                    <option disabled <?= (isset($course) && $course == $i ? "" : "selected"); ?> hidden> -select course- </option>
                    <?php
                    foreach ($kursi as $i => $val) {
                        echo ' <option value="' . $i . '"';
                        if (isset($course) && ($course == $i)) {
                            echo ' selected >';
                        } else echo '>';
                        echo  $val[0] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="formElmt">
                <label for="skaits">Studentu skaits:</label>
                <input type="number" id="skaits" name="skaits" min="1" max="5" value="<?= safe_txt_cut($skaits) ?>">
                <?php
                if (isset($err_data["skaits"])):
                    echo "<b>" . $err_data["skaits"] . "</b>";
                endif;
                ?>
            </div>
            <div class="formElmt">
                <input type="submit" id="sButton" value="Uzzinat cenu">
            </div>
        </form>
    </div>
    <hr>
    <?php
    if (!count($err_data) && isset($skaits) && $course !== "") {

        echo '<h2>Piedavajums</h2> <div class=outputList>';

        echo "Vards: <b>";
        echo safe_txt_cut($vards) . "</b><br>";

        echo "Email: <b>";
        echo safe_txt_cut($epasts) . "</b><br>";

        echo "Kursa nosaukums: <b>";
        echo safe_txt_cut($kursi[$course][0]) . "</b><br>";

        echo "Studentu skaits: <b>";
        echo safe_txt_cut($skaits) . "</b><br>";

        $price = cenaCount($kursi[$course][1], $skaits);
        echo "Cena par kursu: <b>";
        echo round($price[0], 2) . " EUR</b><br>";
        // if ($price[1] > 0) {    //neradit Atlaide ja atlaide ir 0
        echo "Atlaide: <b>";
        echo round($price[1], 2) . " EUR</b><br>";

        echo "Kopa par kursu: <b>";
        echo round($price[2], 2) . " EUR</b><br>";
        // }

        echo "Kopa par kursu ar PVN: <b>";
        echo round($price[2] * 1.21, 2) . " EUR</b><br>";

        echo  "</b><br></div>";
    }
    ?>
</body>

</html>