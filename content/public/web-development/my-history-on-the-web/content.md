---
title: My history on the web
created: 20211108
---

# My history on the web

{!!dateblock!!}

I found myself telling the story of my participation online in multiple places; decided it’d be easier to put it in one place—in reverse chronological order using estimated years. It's important to note there is a difference between when something started and when I became aware of, and started using, something.

## 2021–

There seems to be a renaissance of the server-side applications. The monolithic application even. More and more businesses and developers seem to be appreciating that not all websites need to depend on APIs and extensive JS.

Meanwhile some organizations and businesses are just starting their microservice and single-page client-side web app journey.

Which of these is on the [bleeding edge](/web-development/modern-web-development) and which is behind the curve?

Or, maybe, they're both fine. The question I have is: Are you *choosing* the approach that best suits your needs, context, and constraints? If your company went all [.GM](General Motors) tomorrow, could you maintain your website?

Let us also consider the notion of low- and no-code solutions, which were available and promised in 2001. "Develop a full blown website without learning how to write code!"

What does "modern" mean again?

The codebase for this site as of this writing, might be considered a monolith; it’s all in one place. However, it’s quite modular by design; is it still a monolith? Further, this “monolith” can deliver this site using:

- dynamic page building and
- a static site.

Would we be better served if this was *not* a monolithic app?

## 2017–2020

Key takeaways:

1. Interacting with databases takes a lot of code.
2. Creating the administration panel of a website takes a lot of code.
3. Solid state drives are wicked fast.

I was laid off for the third time. Modified the website to showcase my development work, open source projects, and products; not sure why, but that's what I did.

Wrote a book.

Changed the site again to be a bit more focused on coaching individuals and small businesses.

Mom passed away and I took some time before starting my next position.

## 2017

Key takeaways:

1. Use the fringes to advance adoption and improve the core.
2. Adoption on the Internet is slow.
3. Chasing the new hotness is exhausting.

I remember working with a developer in the last year of my previous project (see 2013–2016). It was a wonderful experience and I grew a lot. We would get into debates and arguments about web development.

Initially he was pretty much all-in on the single-page, client-side web app approach. As we talked he started to shift. Testing and accessibility became a focus and he really appreciated the idea of progressive enhancement. 

I was channeling my frustration into creating the “on constraints” series and I don't know how much the one on [internet bandwidth](/web-development/on-constraints/internet-bandwidth/) got him thinking about progressive enhancement and the idea of how the Internet evolves, but it was after sending him that one that he basically altered his approach.

The idea is evolution in general.

We are all bound by the technologies of our times. The stuff at a thing's core get iterated on, experimented upon, and eventually they calm down. It's amazing that you can open a plain text editor (turn rich text formatting off), write some text, and save the file with a `.html` extension and display that in a browser. 

You just created a website.

Of course, if you want to do something "interesting" with it you'll need to add some styling—you can do that inline by adding attributes to an element, a style tag in the head of the document, or by creating another plain-text file…no special tools or applications required.

Or course, if you want to do something "really interesting" you'll want to do some interactive things, which can be done with more plain-text via JavaScript or [.CSS](Cascading Style Sheets).

No special tools or build steps required.

I think this is part of why the explosion recently has been more about serverless and client-side approaches, they can all be built without any special skills, knowledge, or tools.

We keep making it easier and easier to do what used to take special skills, knowledge, and tools by bringing it into the core of the technologies. Calling APIs with JavaScript used to be pretty difficult in comparison; now, not so much.

It's like pruning a tree.

We spend time growing into the space beyond the trunk. We create tools like jQuery, Angular, React, Laravel, WordPress, Drupal, Bourbon, and Sass to push the boundaries; to grow beyond the box and constraints. And, eventually, some of the things that used to be difficult to near impossible become truly native to the core of the platform.

