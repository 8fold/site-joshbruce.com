https://www.conventionalcommits.org/en/v1.0.0/

The code found here is able to generate the same (or really close to it) site using multiple styles. Each style is held inside a directory; the names start with "Site." Each style has an associated read me file (listed in order of creation):

1. [Dynamic PHP: single-page, server-side](https://github.com/8fold/site-joshbruce.com/blob/main/src/SiteDynamic)
2. [Static HTML](https://github.com/8fold/site-joshbruce.com/blob/main/src/SiteStatic)

The content is also available in a [separate repository](https://github.com/joshbruce/content-joshbruce.com) before it gets published.

## Running locally

1. Clone the repository.
2. Start a PHP server environment; recommend:
	- [MAMP](https://www.mamp.info/en/mamp-pro/windows/),
	- [XAMPP](https://www.apachefriends.org/download.html), or
	- custom build.
3. Point the locally hosted domain to the `site-dynamic-php` directory.

When you go to the locally hosted URL, it should throw a 500 server error. This is because you will need two things: the content folder and a `.env` file.

Let's start with the content folder; using the content for joshbruce.com:

1. Clone the [content repository](https://github.com/joshbruce/content-joshbruce.com).
	- It's recommended this be outside the site project folder.

That's pretty much it for that piece. Navigate back to the root of the site project and crate a `.env` file with the following parameters:

```bash
APP_ENV=local
CONTENT_UP=#
CONTENT_FOLDER=/path/to/inner/content/folder
```

Let's presume the following folder structure on your machine:

```bash
.
└── Desktop/
	├── site-joshbruce.com
	└── content-joshbruce.com
```

Your `.env` file would look like this:

```bash
APP_ENV=local
CONTENT_UP=1
CONTENT_FOLDER=/content-joshbruce.com/content
```

This `.env` file tells us to go up one directory; to `Desktop` in this example. Then, from there, point to `/content-joshbruce.com/content`, which is where our text-based content lives.

## History

1. GitHub [releases](https://github.com/8fold/site-joshbruce.com/releases) go from now back to roughly October 28th, 2021.
2. The [SUPER_DETAILS.md](https://github.com/8fold/site-joshbruce.com/blob/main/SUPER_DETAILS.md) file will cover prior to that.
3. The [commit history](https://github.com/8fold/site-joshbruce.com/commits/main) and [closed pull requests](https://github.com/8fold/site-joshbruce.com/pulls?q=is%3Apr+is%3Aclosed) are also a possibility.

## Other

One of my favorite principles from The Manifesto for Agile Software Development is:

> Simplicity--the art of maximizing the amount
>
> of work not done--is essential.

### Work I did not do

1. Admin panel: Over the years, I've created a fair amount of content management systems and methods for making updating websites easier for non-developers. Most of the code I wrote had to do with administration. Whether it was beating out-of-the-box content management systems into submission or creating my own. I can avoid this by leveraging other platforms.
2. Authentication:  Most of the security issues and concerns involved authenticating users. Instead, I'm hoping to avoid this by leveraging the authentication of platforms for source control, social media, and chat clients.
3. Database connection: Beyond the admin panel and authentication, database connections and querying accounting for the bulk of defects and code. Using a flat-file system, I don't need to create a database connection. Further, the method of content creation solves a few other problems.
4. No transformation: Some of the code I've written has to do with transforming user input into web-safe data (ex. Titles to slugs for the URL). The flat-file method being used reduces the need for this.
5. I did not use a router: Because this strategy is file- and path-based, the URL path *is* the query for content. There may be minimal checking for templates (controllers), but we're not there yet.
6. I did not write any HTML: Not even for templates.

### Minimal dependencies

There's a double-edged sword here.

On the one hand, leveraging libraries, packages, and frameworks created and maintained by others increases the amount of work I didn't have to do. However, it also increases risk and potentially limits the upgrade path of the code I *did* write.

For example:

As of October 28th, 2021, I'm listed as a maintainer of [Marked](https://github.com/markedjs/marked). This happened because a library I wanted to use, used Marked. Not only that, but it always used the latest version of Marked. A denial of service vulnerability was discovered and Marked had fallen into disrepair and it didn't seem like the maintainer of the library I directly wanted to use wanted to switch to the something different. After a little back-and-forth figuring out how to do it (first time "taking over" a project) and [a bit of a ruckus](https://github.com/markedjs/marked/issues/1522) in the community, a small group formed to become the core team and to be stewards of the codebase for a community-led project. The core also serves to increase the developer experience.

Marked fixed the vulnerabilities and the community and library have been pushing forward ever since.

Right now some of the sites I maintain use [Laravel](https://laravel.com), which is a wonderful framework. With that said, at present I maintain a library that helps facilitate the flat-file system used by the sites. That library depends on the [FlySystem](https://flysystem.thephpleague.com/v2/docs/) from the PHP League. My library is mainly a proxy into FlySystem and they release version 2 of that codebase. I updated my library to use version 2. Laravel also depends on FlySystem. Unfortunately, Laravel won't be upgrading until version 9 of Laravel. Laravel 9 was scheduled to be released in November of 2021. Much of the Laravel codebase leverages [Symfony components](https://symfony.com). Symfony releases after Laravel, which the major version of Laravel could not take advantage of the latest Symfony components; so, Laravel changed its release to [January](https://laravel-news.com/laravel-9) instead of September (?? could be wrong on what it used to be). This means I couldn't use the latest version of my library until January 2022; or, I could do what I ended up doing which was to support both version 1 and 2 of FlySystem.

I plan to remove the dependency on Laravel and FlySystem for all the sites I maintain unless explicitly asked. As most of the sites I maintain no longer require databases or direct authentication and even one of the maintainers of FlySystem said it creates more overhead than it's worth when only working in local files, I think we're good.

I was experimenting with a lot of other approaches for decoupling and wrapping over the last few years. I've run into a few issues with this and versioning. This version collision and the performance degradations it caused has led me to flag many of these other libraries for deprecation and abandonment. As this writing, we have 5 required libraries. Generally speaking they have no common dependencies and I maintain two of them.

This frees me up a great deal to move about the cabin as I see fit.

### Analysis

General performance statistics and experiments can be found on [joshbruce.com](/web-development/site-stats).

## Testing can't push to main

I'm also debating on how dependencies should be handled here.
