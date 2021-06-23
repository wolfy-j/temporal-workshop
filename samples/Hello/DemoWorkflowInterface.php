<?php

namespace Workshop\App\Hello;

use Temporal\Workflow\SignalMethod;
use Temporal\Workflow\WorkflowInterface;
use Temporal\Workflow\WorkflowMethod;

#[WorkflowInterface]
interface DemoWorkflowInterface2
{
    #[SignalMethod]
    public function addName(
        string $name
    ): void;

    #[SignalMethod]
    public function stop(): void;

    #[WorkflowMethod(name: "demo_workflow")]
    public function run();
}