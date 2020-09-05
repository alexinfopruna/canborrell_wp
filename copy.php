<?php


echo "www";
$h = fopen("../canBorrell_inc_PROD/import_carta/Familias.csv", "w");
fwrite($h, "HOla"); 
echo "";
echo copy('Familias.csv', '../canBorrell_inc_PROD/import_carta/Familias.csv');
echo copy('SubFamilias.csv', '../canBorrell_inc_PROD/import_carta/SubFamilias.csv');
echo "EEEE";
