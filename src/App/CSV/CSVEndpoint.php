<?php


namespace Workshop\App\CSV;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Workshop\Util\Endpoint;

class CSVEndpoint extends Endpoint
{
    public const PATH = '/csv';

    public function handle(ServerRequestInterface $request): ?ResponseInterface
    {
//        $csv = $this->workflowClient->newWorkflowStub(CSVWorkflow::class);


        for ($i = 0; $i < 100000; $i++) {
            $csv = $this->workflowClient->newWorkflowStub(CSVWorkflow::class);
            $run = $this->workflowClient->start($csv, 'input/sample.csv');
        }

        //echo $run->getExecution()->getID();

        return null;
    }
}