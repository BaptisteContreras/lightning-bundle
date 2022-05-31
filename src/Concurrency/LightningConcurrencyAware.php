<?php


namespace Sflightning\Bundle\Concurrency;


use Sflightning\Contracts\Concurrency\ConcurrencyManagerInterface;

interface LightningConcurrencyAware
{
    public function setCoroutineConcurrencyManager(ConcurrencyManagerInterface $concurrencyManager): void;
}