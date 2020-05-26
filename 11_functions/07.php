<?php

$last = function($str) {
    if (strlen($str) === 0) {
        return null;
    }

    return substr($str, -1);
};
