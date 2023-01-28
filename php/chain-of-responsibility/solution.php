<?php

namespace DesignPatterns\ChainOfResponsibility\Solution;

interface Handler
{
    public function setNext(Handler $handler): Handler;

    public function handle(string $request): ?string;
}

abstract class AbstractHandler implements Handler
{
    private $nextHandler;

    public function setNext(Handler $handler): Handler
    {
        $this->nextHandler = $handler;

        return $handler;
    }

    public function handle(string $request): ?string
    {
        if($this->nextHandler) {
            return $this->nextHandler->handle($request);
        }
        
        return null;
    }
}

class HttpHandler extends AbstractHandler
{
    public function handle(string $request): ?string
    {
        if($request === 'Http') {
            return "This handler for caught HttpRequest";
        } else {
            return parent::handle($request);
        }
    }
}

class AuthHandler extends AbstractHandler
{
    public function handle(string $request): ?string
    {
        if($request === 'Auth') {
            return "This handler for caught AuthRequest";
        } else {
            return parent::handle($request);
        }
    }
}


class ModelHandler extends AbstractHandler
{
    public function handle(string $request): ?string
    {
        if($request === 'Model') {
            return "This handler for caught some requests to Model";
        } else {
            return parent::handle($request);
        }
    }
}

class TemplateManagerHandler extends AbstractHandler
{
    public function handle(string $request): ?string
    {
        if($request === 'TemplateManager') {
            return "This handler for choosing some Template Manager";
        } else {
            return parent::handle($request);
        }
    }
}


class SomeRenderEngineHandler extends AbstractHandler
{
    public function handle(string $request): ?string
    {
        if($request === 'SomeRenderEngine') {
            return "This stage for preparing some Template by SomeRenderEngine";
        } else {
            return parent::handle($request);
        }
    }
}

function clientCode(Handler $handler)
{
    $someRequests = ["Http", "Auth", "Model", "TemplateManager", "SomeRenderEngine"];

    foreach ($someRequests as $request) {
        echo "Client: Who wants a " . $request . "?" . PHP_EOL;
        $result = $handler->handle($request);
        if ($result) {
            echo "  " . $result;
        } else {
            echo "  " . $request . " was left untouched." . PHP_EOL;
        }
    }
}

$http = new HttpHandler();
$auth = new AuthHandler();
$model = new ModelHandler();
$tempManager = new TemplateManagerHandler();
$renderEngine = new SomeRenderEngineHandler();

$http->setNext($auth)->setNext($model)->setNext($tempManager)->setNext($renderEngine);

echo "Chain: Http -> Auth -> Model -> TempManager -> RenderEngine";
clientCode($http);
echo PHP_EOL;

echo "Check another Chain: TempManager -> RenderEngine";
clientCode($tempManager);
echo PHP_EOL;
