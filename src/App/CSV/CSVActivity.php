<?php


namespace Workshop\App\CSV;

use League\Csv\Reader;
use Temporal\Activity\ActivityInterface;
use Workshop\Util\Path;

#[ActivityInterface(prefix: "csv.")]
class CSVActivity
{
    public function count(string $filename)
    {
        return count(file(Path::resolve($filename)));
    }

    public function calculateSum(string $filename, int $offset, int $limit)
    {
        return 10;

        $csv = Reader::createFromPath(Path::resolve($filename));

        $sum = 0;
        $count = 0;
        foreach ($csv as $line) {
            [$index, $amount] = $line;
            if ($index < $offset || $index >= ($offset + $limit)) {
                continue;
            }

            $sum += $amount;
            $count++;
        }

       // usleep($count * 500);

        return $sum;
    }
}