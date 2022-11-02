<?php

declare(strict_types=1);

namespace Core;

abstract class AbstractController
{
    protected array $routeParams = [];

    public function __construct(array $routeParams)
    {
        $this->setRouteParams($routeParams);
    }

    public function __call(string $name, array $arguments)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)){
            if ($this->before()) {
                call_user_func([$this, $method], $arguments);
                $this->after();
            }
        } else {
            throw new \Exception("Method $method not found");
        }
    }

    protected function before(): bool
    {
        return true;
    }

    protected function after(): void
    {

    }

    /**
     * @return array
     */
    public function getRouteParams(): array
    {
        return $this->routeParams;
    }
    /**
     * @param array $routeParams
     */
    public function setRouteParams(array $routeParams): void
    {
        $this->routeParams = $routeParams;
    }
}