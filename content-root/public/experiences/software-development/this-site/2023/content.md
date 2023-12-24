# 2023 site in-depth

{!!dateblock!!}

1. [web.dev](https://web.dev/measure/),
2. [pingdom](https://tools.pingdom.com), and
3. [keycdn](https://tools.keycdn.com/speed).

I will use three categories or styles of pages:

1. short content, minimal assets and media.
2. long content with media.
3. long content with third-party integrations - should be difficult to find one of these.

- Dynamic content generation: Once the site is running, it SHOULD return a response in less than 150ms.
- [web.dev](https://web.dev/measure/): All stats (except PWA) SHOULD be greater than 95 percent.
    1. Performance - 100, Accessibility - 100, Best practices - 100, SEO - 100
    2. Performance - 100, Accessibility - 100, Best practices - 100, SEO - 100
    3. n/a
- [pingdom](https://tools.pingdom.com): Testing from Asia (seemed the longest delay); performance grade MUST be B or higher and SHOULD be A.
    1. Grade A, Load time 822ms
    2. Grade A, Load time 772ms
    3. n/a
- [keycdn](https://tools.keycdn.com/speed) (speed test): Testing from Tokyo based on delay for pingdom; grade MUST be A.
    1. Grade A, Load time 896ms
    2. Grade A, Load time 902ms
    3. n/a
