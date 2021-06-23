<?php

namespace Workshop\App\Hello;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Temporal\Client\WorkflowOptions;
use Temporal\Workflow;
use Workshop\Util\Endpoint;

class HelloEndpoint extends Endpoint
{
    public const PATH = '/';

    public function handle(ServerRequestInterface $request): ?ResponseInterface
    {
        $demo = $this->workflowClient->newWorkflowStub(
            DemoWorkflowInterface::class,
            WorkflowOptions::new()
                ->withWorkflowTaskTimeout(60)
        );

        $run = $demo->run();
        var_dump($run);

        return null;
    }
}