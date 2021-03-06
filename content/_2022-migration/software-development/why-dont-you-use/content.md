---
title: Why don't you use (WordPress, PolyWorkHQ, Medium, LinkedIn, and so on)?
header: Why don't you use a framework or platform?
created: 20210619
updated: 20211109
---

# Why donʼt you use a framework or platform?

{!!dateblock!!}

> I’m working on updating the structure and format of the site. **This page will be deleted.**

Since 1998 I have always created the platform used by my website. Be it Adobe Flash, PHP, or trying to write one in Swift. Inevitably someone asks me why I feel the need to reinvent the wheel or why I think I'm "better" or "too good" for those other platforms.

Not to sound too "get off my lawn" about the whole situation I'll say: I've tried other platforms, continue to try other platforms, and continue to come back to the ones I've built.

I've never been a fan of WordPress and I started using it around 2005 and it inspired some of the decisions I made as I iterated on my own content management system. The biggest problem I have with WordPress is that its rapid rise in popularity turned it into this odd Frankenstein's monster where every website either had to use WordPress or the problem we were trying to solve could be solved by WordPress, even if WordPress wasn't designed to do it.

I've had two regular jobs as a web developer. In both cases, every problem or site that came across the table WordPress had to be the solution.

In the early 2000s we wanted to avoid custom code to reduce the learning curve of someone coming in after me; of course, I still had to explain all the customizations we did to WordPress to make it work for the client.

In 2012 at my second and last gig as a full-time web developer (working for corporate) I would spend hours and sometimes days trying to beat WordPress into submission to give the client what they needed. This usually ended with me writing a user's manual so they could update the site themselves.

The equivalent from 2015 or so would be the single-page client-side web app; think frameworks like Angular. A brochure site for a local restaurant with a menu and list of locations doesn't need all that...not a good solution for the specific problem.

[Maslow's Hammer](https://en.wikipedia.org/wiki/Law_of_the_instrument) was in full effect and still kinda is. Turning a technology (the web) designed to be accessible to the "commoner" into something requiring complex, advanced knowledge.

This desire to make the web accessible to more people so they could create their own content saw a boom in platforms where those who didn't want to learn the syntax of HTML and the technology of transferring files could post their own content. [Twitter](https://twitter.com), [Facebook](https://www.facebook.com), [MySpace](https://myspace.com), [LinkeIn](https://www.linkedin.com) and other social media platforms started dominating the landscape. Of course, many of these came after the push by developers to create software the "commoner" could install on their own servers to generate their sites; [WordPress](https://wordpress.org), [TextPattern](https://textpattern.com), [Movable Type](https://www.movabletype.com), and countless others.

There seems to be a resurgence of platforms and applications coming in now as the technologies have stagnated or the ethics of the creators is being challenged.

I spent the first 10 years of [my history on the web](/web-development/my-history-on-the-web/) with a website I developed and curated. I spent three years without a website at all (while getting paid to develop websites for other people). And I've spent another 10 years looking for a platform and audience in applications developed by other people.

The thing that keeps me coming back to a custom build addressing my specific needs is that I'm in control.

Don't get me wrong, I'm not a very command-control person, in fact, quite the opposite. With that said, I want to be able to create my own [terms of service](/legal/) and abide by my own ethics, I don't want you to feel my content is forced upon you by someone else, and another big thing is I don't want to be tightly coupled to someone else's product or service (I want to be relatively self-sufficient).

## Solving my own problems

As of the [2021 build](/web-development/2021-site-in-depth/) of this site, I no longer use [Laravel](https://laravel.com); for reasons described in [this article](/web-development/). In short, I didnt use a lot of the features provided by Laravel.

I don't use trackers or analytics that can keep tabs on my visitors; I don't care how old you are (for the most part) or any other demographic information. Actually, for the most part, I avoid analytics altogether because it could slow down your experience, even the non-stalker-esque tracker I wrote.

The Internet is fast. We're just not building like we had to back in the day when it was literally slow.

## Don't force feed

There's a lot of advice out there on how to grow an audience. One of the most prolific and specific pieces of advice is to generate a shit-ton of content.

> You should be posting four or five times a day!

I feel like this advice comes from the more eyeballs mentality that originated with ad revenue. More eyeballs equals more money to the platform owner. Of course, if you're posting to someone else's platform, they're making all that money. Not only that, but this advertising model has led to the creation of the feed and trying to get people to scroll forever on the page.

If I want to appear in your feed, I need to produce more content than the next person. Specifically, I need to create more content you are willing to interact with than the next person.

I remember when I was still publishing on Medium I started talking about productivity and [self-improvement](/design-your-life/) and was just starting to build an audience. I started following some other folks in that niche. They were putting out daily articles; using the following formula.

1. Monday: Post article about life hack 1.
2. Tuesday: Post article about life hack 2.
3. Wednesday, Thursday, Friday: Post articles about life hacks 3, 4, and 5, respectively.
4. Saturday: Post article about "5 great life hacks" that summarized and regurgitated the previous five articles.
5. Monday: Post article about life hack 6.
6. Tuesday...
7. Saturday: Post article about "10 great life hacks" that summarized and regurgitated the previous 10 articles.

Quantity. Quantity. Quantity.

That's not how I've ever wanted to roll on the Internet. However, I felt what happened as a result; lowered engagement, less discoverability of the content I was putting out, and so on. So, I stopped posting to Medium while I could figure out how I wanted to do content in this ever-changing medium called the Internet.

The two big things I didn't want were:

1. I didn't want to repeat content.
2. I didn't want to leave content up that was stale.

That's when I came to the three content type model.

## Decoupling

The longer you let someone or something else do things for you, the more coupled you will become. Something I'm seeing a lot of in the software development space is "modernization" efforts.

Moving clients from database A to database B or micro-services instead of monoliths.

To pick on WordPress again, it used to be that WordPress would create a whole database architecture for you (don't know if that's still the case). The more content you created, the more it was tightly coupled to that database architecture and, by extension, to WordPress. It got to the point that many of the other content management applications had scripts that would perform database migrations from WordPress (or other popular tools).

Of course, you're basically getting a divorce and immediately remarrying someone else with similar baggage.

As of this writing, this site doesn't use a database, it uses the file system; kind of like a traditional website build from 1998 or, if you're into static website generators, it's like that from a content perspective. From a presentation perspective, there are a few hundred lines of site-specific code I maintain. For the most part they're plain PHP or using libraries I also write and maintain in a similar "only solve problems you have" spirit.

The most annoying part for me right now is getting all my content wrangled back into this site; decoupling from the various Web 2.0 platforms I’ve tried over the years. Beyond that, this site's just leveraging what the Internet is good for. Receiving requests and returning responses; mostly in the form of plain-text.
