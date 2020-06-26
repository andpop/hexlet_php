
<?php

namespace App\removeFirstLevel;

// BEGIN (write your solution here)
function removeFirstLevel_another(array $tree)
{
    $result = [];

    foreach ($tree as $node) {
        if (is_array($node)) {
            array_push($result, ...$node);
        }
    }

    return $result;
}

function removeFirstLevel(array $tree)
{
    return array_reduce(
        $tree,
        fn($acc, $node) => is_array($node) ? array_merge($acc, $node) : $acc,
        []
    );
}
// END
