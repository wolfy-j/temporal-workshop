<?php

namespace Workshop\App\Hello;

use Temporal\Activity\ActivityOptions;
use Temporal\Workflow;
use Temporal\Workflow\SignalMethod;

class DemoWorkflow implements DemoWorkflowInterface
{
    private array $names = [];
    private bool $stop = false;

    #[SignalMethod]
    public function addName(
        string $name
    ): void {
        $this->names[] = $name;
    }

    #[SignalMethod]
    public function stop(): void
    {
        $this->stop = true;
    }

    #[Workflow\WorkflowMethod(name: "demo_workflow")]
    public function run()
    {
        $activity = Workflow::newActivityStub(
            DemoActivityInterface::class,
            ActivityOptions::new()->withStartToCloseTimeout(10)
        );

        $result = [];

        while (true) {
            yield Workflow::await(fn() => $this->names !== [] || $this->stop);

            if ($this->names === [] && $this->stop) {
                break;
            }

            $name = array_shift($this->names);
            $result[] = yield $activity->hello($name);
        }

        return $result;
    }
}