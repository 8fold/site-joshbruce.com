# Hosting (externally)

{!! dateblock !!}

Believe it or not, you don't need a domain name. More correctly, you don't need a human-friendly domain name like `joshbruce.com`.

There is:

- a human-friendly identifier,
- a service-friendly identifier, and
- a device-specific identifier.

Consider calling someone using a digital assistant. 

When I do this, here's what I say: Hey, Siri, call Lynn. 

"Lynn" is the human-friendly identifier. Siri takes that and brings up the service-friendly identifier, the phone number: XXX-XXX-XXXX. Siri then "dials" (sends a request) to a telephone service provider. Somewhere, the phone number is associated with a device-specific identifier (for a cellphone, it would be the SIM card identifier). The request makes it to Lynn's phone, and it starts ringing. 

If they answer, an "Okay" response is sent back through the whole chain to my phone, and Lynn and I are connected. If Lynn doesn't answer, eventually, a "Request timed out" response will be sent back, or a voicemail service will answer for Lynn and send back an "Okay" response. 

The process flow is this:

1. An initial request is created.
2. A request is received.
3. A process happens.
4. A response is sent to the initial requestor.

What we call a domain name is typically a human-friendly identifier. This is associated with a service-friendly identifier (your external web host). And using both of those, we can determine a device-specific identifier to find the specific device (or devices) your files are stored on.

Atomic concepts stacked on top of one another to do amazing things.

Let's start with the host.

## Web hosting providers

I'll get the rough bit out of the way immediately.

I recommend avoiding Network Solutions and GoDaddy.

