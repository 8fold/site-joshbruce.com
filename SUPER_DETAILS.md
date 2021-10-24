# Super details

## Start automated testing

```bash
total time: 46
non-dev packages (composer show --tree --no-dev): no change
```

We're starting to get a few possible path. I'd like to be able to test those paths automatically instead of changing variables inside of the `index` file.

I don't *need* to run a server or browser to test what we have so far. I can mimic it using dependency injection and creating a faux (mock) `$_SERVER` array.

The real server interaction happens when we emit things like headers and print text. The headers will be represented as arrays and the body will be represented as a string.

I'm going to try building into the interfaces and objects described by [PSR-7](https://www.php-fig.org/psr/psr-7/); namely, request, middleware, response, and emit. I'm looking for convention over coming up with my own solution to solved problems.

## Primary response codes

```bash
total time: 0
non-dev packages (composer show --tree --no-dev):
vlucas/phpdotenv v5.3.1 Loads environment variables from `.env` to `getenv()`, `$_ENV` and `$_SERVER` automagically.
├──ext-pcre *
├──graham-campbell/result-type ^1.0.2
│  ├──php ^7.0 || ^8.0
│  └──phpoption/phpoption ^1.8
│     └──php ^7.0 || ^8.0
├──php ^7.1.3 || ^8.0
├──phpoption/phpoption ^1.8
│  └──php ^7.0 || ^8.0
├──symfony/polyfill-ctype ^1.23
│  └──php >=7.1
├──symfony/polyfill-mbstring ^1.23.1
│  └──php >=7.1
└──symfony/polyfill-php80 ^1.23.1
   └──php >=7.1
```

Testing will be done manualy for now as what I plan to write will require a running server environment.

There are three response codes I want to be able to support:

- 200 OK
- 404 Not found and
- 500 Internal server error

These will need to be checked in reverse.

1. 500: Conntent root directory not found. Or DotEnv required parameters not set.
2. 404: File for request URI could not be found within the content root directory.
3. 200: File found inside content root directory.

I'm not going to use the same template for the 404 and I did the 500. A server error should have fewer options than a 404. The user typically can't recover from the 500 by themselves; however, they can recover from a 404 relatively easily.

## Hard reset

total time: 0

If you look at the commit history you'll find the file history. I've decided to do a hard reset and move through this in a more systematic way.

I've removed all files except those in the `public` directory. I've removed all non-dev dependencies except `.env` to maintain the "secret" location of the content directory.
