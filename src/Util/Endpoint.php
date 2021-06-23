<?php

namespace Workshop\Util;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Temporal\Client\WorkflowClientInterface;

abstract class Endpoint
{
    public const PATH = '';
    protected WorkflowClientInterface $workflowClient;
    
    public function __construct(WorkflowClientInterface $workflowClient)
    {
        $this->workflowClient = $workflowClient;
    }

    abstract public function handle(ServerRequestInterface $request): ?ResponseInterface;
}