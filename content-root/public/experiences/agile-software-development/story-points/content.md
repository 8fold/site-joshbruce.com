# Story Points

{!! dateblock !!}

In the Agile Software Development space, there is a divisive tool and practice: The story point.

Let's get the bottom line up front out of the way:

1. There is no single, universal, and optimal way to get stuff done.
2. The points aren't the point.
3. If the story points leave the team, or some metrics and dashboards leave the team derived directly from story points, bad things usually happen (more than a 90 percent chance).
4. [Ron Jeffries](https://ronjeffries.com/articles/019-01ff/story-points/Index.html), an original signatory of [The Manifesto for Agile Software Development](http://agilemanifesto.org), has said a lot on the subject.
5. [Martin Fowler](https://martinfowler.com/bliki/StoryPoint.html), an original signatory of The Manifesto, has also described them while pointing out an alternative.
6. [Jeff Sutherland](https://www.scruminc.com/story-points-why-are-they-better-than/), an original signatory of The Manifesto and co-creator of the [Scrum framework](https://scrumguides.org), has written about them and more recently discussed using alternatives with teams in his consulting practice.
7. Story points don't need to be constrained to [Fibonacci sequencing](https://en.wikipedia.org/wiki/Fibonacci_sequence).
8. Order things from the most to the least perceived value, accounting for [finish-to-start relationships](https://en.wikipedia.org/wiki/Dependency_(project_management)#Standard_types_of_dependencies).

All right, five assertions and three name drops, with links, should be good enough for a summary and list of resources.

What we're describing here are possibilities.

One of my core practices is not to get hung up on history.

Focusing on history is often used to justify current behavior, explain how our actions don't match the original intent, or blame someone or something for a current situation. That leads to debate and gatekeeping behavior (see every major religion worldwide). Who and how the vase became broken is less important than the current reality that the vase is broken.

We'll accept that story points exist as a term, tool, and social construct. Further, as a tool, they are typically used to facilitate communication, understanding, and consensus. Finally, as a social construct, they have only the meaning and purpose you (or your team) give them.

Story points are an abstraction. Humans, generally speaking, do better with concretes, not abstractions.

If I were to ask you to define the abstract concept of freedom, you would probably respond with concrete examples. (And, later, the Government might sentence me to [drink hemlock](https://en.wikipedia.org/wiki/Trial_of_Socrates).)

We couldn't talk about story points without talking about estimates.

Regarding most knowledge work, the answer with the most integrity, courage, and transparency is, "I don't know."

(Even if you've done similar things in the past, and it's not as "simple" as breaking a complicated unknown into smaller, known items and adding them together; [work breakdown structures](https://en.wikipedia.org/wiki/Work_breakdown_structure).)

Unfortunately, "I don't know" usually doesn't fly, and folks have a hard time "decomposing" things into deployable parts, "I need all of it!" So, the next best thing I appreciate is the best case, worst case, and most likely case; anchor and spread:

> It will most likely be done by X plus or minus Y.

X and Y can change as we start the work or have conversations.

This is also helpful in a salary negotiation because we stop talking about the mundane (the salary) and start talking about the important part (the total compensation and context).

<aside>

**Principle:** Impermanence is at the heart of agility. If you don't believe things can change or think things are prohibitively difficult to change...let's say it's a dark place.

</aside>

How can story points be used?

The following are neither mutually exclusive nor inclusive. Many times we stack these approaches and practices. (I'll be explicit when putting on my judgy pants, which are less about judgment and more about interpretation, experience, and frustration.)

The concept of story points applies to any context in which you are trying to get something done or help others get something done (see Pomodoros in [The Pomodoro Technique](https://francescocirillo.com/products/the-pomodoro-technique)).

The hard truth is that agile isn't a noun. It's an adjective. If you can't easily pivot without causing pain, you are not operating with agility or within an agile system. The principle from The Manifesto for Agile Software that comes to mind is "Accepting changing requirements even late in development," and the value that comes to mind is "Responding to change over following a plan."

If your system is easy to change, that's not a problem. If your system is rigid, for whatever reason, that's a problem. (That's probably a post for another time.)

## Story points as a proxy for time

Let's start with the most common use I've seen in practice. It's the one many of us learned through [the oral tradition](https://youtu.be/fzqEHwXVpKQ) of how to "do agile."

<details>
<summary>What problems does this approach seek to solve?</summary>

This is a non-exhaustive list, and I have not seen empirical research or evidence that it works for all people in all contexts.

1. The belief that humans are bad at estimating time.
2. It's faster to estimate in points than it is to estimate in time. (Mainly because we're not trying to be exact.)
3. Improved capacity planning.

</details>

<details>
<summary>Judgy pants</summary>

The points aren't the point. The understanding and consensus about what we're about to do are.

1. Humans are decent at estimating time (or anything else) when details about the outcome are known, and we don't try and be precise. This is one reason we believe gathering requirements upfront will improve estimations and predictability. But, unfortunately, we often spend so much time gathering requirements and designing based on those requirements that we reduce the time available to execute whatever we're planning.
2. The points aren't the point, and the desire to speed up estimating means we reduce the time spent on understanding and reaching a consensus around what is being asked for. Further, we increase cognitive load and time to get the estimate for this use case because we're juggling numbers; it'll take `X` hours. I multiply `X` by `Y` to arrive at `Z` story points. Further, I must round `Z` up to the nearest Fibonacci number if we use the Fibonacci Sequence. Finally, users and sponsors don't care about points, so to answer the question of "when will it be done," we need to reverse engineer the points back to time. I've seen teams create spreadsheet tools to make it faster to convert. This adds complexity and maintenance for an optional need we've imposed on ourselves; eliminate the conversion.
3. Capacity planning presumes the same state of the people and time doing the thing (group or individual). I don't know about you, but I'm not an assembly line robot, and I get tired sometimes, go on vacation, or do other things. So, we're constantly adjusting capacity based on present reality. Further, no matter how many times we invoke [Brooks's Law](https://en.wikipedia.org/wiki/Brooks%27s_law), we believe adding people adds capacity to software development projects; software isn't an assembly line of standardized parts.
4. Humans are great at procrastination or inflating the complexity of a solution to a given problem. See [Rube Goldberg Machines](https://en.wikipedia.org/wiki/Rube_Goldberg_machine). This tendency leads to creating bloated and byzantine operating environments wherein changing something as simple as a lightbulb becomes an all-day affair with multiple communications across multiple people and departments. For example, only maintenance personnel can change the lightbulb. They must adhere to the policies and laws related to work in general ([OSHA](https://en.wikipedia.org/wiki/Occupational_Safety_and_Health_Act_(United_States)) in the United States). That means carrying the ladders properly, wearing the correct safety gear, and so on.

> Do the most important thing until it ships or is no longer the most important thing.
>
> <cite>Kent Beck</cite>

And, because movie references are kind of my thing:

> Stop trying to hit, and hit me.
>
> <cite>Morpheus, *The Matrix*

If the story points are a proxy for time, use time. Then you don't have to train people, document what the term means, and so on. In other words, you transparency by increasing the amoutn of work not done; the definition of simple from The Manifesto.

</details>

<details>
<summary>How it typically works.</summary>

We have a list of stuff we want to get done someday, maybe.

An optimization is that the list is ordered from top-to-bottom from the greatest to the least perceived value; this reduces scanning the list to find the most important thing. If we take something from the top, it's always the most important thing. Further, if the thing on the top of the list depends on something else being finished first, it inherits the perceived value of the successor. For example, Item A has a perceived value of 5. Item B has a perceived value of 2. Item B must be completed before Item A can be started, finished, or both. Item B has a perceived value of 7 and goes to the top of the list.

We look at the most important thing, Item B. First, the individual or group who are [accountable](https://medium.com/@kentbeck_7670/accountability-in-software-development-375d42932813), responsible, or both for getting the thing done have a conversation (the part that matters) to reach mutual understanding and consensus on how long it will take, in time.

They apply a multiplier to convert the time into the story point equivalent. If using Fibonacci sequenced numbers, they'll typically round the number up to the nearest Fibonacci number.

The multiplier adds padding for the unknown, ever-changing reality in which we find ourselves; meetings, vacations, firefighting, sickness, and so on.

</details>

## Story points as non-time (confidence)

This is how I learned story points through the oral tradition. I learned in 2011 based on someone's experience from around 2005. We used Fibonacci Sequencing. The rationale for using Fibonacci Sequencing was because the less confidant we are, the more likely we are to be wrong, and the Fibonacci Sequence builds that in by increasing the gaps between numbers the higher you go.

When we view story points as a social construct and tool used to facilitate the individuals and interactions (conversation and information) in a team, we can do all sorts of things.

<details>
<summary>What problems does this approach seek to solve?</summary>

- Give a numeric value to a single abstract concept (confidence in this case).
- Operate as a shorthand for communicating understanding to stakeholders and interested parties.
- When using story points to measure confidence, we don't need a strict definition of ready; we can use the points to communicate an individual or collective understanding.
- Reduce context switching and cognitive load; time is time, and a story point is a proxy for another abstract concept.

</details>

<details>
<summary>Judgy pants</summary>

Shorthand is excellent for expediting communication. You may sacrifice quality for that shorthand. The sacrifice in quality reclaims the speed benefit received from expediting communication. (Consider this as the leverage debt metaphor when someone mentions [technical debt](https://youtu.be/Jp5japiHAs4), only this is communication debt.)

A short, lighthearted example is when I first heard someone use the term "obvy" as shorthand for "obviously." I paused the conversation and asked what the term meant—the term "obvy" wasn't.

I was a Federal Government contractor for 10 years. Lots of acronyms to expedite communication. Acronyms are an abstraction; humans don't do well with abstracts—abstracts differ from similes, metaphors, and analogies. The FBI is shorthand for The United States Federal Bureau of Investigation.

I went to work for the private sector as a Scrum Master. I asked the team who our customer was. They said, "The FBI."

I was blown away. I was like, "We're making stuff for the FBI‽"

They nodded. They were confused by my shock and enthusiasm.

I said, "I thought this was an internal product. I didn't know we did work for The Government."

The penny dropped for the team's manager, who said, "No. Not that FBI. FBI stands for (I literally can't remember, it started with 'Finance')."

It took him less than 2 seconds to say the acronym. It took him less than 2 seconds to say the full name. It took 30 seconds to explain what "FBI" stood for. (And my autocorrect helper keeps wanting to use "The" in front of it because there is only one FBI, apparently.)

In the remaining time I was there, I didn't mentally unpack the acronym to the organization's name. Instead, I translated it to "the customer."

To tie a bow on this:

1. Stop trying to hit me, and hit me. If the numbers represent confidence, call them that. (Even if it means modifying the tools you use to track work.)
2. The United States Federal Government passed a law regarding plain language in Federal Government communications; long ago and far away now. There is a plain language [website](https://www.plainlanguage.gov/resources/articles/keep-it-jargon-free/) with all sorts of good stuff for citizens and Government employees. [One page](https://www.plainlanguage.gov/resources/articles/keep-it-jargon-free/) entitled *Keep It Jargon-free* has the following: The English Defence Minister, George Robertson, tried cutting out abbreviations and acronyms at the Ministry of Defence. “I soon realized solving Bosnia would be easier.”
3. And, [something funny](https://youtu.be/wXlvy3sTTBk) from Good Morning Vietnam.

Most problems we experience when operating as a group boil down to communication. We create most tools and solutions to overcome perceived communication and coordination problems. If the tools and solutions make it so humans don't have to talk to one another, we haven't solved the communication problem. We've implemented a workaround.

</details>

<details>
<summary>How it typically works.</summary>

The individual or group will give a time-based target. It could be days, hours, a precise calendar date, or another time-based thing. The story points become a multiplier of sorts.

For example, best case, I think something will take an hour. I do not understand the request and system, so I give it a story point value of 4 (because we're not using the Fibonacci Sequence). So it could take 4 times longer. The ensuing conversation (the important part) might revolve around how to make that number lower. Do I (or the group) need a better understanding of the system? Is there something in the code causing friction? If so, can we remove it? If so, how long and how confident are we in that estimate? And so on.

The understanding and consensus is the point.

(Judgy pants: Scrum has up to an eight-hour time box for Sprint Planning, partly to allow for the conversation to happen in that session; that's why it's called planning, not reporting on the plan—it's a working session. People just getting to know one another will take longer to communicate effectively, and having time available for real conversations is more important than strictly adhering to a deadline we're in control of. We'll get 100 of the greatest minds together to solve world hunger in 30 minutes.)

</details>

## Story points as non-time (complexity and risk)

Sponsors (or you for personal management) tend to want to know, based on time, roughly when something will be done and the probability of negative impact. (I'll avoid injecting the Risk Management practice post here.)

The highest impact risk usually comes in the form of known unknowns. Next to that is the complexity of the situation or solution.

(When I cook an egg for myself, it's low complexity and low risk because I do it, and few things are involved—pan, fire, and egg. The complexity and risk increase when I visit a restaurant because more individuals and interactions are involved. If I order food for delivery, the complexity increases again compared to going to the restaurant, mainly because I inherit the restaurant complexity and risk and add the complexity and risk related to the delivery service. The more complexity and time we add, the more probability there is for failure. That's why it's so amazing when a Rube Goldberg machine actually finishes, it's not the outcome of the task, it's that it finished at all. It's so hard to get these things to work that we're usually skeptical if one is recorded with or without a cut—there has to be a trick edit somewhere.)

<details>
<summary>What problems does this approach seek to solve?</summary>

- Similar to the confidence variation, time is time and story points are something else (complexity and risk in this case).

The analogy I like to use is folding an origami crane. The complexity of the crane does not change; there are the same number and style of folds regardless of who's folding it. However, I've folded origami cranes hundreds of times; it will probably take me less time than someone who has never folded one or someone with a disability (like arthritis).

</details>

<details>
<summary>How it typically works.</summary>

We (the group or individual responsible, accountable, or both for getting the stuff done) determine a scale. In this case, complexity and risk will be on a two-dimensional scale. Each intersection is given a corresponding story point value (a [reduce or fold function](https://en.wikipedia.org/wiki/Fold_%28higher-order_function%29) if you're into functional programming).

The following table uses complexity and risk along with a Fibonacci Sequence.

<table style="width: 100%;">
	<tbody>
		<tr>
			<th rowspan="3">Complexity</th>
			<td>High</td>
			<td>3</td>
			<td>5</td>
			<td>8</td>
		</tr>
		<tr>
			<td>Medium</td>
			<td>2</td>
			<td>3</td>
			<td>5</td>
		</tr>
		<tr>
			<td>Low</td>
			<td>1</td>
			<td>2</td>
			<td>3</td>
		</tr>
		<tr>
			<th colspan="2">Risk</th>
			<td>Low</td>
			<td>Medium</td>
			<td>High</td>
		</tr>
	</tbody>
</table>

Now we can focus on the conversation rather than the points and define criteria for each aspect.

The following are just examples, not mandates.

What criteria describe low complexity or risk?

Our team can do it all by their lonesome, from start-to-finish soup-to-nuts, not just the development piece but the roll-out, marketing, and success tracking.

What about medium complexity?

Our team may depend on two other teams to get their part done before we can do it, and we decide that's a medium complexity. Or is our codebase just that rigid?

How do we reduce those dependencies? Or, how do we introduce flexibility into the codebase?

The points aren't the point.

What does it take for us to think the risk is low? Medium? High? What can we do to get whatever we're looking at moved toward the lower side of the scale? Maybe "proper" story slicing will do it?

Kent Beck, an original signatory of The Manifesto for Agile Software Development and credited with capturing, if not inventing, [Extreme Programming](https://en.wikipedia.org/wiki/Extreme_programming), once said:

> Make the change easy—this may be hard—then make the easy change.

</details>

<details>
<summary>Judgy pants</summary>

Seriously, please stop trying to hit me and hit me.

Engineers tend to be a pretty literal bunch. Further, humans generally do better with concrete things rather than abstractions. Change is hard enough. We don't need to tack on learning a new language. Finally, [Conway's law](https://en.wikipedia.org/wiki/Conway%27s_law) will win the day.

If you don't know what Conway's Law says, try this.

I can describe the code if you show me the people and how they communicate. Further, if you show me the code, I can probably describe the people and operating models.

Indirect communication styles tend to lead to software with indirect and circuitous routes of getting to the desired outcomes; Rube Goldberg machines. I see this a lot in organizations where folks would rather "nice each other to death" than be perceived as rude due to being direct in their communication. (Or organizations with little psychological safety.)

Another thing we see, thanks to marketing and branding, is creating new labels for already-named things. Or, misapplying common labels to a custom implementation, "We do Scrum, we just don't have a Product Backlog, don't use Sprints, and refuse to do retrospectives."

Don't get me wrong, naming things is hard, and you may not know a concept has a label, but it's easier to modify your word when you find out than it is to get the world to accept your new word.

I [accidentally created Scrum and Agile Software Development](https://joshbruce.com/experiences/agile-software-development/in-an-ideal-world/). I was working on a name for the way I was working. A year or so later, I was introduced to Scrum and Agile Software Development, one less thing I needed to create and maintain. (At the same time, I was introduced to Extreme Programming, The Pomodoro Technique, Getting Things Done, The Project Management Body of Knowledge, and many other representations of similar concepts. Now it's just how I work, no labels.)

If our users (or sponsors) think in terms of time, talk in terms of time. If our users (or sponsors) want to discuss risk, talk about risk. Complexity? Talk about complexity.

Don't burden them with learning a new label, definition, or abstract concept that's a proxy for another abstract concept, like risk and complexity (unless they ask for it). And be patient because we all have linguistic baggage that must be unpacked for "common" words like "risk." Much less the debate around whether something called a "feature" could be estimated in "story points" because it's not a "user story" in our work tracking system.

> Don't get caught up in the thickness of thin things.
>
> <cite>Stephen R. Covey</cite>

</details>

## Story points as a relative size in a batch

The first three were mainly about a story point representing something. These last two are more about different ways of making the mundane part (the math) easier to move on to the important part (the understanding and consensus).

Because this is more about the conversation that could take many paths, the "How it's typically done?" section might be a bit rough.

<details>
<summary>What problem does this approach seek to solve?</summary>

- Simplify the mundane part (the math) to get to the important part (understanding and consensus).

</details>

<details>
<summary>How it's typically done?</summary>

There's usually a large batch of things (Product Backlog or to-do list). We are moving some things from the large batch to create a smaller one (Sprint Backlog or today list). There's usually a time constraint to deliver things moved into the smaller batch. The large batch is sorted from the thing with the most perceived value to the thing with the least perceived value.

Let's say we have the following in our "large" batch:

1. Item A.
2. Item B.
3. Item C.

Does Item A depend on something else being done first?

Yes.

Okay, on what?

Item B. We change our list:

1. Item B.
2. Item A.
3. Item C.

Item B moves to the top of the list. Does Item B depend on something else being done first?

No.

Great, bring Item B into the smaller batch and give it a story point of 1.

- Large batch:
	1. Item A.
	2. Item C.
- Small batch:
	1. Item B—1 story point.

Could we finish or start something else in the allotted time?

("No" is a perfectly valid response, nothing wrong with a batch size of 1.)

We say, "Yes."

Item A is now back at the top. Does Item A depend on something other than Item B to be done first?

No.

Great. Is Item A larger or smaller than Item B?

Larger.

How much larger?

**The mundane part:** Someone says 3 times larger, and someone else says 6 times larger. (See [Planning Poker](https://en.wikipedia.org/wiki/Planning_poker).)

Okay, why the discrepancy?

**The important part:** The person who said 3 knows something about the system the other person doesn't know, and they explain that it exists. The person who said 6 also knows something about the system that makes it more difficult, and they explain that it exists. And so it continues until everyone agrees that Item A is 4 times larger than Item B. So we mark Item A as being 4 story points (back to the mundane part).

- Large batch:
	1. Item C.
- Small batch:
	1. Item B—1 story point.
	2. Item A—4 story points.

Can we finish or start something else in the time allotted?

Yes.

Item C is now at the top of the larger batch. Does Item C depend on something else being done first?

No.

Great. Is Item C larger or smaller than Item A (the biggest thing we have so far)?

Smaller.

Is Item C larger or smaller than Item B?

Smaller.

- Large batch: Empty
- Small batch:
	1. Item C—1 story point.
	2. Item B—`x` story point.
	3. Item A—`4 * x` story points.

Great. Mark Item C as 1 story point. How much larger is Item B compared to Item C (the mundane part)?

**The important part:** We discuss and agree that Item B is 5 times larger than Item C.

**The mundane part:** We mark Item A as 20 story points because we already agreed it's 4 times larger *relative* to Item B.

- Large batch: Empty
- Small batch:
	1. Item C—1 story point.
	2. Item B—5 story points.
	3. Item A—20 story points.

Can we finish or start something else in the time allotted?

No.

Can I make Item A smaller?

Yes. We can delay certain functionality until later.

Great. Let's extract those pieces into a new item—Item D.

- Large batch:
	1. Item D
- Small batch:
	1. Item C—1 story point.
	2. Item B—5 story points.
	3. Item A—`x` story points.

Is Item A still larger than Item B?

Yes.

How much larger?

We talked and agreed Item A is now twice the size of Item B. Therefore, we mark Item B with 8 story points. (Item D is now at the top of the list.)

- Large batch:
	1. Item D
- Small batch:
	1. Item C—1 story point.
	2. Item B—5 story points.
	3. Item A—10 story points.

Can we start or finish something else in the time allotted?

Yes.

Is Item D larger or smaller than Item A?

Smaller.

Is Item D larger or smaller than Item B?

Smaller.

Is Item D larger or smaller than Item C?

Smaller.

Great. Mark Item D as 1.

- Large batch: Empty
- Small batch:
	1. Item D—1 story point.
	1. Item C—`x` story point.
	2. Item B—`x * 5` story points.
	3. Item A—`x * 5 * 2` story points.

How much larger is Item C relative to Item D?

We agree it's twice as large and mark Item C with 2 story points.

- Large batch: Empty
- Small batch:
	1. Item D—1 story point.
	1. Item C—2 story points.
	2. Item B—10 story points.
	3. Item A—50 story points.

Go forth and do the things!

</details>

<details>
<summary>Judgy pants</summary>

50 story points‽ You shouldn't have anything that large! Break it down further, split it across multiple time boxes, something! Anything! It's the end of the world! You don't know how to Agile. (Not a strawman, people have put on their judgy pants and said these things.)

There are a lot of assumptions built into this type of response.

If I have something that can be done in 1 minute, something 50 times larger can be done in 50 minutes.

(Stop trying to hit me, and hit me. The points aren't the point. And humans are better with concretes than abstracts.)

The point is understanding and consensus. Through the conversations, we teach each other about the implementation and context and simultaneously learn more about the user needs driving the prioritization. (No "offline" knowledge transfer sessions are necessary. No "give them the easy stuff until they get up to speed.")

If you don't enjoy hanging out and conversing with your teammates, explore and unpack that. If you don't care about the implementation or user needs, unpack that, "Why don't I like these people enough to spend time with them? Why don't I care about what we're building and why?"

Anything can feel like busy work that doesn't deliver value. However, things like story points, estimating in general, and meetings are tools, and they only provide value through how the participants use them. Further, they cannot be improved if the participants only say, "This thing has no value for me; therefore, it shouldn't exist."

Once we revealed Item B as the most important, why didn't we stop there and change the time allotted to match how long we thought it would take to get It done?

Then we ask, what knowledge we need to get Item B done? Who has that knowledge? Who else would like to have that knowledge?

Great! We have a team. Go, do the thing!

They do the thing until it's done, run out of time, or it's no longer the most important thing.

([Turtles all the way down](https://en.wikipedia.org/wiki/Turtles_all_the_way_down).)

No story points are necessary. Just a hypothesis, "We think we can get this done in `x` period." Run the experiment with the drive to get Item B done with a certain degree of quality as soon as possible. While running the experiment, capture work that can be delayed until later and any shortcuts performed. Reevaluate after the time is up.

Is Item B still the most important thing?

Yes.

Are these still the people with all knowledge to get it done?

No. We discovered this work here and need someone who knows about this thing. Cool. New team!

What's the new hypothesis for when it'll be done?

Going down this line of questioning has spawned a few unpacking conversations with leaders. They can be summed up as "We can't operate this way. People are lazy (or perfectionists or procrastinators or will milk it for all it's worth), and it'll never get done."

Unpacking that baggage is always an exciting ride that includes questions like:

- Why are you in a relationship with people you don't believe have your best interests at heart and in mind?
- Is it that you don't trust them? Or that you don't trust your ability to pick humans to be in a relationship with?
- What evidence do you have to feel this way?
- Are you blaming them for your ex?

Direct communication can sometimes feel rude.

</details>

<aside>

**Principle:** We often conflate efficiency and speed.

"We want this meeting to be more efficient" translates to "We want this meeting to be shorter." We don't consider the cost of making all the meetings shorter or ask why we don't like conversing with the people in the room. (Spend all day with a loved one, no problem—spend more than 30 minutes with a teammate, problem.)

</aside>

## Story points as an input into velocity

This one is the most common reason for story points. Story points exist to create velocity and burndown graphs.

This approach is built into every "agile" work tracking tool I've ever used. But, unfortunately, it's also the easiest to game, even if the gaming is unconscious.

For velocity to exist, we need a consistent time box and a constant representation of 1 story point across multiple time boxes.

(A mile is a mile—story point. Driving `X` miles per hour is always `X` miles per hour—the hour is the time box. Imagine a world in which the measure of a mile changed every hour or so. Or where the measure of an hour changed regularly.)

<details>
<summary>What problem does this approach seek to solve?</summary>

- How much work can the team bring into a time box (capacity)?
- How long will delivering the estimated work take (forecasting)?
- The time box specifically seeks to solve the problem of [Parkinson's Law](https://en.wikipedia.org/wiki/Parkinson%27s_law) and acts as a foundational risk management plan; we reduce risk by working in smaller batches completed more often.

</details>

<details>
<summary>How it's <s>typically</s> done (well?).</summary>

(Judgy pants: It's *typically* done poorly.)

The team (or individual) establishes what 1 story point represents; I recommend it represent the start-to-finish "Hello, World!" in your operating context.

Posed as a question, "What will it take in your context for a user to ask to see 'Hello, World!' on a screen and then see it on their screen?" This becomes the representation of 1 story point. Every other request is sized relative to that.

(Judgy pants: If the 1-pointer takes longer than 1 day when translated to time, that's probably a sign that there are other things you could focus on than getting better at estimating, sequencing, and completing work.)

The "Hello, World!" recommendation has a bias toward separating time from story points. *Typically*, teams will stick to a story point representing 1 "ideal" day but typically won't include quality assurance, meetings, or other load multipliers. (Judgy pants: Regardless, if it's impossible to have a 1-point item because of the context you find yourself in, that's a sign.)

The team (or individual) establishes what time box they will use for an indefinite period. 2 weeks is typical for groups, and 1 day is typical for individuals.

The team (or individual) will typically use some form of batch reduction exercise (see previous section for one example). Everything is sized and brought into the smaller batch. (We're going to presume this is the first time.)

The team (or individual) tries to complete what they can within the allotted time.

At the end of the allotted time, we look at what got done and add all the story points of the done things together. That gives us our velocity for those two weeks. The velocity for those two weeks gives us our capacity for the next two weeks.

At the beginning of the two weeks, we don't bring in more points than we did in the previous two-week period (or an average of, say, the last five two-week periods). We can bring something else in if we finish all the work and still have time.

If you want to see what else typically happens, read the "judgy pants" section because this is where the "well" part ends.

</details>

<details>
<summary>Judgy pants</summary>

"Consistent" and "constant" are red flags here regarding agility. Agility embraces the reality that, well, reality is inconsistent and non-constant.

You might ask, "What happens if something is started but not finished?"

That's a question for the ages, is always a point of contention, and depends on the environment (context).

If your environment believes story points aren't the point, whatever doesn't get completed, typically gets put back into the larger batch and prioritized. The progress to date is usually saved somewhere. And it will either be resized when brought back into another time box or left with the same story point count despite work being started and saved for the future.

If your environment leads folks to consider points as part of the merit credit system (or worse, are explicit parts of vendor contracts), teams will typically split the item in two based on points. This warrants explaining.

Let's say we have Item A at 10 story points. It was brought into a time box but not completed. The team agrees that 8 story points worth of work was completed. So, they change the story points for Item A from 10 to 8, create Item B (a copy of Item A), and mark Item B as 2 story points. Item A is moved to complete, so the team gets "credit" for the work (according to velocity and burndown), not the value delivered to users.

If your environment wants to increase velocity, have the team apply story points to everything in the larger batch and never change them based on the current context (a context that hopefully is continuously improving). Hopefully, as the system becomes easier to change and the team's knowledge increases, the complexity of future work decreases; however, the initial story points will remain the same. Over time, the team will appear to get more work done when the complexity of the work decreases. From a psychological perspective, this can be motivating if you don't peel back too many onion layers.

If your environment wants to keep velocity constant, always recalculate story points based on current understanding.

I've never seen an environment that wanted to decrease velocity. However, a decreasing velocity could mean we're getting much better at our processes or focusing on hitting a "done" or "stable" state; users aren't asking for features or reporting bugs. (I had an app on iOS that hadn't been changed in years, no one was asking for new features or reporting bugs, and people were still buying it.)

</details>

## Conclusion

If you're consistently delivering value, no matter how "small," and you're having the conversations that facilitate delivering that value—then story points aren't necessary.

If you're not consistently delivering value, you're not having the conversations, or both—then story points might help.

They can help give you breathing space. To pause from the hustle culture, grind, grind, grind to explore the work and ask questions. Some of these questions may terrify you. Some of these questions may excite you.

Scale up and down as needed. Knowing what to add and take away is much more important than just adding practices and processes all the time to reach "feature parity" with other folks operating in similar ways using similar language.

