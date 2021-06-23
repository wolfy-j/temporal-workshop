<?php


namespace Workshop\App\CSV;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Workshop\Util\Endpoint;

class ResultEndpoint extends Endpoint
{
    public const PATH = '/csv-result';

    public function handle(ServerRequestInterface $request): ?ResponseInterface
    {
        $id = $request->getQueryParams()['id'];

        $csv = $this->workflowClient->newRunningWorkflowStub(CSVWorkflow::class, $id);

        /** @var CSVWorkflow $csv */
        var_dump(
            [
                'id' => $csv->getStatus()
            ]
        );

        return null;
    }
}