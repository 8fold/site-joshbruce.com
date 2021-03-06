# Super details

## Iterate workflow

```bash
total time: 7h
non-dev packages (composer show --tree --no-dev): no change
```

There are too many steps at the moment and it doesn't feel like others could easily contribute — not that many will.

I established rules for branches requiring a pull request and pull request review. I haven't gone so far as protecting `main` entirely — even from me — because GitHub doesn't support this natively (I submitted a feature request) and there's not an elegant way around this; if I require PR review even for admins, I'd need another admin I could count on, which could be done with a second account — and that seems annoying. So, instead, I'll always work from a branch and submit PRs.

At keystone points, I will then create a GitHub release and auto-generate the release notes. This way, you don't have to go through the individual commit history.

## Styles and other pages

```bash
total time: 7h
non-dev packages (composer show --tree --no-dev):
8fold/commonmark-fluent-markdown 0.10.0 A fluent API for CommonMark by the PHP League
├──8fold/commonmark-abbreviations ^1.2 || ^2.0
│  ├──league/commonmark ~2.0.1
│  │  ├──ext-mbstring *
│  │  ├──league/config ^1.1.1
│  │  │  ├──dflydev/dot-access-data ^3.0.1
│  │  │  │  └──php ^7.1 || ^8.0
│  │  │  ├──nette/schema ^1.2
│  │  │  │  ├──nette/utils ^2.5.7 || ^3.1.5 ||  ^4.0
│  │  │  │  │  └──php >=7.2 <8.2
│  │  │  │  └──php >=7.1 <8.2
│  │  │  └──php ^7.4 || ^8.0
│  │  ├──php ^7.4 || ^8.0
│  │  ├──psr/event-dispatcher ^1.0
│  │  │  └──php >=7.2.0
│  │  └──symfony/polyfill-php80 ^1.15
│  │     └──php >=7.1
│  └──php ^7.2|^8.0
├──league/commonmark ^2.0
│  ├──ext-mbstring *
│  ├──league/config ^1.1.1
│  │  ├──dflydev/dot-access-data ^3.0.1
│  │  │  └──php ^7.1 || ^8.0
│  │  ├──nette/schema ^1.2
│  │  │  ├──nette/utils ^2.5.7 || ^3.1.5 ||  ^4.0
│  │  │  │  └──php >=7.2 <8.2
│  │  │  └──php >=7.1 <8.2
│  │  └──php ^7.4 || ^8.0
│  ├──php ^7.4 || ^8.0
│  ├──psr/event-dispatcher ^1.0
│  │  └──php >=7.2.0
│  └──symfony/polyfill-php80 ^1.15
│     └──php >=7.1
├──php ^8.0
└──symfony/yaml ^2.3 || ^3.0 || ^4.0 || ^5.0
   ├──php >=7.2.5
   ├──symfony/deprecation-contracts ^2.1
   │  └──php >=7.1
   └──symfony/polyfill-ctype ~1.8
      └──php >=7.1
8fold/php-html-builder 0.5.3 A library for building HTML document and element strings.
├──8fold/php-xml-builder ^0.6
│  └──php ^7.4||^8.0
└──php ^7.4||^8.0
laminas/laminas-httphandlerrunner 2.1.0 Execute PSR-15 RequestHandlerInterface instances and emit responses they generate.
├──php ^7.3 || ~8.0.0 || ~8.1.0
├──psr/http-message ^1.0
│  └──php >=5.3.0
├──psr/http-message-implementation ^1.0
└──psr/http-server-handler ^1.0
   ├──php >=7.0
   └──psr/http-message ^1.0
      └──php >=5.3.0
nyholm/psr7 1.4.1 A fast PHP7 implementation of PSR-7
├──php >=7.1
├──php-http/message-factory ^1.0
│  ├──php >=5.4
│  └──psr/http-message ^1.0
│     └──php >=5.3.0
├──psr/http-factory ^1.0
│  ├──php >=7.0.0
│  └──psr/http-message ^1.0
│     └──php >=5.3.0
└──psr/http-message ^1.0
   └──php >=5.3.0
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

Tried sending the CSS back with a header of text/css and it was denied as being text/plain. I'm hoping adding a [PSR-7 implementation](https://github.com/Nyholm/psr7) and an [emitter](https://github.com/laminas/laminas-httphandlerrunner) will reduce the amount of code I've written and make it more versatile for sending files.

Adding these two libraries seems to have done the trick. I could have left the Response class as it was but decided to use the PSR-7 implementation handle it; still using the Response class as a proxy. Also put the response in charge of emitting the result. Therefore, if I decide to go with a different implementation it should be easy to switch out; especially since we're using aliased class names.

Update the library, switch out the use statements, and possibly update some of the API calls.

Still haven't needed to create a Request class.

## Shorten path to response

```bash
total time: 5h 30m
non-dev packages (composer show --tree --no-dev): no change
```

The Environment class is experiencing a bit of scope creep, I feel.

Our Request will only pay attention to the URL; we are not concerned with the body of a request.

## Add file-based content management

```bash
total time: 5h
non-dev packages (composer show --tree --no-dev):
8fold/commonmark-fluent-markdown 0.10.0 A fluent API for CommonMark by the PHP League
├──8fold/commonmark-abbreviations ^1.2 || ^2.0
│  ├──league/commonmark ~2.0.1
│  │  ├──ext-mbstring *
│  │  ├──league/config ^1.1.1
│  │  │  ├──dflydev/dot-access-data ^3.0.1
│  │  │  │  └──php ^7.1 || ^8.0
│  │  │  ├──nette/schema ^1.2
│  │  │  │  ├──nette/utils ^2.5.7 || ^3.1.5 ||  ^4.0
│  │  │  │  │  └──php >=7.2 <8.2
│  │  │  │  └──php >=7.1 <8.2
│  │  │  └──php ^7.4 || ^8.0
│  │  ├──php ^7.4 || ^8.0
│  │  ├──psr/event-dispatcher ^1.0
│  │  │  └──php >=7.2.0
│  │  └──symfony/polyfill-php80 ^1.15
│  │     └──php >=7.1
│  └──php ^7.2|^8.0
├──league/commonmark ^2.0
│  ├──ext-mbstring *
│  ├──league/config ^1.1.1
│  │  ├──dflydev/dot-access-data ^3.0.1
│  │  │  └──php ^7.1 || ^8.0
│  │  ├──nette/schema ^1.2
│  │  │  ├──nette/utils ^2.5.7 || ^3.1.5 ||  ^4.0
│  │  │  │  └──php >=7.2 <8.2
│  │  │  └──php >=7.1 <8.2
│  │  └──php ^7.4 || ^8.0
│  ├──php ^7.4 || ^8.0
│  ├──psr/event-dispatcher ^1.0
│  │  └──php >=7.2.0
│  └──symfony/polyfill-php80 ^1.15
│     └──php >=7.1
├──php ^8.0
└──symfony/yaml ^2.3 || ^3.0 || ^4.0 || ^5.0
   ├──php >=7.2.5
   ├──symfony/deprecation-contracts ^2.1
   │  └──php >=7.1
   └──symfony/polyfill-ctype ~1.8
      └──php >=7.1
