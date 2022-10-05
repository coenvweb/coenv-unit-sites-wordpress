


<?php

$test = mysqli_connect('127.0.0.1', 'coenv_base', 'C1RTljH097kRncOttP');
if (!$test) {
die('MySQL Error: ' . mysqli_error());
}
echo 'Database connection is working properly!';
mysqli_close($testConnection);

passthru('whoami');
