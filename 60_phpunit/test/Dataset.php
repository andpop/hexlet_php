<?php
namespace App;

require_once "Solution.php";

use function App\Solution\cube;

class Solution2Test extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider additionProvider
     */
    public function testCubeWithDataSet($expected, $argument)
    {
        $this->assertEquals($expected, cube($argument));
    }

    public function additionProvider()
    {
        return [
            [1, 1],
            [8, 2],
            [27, 3],
            [-1, -1]
        ];
    }
}


