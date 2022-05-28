<?php

namespace Sflightning\Bundle\Concurrency\Exception;

use Sflightning\Contracts\Concurrency\Promise\LightningPromiseInterface;

class UnsupportedPromiseTypeException extends \RuntimeException
{
    /**         Constructor         **/

    public function __construct()
    {
        parent::__construct('Promise provided for execution must be callable or %s instance', LightningPromiseInterface::class);
    }
}