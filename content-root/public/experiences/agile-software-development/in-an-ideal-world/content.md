# In an ideal world…

{!! dateblock !!}

A common refrain wherever I go:

> In an ideal world, Agile works. Unfortunately, this isn't an ideal world.

To be clear, your feelings are valid. And life rarely feels ideal while we're in the middle of it.

<aside>

**Principle:** We are lost if we don’t believe we can make this world the ideal.

That was deep.

</aside>

Let’s try a joke I heard once from Ken Schwaber (co-creator of Scrum):

> Agile Software Development is what you get when you observe software teams in their natural environment.

If that still doesn’t resonate, [maybe a quote from Yoda](https://youtu.be/z4jeREy7Pbc)?

> No! No different. You must unlearn what you have learned.

How about something someone asked me recently that spurred writing this:

> Can this work in the real world?

Reading recommendations:

1. [Reinventing Organizations](https://www.reinventingorganizations.com/) (book),
2. [Shoshin](https://en.wikipedia.org/wiki/Shoshin) (the beginner’s mind) (Wikipedia article), and
3. the story in this article.

## The [TL;DR](https://www.merriam-webster.com/dictionary/TL%3BDR)

Yes, it can work in the “real” world.

Will it happen magically? No.

Will it happen because of ceremonies? No.

<aside>

**Principle:** Processes aren't a panacea.

</aside>

Will it be easy? It depends on a lot of factors. The main element is the baggage we bring to the table ([Individuals and interactions over processes and tools](http://agilemanifesto.org/)).

Humans tend to talk about the good stuff and de-emphasize the rough spots. This can create the perception of “ideal worlds” where stuff that worked over there won’t work here. Or, it was easy for them and will be hard (if not impossible) for us.

> We need the *best* people. The *right* team sizes. The *optimal* org-structure. The ideal...

To quote [Randy Pausch](https://youtu.be/oTugjssqOT0) (and use the word *right*):

> If you do the right things adequately, that's much more important than doing the wrong things beautifully [...]. It doesn't matter how well you polish the underside of the banister.

In summary, the doomed project goes like this:

1. We finished the initial requirements in 18 months, on time and with enough budget to keep going.
2. The users could start using the application after 3 months; despite not being "made live" for another 18 months.
3. We kept going for another 6 months because we got wrapped up in the momentum of delivering value.
4. The University ran the same software for about 10 years and never called me about new features or defects.

## The setup

It’s 2007, a year before [The Great Recession](https://en.wikipedia.org/wiki/Great_Recession). I’m in my mid-to-late-twenties. I just quit my job. And I moved from Dayton, Ohio, to Atlanta, Georgia.

No job lined up. No leads. Over 500 rejection letters from various job applications over the previous two years.

No money. I had the first month’s rent (borrowed from my father) and gas money (gifted from friends).

All my possessions were packed in my four-door sedan. I could still see out the back and take a passenger if I wanted.

An email was sent to the wrong person (me) and landed me a freelance web development opportunity for a major university.

The project was doomed by all accounts. Yes, doomed.

1. It was a 36-month project. We were 18 months in when I was brought in as the sole developer.
2. In the 18 months leading up to this point, the committee had agreed on one thing: The design of the home page for a 1,500-page website.
3. We were going to convert the 1,500 pages of HTML to a database and create a custom [.Content Management System](CMS).
    1. The previous developer had started building the CMS, so we had that going for us.
4. My academic training was in studio arts, and I had only worked in traditional service jobs until then. Web design and development was a hobby, and I had only worked with 4 other clients before then. 2 were friends (they don’t “really” count), 1 threw my work out upon delivery after paying me, and the last never paid me.
5. The [.Project Manager](PM) wasn’t trained in being a PM. Their day job was as a server administrator at a different university.
6. The client was a committee member who had been given (thrown) all operational authority (and accountability) for the project's outcome, no training. They still reported to the committee, but they made the final decisions (the [advice process](https://reinventingorganizationswiki.com/en/theory/decision-making/)).
    1. In other words, they were the customer in [Agile Software Development](http://agilemanifesto.org/), the [Product Owner in Scrum](https://scrumguides.org/scrum-guide.html#product-owner), the [DRI at Apple](https://about.gitlab.com/handbook/people-group/directly-responsible-individuals/), and the scapegoat depending on how you wanted to look at it.
7. None of us had even heard of Agile Software Development.

By all accounts, I should have said no, but [bird’s gotta eat](https://youtu.be/h4o_8BYVQ2k), and it was an hourly gig.

Items 4, 5, 6, and, arguably, 7 in many organizations would have been considered serious weaknesses.

We soon learned it was our greatest strength because we had no preconceived notions about how things “must” be done or what the “right” or “best” things to do were (shoshin), and we didn't try to copy what others were doing (we had a site to build).

## The pain (or impediments, or friction, or risk)

Whatever we call it, it was stuff getting in the way of joy and delivering value.

I looked at the code for the CMS and didn’t fully understand what was happening. I tried signing in, and it didn’t work. So I contacted the original developer on AOL Instant Messenger (the MS Teams and Slack of the day). They fixed it.

Every day, for the next 3 days, it was the same story.

On the fourth day, I said, “Thanks.” And asked, “What are you doing to fix it, though?”

(Fair warning, if you know me and think I’m blunt or maybe a bit brazen, it was more intense back then.)

I use the term “fix” loosely here because it wasn’t fixed, it was temporarily no longer a blocker, but it’d be back the next day.

The original developer responded, “If you read the code, it should be self-explanatory.”

This made me feel dismissed and stupid. I had read the code. It didn't make sense to me. But, apparently, I was the problem, not the code.

This is a trap many of us fall into.

We are experts in a thing (find it easy) and don't understand why others find it difficult. We also tend to be dismissive when we’re busy doing something else and someone asks a question with a perceived obvious answer from our "expert" perspective. And, finally, ego is a powerful force, "There's no way I created a complicated thing."

I called the PM and said, "The other developer isn't helpful. I can spend the next 6 months learning how this thing is supposed to work, or I can start over. I recommend starting over.”

He (eventually) agreed.

(If the deadline wasn't so close, or the original developer wasn't so dismissive, I might not have defaulted to what many of us default to, which is throwing everything out and starting over; I will create the ideal world once we get the "real" world out of the way.)

So now we only had the design for the home page. (Doomed, I tell you.)

The customer would communicate mainly through email; this was not their full-time job at the university. So every day, I received 5 or 6 emails.

Some were feature requests, and others were defects. Eventually, I started a list in OmniOutliner (a [Product Backlog](https://scrumguides.org/scrum-guide.html#product-backlog)). But things were still falling through the email cracks, and we were both frustrated. And all three of us started playing the blame game (storming and foreshadowing).

The PM and I would talk regularly, and he would try to articulate what the customer wanted. Occasionally, he'd bring his emotions and opinions into it. This distracted me from what the customer actually said or needed; customer feedback was diluted. Then, if I asked a question the PM couldn’t answer, I'd wait while he went and asked the customer, then came back to me.

<aside>

**Principle:** Minimize the gap between those who need the value and the people creating that value.

</aside>

Eventually, I asked, “Can I just talk to the customer?” ([Customer collaboration over contract negotiation](http://agilemanifesto.org/).)

The PM responded, “I’ve never had a developer ask me that. Let me check.”

The three of us got on a call.

I said, “Look, I’m frustrated. You’re frustrated. We’re all under the gun to get this done. I think we can make this work."

(This was our first [Sprint Retrospective](https://scrumguides.org/scrum-guide.html#sprint-retrospective), of course, none of us knew what that was.)

They agreed.

I continued, “Part of the problem is all the emails. I’m accepting them, but I’m losing some ([Accept changing requirements, even late in development](http://agilemanifesto.org/principles.html), [transparency](https://scrumguides.org/scrum-guide.html#scrum-values), and owning my faults). So here’s what I suggest. Save those emails until the end of the week. Then, every Friday, we’ll have a call. I’ll show you what I’ve managed to get through ([Sprint Review](https://scrumguides.org/scrum-guide.html#sprint-review)) and we’ll talk about how working together is working or not ([Sprint Retrospective](https://scrumguides.org/scrum-guide.html#sprint-retrospective) or post mortem, if you prefer). Send me one email after that session.”

He agreed.

I continued, “This will give me a day or two to get a feel for the new things and add them to the list. Then, on Monday, let’s have a call, and we’ll prioritize the list, and I’ll ask any clarifying questions I might have ([Sprint Planning](https://scrumguides.org/scrum-guide.html#sprint-planning)).”

He agreed.

I finished, “Between those two sessions, don’t talk to me.” (Not ideal. But effective.)

I had more clients and needed to manage my time without losing sight of this customer’s needs; this was my bread-and-butter client (they paid the rent, and the others paid for food). “Unless the system is down or you can’t sign in, save it for the Friday email. If it’s a defect, cool. If it’s a new feature, right on. We'll add all of them to the list and prioritize them on Monday. Just save the email until Friday.”

We agreed.

We had just established a set of alliances and agreements (a team culture or [norming from Tuckman's Model](https://en.wikipedia.org/wiki/Tuckman%27s_stages_of_group_development#Norming)—I had no idea what Tuckman's Model was at the time), and we established an initial project management plan (which is essentially what the [Scrum Guide's](https://scrumguides.org/scrum-guide.html) 16 pages are; I didn't know what a Project Management Plan or Scrum Guide were).

## The progress

I was being pushed to get a user interface “up and running” because clients tend to prioritize what is seen. So I was concentrating on a script to grab all 1,500 HTML files, remove the non-content parts, get the main content into a database, and give myself a way to pull that information from the database.

Without content, there is no product, no matter how pretty it looks ([Working software over comprehensive documentation](http://agilemanifesto.org)—a design is documentation). The script could create the entire database structure and content in one go; they were still adding new pages as we built.

My roommate's younger (adult) brother wanted to get into web development. Once I got the script and database architecture to a relatively stable point, I hired him to validate the migration. Page-by-page, he would go to the live site for two weeks, then look at the database and ensure we weren’t missing any content or HTML structure. He and I met every day for a few minutes to talk about how we were coming on our goals ([Daily Scrum](https://scrumguides.org/scrum-guide.html#daily-scrum)). If he found a problem, I'd update the script. (I paid him out of my pocket.)

I started building the home page.

There was some JavaScript work that needed doing. But, unfortunately, I did not do JavaScript (I was focused on what we now call User Experience design). So we brought in someone else for a day or two (they were paid from the project budget and taught me enough to know how to fix problems with it).

I depended on both of them, but only for a brief period and specific aspects.

Every Friday for the first two months, the PO, PM, and I had our meeting. I showed what we got done, received feedback, and the PO compiled and sent the email.

On Monday, we’d prioritize the list. Then, during the week, I did whatever needed doing for whatever client I was working with ([Sprint Backlog](https://scrumguides.org/scrum-guide.html#sprint-backlog) across multiple products and projects).

Eventually, we got to a point where I was finishing features and deploying updates daily, and I’d send an email describing what they should test next ([Deliver working software frequently](http://agilemanifesto.org/principles.html)).

During the process improvement portion of our Friday meeting (Sprint Retrospective), we decided only to have the meeting if necessary; the customer and their department needed help keeping up with daily updates and testing. We had moved from "Tell me what you're going to do" to "Tell me what you've done" to "Oh my god, it's too much." (The crossing point from [complexity to agility](https://www.youtube.com/watch?v=jeX4fan9xHI).)

We all agreed to switch to asynchronous communication. We had a good pulse and knew each other well enough to communicate effectively (performing from Tuckmnan's Model).

Eventually, the feature requests started dwindling.

## The end

After 24 months, we decided to have a call.

The PO asked the most standard of PO questions, “When will it be done?”

I said, “It’s software. It’s never done.”

“What do you mean?”

“Let me put it this way. I’ll be done when you stop paying me, asking for features, or reporting bugs. Y'all have been able to create content for over 18 months, you aren’t reporting any new bugs, and we finished the initial set of requirements 6 months ago; we made the deadline. You’ll be done when you move on to a different project or role. But someone, somewhere, will always be working on this until they decide the website (product) is no longer needed. All we need to do is launch.”

We laughed.

He said, “Got it.”

We made the site live. That was the last time he and I spoke.

The department at the university appeared to be running the same site code a decade later ([Continuous attention to technical excellence](http://agilemanifesto.org/principles.html)).

## The beginning

While freelancing, every year, my clients told me I needed to charge more. So every year, I doubled my hourly rate.

In 2010, The Great Recession finally hit my clients, and I successfully achieved my mission statement: To become obsolete to my clients. I found myself [homeless](/books/#homeless-not-hopeless-unpublished), living in my car. All my possessions fit in the trunk this time. (Lesson learned.)

In 2011 I found myself on a team at my first contracting gig. I was formally introduced to Agile Software Development, Scrum, and the signatories. Before that, I knew nothing of the profession and industry, well, any industry, really.

They said, "We do Scrum here."

I had no idea what that was and asked. It was described familiarly but didn't match my lived experience. So I ran home and started searching and found The Manifesto for Agile Software Development.

I agreed with all the values and principles from The Manifesto because I lived (and learned) through it. I discovered [eXtreme Programming](https://www.amazon.com/Extreme-Programming-Explained-Embrace-Change/dp/0321278658) and learned it had iterations like Scrum, along with some technical practices facilitating the iterative approach. I also learned that most signatories were still working, writing, and speaking. Further, I found out that The Manifesto was published in 2001. Finally, I learned that beyond The Manifesto, there isn't much the signatories agree on; diversity of thought may not be "ideal."

I was skeptical because of what I saw on my team, and [I'm not much of a joiner](https://youtu.be/yc8qbcIMZVg?t=21) to begin with. I wanted to see if the reality matched (or could match) the marketing of Agile Software Development.

Was this my tribe? I eventually took some training classes.

In 2012 I was a front-end web developer for a small marketing company and was (mostly) the sole developer for the [US Popclock](https://www.census.gov/popclock/), done in the spirit of "agile." The experience caused me to pack a lot of baggage and decide I'd never do development for a company again; however, I would be a coach.

In 2015 I was brought in as a UX expert on a team operating in a government organization "doing SAFe" after using Kanban in my technical editor role. Around that same time, I finished a 5-day boot camp, two days of meeting facilitation, and three days of professional coaching. I was also helping my mother handle the foreclosure of her house (not part of the plan because life is messy—[Responding to change over following a plan](http://agilemanifesto.org)). When I returned from the boot camp, I asked my teammates if I could be the coach for the team. They agreed. We facilitated an intentional culture session and gained momentum and influence within the program.

In late 2018 I was laid off (life is messy).

In early 2019, my mother passed away (life is messy).

Within 30 days of my mother's passing, I was brought into a Fortune 500 company and given 18 months to "do something" with a team. We started small by changing how "the daily" operated and asking the team how they wanted me to work. Then, 12 months later, they were doing well, and I shifted to conditioning mode. I was also asked to help another team, at least for the last 6 months I was there. (COVID happened, and I moved cross-country right before the 15 days to slow the spread ended with 6 months left on the contract; life is messy.)

The following program I joined didn't go well, and I bailed after 6 weeks. The next program I was on had potential, but we didn't mesh.

As a point of self-improvement (retrospective), I explored updating my résumé. As a result, I landed a new gig at the same time as the previous program, and I agreed to split ways.

I've been impressed so far.

Is it "ideal"? It depends on what immutable qualities are required to be "ideal."

In my day-to-day, I'm surrounded by coaches, directly and indirectly. Nowhere is "ideal" in someone's eyes. In the "real" world, life is messy.

With that said, most of the coaches I know directly aren't the signatories of The Manifesto. Most of them haven't written books. They're not giving talks. They aren't rockstars. They are "normal" (not ideal) people doing what they can to improve the value delivery to users and the journey along the way.

<aside>

**Principle:** Work doesn't have to feel like work.

</aside>

"Agile" is all around you. I took a team out to breakfast once on my dime to demonstrate prioritization and weighted shortest job first through a line cook at the office cafeteria. When COVID hit, our requirements and plans all got blown up.

Returning to the opening, can it work in the real world? I say yes. That said, it also depends on the following:

> What do you consider to be [the real world](http://www.jimpryor.net/teaching/courses/epist2001/matrix.html#:~:text=Morpheus%3A%20What%20is%20%22real%22,end%20of%20the%2020th%20century.) and how do you know it's real?