8fold/php-html-builder 0.5.3 A library for building HTML document and element strings.
├──8fold/php-xml-builder ^0.6
│  └──php ^7.4||^8.0
└──php ^7.4||^8.0
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

Our style linter isn't letting us pass because the HTML content we have extends beyond the desire lined limit.

I'll want to move all of this content out of the classes themselves.

We'll need a 500 error page in a local content space to cover the possibility that the user-defined content space doesn't work. Thinking I'll put it in the `public` folder.

From there, we can use the user-defined content folder.

## Create App and make entry point

```bash
total time: 3h
non-dev packages (composer show --tree --no-dev): no change
```

The response to the 500 errors are handled by the Environment class. I threw the 200 response in there as well, not sure why. At this point, I should be able to start building the conventional Request object. We will ask an App object to respond to the request. That Response will be sent to the Emitter.

~~I'm also going to want to establish a baseline of performance tests.~~

## ~~Create App~~ Update Environment as entry point

```bash
total time: 1h 46m
non-dev packages (composer show --tree --no-dev): no change
```

The first section of 500 erros happens before a formal request is made; we're determining whether we can respond to any request, much less the specific one given. We will create an Environment class that will verify our environment. We're going to make it possible to pass an array mimicking the `$_SERVER` global to allow for the creation of automated testing.

The Emitter is actually doing to jobs. There is the emission aspect, which requires a server to be running. There is also the building of a response. We're going to separate these two concerns by creating a Response class. This Response class will follow the PSR-7 interface; however, it MAY not implement all of the methods of the interfaces.

## Start automated testing

```bash
total time: 46m
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
