<?php

declare(strict_types=1);

use Temporal\Client\GRPC\ServiceClient;
use Temporal\Client\WorkflowClient;
use Symfony\Component\Console\Application;
use Workshop\Util;

require __DIR__ . '/vendor/autoload.php';

$locator = Util\Locator::create('src/');

$host = getenv('TEMPORAL_CLI_ADDRESS');
if (empty($host)) {
    $host = 'localhost:7233';
}

$workflowClient = WorkflowClient::create(ServiceClient::create($host));

$app = new Application('Temporal Workshop');

foreach ($locator->getCommands() as $command) {
    $app->add(Util\Command::create($command, $workflowClient));
}

$app->run();