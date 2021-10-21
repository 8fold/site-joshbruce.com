<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

// die(var_dump($_SERVER));

/**
 * We're going to try putting in only the things we need when we need them,
 * with some constraints that will make certain choices up front.
 *
 * 1. We will be using a "front controller" represented by App. This way we can
 *    fast-forward though PHP as template engine.
 * 2. We will be using Apache or another server that uses .htaccess with a
 *    rewrite module allowing to facilitate this front controller.
 */
print \JoshBruce\Site\App::run();