[Client-side form](https://developer.mozilla.org/en-US/docs/Learn/Forms/Form_validation) validation and [accordions](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/details) to name but two. And, eventually, we'll get the [modal](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/dialog) we all deserve. My contention is that we have to start using them now to press implementation by browser developers. We use newer markup in our sites and maybe use polyfills to help provide cross-browser support and, when the browsers catch up, we can get rid of the polyfill; again, [for the modal](https://github.com/GoogleChrome/dialog-polyfill) we all deserve, for example.

## 2013–2016

Key takeaways:

1. Humans like solving complex problems.
2. If the problems aren't complex, we tend to [complicate the solution anyway](https://en.m.wikipedia.org/wiki/Rube_Goldberg_machine).
3. Beginning with the end in mind isn't the same as trying to begin at the end.

Static sites. Serverless. Back to the monolith—just make sure it's modular.

It felt like we started learning the drawbacks to microservices; they don't solve the complexity, they shift and distribute it. I started watching talks by those who had been in the software industry longer than me.

Most people I met were talking about using the right tool for the job; only no one could agree on what the right tool was—HTTML bad, React good.

I went to a locally-owned restaurant's website. It consisted of a single page with location, hours, contact information, and the menu; it was reminiscent of the site I made in 2001. The initial load was instant, but then I had to wait as the single-page, client-side web app spun up and requested the data it didn't get from the server the first time.

I was on project as a [.UX](User Experience) expert. I remember my team waiting for two months for the following requirements to be demonstrated:

1. A form with 7 fields.
2. The data would be stored somewhere.
3. It would need to be reviewed somehow before being published.

The proposed solution was going to incorporate GitHub and use the APIs to perform the review process. I explained that it seemed like a pretty complex solution for something so simple that we've been doing on the Internet since the early 2000s; can we break it down into something simpler and build on that; possibly into the solution being proposed?

That didn't go over well.

Out of frustration in waiting and trying to get the non-technical among us to understand my frustration I told the product owner: I'm just gonna build it.

He asked what I meant. 

I said I was going to build in two weeks what we've been waiting two months for. I cracked open [Laravel](https://laravel.com) and went to town. I built atomic, reusable components and contributed to the [United States Web Design System](https://designsystem.digital.gov). In two weeks I demonstrated what I had. The product owner said, "We need to show this to everyone." A week, and a few improvements later, we did.

This was the first time I had heard the phrase: Front-end development just takes so long.

I was floored. I couldn't understand. Then I saw how the tools being used worked; it all made sense. What I could do and change in a matter of seconds would take forever using "modern" tools.

The program shifted dramatically after the demonstration. We started building our own design system for the program, using the research and groundwork from the [.USWDS](United States Design System). We started making a component library for reusable components to be shared across multiple development teams on the program. While the USWDS used a modified [[.BEM](Block Element Modifier)](http://getbem.com/introduction/) approach, one of our front-end developers wanted to use a more utility-based approach; inspired by a seemingly dead or dying project [Semantic UI](https://semantic-ui.com/?ref=framestack).

## 2012–2013

Key takeaways:

1. Establish boundaries early in relationships and stick to them.
2. If you're good at something, it's easy for people to forget the pain that got them the result.
3. It's not that speed increases; it's that complexity of future work decreases while the changeability of the system overall increases.

After getting laid off I worked as a web developer "for corporate." Mainly brochure and marketing sites. 

Parallax scrolling became a thing for a while, one of our sites used it and I did the math to make it work. I created my first single-page, client-side web app almost entirely in JavaScript using [.API](Application Program Interface) calls.

I worked 6 weeks at 72 hours a week and was pushed to do more and to "go faster."

(Years later I created [a talk](https://youtu.be/jeX4fan9xHI) using the experience as the reference. And vowed to not development “for corporate” again.)

In the previous two years I started looking into developing native apps for iOS. During this time, I released an app written in Objective-C. 

I wasn't a web designer or developer, I just liked making things.

Dynamic site generation was waning. There was an evolution of static site generators and frameworks for building single-page, client-side web apps. For the former there was [Jekyll](https://jekyllrb.com); initial release, 2008. For the latter there was [Sproutcore](https://sproutcore.com/about/) and later Angular and React. Now we had an approach for the primary types of applications people were developing. Content-based experiences, app-like experiences, and the content (data) management and administration experience.

Each with its pros and cons.

It felt like everyone started realizing what Apple had been up to and jumped on that train. ([Grid Style Sheets](https://gss.github.io), for example.)

Two out of the three mentioned projects now seem to be dead or dying.

## 2011

Key takeaway: There's no such thing as permanent employment.

The idea of performing network calls to update a page without refreshing was picking up steam; [.AJAX](Asynchronous JavaScript and eXtensible Markup Language) hade been around since 1999 and this felt like a further evolution of those concepts.

Things we got for free from the server, the browser, or both started being taken on by frameworks and developers. Server-side languages started feeling like they had fallen out of favor and into disrepair. The first [.CMS](Content Management System) wars seemed to have run its course as it was no longer about getting people to have their own website and turned into helping people become content creators and influencers on everyone else's platforms.

This is also when I was formally introduced to Agile Software Development. I was brought onto a project as a UX Expert. When I walked into the room, the technical lead said: We do Scrum here.

When asked what that was he explained it in that way people explain things they know enough to be dangerous but maybe feels like they're lacking the nuance; it felt familiar to me. It sounded like what I had spent the last three years doing.

I ran home and found as many things as I could find on the subject; starting with [The Manifesto for Agile Software Development](https://agilemanifesto.org) and [The Scrum Guide](https://scrumguides.org). It seemed like I found where I’d naturally fit in.

The project was built on Microsoft technologies, which was fine, all I cared about was being a UX expert on the project. I worked with designers to improve the presentation. I worked with developers to improve their code and their approach.

I got laid off for the first time.

## 2010

Key takeaways:

1. Flow is a powerful force.
2. Minimizing dependency creates flexibility.
3. Content creators don't really *want* to update their own sites.

Living in my car. It was one of the best years of my life. I would still do development work on occasion. Not having to pay rent or utilities was a bless’d relief. The curse was avoiding telling people I was effectively homeless because I feared they’d try to help me to the point of hurting me.

I worked on the United States Census. I did well. My team did better. My performance kept me on for three operations in a row. But, I didn't have an exit strategy and the last operation required a phone line to direct connect to the Census to redistribute work to other workers with laptops—it took the agility away and I was useless. Modifying the flow of work became a huge bottleneck and I didn't see a way around it.

I got a call from a recruiter for the first time. It was for a 6 month contract at WebMD as a content publisher. It paid almost double what I had ever made in my life. My job was to copy and paste from relatively plain text documents into the forms of their custom CMS]. That was it. 

I would go in. There would be a bunch of word processor documents assigned to me. I would select the CMS template, copy-and-paste into the form, and submit the content for review. 

The document literally had the name of the template and the target field names.

Again, I was getting paid double what I was accustomed to making and almost three times what I made my last year of full-time freelancing.

## 2007–2010

Key takeaways:

1. Releasing a little bit on a regular basis is the shortest way to get managers to stop asking for status.
2. Never enter anything without an exit strategy.
3. Accessibility and semantics are important.

We'll call this The Dark Ages.

I took my sites down and just started squatting on my domains. I didn't want to do development; not sure what I *wanted* to do if we're being honest and in the decade of having a site I only received the one gig from it, and didn't get paid for it. This colored my perception quite a bit when talking with potential clients. 

One exchange in particular has always stuck with me:

> Why do you think you need a website?

They would give me reasons, which usually boiled down to, it legitimizes you as a business. To which my response was usually:

> You're about to hire me to do this work. I don't have a website. How does that fit into your rationale for needing a website; especially given you are small, local, brick-and-mortar shop.

Publishing platforms like Twitter, MySpace (waning), and Facebook were starting to take off as a way for folks to create content online. The owner of the boutique marketing firm I worked for showed me a corporate website one day.

It was a single page. It had about 100 words of copy. Then it had a bunch of links to their presences on various other platforms. The boutique owner simply said:

> They get it.

I think he was right for the time.

Modernizing a website in this time was in converting static files into content stored in a database and templates to display pages. People wanted sites they could update themselves.

This is the time when I jokingly say I "invented" [Agile Software Development](https://agilemanifesto.org).

My biggest client was a department at a university. They were modernizing their site. I developed the CMS for the site, wrote the data migration scripts, pretty much everything.

One day I asked if I could speak to the customer because going through the project manager was starting to wear thin. The project manager had apparently never been asked that question before, but said he would ask. When I got on the phone with the customer I said:

> Listen, you're sending me these emails. Some are bug reports. Others are feature requests. It's difficult to keep it straight and obviously things are falling through the cracks and annoying both of us. So, I would like to propose something.

1. I will keep a list (backlog) of all these requests.
2. On Monday we'll get together and prioritize those items and make sure I understand them and aren't missing any to the best of our knowledge (planning).
3. On Friday we'll get together again and I'll show you what I believe I can mark as done and you can verify they are done. Further, on this day, send me *one* email with all the new stuff to add to the list (review).
4. In between those two days, I won't reach out to you unless it's impacting the current work, and you won't reach out to me unless you can't sign in to the system (identifying blockers).

That was it.

Later I would learn this is the basic project management pattern of [.XP](eXtreme Programming) and Scrum.

Eventually we got to the point where I was releasing a new version every night. I would email release notes to the customer and await feedback on those items. Eventually we stopped having our Friday meeting.

After a little over two years the customer asked:

> When will it be finished?

I replied: It's software development, it's never finished.

He asked a follow-on question that escapes me. To which I responded: 

> Let me put it a different way. You'll be finished when you move on to a different project. I'll be finished when you stop asking for things, reporting defects, paying me, or some combination thereof. Someone will always be working on it though. Someone will always be doing something. We finished the baseline requirements six months ago, which was on time for the project's original delivery date. Users aren't reporting defects. Everything since then has been gravy or icing.

He chuckled and said he understood. A week later we launched the site and they stopped paying me.

A few months later, I started living in my car. I had succeeded in my mission of making myself obsolete to my clients.

## 2005–2007

Key takeaways:

1. Learning how to do things others don't want to is an easy way to get an interview.
2. Presenting win-win scenarios can help you get hired.
3. Internet Explorer 6 sucks.

I got bored doing Flash development. Once I hit a certain point, it just wasn't interesting anymore. I'm more in that greenfield and brownfield space, not the farmer space.

I was in college and still updating the Flash-based portfolio site by uploading images and new versions of my résumé.

I interviewed as a web designer for a boutique marketing firm in Ohio. I explained that I can do development, but wanted to be more of a UX person. And the whole story from a few years prior. During the first attempt the owner asked if I knew [.PHP](PHP: Hypertext Preprocessor) and [.MySQL](My Structured Query Language). I said no and he said I should learn.

I didn't get the job. I did buy a book on PHP and MySQL though.

It was a bit frustrating to be honest. I didn't know how to get to where I wanted to be and it seemed like all people close to the industry wanted to hire me for was to do the part I (and they) didn't want to do: write code.

Created my first CMS using PHP and MySQL. Everything I did for it was about improving the user experience and my definition of what UX meant started becoming more broad.

As of this writing, everything is user experience design for me, the questions are: who are the users and what are they using?

Quit my job in 2007. Moved to Georgia. Started freelancing as a web developer and business consultant.

I experimented a lot in this time. One experiment was extending [.HTML](Hypertext Markup Language). Another was in turning a long page of content into smaller pages that were displayed using JavaScript; all the content was delivered but you would click inline anchor links to show and hid me sections of the single article. The last experiment was making the site more project-based in its delivery.

## 2001–2004

Key takeaway: Separate content (data) and the presentation of that content.

In 2020 (well 2010) terms, Macromedia Flash was a single-page, client-side web app.

A single `index.html` file was delivered to the browser from the host. The browser would then confirm it had the player. If it did, the browser would request the other app assets.

Three things sucked about Flash when I first started:

1. You had to wait for the whole app to load, which represented your entire site.
2. If you wanted to send someone to a specific part of the site, you had to tell the person which buttons to click to get there.
3. Which brings us to the third problem—caching and updating the site; if you updated the site, and it was cached for the user, they wouldn't see your new stuff (and if the navigation changed, the instructions your friend gave you wouldn't work).

Eventually things advanced in Flash:

1. Eventually it got to the point where I could request images and text from the host, without having to refresh the page or update the Flash file; again, like a single-page, client-side web app using API calls ([everything old is new again](https://youtu.be/AbgsfeGvg3E)). (In 2015-ish terms, this would lazy-loading assets.)
2. Using a little JavaScript, you could read the [.URL](Uniform Resource Locator) (specifically the fragment, or hash) and update the same from the Flash app; this way you could send the hashed URL to your friend and my app could take them to the appropriate spot. This also respected the browser’s page stack better.
3. Because the assets weren't part of the app, I could update the content without updating the Flash file itself. I only needed to do that if I wanted to redesign the site and, if I didn't change where the files were, caching was almost a non-issue.

I did almost everything in code at that point; the file size became much smaller doing it that way.

The last version of my site that used Flash was 3 kilobytes.

For reference, that's half the size of the CSS used for this site as of this writing. That was the animations, retrieving assets, drawing things, and so on. Granted, I was leveraging a dependency that helped make that happen—the Flash Player could be thought of as the packages many of us use today. Further, since it was installed on the user’s computer, it didn’t add unnecessary weight to the initial download of my code.

So, yeah, think Angular and similar single-page client-side web app solutions as they were up until around 2015. Or Gmail as of October 2021:

```
https://mail.google.com/mail/u/1/#inbox
```

Only my single-page, client-side app was in Flash with a little JavaScript, not purely in JavaScript.

## 2001

Key takeaway: Know when to hold ʼem, when to fold ʼem, when to walk away and when to run.

Started building sites using Flash 4, which is now [Adobe Animate](https://en.wikipedia.org/wiki/Adobe_Animate)…the story I heard about how that happened really opened my eyes to the way the [.IT](information technology) field works.

I bought my first domain, which was joshuabruce.com, because joshbruce.com was taken.

I was offered my first web designer gig. I stress the term designer there because I wanted to *design* the pages and tried to explain as best as I could that I "wasn't a developer." That offer fell through because the contract I was hired for was cancelled.

I did manage to do a site for the company as a contractor. For the time, it was a pretty nice design built in [Photoshop](https://www.adobe.com/products/photoshop/landpa.html?sdid=KKQIN&mv=search&kw=photoshop&s_kwcid=AL!3085!10!79164992492577!79165251442724&ef_id=afed0e5de87c155014a96fd465b3c2bc:G:s) before Adobe shifted to be more multimedia and not so focused on print. This was before the slicing feature was in Photoshop and I set up the file to make it easier for the developers to slice and build the site.

The company had other ideas though and told me to, "Go ahead and put it in HTML."

I tried to say I wasn't a developer again and that didn't get through. So, I used [Microsoft FrontPage](https://en.wikipedia.org/wiki/Microsoft_FrontPage) to create the pages and did minor edits to the HTML. The response from the [.CTO](Chief Technical Officer) at the time was the design was great, the Photoshop file was perfect, but my HTML sucked for someone at my billing.

Mind you, this was the same person who asked if I was into JavaScript. When I said, no, the next question was, "Oh, you're a Flash-guy, so, ActionScript?" My response was: No, I'm not a developer. I do page layouts, interactions, and arrange the information for the page and the site.

Anyhoo.

Dot-com bubble blew up in my face. That company got bought. A couple months later the company that bought them was bought by a third company. (There might have been a fourth.) All the while I'm trying to get my check for this one job. It became a battle on principle, that I lost.

I gave up trying to explain what I saw as the difference between web design and development and decided that if folks wanted me to be a developer, I would do that.

I started creating the content management methodology mentioned above.

## 1998–2000

Key takeaway: The Internet is the most accessible platform for creators and consumers.

Someone I met through [.AOL](America Online) showed me a website they built. I asked how and they mentioned it was something that AOL just had and you could create a personal site.

They had a free [.WYSIWYG](what you see is what you get) editor. And I created my first portfolio site using that.

Then I picked up Microsoft FrontPage, which is no longer a thing.

Think of this like Wix, Squarespace, or similar.

Tools like these made the Internet feel accessible. Anyone could easily create content and put it somewhere. Not only that but people using assistive technologies could experience the same thing; it’s pretty difficult to make an inaccessible website.

## Prior to 1998

I was online using [AOL](https://www.aol.com), which served as my [.ISP](Internet Service Provider).

It was fun. Felt like Discord, Slack, MS Teams combined with Apple Messages and a browser. I didn't even know people could access the Internet any other way at the time. I met a few people that way.

The Internet at that time seemed more about meeting different people and then trying to meet [.IRL](in real life).
