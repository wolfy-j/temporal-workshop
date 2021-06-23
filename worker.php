<?php

declare(strict_types=1);

use Temporal\WorkerFactory;
use Spiral\RoadRunner;
use Workshop\Util;
use Temporal\Client\GRPC\ServiceClient;
use Temporal\Client\WorkflowClient;

ini_set('display_errors', 'stderr');
include "vendor/autoload.php";

$env = RoadRunner\Environment::fromGlobals();
$locator = Util\Locator::create('src/');
$workflowClient = WorkflowClient::create(ServiceClient::create('localhost:7233'));

if ($env->getMode() === RoadRunner\Environment\Mode::MODE_HTTP) {
    $http = Util\HttpWorker::create();

    // http endpoints
    foreach ($locator->getEndpoints() as $endpoint) {
        $http->registerEndpoint(new $endpoint($workflowClient));
    }

    $http->run();
    exit();
}

$factory = WorkerFactory::create();

$worker = $factory->newWorker(
    'default',
    \Temporal\Worker\WorkerOptions::new()
        ->withMaxConcurrentActivityTaskPollers(4)
        ->withMaxConcurrentWorkflowTaskPollers(2)
);

// workflow types
foreach ($locator->getWorkflowTypes() as $workflowType) {
    $worker->registerWorkflowTypes($workflowType);
}

// activities
foreach ($locator->getActivityTypes() as $activityType) {
    $worker->registerActivityImplementations(new $activityType());
}

$factory->run();
