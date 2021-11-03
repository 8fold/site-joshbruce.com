One of my favorite principles from The Manifesto for Agile Software Development is:

> Simplicity--the art of maximizing the amount
> of work not done--is essential.

The content is also available in a [separate repository](https://github.com/joshbruce/content-joshbruce.com) before it gets published.

## Work I did not do

1. Admin panel: Over the years, I've created a fair amount of content management systems and methods for making updating websites easier for non-developers. Most of the code I wrote had to do with administration. Whether it was beating out-of-the-box content management systems into submission or creating my own. I can avoid this by leveraging other platforms.
2. Authentication:  Most of the security issues and concerns involved authenticating users. Instead, I'm hoping to avoid this by leveraging the authentication of platforms for source control, social media, and chat clients.
3. Database connection: Beyond the admin panel and authentication, database connections and querying accounting for the bulk of defects and code. Using a flat-file system, I don't need to create a database connection. Further, the method of content creation solves a few other problems.
4. No transformation: Some of the code I've written has to do with transforming user input into web-safe data (ex. Titles to slugs for the URL). The flat-file method being used reduces the need for this.
5. I did not use a router: Because this strategy is file- and path-based, the URL path *is* the query for content. There may be minimal checking for templates (controllers), but we're not there yet.
6. I did not write any HTML: Not even for templates.

## Minimal dependencies

There's a double-edged sword here.

On the one hand, leveraging libraries, packages, and frameworks created and maintained by others increases the amount of work I didn't have to do. However, it also increases risk and potentially limits the upgrade path of the code I *did* write.

For example:

As of October 28th, 2021, I'm listed as a maintainer of [Marked](https://github.com/markedjs/marked). This happened because a library I wanted to use, used Marked. Not only that, but it always used the latest version of Marked. A denial of service vulnerability was discovered and Marked had fallen into disrepair and it didn't seem like the maintainer of the library I directly wanted to use wanted to switch to the something different. After a little back-and-forth figuring out how to do it (first time "taking over" a project) and [a bit of a ruckus](https://github.com/markedjs/marked/issues/1522) in the community, a small group formed to become the core team and to be stewards of the codebase for a community-led project. The core also serves to increase the developer experience.

Marked fixed the vulnerabilities and the community and library have been pushing forward ever since.

Right now some of the sites I maintain use [Laravel](https://laravel.com), which is a wonderful framework. With that said, at present I maintain a library that helps facilitate the flat-file system used by the sites. That library depends on the [FlySystem](https://flysystem.thephpleague.com/v2/docs/) from the PHP League. My library is mainly a proxy into FlySystem and they release version 2 of that codebase. I updated my library to use version 2. Laravel also depends on FlySystem. Unfortunately, Laravel won't be upgrading until version 9 of Laravel. Laravel 9 was scheduled to be released in November of 2021. Much of the Laravel codebase leverages [Symfony components](https://symfony.com). Symfony releases after Laravel, which the major version of Laravel could not take advantage of the latest Symfony components; so, Laravel changed its release to [January](https://laravel-news.com/laravel-9) instead of September (?? could be wrong on what it used to be). This means I couldn't use the latest version of my library until January 2022; or, I could do what I ended up doing which was to support both version 1 and 2 of FlySystem.

I plan to remove the dependency on Laravel and FlySystem for all the sites I maintain unless explicitly asked. As most of the sites I maintain no longer require databases or direct authentication and even one of the maintainers of FlySystem said it creates more overhead than it's worth when only working in local files, I think we're good.

I was experimenting with a lot of other approaches for decoupling and wrapping over the last few years. I've run into a few issues with this and versioning. This version collision and the performance degradations it caused has led me to flag many of these other libraries for deprecation and abandonment. As this writing, we have 5 required libraries. Generally speaking they have no common dependencies and I maintain two of them.

This frees me up a great deal to move about the cabin as I see fit.

## Analysis

The mission of this build is to be quick and considerate. I can't trust that my experience is the experience of someone else; there are too many variables.

Is my internet connection better? Is my hardware better? Is the content cached? Is the server closer to me than another person?

My host lets me use one of two servers. One is on the eastern half of the United States and the other is on the western half.

The following is a list of tools and targets.

Regardless of settings or page, I want page load times to be 3 seconds or less. Pages to test:

1. https://joshbruce.com (short content, minimal assets and media)
2. https://joshbruce.com/web-development/2021-site-in-depth (long content, images)
3. https://joshbruce.com/web-development/on-constraints/internet-bandwidth (long content, iframes)

- Dynamic content generation: Once the site is running, it SHOULD return a response in less than 150ms.
- [web.dev](https://web.dev/measure/): All stats (except PWA) SHOULD be greater than 95 percent.
	1. Performance - 100, Accessibility - 100, Best practices - 100, SEO - 89
		- SEO is low because we lack the description meta tag.
	2. Performance - 99, Accessibility - 95, Best practices - 100, SEO - 90
		- Accessibility is low due to permalink inclusion using aria-hidden true.
		- SEO is low because we lack the description meta tag.
	3. **Performance - 99, Accessibility - 89, Best practices - 100, SEO - 89**
		- Accessibility is low due to permalink inclusion use aria-hidden true AND `iframe` lacks title attribute.
		- SEO is low because we lack the description meta tag.
- [pingdom](https://tools.pingdom.com): Testing from Asia (seemed the longest delay); performance grade MUST be B or higher and SHOULD be A.
	1. Grade A, Load time 1.54s
	2. Grade A, Load time 2.1s
	3. **Grade B, Load time 3.42s**
- [keycdn](https://tools.keycdn.com/speed) (speed test): Testing from Tokyo based on delay for pingdom; grade MUST be A.
	1. Grade A, Load time 1.24s
	2. Grade B, Load time 2.9s
	3. Grade A, Load time 2.53s

## Running locally

1. Clone the repository.
2. Start a PHP server environment; recommend:
	- [MAMP](https://www.mamp.info/en/mamp-pro/windows/),
	- [XAMPP](https://www.apachefriends.org/download.html), or
	- custom build.
3. Point the locally hosted domain to the public directory.

## History

The primary way to view the history of this project is to look at the [releases](https://github.com/8fold/site-joshbruce.com/releases). The name of each is release indicates the total time spent writing the code found here.

I didn't start this project using the aforementioned method; therefore, prior to the first GitHub release, you can:

1. look at the [commit history](https://github.com/8fold/site-joshbruce.com/commits/main) in general (prior to October 25th, 2021),
2. look at the [closed pull requests](https://github.com/8fold/site-joshbruce.com/pulls?q=is%3Apr+is%3Aclosed), and
3. read the [super details](https://github.com/8fold/site-joshbruce.com/blob/main/SUPER_DETAILS.md).

