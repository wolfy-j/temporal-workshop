<?php


namespace Workshop\App\CSV;


use Temporal\Activity\ActivityOptions;
use Temporal\Promise;
use Temporal\Workflow;
use Temporal\Workflow\WorkflowInterface;
use Temporal\Workflow\WorkflowMethod;
use Workshop\App\Hello\DemoActivityInterface;

#[WorkflowInterface]
class CSVWorkflow
{
    private $activity;

    private int $sum = 0;
    private int $count = 0;
    private int $done = 0;

    public function __construct()
    {
        $this->activity = Workflow::newActivityStub(
            CSVActivity::class,
            ActivityOptions::new()
                ->withStartToCloseTimeout(60)
        );
    }

    #[Workflow\QueryMethod]
    public function getStatus(): array
    {
        return [
            'count' => $this->count,
            'sum'   => $this->sum,
            'done'  => $this->done
        ];
    }

    #[WorkflowMethod(name: "calculate_csv_sum")]
    public function run(
        string $filename
    ) {
        $this->count = yield $this->activity->count($filename);

        $countChunks = ceil($this->count / 1000);
        $chunks = [];
        for ($i = 0; $i < $countChunks; $i++) {
            $chunks[] = $this
                ->activity
                ->calculateSum($filename, $i * 1000, 1000)
                ->then(
                    function ($result) {
                        $this->sum += $result;
                        $this->done += 1000;
                        return $result;
                    }
                );
        }

        //file_put_contents('php://stderr', 'here');
        yield Promise::all($chunks);
        file_put_contents('php://stderr', 'OK');

        return $this->sum;
    }
}