<?php

$file = __FILE__;

if (file_exists($file) && is_readable($file)) {  // Можно оставить только is_readable()
    $lines = file(__FILE__);
    foreach ($lines as $line) {
        echo $line;
    }

    echo "========================================================\n";

    $content = file_get_contents(__FILE__);
    echo $content;

    echo "========================================================\n";
    
    $handle = fopen($file, "rb"); // r+
    if ($handle) {
        try {
            $content = fread($handle, filesize($file));
        } finally {
            fclose($handle);
        }
    }

    echo "========================================================\n";

    $handle = fopen($file, "rb");
    if ($handle) {
        try {
            while (!feof($handle)) {
                echo fgets($handle, 1024);
            }
        } finally {
            fclose($handle);
        }
    }

    echo "========================================================\n";

    $handle = fopen($file, "rb");
    if ($handle) {
        try {
            // javier   argonaut    pe
            // hiroshi  sculptor    jp
            // robert slacker us
            // luigi florist it
            while ($userinfo = fscanf($handle, "%s\t%s\t%s\n")) {
                list($name, $profession, $countrycode) = $userinfo;
            }
        } finally {
            fclose($handle);
        }
    }

    echo "========================================================\n";

    $file = new SplFileObject("file.txt");

    while (!$file->eof()) {
        echo $file->fgets();
    }

    foreach ($file as $linenumber => $content) {
        printf("Line %d: %s", $linenumber, $content);
    }

    $linesTenToTwentyIterator = new LimitIterator(
        $file,
        9, // start at line 10
        10 // iterate 10 lines
    );
    foreach ($linesTenToTwentyIterator as $line) {
        echo $line; // outputs lines from 10 to 20
    }
}
