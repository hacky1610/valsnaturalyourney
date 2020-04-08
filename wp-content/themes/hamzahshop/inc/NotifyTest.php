<?php
include 'Notify.php';

echo GetOrderMessage("Daniel","Allemagne","10 Uhr") . "<br>";
echo GetOrderMessage("Val","France","10 Uhr") . "<br>";
echo GetOrderMessage("Daniel","Espagnol","10 Uhr") . "<br>";


GetCountryList();