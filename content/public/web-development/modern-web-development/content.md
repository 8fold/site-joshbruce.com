---
title: Modern web development
created: 20211018
updated: 20211105
---

# Modern web development

{!!dateblock!!}

The term "modern" is an odd one, freighted with baggage. In the context of web development it seems even stranger given that I’m older than the public web.

In some cases the term modern feels rather ageist when it’s used to say, “I won’t use anything from a certain number of years ago”—the new shiny is better than old reliable. I remember using [CSS Zen Garden](http://csszengarden.com) as a reference to demonstrate how flexible minimal, semantic markup can be due to the use and ubiquity of [.CSS](cascading style sheets). The retort from the development team at the time was that CSS Zen Garden was an "old" site.

Technological ageism.

In other cases "modern" seems tightly coupled to an approach or technology stack. The single-page client-side web app, use of microservices, and over-the-wire calls.

I'm sure there are more uses and think this is enough to suffice.

The web is built on an old concept, in my opinion; input and output or I/O. A human user interacts with a client. That interaction is turned into a request. That request is sent somewhere. That somewhere then returns a response.

A static website for example:

1. The human enters an address into a browser (client) and hits enter.
2. A request is made to the internet service provider who will pass it along to where it needs to go (this is a simplification).
3. The request arrives at a computer somewhere (server).
4. The server takes off the domain or [.IP](internet protocol) address from the path requested and looks for a specific file or a fallback (or default) at that location.
5. The server then builds a response (some common responses are listed):
    - An appropriate file is found and everything is "ok"; a [200 response](https://httpwg.org/specs/rfc7231.html#status.200).
    - An appropriate file is *not* found; a [404 response](https://httpwg.org/specs/rfc7231.html#status.404).
    - An appropriate file is found, but you lack the credentials to get an ok response: a [403 response](https://httpwg.org/specs/rfc7231.html#status.403).
    - An appropriate file is found, but wants to send you somewhere else instead: a [300 response](https://httpwg.org/specs/rfc7231.html#status.300).
    - The server doesn't even know where to begin really; a [500 response](https://httpwg.org/specs/rfc7231.html#status.500).
6. The response is sent back to the client for interpretation and display.

This is the basis for any style of communication, internet or otherwise. Each word and sentence you read can be interpreted as a request from me, the author. The request I'm making is for your understanding. If I use words you know, then your response will be a 200. If I use a word you don't know, then the response will be a 404 (word not found error). If I use or reference an inside joke you aren't familiar with, it will either be a 404 or 403. If I link to something and you follow the link, that's a 300 response. If the words somehow "break your brain," that's a 500 response.

In the ’90s, you kinda had to be tech-savvy and “in the know” to be creating and consuming content online, and it felt like it. Consider the [.URLs](uniform resource locators) of the time:

For example:

1. `http://www.yourdomain.com/home.html`
2. `http://www.yourdomain.com/about.html`
3. `http://www.yourdomain.com/contact.html`

At least the domains were human-friendly and not straight [.IP](internet protocol) addresses. There are only two human-friendly parts of the routes listed: the domain and the file name (at least the filename without the file extension—everything else is to help the computer understand what you’re trying to do).

I’m not an historian beyond my own life, so, this isn’t meant as a literal retelling of the history of the Internet and I recognize that there’s a big difference between when something started and when I became aware of it.

Three things seemed to happen; in no particular order.

First, dynamic languages and template engines: [.PHP](PHP: Hypertext Preprocessor), [.ASP](Active Service Pages), and so on. We called it dynamic because you didn’t need to change the [.HTML](hypertext markup language) file to change the content. We also needed to tell the server, "Hey, this isn't HTML!" So, you started seeing routes like the following: `http://www.yourdomain.com/about.php`, which sucked because, if you didn't know the underlying technology, you didn't get to see the site.

Second, more sites started taking advantage of the default or fallback file option. Name a file `index` and put it in a folder. If the request received doesn’t have a file name and extension, the `index` file is used. This led to the creation of deeper folder hierarchies, each with one file in them. So, instead of a folder with four files, we had three or four folders with one file each, resulting in the following routes:

1. `http://www.yourdomain.com/`
2. `http://www.yourdomain.com/about`
3. `http://www.yourdomain.com/contact`

Before this strategy, if you wanted to change the technology of your site, say, from ASP to PHP, you had a serious problem. With the folder-based strategy, the server does the heavy lifting and doesn’t expose the underlying technology. As a developer you could change your tech-stack whenever you wanted to without worrying about breaking your routes.

The third thing is the `www` bit. In the beginning `www` was used to distinguish between the Internet as a whole and some internal server network (extranet versus intranet, respectively). Again, this was annoying from a user experience perspective. As we progressed, it became possible to remove the `www` from the route (the "extranet" became the default for browsers):

1. `http://yourdomain.com/`
2. `http://yourdomain.com/about`
3. `http://yourdomain.com/contact`

Arguably, secure-by-default is becoming an integral part of the web, which changes the `http` to `https`.

The route is the keystone of the Internet. And I would say this route style and format is the basis of modern web development.

I witnessed this evolution of routes over the course of a few years.

The promise from an HTML-perspective was [semantic markup](https://www.w3.org/standards/semanticweb/); starting around 2005 (at least that's when I started hearing more about it). We still haven't got there though. Many sites I visit still default to using `div` and `span` for block and inline elements, respectively, outside of content. Not a lot of `article`, `main`, and `setion`, for example.

I first heard about [microdata](https://html.spec.whatwg.org/multipage/microdata.html#microdata) and microdata vocabularies around 2009. This let you put attributes in your HTML elements to help further describe the content. For example, if you view the source of this page, you should see that the article tag uses a `typeof` attribute with a value of `BlogPosting` and a `vocab` attribute with a value of `https://schema.org`. This means I'm using the microdata vocabulary from [schema.org](https://schema.org/) and a computer reading this file can better understand my intent; as long as it can read [.XML](eXtensible Markup Language) (specifically HTML) and can understand the schema.org vocabulary. The navigation is wrapped in a `nav` element, describing the intent of that area of the page. This article is wrapped in an `article` element, defining the intent. The microdata further describes my intent. I could put the microdata at the top of the page using [.JSON-LD](JavaScript Object Notation for Linking Data); however, I would prefer to put it in the HTML itself because the interpreter doesn't need to know [.JS](JavaScript) to interpret the intent, thereby, being technologically agnostic—anything that can parse XML (or a plain text string) can interpret this page.

[My history on the Internet](/web-development/my-history-on-the-web) has been interesting.