Both have a history of doing some interesting things or not being as secure and transparent as possible. For example, a while back, if you just wanted to see if a domain name was available but not register it yet, and you used Network Solutions to check, they'd register the domain for you, which meant you couldn't register it with anyone else ([2008 article](https://www.eweek.com/security/is-network-solutions-snatching-domain-names/)). And hackers infiltrated GoDaddy and managed to stay there for multiple years ([2023 article](https://www.wired.com/story/godaddy-hacked-3-years/)). On top of that, I've never had a good experience with their support, customer service, or software.

I used Network Solutions around 2000 but grew frustrated and switched to Dreamhost around 2003. Switching was difficult mainly due to my lack of knowledge and Network Solutions' lack of customer service. I'm still using [Dreamhost](https://www.dreamhost.com). (That's not an affiliate link. And, if you go with Dreamhost and tell them I sent you, I get a discount.)

If you'd rather use someone other than Dreamhost, here's a short list for you:

1. [Media Temple](https://mediatemple.net), according to [CSS Zen Garden](http://www.csszengarden.com), it's still where that site is hosted and was gaining popularity as I was considering my switch in the early 2000s.
2. [Bluehost](https://www.bluehost.com) has been around for a while as well.

I can't vouch for either of these alternatives.

Here's a list of resources for articles and comparisons of various hosts:

1. [10 best Dreamhost alternatives](https://www.websiterating.com/web-hosting/best-dreamhost-alternatives/).
2. [Top 7 Media Template alternatives in 2023](https://www.affiliatebay.net/media-temple-alternatives/).
3. [7 best Bluehost alternatives](https://www.websiterating.com/web-hosting/best-bluehost-alternatives/).

I can't vouch for the content of these articles, and I don't think either of us wants to get bogged down in the minutia and personal opinions. So, let's talk about what to look for at the top:

1. You should be able to change hosting service providers anytime without question or pain.
2. You should be able to change hosting plans at the same service provider without question or pain.
3. You should be able to upload files to the host somehow.
4. You should be able to set (or change) the *public* root directory your domain points to.

That's it.

Just like you should be able to change your cellular phone company, cable provider, streaming services, internet service provider, and so on—you should be able to take your files, upload them somewhere else, and point your human-friendly domain name to the new place.

All right, with that out of the way, you'll most likely be presented with one or all of the following options:

1. shared hosting,
2. a virtual private server, and
3. a dedicated server.

These are listed from what is typically the cheapest to the most expensive.

**Shared hosting** is like a movie theatre with multiple screens. Everyone has the same access to the same number of screens, the same amount of concessions, all of that. Of course, if Person A decides to start a fire, we all have to leave.

In more technical terms, with shared hosting, if Person A has a site on the same shared device as your site, and their site crashes the server, your site is also unavailable to users until the server restarts.

That said, shared hosting is mostly used by people who aren't making money from the Internet, don't see a lot of traffic, and are limited to one site per account (Person A, for example, has a site about their cat, and less than a thousand people a second want to look at it).

We've also been doing shared hosting for decades and have optimized them pretty well. For example, if Person A caused the site to crash enough times, they might get a yellow card, so to speak, or be moved to a different server or denied continued service by the provider. And, even if Person A does take the server down, chances are it'll be for a few seconds, not days or weeks.

Shared hosting is a great place to start, and I never had issues. I'd still be using shared hosting if I didn't have multiple sites and wanted to use something not allowed on shared hosting plans by Dreamhost. Chances are you don't want or need either of those right now.

**A virtual private server** (or VPS) is like renting a screen within the movie theater. I choose who can be at that screen. We still share some things with other people at the theater, but that one screen is ours. If Person A starts a fire somewhere, that doesn't bother us. Chances are it'll only take down that screen, not the whole theater. However, if we start a fire, it's all on us.

Virtual private servers take the resources available on the same computer and allocate a specific amount to each account hosted on that computer. For the most part, website requests take very few resources unless you're doing something *really* fancy or popular. (And you might be surprised at what point you're doing something *really* fancy and popular. The Internet caters to the most constrained, so there are many ways to create crazy things without a boatload of hardware resources being necessary. For example, most requests to this site are processed in less than half a second.)

As of this writing, I use a virtual private server plan at my host.

**A dedicated server** is what it sounds like; you're renting the whole multi-theater building. Someone else still owns the building. Someone else decides how many screens, movies, and concessions are available. Someone else is responsible for hiring and firing people who work there. But you have free reign based on the rental agreement you signed.

From the technical side, the sites you operate are the only sites on the machine. You can choose how to divvy things up.

Given the focus of this series, shared hosting will do just fine. It'll cost around 5 USD per month, and you'll most likely get a discount if you purchase multiple months at a time. You can always switch providers or plans at the provider later if you start feeling too constrained.

## Uploading files (file manager)

There are two primary ways to get your files onto your host.

We'll presume you've signed up for hosting somewhere; it could be anywhere. When you sign into the host's website, you'll see what is sometimes called the admin panel. You should see FTP (for File Transfer Protocol) somewhere; if you don't, you might see something like "File manager."

If you click on that, it should take you to a different screen listing all the files and directories for your section of the host (your seat at the screen). This will be tied to your user and won't be able to get to anyone else's files and directories (other people's seats); if you can get to other people's stuff, you should choose a different host.

Your host will most likely have documentation on the subject (this is [Dreamhost's documentation](https://help.dreamhost.com/hc/en-us/articles/360003490852-Using-the-website-file-manager-in-the-panel), for example); if they don't, it's probably a flag that you should consider a different host.

Even if you never register a domain and never have a publicly accessible website, you can store files here, in "the cloud."

Somewhere on the page should be a place where you can upload files and directories from your local machine.

Go ahead and upload the `/my-site` directory.

If you're not interested in an alternative, skip to [what's in a name](/essays-and-editorials/webdev/absolute-beginners/registering-a-domain/).

## Uploading files (FTP client)

A little more involved, and if you don't mind using the host's file manager solution, skip right over this.

Technically this is probably more aptly named a user agent, but client and user agent have become synonymous. It's a software application you install on your computer that can connect to your host. With an FTP client, you don't need to sign in to the admin panel, navigate to their file manager, get to the right place, and upload files; you launch the FTP client and go.

It's a shortcut. The Internet is full of them.

I've used [Panic Transmit](https://panic.com/transmit/) for years on macOS. There are [plenty of FTP clients available](https://www.lifewire.com/ftp-client-software-for-windows-818114); one missing from that list is [Cyberduck](https://cyberduck.io), which I recommend. Again, the host should have documentation on this (and [here's Dreamhost's](https://help.dreamhost.com/hc/en-us/articles/115000675027-FTP-overview-and-credentials)).

You'll need the following:

1. the hostname (may or may not be your domain name),
2. your FTP username, and
3. your FTP password.

Click connect, and you should see something familiar; a list of files and directories on your host.

You can drag and drop the `/my-site` directory onto the host. You can drag files from the host onto your computer. In some cases, you can open a file directly from the host, edit it, and hit save and it will be automatically saved (synced) on the host. (Potential drawback or risk here is you won't have a local copy. Or, if you break something before testing it locally, your site will be down.)

Almost there. Next, we'll explore [what's in a name](/essays-and-editorials/webdev/absolute-beginners/registering-a-domain/).



