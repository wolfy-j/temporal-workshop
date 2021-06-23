<?php

namespace Workshop\App\Hello;

use Temporal\Activity\ActivityOptions;
use Temporal\Workflow;

class DemoWorkflow implements DemoWorkflowInterface
{
    #[Workflow\WorkflowMethod(name: "demo_workflow")]
    public function run(
        string $name
    ) {
        return yield Workflow::executeActivity(
            'Activity',
            [$name],
            ActivityOptions::new()
                ->withStartToCloseTimeout(600)
                ->withTaskQueue('sample')
        );
    }
}