<?php

namespace Workshop\App\Hello;

use Temporal\Workflow\SignalMethod;
use Temporal\Workflow\WorkflowInterface;
use Temporal\Workflow\WorkflowMethod;

#[WorkflowInterface]
interface DemoWorkflowInterface
{
    #[WorkflowMethod(name: "demo_workflow")]
    public function run(string $name);
}