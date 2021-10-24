# Super details

## Primary response codes

```bash
total time: 0
non-dev packages:
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

1. 500: Conntent root directory not found.
2. 404: File for request URI could not be found within the content root directory.
3. 200: File found inside content root directory.

## Hard reset

total time: 0

If you look at the commit history you'll find the file history. I've decided to do a hard reset and move through this in a more systematic way.

I've removed all files except those in the `public` directory. I've removed all non-dev dependencies except `.env` to maintain the "secret" location of the content directory.
