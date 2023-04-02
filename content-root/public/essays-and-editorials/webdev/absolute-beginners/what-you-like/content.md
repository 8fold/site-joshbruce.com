# What you like

{!! dateblock !!}

Life's too short and too long to spend it doing crap you don't like because you feel like you *need* to for some reason.

Some people really like creating user interfaces with [.Hypertext Markup Language](HTML), some people would rather use a tool to make that happen. Some people like styling things with [.Cascading Stylesheets](CSS), some people would rather use a tool. Some people don't like either and would rather use a template made by someone else.

Some people want to make content and don't want to mess with any of that. Some people want to take someone else's content (or their one bit of content) and experiment with ways to change the look, feel, and experience (a la [CSS Zen Garden](http://www.csszengarden.com)).

Some people like administering servers. They love optimizing and optimizing, and they couldn't care less about what's being served on the hardware.

Given how long we've been doing this internet thing, we have you covered...like a lot.

We're going to cover a lot of ground, and in the spirit of this series, we'll start with low cost and low technical expertise.

(The quotes of desires aren't strawmen, they are things I've heard people say over the years.)

## In it for the content

> I want to create content and "get it out there," I still feel like I need a website, but I don't want to have to build and maintain it.

Cool. Not a problem. Lots of options. You are the reason [Web 2.0](https://en.wikipedia.org/wiki/Web_2.0) happened. And, we're entering a somewhat new era of monetization on the web; fewer ads, more subscribers.

A key to this approach is to go where you think your audience is.

Choose the types of content you want to create. Pick the platforms for that content. Create a one- or two-page site that links to all those places.

> I don't want to design the site and feel like I can't afford to pay someone to design it.

Not a problem; to be fair, it doesn't need a great design. And, if you search for "one-page website templates," you could probably find one that suits your purposes as a one-time purchase or even free, and you have enough knowledge to tweak it here and there.

That said, this is a replacement for a calling card. We wouldn't even call it a brochure site. It gives you one place to send people, who can go to the other places, usually places they already have accounts. Chances are, you're not going to pop up in "organic search" results—you are driving people to the site. Though I created a site for a client with 43 words of copy, it started ranking high on search results.

(I'm hesitant to link to an example because that site might change into, well, not this.)

The body copy could almost literally be: Hi, I'm me. You are you. You can connect with me...{unordered list, lightly styled, with links to all the other places you are online}.

What's nice about this is if you decide you don't like a platform anymore, you can deactivate or archive that account and put the link in a different unordered list: You used to be able to find me...

When someone asks, instead of rattling off five different platforms and usernames, say, "Start at my website..."

Done.

This calling card site will cost about 50 [.United States Dollars](USD) a year.

You don't need a database. You don't need a framework or content management system. You don't need most things. (To be fair, most people don't need that stuff either.)

## In it for the design (and content)

> I like designing interfaces and page layouts.

Right on. Keep practicing HTML and CSS. I knew a user experience designer who would redo other people's sites through their lens. "Here's a site whose content I appreciate. However, I think the design could be improved. Here's the process I took. Here's the thinking. Here's the result."

I did something similar for a while. I’d go to a site, view the source, then recreate the same design usually with more semantic markup and less code (like 50–80 percent less HTML and CSS).

They usually stuck with big corporate sites, New York Times, Google, and so on. They didn't go to `joshbruce.com` and say, "Here's how I would have done this."

Check out the various design systems and user interface frameworks (so many design systems):

- [US Web Design System](https://designsystem.digital.gov).
- [Zurb Foundation](https://get.foundation/sites/docs-v5/).
- [Google Material](https://m3.material.io).
- [Bootstrap](https://getbootstrap.com).
- [Semantic UI](https://semantic-ui.com).

> I don't want to write code, though.

Ah, not a problem.

Find a website builder application. I recommend software you purchase once, not a subscription, but whatever floats your boat.

Specifically, what we're talking about is a non-web-based piece of software. You'll create the site with the software, then export and upload the files it generates. (Most builders have built-in FTP clients to export directly to your host.)

[Blocs](https://blocsapp.com) is about 100 USD as a one-time purchase and seems to have a robust community and many additions. [RapidWeaver](https://www.realmacsoftware.com/rapidweaver/) is about 100 USD and seems pretty decent. Compared to popular alternatives, either will pay for itself in about 6 months in money saved from subscription-based platforms. (Not sure what's available for Windows. I've at least played with both of these.)

If you're okay with paying a monthly premium, [Wix](https://www.wix.com/upgrade/website) provides hosting (point the domain there) and a web-based, what-you-see-is-what-you-get (WYSIWYG) editor; probably won't be able to take advantage of the storage on disk for non-site files though. 

While I don't recommend Adobe applications anymore, you can get [Adobe DreamWeaver](https://www.adobe.com/products/dreamweaver.html) for about the same price as Wix every month; it's available for both macOS and Windows and has been around for over 20 years and will have similar capabilities as Blocs and RapidWeaver.

I'm biased regarding writing my own HTML or heavily modifying the output of WYSIWYG editors. Still, I started with [FrontPage](https://en.wikipedia.org/wiki/Microsoft_FrontPage) in the drag-and-drop sense and switched to DreamWeaver when it was still [Macromedia](https://en.wikipedia.org/wiki/Macromedia) DreamWeaver mainly as a code editor and local previewer.

## In it for servers and code

> I like playing with computers, code, or both.

Right on!

Get a computer, preferably a Unix-based machine; a [Linux distro](https://www.linux.org/pages/download/), [macOS](https://support.apple.com/macos), and Windows is getting there. Install [Apache](https://www.apache.org) or [NGINX](https://nginx.org/en/). Connect the computer to the Internet. See if your site can be displayed from that computer using a device on a different network.

I started with a mac mini from Apple. I used OSX Server as a file server, iCloud before iCloud. It was an interesting learning experience. That's how far I wanted to tread down that server administrator path.

Also, find a language and, more importantly, a community you appreciate and who appreciates you.

I prefer [PHP](https://www.php.net) and [PHPC.social](https://phpc.social/getting-started). I also appreciate [Software Crafters Meetups](https://www.meetup.com/seattle-software-craftsmanship/).

[Server-side Swift](https://www.swift.org/server/) also seems interesting; not a lot of infrastructure around it yet. I know a lot of folks who prefer [Python](https://www.python.org). Some people are into [Ruby](https://www.ruby-lang.org/en/). Even [Haskell](https://www.haskell.org) via [Happstack](https://www.happstack.com/page/view-page-slug/1/happstack). JavaScript, of course, via NGINX. Java. Whatever you're into.

All of these languages have frameworks and libraries. Each of those will have its sub-cultures and communities. Laravel, Symfony, and so on for PHP. Ruby on Rails, Jekyll, and so on for Ruby. Django, Masonite, and so on for Python. I'm going to stop now.

My humble request is to avoid elitism and feeling inferior; a paradox, to be sure. Some people are hung up on being a "real" programmer. It's one of the most frustrating aspects of software development for me; we can be so mean to one another. 

"I only do HTML and CSS. I'm not a real developer." Or, "I'm self-taught and don't have a computer science degree. I'm not a real developer." Or, "You don't write tests? I thought you were a *real* developer." 

(I understand this is part of the human condition in many ways, and still, it seems exceptionally prevalent in the software development space.)

## Conclusion

The Internet is a magical thing comprised of the most mundane things (plain text, not even rich text). It can feel magical. 

Seeing what others have done and are doing can fill people with a sense of, "I could never do that!" I don't think that's true. What is probably more accurate is, "I don't want to do that." And that's okay.

Further, if you want to have a site on the Internet but don't want to make web design and development your career, that's okay too—don't let others give you shit for that. 

Finally, if you're worried, people will give you shit, and that's the thing that's stopping you from starting. You have a friend in me. I will gladly hold space for you. 

With that said, as always, I typically work on pull from folks letting me know the content they want to see (otherwise, I write about whatever and whenever). If you found this series helpful and would like to go beyond the absolute beginner topic (or would like a deeper dive into something from the absolute beginner space), let me know:

- [PHPC.social](https://phpc.social/@itsjoshbruce) (Mastodon)
- [LinkedIn](https://www.linkedin.com/in/josh-c-bruce/)