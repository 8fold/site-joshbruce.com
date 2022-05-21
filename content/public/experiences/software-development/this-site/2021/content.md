---
title: 2021
created: 20211031
---

# 2021 site in-depth

{!!dateblock!!}

I think I'm going to call this one the quick and considerate update.

The main focus of this site is text-based ramblings. The Internet has come a long way since I started. My understanding of it and [software development](/software-development/) has also come a long way.

## Considerate (lots of firsts)

Most operating systems and browsers now support user preferences. To be fair, users have had the ability to create custom style sheets for a little while now (no extensions necessary):

- [Safari](https://apple.stackexchange.com/questions/176831/change-css-style-in-safari-on-all-sites).
- [Firefox](https://support.mozilla.org/en-US/questions/841578).
- [Internet Explorer](https://support.microsoft.com/en-us/topic/internet-explorer-11-crashes-when-you-use-a-custom-style-sheet-b343676b-26c8-0c2d-624e-cc61a4cea53e), though seems like it could be broken.
- Edge and Chrome would be better suited using an extension from what I could find.

Most modern browsers also have what is referred to as a reader view where the browser will take your content and apply the browser team's styles to it in a separate modal presentation.

![Screenshot of this page in reader view in Safari](/media/web-development/reader-view.png)

Users can also decide to turn styling off or go without JavaScript. Reduce animations and motion. Users may also be looking at the site on a screen the size of a watch less than a foot away or a 60 inch television from 50 meters. Could be the latest browser running on the latest hardware, or, something old on both scores.

The questions are: What experience should they be able to have, if any? What experience do we want them to have?

Believe me when I say, the hardest thing about web design and development is realizing that if there is only *one* way to properly experience what you've created, it could be problematic.

So, [progressive enhancement](https://developer.mozilla.org/en-US/docs/Glossary/Progressive_Enhancement) for the win.

### No [.CSS](cascading style sheet) or [.JS](JavaScript) first

The core functionality of this site is the ability for a user to navigate and read content. Most, if not all, considerations should be made from that lens.

![Screenshot of this page without styles of JavaScript](/media/web-development/progressive-enhancement.png)

As of this writing, as long as the browser the person is using understands some [.HTML](hyptertext markup language) that's been around since version 1, they'll be able to navigate, read, and see the images.

This does raise the question of how do we determine what features we should and should not use. Otherwise known as what browsers will we actively support?

1. I will actively support browsers that simply don't have CSS or JS available to them. (Support isn't the same as catering. Support just means they'll most likely be able to see something. The Internet is insanely backward compatible. See the original [Space Jam](https://www.spacejam.com/1996/) movie website from 1996—it still works.)
2. I will neither support nor cater to any version of Internet Explorer. If a user reports the site isn't awesome on [.IE](Internet Explorer), I will kindly suggest they upgrade as it is scheduled to reach end of life around the [middle of 2022](https://docs.microsoft.com/en-us/lifecycle/faq/internet-explorer-microsoft-edge) (though compatibility mode will keep it alive for a long while after).
3. I will actively push forward the adoption of various web technologies by using them: specifically, [CSS Grid](https://caniuse.com/css-grid) and [Custom Properties](https://caniuse.com/css-variables). This means, according to the Can I Use website, this site will be roughly similar on most desktop browsers updated since 2017 and most mobile browsers.

That's pretty much how I chose.

It's conjecture in that I didn't ask users, however, I don't know any of my users at the moment. My guess would be friends and family and I know we're all pretty good about updating software.

### Reduced motion first

It may be hard to tell given how much animation and transitions play in modern interface design, but some people really don't do well with all that motion.

Therefore, I want to be considerate of that. In the [style sheet](/assets/css/main.css) there is a media query that says `prefers-reduced-motion`, at least as of this writing. By default, any CSS transitions that could cause a lot of movement are placed here.

We might call this: reduced-motion-first design.

It's not because the user may not have a browser that supports this type of thing, it might just be they don't do well with it and would be annoyed to the point of bailing.

### User preferences first

If a user prefers dark color schemes, I want to respect that. Again, looking at the style sheet, you'll see a media query that says `prefers-color-scheme`. By default the site uses a light theme and modifies what it needs to in order to go into dark mode.

[Firefox](https://www.mozilla.org/en-US/firefox/new/) has some good accessibility tools built in. And I use them to check for contrast, tab order, and other things.

It's worth noting that I could have made this a toggle a user could turn off and on. If I did that, I would still want to show up respecting their system preference. Progressively enhancing into the toggle behavior would take a fair amount of additional effort and complexity—sessions, form submission, and then JS.

So, it's in the backlog, it's marked as low value, medium effort and not worth it at the moment. If people start asking for it, the value might go up. However, until the perceived value outweighs the effort, it won't happen.

### Mobile first

The CSS is designed to define what the site should look like on mobile. Media queries will be used to modify specifically for the other screen sizes. As of this writing, there are no media queries related to screen size or resolution.

## Quick

There's a joke about football coaches who are "old school." These coaches believe the forward pass is a trick play. This is how I feel about caching. Or, at least developing a caching strategy.

### Caching strategy

The Internet would be crazy slow if it wasn't for caching, of course, but still.

In short caching is copying a file stored in one place and storing that copy somewhere closer to the person who needs it.

We can take the output of any process and store that somewhere. The fastest websites are still the old school websites (like the Space Jam one from above).

We can also ask the browser to cache things on your device for a certain period of time. If you've ever reached out to support and they told you to:

> Clear your cache and cookies.

They're trying to overcome the problems with caches. As of this writing, I don't use any strategy in my code to generate a cache. Instead, I leverage the cache controls of browsers. For example, I think the page is cached for about 10 minutes, any media is cached for a week, and any assets are cached for 30 days.

When the content is on the server closest to me, that means folks in Tennessee might get the response a bit faster than someone in Texas. However, once someone in Texas requests the content, it will most likely be cached closer to them, which means future requests from Texas will also be closer and quicker.

This means I have to be mindful of how long it takes for everything to process. On my local computer (the one I use to develop and write the content), it's about 100 milliseconds; one-tenth of one second.

So, chances are, you will not need to clear your cache to see the latest and greatest from the site. Further, performance increases made in languages and the servers managed by my web host will automatically benefit me without any overhead or consideration on my end—it just works.

### Optimized files

The screenshots above are in the [.PNG](Portable Network Graphics) format, which is pretty big compared to some other formats. I run them through an optimizer. The optimizer can reduce their size by around 50 percent or more. This makes the graphics load faster. I also plan to use some more future-oriented formats, which are designed more for the Internet and smaller file sizes.

My server will also compress certain file types before they are transferred to you. Because my host handles this for me it means there's no additional overhead for me.

One of these files that gets compressed before being sent should be the CSS. Since switching to using CSS properties almost exclusively to define my "design system," I've noticed a slight improvement when the CSS is compressed. Once you receive the compressed file, it will be uncompressed and displayed for you. This all happens automatically.

Because I use the libraries I do for generating the HTML, it's actually minified, which is to say stripped of extra whitespace that's used to make it easier to read. For a non-HTML example, look at the [minified version](/assets/css/main.min.css) of the CSS served with this page; as opposed to the [non-minified version](/assets/css/main.css) I've been linking to up to this point. If you look at the raw HTML source for this page, you'll notice it's mostly one continuous line of text.

### Let the browser and server be a browser and server

That's a long headline.

For [modern web development](/web-development/modern-web-development/) we have a tendency to get in the way of or replace the capabilities we get for free from the browser-server relationship. Instead of clicking a link and the browser responding, we jump in the way using JS to see if we need to do something before handing it to the browser to then do what it would have done anyway. Before delivering a response to a request on the server-side, we jump in the way and reroute things (guilty of both).

We want to minimize how much we use our code to replace or intercede with the browser and server.

Basically, our modern web development code is a helicopter parent on the defensive. Are you sure want to click that link and navigate away from this page? Here, let me check first.

When client-side application development started gaining steam (and even back in the Flash days), the mantra was: Don't break the back button.

This was because developers were using JS to interpret address (route or header) requests and not respecting the browser page stack. You navigate a few times, then hit the browser back button and lose all the progress up to that point. Did that cause these developers to stop breaking the back button?

For some, sure, but others just created their own duplication of the browser navigation (back, forward, and even refresh)…thereby replacing and taking on the burden of writing a browser as well as a web application.

## Shareable

No, this doesn't mean integrations with social media (being able to like or love something on my site, which posts to your social media for you). Instead, we're talking about human-readable [.URLs](uniform resource locators) and inline anchor tags.

Safari has a [sharing capability](https://support.apple.com/guide/safari/share-or-post-webpages-sfri40722/mac) built in. Click the button, send the URL via email, message, or something else entirely. For browsers that don't have this capability, you can still copy-and-paste.

When someone receives it, they should be able to read it and have a pretty fair idea of what they're going to get.

This drive to make things shareable means the information architecture of the site needs to be pretty tight.

My general rule for the site is that content should not be more than 3 levels deep.

The hash signs (#) are links directly to that header. If you click it and share that URL, the person you're sending it too will come straight to that headline, if it's available.

I also have a ticket to add the tags necessary to support the social cards as well, just not a hight priority at the moment. (You know, you share a link on social media and there's a fancy card presented.)

## Content is still king

I appreciate the design department at Apple. (I also appreciate other departments, but we'll stick with marketing and design.) When you go to their website, there is no question what they want you to do and look at: the products.

Press releases? That's like a full page scroll and two clicks away. If you didn't know where to look, you wouldn't see it.

Investor relations? Same.

For this site, it's the articles. Period.

The menu isn't even at the top of the page.

Navigation, copyright and other legal, along with support and social (coming soon) are all secondary to the content you're reading, the related and linked to content, and the external resources and references.

The design reenforces this; in my opinion.

## Deploying updates

Right now the code and content is all stored on GitHub. I've cloned them to the server. My code editor has a terminal and lets me automatically sign into my remote server. two commands and a password later, the site's pretty much updated.

Eventually I'm looking to add a script that will automatically do the update for me (continuous deployment) but, for now, it's not annoying enough.

It's relatively instant and the site usually isn't down while I do it. Just the changes that were made since the last update are brought over.

Takes less than a second for me to deploy the site and content.

## Site statistics

This isn't about page views, clickthrough rates, or the like; it's about performance characteristics and [.SLAs](Service Level Agreements).

The mission of this site is part sharing and part exploration.

The sharing piece is in the content itself; for what it's worth (humble to a fault). The exploration is mainly in ways to build websites.

The following is not a binding contract with users—just to be clear.

1. Any page on the site should load in less than 3 seconds on a regular 3G connection. That's from the time the request is sent to the time the user receives the response.
2. Every page should provide a positive experience for those using [.AT](Assistive Technologies). (This will be more difficult for me as I'm not very skilled at using AT and don't know a lot of people in general and specifically not those who use AT; at least not that I'm aware of—doesn't really come up in conversation.)

Note: I'm not sure of a way to throttle tests performed by third-parties. Therefore, the network time tests will be run using [Firefox](https://www.mozilla.org/en-US/firefox/new/) to test.

I will use the following third-party tools (at minimum):

1. [web.dev](https://web.dev/measure/),
2. [pingdom](https://tools.pingdom.com), and
3. [keycdn](https://tools.keycdn.com/speed).

I will use three categories or styles of pages:

1. short content, minimal assets and media.
2. long content with media.
3. long content with third-party integrations - should be difficult to find one of these.

### December 1st, 2021

Waiting for response: ~50ms. (opcache in place, with timestamp checking enabled).

1. https://joshbruce.com (short content, minimal assets and media)
2. https://joshbruce.com/web-development/this-site/2021/ (long content, images)
3. https://joshbruce.com/web-development/on-constraints/internet-bandwidth/ (long content)

- Dynamic content generation: Once the site is running, it SHOULD return a response in less than 150ms.
- [web.dev](https://web.dev/measure/): All stats (except PWA) SHOULD be greater than 95 percent.
    1. Performance - 100, Accessibility - 100, Best practices - 100, SEO - 100
    2. Performance - 100, Accessibility - 100, Best practices - 100, SEO - 100
    3. Performance - 100, Accessibility - 100, Best practices - 100, SEO - 100
- [pingdom](https://tools.pingdom.com): Testing from Asia (seemed the longest delay); performance grade MUST be B or higher and SHOULD be A.
    1. Grade A, Load time 929ms
    2. Grade A, Load time 2.04s
    3. Grade A, Load time 880ms
- [keycdn](https://tools.keycdn.com/speed) (speed test): Testing from Tokyo based on delay for pingdom; grade MUST be A.
    1. Grade A, Load time 1.05s
    2. Grade A, Load time 2.42s
    3. Grade A, Load time 937.25ms

I released the updated code and turned OPcache on. The server default settings are different than my local defaults; therefore, I updated my local server to match those of the server.

```bash
/usr/local/php80/bin/php -i | grep opcache
```

With the following changes.

```bash
opcache.enable=1
opcache.enable_cli=0
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=10000
opcache.revalidate_freq=2
```

The `opcache.fast_shutdown=0` parameter doesn't seem to exist. I commented it out on my local server settings.

Also added lazy loading and asynchronous image decoding to the content using the [Default Attributes](https://commonmark.thephpleague.com/2.0/extensions/default-attributes/) extension.

```php
use League\CommonMark\Extension\CommonMark\Node\Inline\Image;

'default_attributes' => [
  Image::class => [
    'loading'  => 'lazy',
    'decoding' => 'async'
  ]
]
```

### November 30th, 2021

I haven't actually done a deployment, so, this will mainly be about what's happening in local development. I'm still trying to optimize as much as possible locally while not relying heavily on caching; however, I'm not sure that will work out for much longer.

I've started profiling the site using [Xdebug](https://xdebug.org/docs/profiler), which outputs a Cachegrind compatible file. I QCachegrind to view the output (I don't remember where I found an installer, but I know it wasn't through Terminal); regardless, it gives me a good understanding of how long different things take to perform.

The main optimization performed as of this writing is to change the way I check for mimetypes. Instead of using the [PHP method](https://www.php.net/manual/en/function.mime-content-type.php) and overwriting, I use the PHP method as the fallback.

- [Original](https://github.com/8fold/site-joshbruce.com/blob/093ede071cc9df78bc098c2feb21b3d7b1ab2a67/site-dynamic-php/src/FileSystem/FileTrait.php#L48) versus
- as [fallback](https://github.com/8fold/site-joshbruce.com/blob/175f5c586494ca0de6ca5b2cfa0b8c271ca213e3/site-dynamic-php/src/FileSystem/FileTrait.php#L48)

While I didn't think it would make a difference, it seems to have worked out better.

What I'm finding beneficial about profiling is I can establish a baseline. Stated in conversational language:

> Can I improve performance without modifying PHP or server settings?

As of this writing, the answer is no. Most of the time spent processing each request is spent with autoloading classes and compilation. (Technically, some of the class composition through traits and inheritance could be removed but the trade-off in readability and maintainability seems too great.)

So, I've decided to look at the [Symfony performance documentatioin](https://symfony.com/doc/current/performance.html#use-the-opcache-byte-code-cache) to see what I can do there.

Going to start with [optimizing the Composer autoloader](https://symfony.com/doc/current/performance.html#optimize-composer-autoloader). I can do this without changing server configurations and, given where the bulk of time is spent, I'm thinking it could be helpful.

![Performance profile showing most time is spent with Composer autoload](/media/web-development/20211130-performance.png)

Main is the longest running; not really a surprise given it encompasses everything. I'm honestly not sure how to convert this to milliseconds and I'm not entirely sure what is meant when we say they're in 10 nanosecond increments; do I divide by 10 before converting to milliseconds or do I multiply by 10?

Anyway, the number is 1,815,256.

Using the regular optimized autoloader has 1,690 classes.

![Performance profile showing time has been reduced after changing the autoloader](/media/web-development/20211130-performance-post-composer.png)

The new number is 1,318,973. So, roughly a 28 percent reduction, if I'm reading this correctly.

Using this optimized, authoritative autoloader has 590 classes.

Based on these numbers I'm going to add two new scripts to the `composer.json` file. The first to optimize the autoloader by itself and the other to run the complete set of scripts. I will call it "deploy," which will modify my deployment sequence a bit.

Of course, now the output is showing what's really taking the bulk of the time; rendering the markdown to HTML.

Somewhere around 50,000,000 is spent beyond my ability to change—the [Commonmark](https://commonmark.thephpleague.com) package I depend on. That's not a criticism on Commonmark, I'm using a lot of packages and I'm pretty impressed. With that said, I decided to split off a converter specifically for titles.

Now I'm going to continue with the checklist from Symfony. Specifically setting the [realpath cache](https://symfony.com/doc/current/performance.html#configure-the-php-realpath-cache). I'm hoping I can do this from within the `index.php` file and not editing the actual `php.ini` file. I'm pretty sure I could do it on my server, I'm just not sure I actually want to. Symfony suggests doing this because specifically when there is a lot of relative- to real-path conversions. Ever since I switched to a relative path-based solution, there's a lot of that going on.

Here are the initial setting:

```bash
opcache.enable=1
opcache.enable_cli=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=10000
opcache.revalidate_freq=2
opcache.fast_shutdown=0
```

According to the admin panel in [MAMP Pro](https://www.mamp.info/en/mamp-pro/windows/) I'm barely hitting these marks; as in nowhere close.

Setting `opcache.validate_timestamps` to zero didn't really gain much for me and I don't think setting the pre-loader will add much either.

Think this is good for now. Will probably go ahead and release and see what happens.

### November 15th, 2021

Waiting for response: ~50ms. (no opcache or CDN)

1. https://joshbruce.com (short content, minimal assets and media)
2. https://joshbruce.com/web-development/2021-site-in-depth (long content, images)
3. https://joshbruce.com/web-development/on-constraints/internet-bandwidth (long content)

- Dynamic content generation: Once the site is running, it SHOULD return a response in less than 150ms.
- [web.dev](https://web.dev/measure/): All stats (except PWA) SHOULD be greater than 95 percent.
    1. Performance - 100, Accessibility - 100, Best practices - 100, SEO - 100
    2. Performance - 100, Accessibility - 100, Best practices - 100, SEO - 100
    3. Performance - 100, Accessibility - 100, Best practices - 100, SEO - 100
- [pingdom](https://tools.pingdom.com): Testing from Asia (seemed the longest delay); performance grade MUST be B or higher and SHOULD be A.
    1. Grade A, Load time 860ms
    2. Grade A, Load time 1.9s
    3. Grade A, Load time 804ms
- [keycdn](https://tools.keycdn.com/speed) (speed test): Testing from Tokyo based on delay for pingdom; grade MUST be A.
    1. Grade A, Load time 1.01s
    2. Grade A, Load time 2.43s
    3. Grade A, Load time 999ms

### November 3rd, 2021

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

