# Lightning Symfony Bundle

A bundle for [Symfony](https://symfony.com/) applications using [Swoole](https://www.swoole.co.uk/).

This bundle provides a bridge to use [Swoole](https://www.swoole.co.uk/) with Symfony and it tries to simplify the use of Swoole concurrency.

This bundle comes with its own [Runtime](https://github.com/BaptisteContreras/lightning-runtime), [Contracts](https://github.com/BaptisteContreras/lightning-contracts) and [Implementation](https://github.com/BaptisteContreras/lightning-lib)

This project is inspired by the excellent [Laravel Octane](https://github.com/laravel/octane) and try to provide a good alternative for Symfony applications !

**Still in development**

## Installation

```
 composer require sflightning/bundle
```

## Usage

This bundle comes with it's own Promise definition : `Sflightning\Contracts\Concurrency\Promise\LightningPromiseInterface` and implementation :  `Sflightning\Lib\Concurrency\Promise` .


#### Create a Promise

You can create a Promise with it's constructor or using the static builder `buildFromCallable`. In both cases you need to provide a `callable` which represents the task to be executed concurrently.

```

use Sflightning\Lib\Concurrency\Promise\Promise;

$promise = new Promise(function(callable $resolve, callable $reject) {
      // Your async task here;
});

$promise->then(function ($result) {
     // If your task succeed;
});

$promise->catch(function ($result) {
    // If your task gone wrong;
});

$promise->finally(function () {
   // And in any case;
});

```

Or you can also use the static builder

```
$promise = Promise::buildFromCallable(function(callable $resolve, callable $reject) {
            // Your async task here;
        })->then(function ($result) {
                // If your task succeed;
        })->catch(function ($result) {
            // If your task gone wrong;
        })->finally(function () {
            // And in any case;
        });
```

#### Execute your promises asynchronously

Now that you have created your promises, it's time to execute them ! (And concurrently). For that, it's simple : You just have to implement `Sflightning\Bundle\Concurrency\LightningConcurrencyAware`
and use the trait `Sflightning\Bundle\Concurrency\LightningConcurrency`. Now your object has three new methods available:

- **executePromise(LightningPromiseInterface $promise): void** : Execute the given promise asynchronously. This method is non-blocking.
- **executePromises(...$promises): void** : Execute the given promises asynchronously. This method is non-blocking.
- **waitForPromise(LightningPromiseInterface $promise, int $timeout = Concurrency::PROMISE_WAIT_INFINITELY): void** : Wait for the given promise to finish. This is the only blocking method in this trait !

```
class MyAsyncService implements LightningConcurrencyAware
{
    use LightningConcurrency;

    public function doSmth(...$args): void
    {
        $promise = Promise::buildFromCallable(function(callable $resolve, callable $reject) {
            // Your async task here;
        })->then(function ($result) {
            // If your task succeed;
        })->catch(function ($result) {
            // If your task gone wrong;
        })->finally(function () {
            // And in any case;
        });

        $this->executePromise($promise);

        // More code



        $this->waitForPromise($promise);
    }
}
```

You can also start a promise in a service and wait for it in the calling controller's method:

```
// MyAsyncService.php

class MyAsyncService implements LightningConcurrencyAware
{
    use LightningConcurrency;

    public function doSmth(LightningPromiseInterface $promise): void
    {
        // Your code

        $this->executePromise($promise);

        // More code
        
        // Notice that we don't do any waitForPromise here, it's the calling object duty for this example !
    }
}

// TestController.php

class TestController implements LightningConcurrencyAware
{
    use LightningConcurrency;

    public function method1(Request $request, MyAsyncService $myAsyncServiceInstance): void
    {
        $promise = Promise::buildFromCallable(function(callable $resolve, callable $reject) {
            // Your async task here;
        });

        $myAsyncServiceInstance->doSmth($promise);
        
        $this->waitForPromise($promise); 
        
        return new Response('OK', 200); 
    }
}
```
