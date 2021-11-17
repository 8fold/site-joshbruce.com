---
title: Feed me (Atom and RSS)
created: 20211116
---

# Feed me (Atom and RSS)

Let's get this out of the way: Atom and [.RSS](Real Simple Syndication) are mostly dead. And, if the United States actually [passes the bill](https://arstechnica.com/tech-policy/2021/11/bill-proposes-algorithm-free-option-on-big-tech-platforms-may-portend-bigger-steps/?comments=1) to require users be able to turn algorithmic sorting and prioritization of content, then there's really no reason for them as a way to combat social media feeds. They are protocols from [my history on the web](/web-development/my-history-on-the-web).

And, yet, here I am, implementing at least Atom on this site.

Let me explain. No, there is too much. Let me sum up.

[Atom](https://validator.w3.org/feed/docs/atom.html#requiredEntryElements) and [RSS](https://validator.w3.org/feed/docs/rss2.html) are both: syndication formats and application-level protocols. Basically, it gives people publishing content a way to put their content out there and *distribute* that content to their readers.

Imagine if you could see your Facebook feed, without signing in to Facebook (technically this is possible, but go with me). Imagine if you could see your Twitter feed, without signing in to Twitter. LinkedIn. Polywork. And so on. Now imagine part of that feed included content from your favorite content websites.

Now imagine you're a content publisher who depends on ad revenue to eat and no one had to come to your site to see the content anymore. (Figuring out how to monetize the Internet will be around as long as money exists.)

If I can *easily* get my Facebook, Twitter, or similar content without having to go to the app, then Facebook, Twitter, and similar don't make ad revenue from my consumption of the content. Same thing with a lot of popular blogging sites who also depend on ad revenue.

As of this writing, there is an increasing in the groundswell for creators to be sponsored directly by consumers of what is created. Multiple platforms exist to facilitate this idea of patronage.

Anyway, one of the issues from back-in-the-day was server bandwidth. In some cases hosting providers would charge site owners by the megabyte. If you had a popular site with a lot of images, you would have to pay more than someone like me (who probably doesn't have a lot of traffic). Therefore, syndication was a way for you to distribute your content further and to more people. Some of the websites I followed back then would actually push their readers to subscribe to their feed and read the content from the feed-reader app instead to help save money.

These formats were so popular at one point, some browsers had the ability to [subscribe to feeds built-in](https://www.askdavetaylor.com/how_to_read_rss_feeds_apple_safari_mac_os_x/).

Oddly enough, I've never offered a feed before for this site. I've also never offered the alternatives that seem to have sprung up to fill this void; namely, the email newsletter. Specifically those newsletters that can send you to a publicly accessible page on the website of the individual or organization sending it. Seems appropriate that I'd do it now.

Atom and RSS aren't the same thing; they are different protocols. Given the state of the web at the moment, I've seen some refer to their feed as RSS (the more well-known and aptly named of the two) despite it using the Atom protocol. I've also seen feeds that actually don't follow either format, they are just [.XML](eXtensible Markup Language) pages that have similar data in them. With that said, they're not *that* different.

The key difference for me is that one seems geared toward new content while the other seems geared toward refreshable content. This is also why I'm just going to call it a feed for the copy you read.

Looking at the specifications for both (linked above), specifically regarding the element that describes a single item, we see RSS has the `pubDate` element and Atom has the `updated` element. Both are dates. The former is when the content was created while the latter is when the content was last time the content was "modified in a significant way." RSS doesn't appear to have a similar capability inherent to the specification.

That's it. That was the deciding factor between RSS or Atom.

My goal with this site isn't to create a bunch of content. I hope to create mostly evergreen content I'll update from time-to-time as the world and my understanding changes.

In 2018 [TechCrunch](https://techcrunch.com) and [Wired](https://www.wired.com/story/rss-readers-feedly-inoreader-old-reader/) couldn't really agree on the future of syndication. However, Wired apparently had an article on the [best RSS feed readers for 2021](https://www.wired.com/story/best-rss-feed-readers/); despite Wired's RSS feed link their footer leading to a 404 page.

![Screen shot of Wired magazine's footer and 404 page, November 16th, 2021](/media/web-development/wired-rss.png)

It's possible one of the feed readers mentioned in the Wired article was [Feedly](https://feedly.com/i/welcome), which has a free and paid version (wonder if the creators get anything from that). Funny enough, one of the features is a bot that helps prioritize and filter for you (an algorithm).

Of course, part of this is about voting in the Internet marketplace of ideas and technologies. Generally speaking, the more people use a specific type of technology, the more likely it is to be supported and enhanced by others.

So, there's the way the protocol wants me to operate, the way the aggregators want me to operate (which could be different), and the way I would prefer to operate.

## The protocol says

The feed itself requires three elements.

id
:    A universally unique, and permanent, [.URI](Uniform Resource Identifier); I'll use the domain.

title
:    Human-readable title for the feed, which is not the same as the titles for individual items; again, I'll use the title of the website.

updated
:    The last time the feed was updated.

The idea of anything on the Internet being "permanent" is somewhat laughable. The term permalink used to refer to this concept of permanence. I don't plan on bailing on this domain and there are times when I buy other, similar domains and end up pointing them here anyway. This will become a bit more interesting when we get to the individual entries.

The updated element is to help with caching and whatnot, I think. Basically, a reader can ping the site and see if what they have on file is before the date listed here. I'm planning on adding the ability for the site to respond to [HEAD only methods](https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/HEAD) to help with this as well, again, I think. I don't write feed aggregators, so, not sure how things will be affected. Anyway, I'm not looking to "cheat" here by making the date always the day that the feed is requested. Therefore, I'll be using the most recent update (or created) date of content for the site.

I will also be using the `author` and `link` elements. The `author` element at the feed level is required unless each `item` has an author element. Given most, if not all, the content will be written by me, this seems fair. If someone else decides to hop in on creating content for the site, the author field in the item will be used. The `link` element will link back to the feed itself.

Finally, I will definitely use the `rights` element, just to cover that base. I'm not sure if I'll use any of the other elements available for the feed level.

`entry` elements require the same three sub-elements and represent the individual entries in the feed. I plan on sorting the entries on the updated field; most recent first. I'll also use the `summary` element, while most likely *not* using the `content` element. The `link` element will also most likely be used.

## Impermanence

I was thinking that I would only show entries that had been updated in the last 12 months as opposed to the feed essentially containing every entry on the site. Aggregators seem to have a thing about caching content beyond what's in the actual feed served by the site. So, I don't think this would be a problem. It also means it's possible the feed could become empty.

With that said, I signed up for an aggregator and subscribed to something to test things and I noticed two things.

1. The number of articles in the aggregator was more than the number entries listed in the actual feed.
2. They were all marked as read—even though I had subscribed that day. This makes me think only entries that are added to the feed *after* my initial registration and sign date will be displayed as unread.

On to the `id` element.

I'm not sure how I want to handle this. I want to be able to move things around on the site. I also might delete things. So, the idea of a link being permanent makes me all weird inside, which is probably a contributing factor as to why I've never had a feed on my sites before.

If this were a database-backed site it would be easier because I could use the primary key of the content (not the primary key of the route) and then I could resolve against that table when someone used the "permalink." I'm thinking about using an indexing method instead.

In theory, a permalink would be an unchanging URI a person could go to and either see the related content or be forwarded to the correct place. For this indexing method, I'm thinking of using the [.YAML](YAML Ain't Markup Language™) front matter to facilitate this. Basically, it would be a list with a number and path.

```yaml
---
template: permalinks
permalinks:
    - 1 /path/to/content
---
```

This way I could use something like: `/permalinks/1`

For the `id` element. Then, if someone came to the site using that URI, I could redirect them to the [.URL](Uniform Resource Locator) of the page in the site. I'm not sure if I would send a redirect header with it or not. Then, if I moved the content, I could update the permalink reference.

This would add a bit of overhead when creating and redirecting entries. However, I'm thinking it might be worth it in the long run. And, if I decide it's not, well, that the impermanence of the Internet. A lot of feeds have just straight disappeared over the years.

## The [.URL](Uniform Resource Locator) for the feed

I've noticed a couple of sites that use feeds and the URL scheme is "feed." This works well when the user has a feed reader installed. However, in Safari and Firefox, it just breaks things. This is compared to having the XML page display. Further, posting these URLs into the online aggregator I'm using for testing results in the app wanting to "build a feed." When I remove the "feed" scheme from the URL I pasted in though, the desired feed appeared.

Therefore, I think I'll take a two-pronged approach…maybe. A link to launch the feed in a reader app and one to copy-and-paste into an app or web-based aggregator.



