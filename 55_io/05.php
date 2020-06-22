<?php

function rrmdir($dir)
{
    $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST);
    foreach ($iterator as $filename => $fileInfo) {
        if ($fileInfo->isDir()) {
            rmdir($filename);
        } else {
            unlink($filename);
        }
    }
    rmdir($dir);
}

function tmpdir($func)
{
    $tempDir = tempnam(sys_get_temp_dir(), '');
    if (file_exists($tempDir)) {
        unlink($tempDir);
    }
    // echo $tempDir;
    mkdir($tempDir);
    $result = $func($tempDir);
    rrmdir($tempDir);

    return $result;
}

tmpdir();
