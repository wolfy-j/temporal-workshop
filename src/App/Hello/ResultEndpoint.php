<?php


namespace Workshop\App\Hello;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Workshop\Util\Endpoint;

class ResultEndpoint extends Endpoint
{
    public const PATH = '/hello-result';

    public function handle(ServerRequestInterface $request): ?ResponseInterface
    {
        $id = $request->getQueryParams()['id'];
        $exit = $request->getQueryParams()['exit'] ?? false;

        /** @var DemoWorkflowInterface $hello */
        $hello = $this->workflowClient->newRunningWorkflowStub(DemoWorkflowInterface::class, $id);

        $hello->addName('Antony');
        $hello->addName('Bob');
        $hello->addName('John');

        if ($exit) {
            $hello->stop();
        }

        return null;
    }
}