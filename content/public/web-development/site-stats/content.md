---
title: Site statistics
created: 20211108
---

# Site statistics

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

## November 3rd, 2021

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
