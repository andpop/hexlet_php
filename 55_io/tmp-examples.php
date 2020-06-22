<?php

$dir = sys_get_temp_dir();

$tmpfname = tempnam(sys_get_temp_dir(), "hexlet");

$temp = tmpfile();
try {
    fwrite($temp, "my_data");
    fseek($temp, 0);
    echo fread($temp, 1024);
} finally {
    fclose($temp);
}