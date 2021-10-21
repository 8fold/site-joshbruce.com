<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

/**
 * Not strictly necessary. Only used as this is going to be a public repository.
 */
Dotenv\Dotenv::createImmutable(__DIR__ . '/../')->load();

/**
 * We're going to try putting in only the things we need when we need them,
 * with some constraints that will make certain choices up front.
 */
print \JoshBruce\Site\App::run($_SERVER);
