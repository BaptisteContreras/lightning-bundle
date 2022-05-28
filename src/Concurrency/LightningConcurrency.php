<?php

namespace Sflightning\Bundle\Concurrency;

use Sflightning\Bundle\Concurrency\Exception\UnsupportedPromiseTypeException;
use Sflightning\Contracts\Concurrency\ConcurrencyManagerInterface;
use Sflightning\Contracts\Concurrency\Promise\LightningPromiseInterface;
use Sflightning\Contracts\Constante\Concurrency;
use Sflightning\Lib\Concurrency\Promise\Promise;

trait LightningConcurrency
{
    /**         Properties         **/

    /** @var ConcurrencyManagerInterface */
    private $coroutineConcurrencyManager;

    /**         Methods         **/

    public function executePromise(LightningPromiseInterface $promise): void
    {
        $this->coroutineConcurrencyManager->executePromise($promise);
    }

    public function executePromises(...$promises): void
    {
        foreach ($promises as $rawPromise) {
            $promise = $rawPromise;

            if (is_callable($promise)) {
                $promise = Promise::buildFromCallable($promise);
            }

            if (!$promise instanceof LightningPromiseInterface) {
                throw new UnsupportedPromiseTypeException();
            }

            $this->executePromise($promise);
        }
    }

    public function waitForPromise(LightningPromiseInterface $promise, int $timeout = Concurrency::PROMISE_WAIT_INFINITELY): void
    {
        $this->coroutineConcurrencyManager->waitForPromise($promise, $timeout);
    }

    /**         Accessors         **/

    public function setCoroutineConcurrencyManager(ConcurrencyManagerInterface $concurrencyManager): void
    {
        $this->coroutineConcurrencyManager = $concurrencyManager;
    }
}