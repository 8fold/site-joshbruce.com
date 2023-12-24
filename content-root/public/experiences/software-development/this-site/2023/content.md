# 2023 site in-depth

{!!dateblock!!}

I've decided to build out the static site. I believe the last few years have been a testament to how fast the Internet can be when you don't layer on a bunch of unnecessary things. With that said, there is no caching for the dynamic site. Therefore, each page was rendered anew on the server before streaming to the user's client.

This included the [`sitemap.xml`](/sitemap.xml) and the [full navigation](/full-navigation/) pages. The site, as of this writing, has less than 200 articles. I would like to add syndication feeds and possibly tagging. However, doing so would increase either the in-memory storage of all the content on the site, or it would require multiple collections of all the content on the site.

As it stands, the sitemap and full navigation are the only two things we generate using a full-site query. The breadcrumbs and previous next logic is targeted and specific to its purpose.

Initially I was just going to have the sitemap be a static file. I created a CLI tool to do that. Then I went ahead and added the minimal logic to make it capable of generating an entire static site. 

## Dynamic site results

SEO has dropped a bit because I've modified the way I do [`robots.txt`](https://github.com/8fold/site-joshbruce.com/blob/main/site-root/public/robots.txt). I disallow all crawlers, then explicitly allow others. Further, I still don't leverage the description `meta` tag.

1. [web.dev](https://web.dev/measure/),
2. [pingdom](https://tools.pingdom.com), and
3. [keycdn](https://tools.keycdn.com/speed).

I will use three categories or styles of pages:

1. short content, minimal assets and media.
2. long content with media.
3. long content with third-party integrations - should be difficult to find one of these.

- Dynamic content generation: Once the site is running, it SHOULD return a response in less than 150ms.
- [web.dev](https://web.dev/measure/): All stats (except PWA) SHOULD be greater than 95 percent.
    1. Performance - 100, Accessibility - 100, Best practices - 100, SEO - 92
    2. Performance - 100, Accessibility - 100, Best practices - 100, SEO - 92
    3. n/a
- [pingdom](https://tools.pingdom.com): Testing from Asia (seemed the longest delay); performance grade MUST be B or higher and SHOULD be A.
    1. Grade A, Load time 842ms
    2. Grade A, Load time 915ms
    3. n/a
- [keycdn](https://tools.keycdn.com/speed) (speed test): Testing from Bangalore as Tokyo was not available; grade MUST be A.
    1. Grade A, Load time 1.54s
    2. Grade A, Load time 1.56s
    3. n/a
