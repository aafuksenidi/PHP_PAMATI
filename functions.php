<?php
function safe_txt_cut($txt) //nepatik rakstīt šo garo desu =(
{
    return (htmlspecialchars($txt, ENT_QUOTES, 'UTF-8'));
}

function print_err($err_data, $key)
{
    if (isset($err_data[$key])) {
        return htmlspecialchars($err_data[$key]);
    }
    return;
}

function cenaCount($pricePerPerson, $personCount)
{
    $discount = 0;  // ir uztaisīt CONST???
    if ($personCount >= 3 && $personCount <= 5) {
        $discount = 0.1;
    }
    $summ = $pricePerPerson * $personCount;
    $discountSumm = $summ * $discount;
    $kopa = $summ - $discountSumm;

    return array($summ, $discountSumm, $kopa);
}
