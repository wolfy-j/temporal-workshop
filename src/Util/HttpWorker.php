<?php


namespace Workshop\Util;

use Spiral\RoadRunner;
use Nyholm\Psr7;

class HttpWorker
{
    private RoadRunner\Http\PSR7Worker $worker;

    /** @var array<Endpoint> */
    private array $endpoints = [];

    public static function create(): self
    {
        $http = new self();

        $worker = RoadRunner\Worker::create();
        $psrFactory = new Psr7\Factory\Psr17Factory();

        $http->worker = new RoadRunner\Http\PSR7Worker(
            $worker,
            $psrFactory,
            $psrFactory,
            $psrFactory
        );

        return $http;
    }

    public function registerEndpoint(Endpoint $endpoint)
    {
        $this->endpoints[$endpoint::PATH] = $endpoint;
    }

    public function run()
    {
        while ($req = $this->worker->waitRequest()) {
            try {
                $path = $req->getUri()->getPath();
                if (!isset($this->endpoints[$path])) {
                    $rsp = new Psr7\Response();
                    $rsp->getBody()->write('NOT FOUND');
                    $this->worker->respond($rsp);
                    continue;
                }

                $endpoint = $this->endpoints[$path];

                ob_start();
                $rsp = $endpoint->handle($req);
                $buf = ob_get_clean();

                if ($rsp === null) {
                    $rsp = new Psr7\Response();
                }
                $rsp->getBody()->write($buf);

                $this->worker->respond($rsp);
            } catch (\Throwable $e) {
                $this->worker->getWorker()->error((string)$e);
            }
        }
    }
}