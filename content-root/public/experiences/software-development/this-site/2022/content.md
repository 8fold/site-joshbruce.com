---
title: 2022
created: 20220423
---

# 2022 site in-depth

{!!dateblock!!}

I decided to dramatically change the information architecture of the site.

This type of changes falls under the practices of [pruning the trees](/essays-and-editorials/pruning-the-trees/) and [refactoring, re-engineering, and rebuilding](/essays-and-editorials/software-development/refactoring-re-engineering-and-rebuilding/).

I appreciate organic growth and change in most things.

As I was creating content and sort of throwing stuff in where appropriate it started to become more difficult for me to keep track of. I knew I wanted to a section for [my books](/books/), for example, and I couldn't think of a place for it to fit. I also realized the subjects seemed less important—to me—than the style of the entries.

I still have the same three article types from the [2021](/experiences/software-development/this-site/2021/) version:

Evergreen
:    Entries created once and updated multiple times as information changes

Serialized
:    Content ordered by date, each entry acting as a snapshot in time for a larger topic (a traditional blog)

Ad-hoc
:    Similar to serialized content in that it represents a snapshot in time; however, it may not represent a long running topic to warrant more than one entry.

The ad-hoc entries are a part of the mechanism of change. Because I have this flexibility I can write whatever I want and, if there seems to be a theme or blocking point, I can adjust based on those.

As I was writing I also wanted a place to review and summarize the works of others. This had been a long-running undercurrent desire and you can see it in the front matter of entries from [previous releases](https://github.com/8fold/site-joshbruce.com); if you get bored enough to look that is.

This reflection brings us to purpose-orientation, if you will; why am I writing the thing?

Examinations and summaries
:    When exploring ideas this is seeking to understand. I'm not trying to judge what someone else has created. I'm just trying to understand what is being communicated, if anything. A wet floor sign communicates a warning about the possible state of the floor. That's it. Now, what I do with that information is different.

Reflections
:    When I reflect and respond to an idea or creative work, I'm trying to do so in relation to the single work. Forget who created, forget when it was created, and so on; just reflect on the thing itself. Of course, I may pull in other created works in a sorta "that made me think of vibe" but it's not meant to compare and rank; one might say the linking is exploring my [connectome](https://en.wikipedia.org/wiki/Connectome). *These are typically tied directly to the examinations and summaries.

Essays and editorials
:    These are my thoughts and ideas, which have been informed by, well, everything I come in contact with. The examination and summaries, the reflections, other people, life events, and so on. Granted I don't believe I can truly remove myself in the summaries and reflections, however, here I am really throwing myself into it, as it were.

Experiences
:    If the essays and editorials section focuses on my thoughts and ideas on various subjects, the experiences area is me playing with those thoughts and ideas. I might decide to try throwing an idea out the window for a while, which will help inform those thoughts and ideas further.

My books
:    When I've sat with different ideas long enough I may decide to consolidate them into a more concise and focused representation. This is when the books come into play.

Most of the technical and experiential considerations from the 2021 version are still in play:

- cross-browser support,
- progressive enhancement,
- performance, and
- shareable.

I'm reducing the emphasis on the site statistics as I believe they are pretty stable, however, I'll probably still check in once a year or so.

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
