# Registering a domain

{!! dateblock !!}

It surprised me when I learned I could register a domain name and not have a publicly accessible (hosted) website. Further, I could have hosting without having a domain name.

Put another way. I could go to Media Temple, register my domain name, and not do anything with it. I could sign up for hosting at Dreamhost and upload files and directories. In this example, Media Temple would be the registrar, and Dreamhost would be the host. But, until I had the domain name point to the [Dreamhost "nameservers"](https://help.dreamhost.com/hc/en-us/articles/216385467-Nameservers-overview), I wouldn't have a publicly accessible website.

For convenience, many web hosts offer domain registration services. Therefore, many of us will register domain names through the same provider we have hosting with.

In this context, think of your files like a cellular phone, your host is your cellular service provider, and your phone number is the domain name.

When I first got a cellphone, I purchased it through Office Depot. The service was with Verizon. And Verizon registered that phone number for me. When I switched to AT&T a few years later, I bought a new phone, got a new service provider, and *kept* the same phone number. When I switched back to Verizon, I kept my phone, changed providers, and *kept* my phone number. Now that I'm back with AT&T, I'm using a phone purchased through Apple, AT&T is my service provider, and I *still* have the same phone number.

In short, you can have the same domain name for years, despite changing everything else related to it.

Unlike phone numbers, at minimum, domain names need to be reregistered every year. When you purchase a domain name, you mainly purchase the top-level domain (TLD), the part after the dot (`.com`, `.net`, `.biz`, and so on). That's because, just like phone numbers, if the full domain name (`joshbruce.com`) is already in use, you can't buy it anyway.

`.com` is by far the most common and popular in the United States, which means the chances are good that someone else already owns that easy-to-remember name you want for your site. `joshbruce.com` was owned by someone else for almost a decade before it became available (the other person stopped renewing), and I bought it. I've always been the owner of `joshuabruce.com`.

That said, people are starting to get accustomed to non-dot-com domain names. Further, you can start getting clever with things. For example, my small business is an association of business professionals and owns `8fold.pro`—short, sweet, and to the point. Much better than EightfoldCoachingAssociates.com or, heaven forbid, bogging it down with hyphens because the unhyphenated `.com` was taken.

There are three numbers to look for when considering a top-level domain:

1. registration cost,
2. renewal cost, and
3. transfer cost.

Registration is how much the first year will cost you; for the most part, around 20 USD. Sometimes there are sales on registering, but it's like an introductory interest rate on a credit card. That's where the renewal cost comes into play.

The renewal cost is how much the second year, and every year after that, it will cost you to continue to own the domain at the given TLD.

The transfer cost is how much it will cost to transfer a domain's registration from one registrar to another.

The renewal cost is the one to pay the most attention to. Nothing sucks more in this context than buying a TLD for 3 USD only to have it jump up to 100 USD the second year.

With that said, as time marches on, the prices tend to increase. When I first purchased `joshuabruce.com`, it was around 5 USD. When I purchased `joshbruce.com`, it was around 10 USD. I renewed once at 14 USD. And now it's about 18 USD.

I highly recommend jumping on the multi-year registration if you have kept a domain for over two years. There's usually a discount when buying multiple years at a time. You're locking in that price, and chances are the price will be higher in the future.

Also, try not to be a squatter. There's a [malicious form](https://en.wikipedia.org/wiki/Cybersquatting) and a benign form. Both are annoying. If you haven't put a site on the domain within 5 years of owning it, sell the domain or let the registration lapse. Let someone else do something with it.

All right, that's the end of the [.Public Service Announcement](PSA).

## What you should look for in a registrar

1. [Private registration](https://www.dreamhost.com/domains/private-registration/).
2. [Comparable pricing](https://www.dreamhost.com/domains/); scroll down to "See all domain prices."
3. To repeat what was mentioned in the [previous article](/essays-and-editorials/webdev/absolute-beginners/hosting-externally/), the ability to point the domain to any public directory in your neck of the server.

When you register a domain, they associate a name, address, and phone number (the WHOIS data). Because the domain name is yours, it's your information (or your company's, if you have one). There's a public database (WHOIS) where you can see when a domain registration will expire (how I got `joshbruce.com`) and potentially contact information for who owns it. If you want to sell domains on the secondary market, leave your contact information public. Otherwise, keep it private. Some random human emails you because they found your name associated with a domain registration, not cool.

Generally speaking, domain names are commodities priced similarly from one registrar to another (think candy at convenience stores, rarely does one charge 5 USD and another charge 200 USD for the same thing). Instead, I'd use this as a flag-check for the host; if the host charges double what someone else charges to register a `.com`, that makes no sense. Even if I use them as my host, I wouldn't use them to register the domain.

You have a host. Chances are you can register a domain name at the host. Let's talk about that first.

## Registering with your host

Sign in to the admin panel. You should see domain registrations somewhere. Go there. You should be able to check that a domain is available, and if so, register it. Once registered, it might take some time, but you should see the domain name listed in the registered domains section of the admin panel (see [Dreamhost's documentation](https://help.dreamhost.com/hc/en-us/articles/215767937-Domain-registration-overview)). Don't forget to enable [WHOIS privacy](https://help.dreamhost.com/hc/en-us/articles/216458407).

There should be a way to edit web hosting related to the domain name. Let's go there.

Here there should be a way to [change the web directory](https://help.dreamhost.com/hc/en-us/articles/360041534491-Changing-the-web-directory-assigned-to-a-domain) for the domain. We want to point the domain to the `/my-site` directory we uploaded in the [previous article](/essays-and-editorials/webdev/absolute-beginners/hosting-externally/). It should look something like this:

<pre class="shiki" style="background-color: #22272e"><code><span class="line"><span style="color: #ADBAC7">/home/username/my-site</span></span>
<span class="line"></span></code></pre>

Anything you don't want accessible to the public, don't put it in that directory.

It might take a few minutes (definitely less than a day), but eventually, you can put your domain name into the browser and see your home page.

Next, we'll discuss picking [the parts you like](/essays-and-editorials/webdev/absolute-beginners/what-you-like/) and avoiding the parts you don't. If you want (or need) to register with someone other than your host, keep going.

## Registering with someone else

This can be a bit more involved than we can cover here. With that said, here's the [Dreamhost documentation](https://help.dreamhost.com/hc/en-us/articles/214694378-What-DreamHost-DNS-records-do-I-point-my-site-to-) and summary of what we're trying to do. (Even if you don't use Dreamhost, the documentation applies.)

1. You need to go to the registrar of your domain name.
2. There should be a way to change the domain name system (DNS) record somewhere.
3. When you get there, you should be able to add the "nameservers" for your host to the DNS record of your registrar.

Next, we'll discuss picking [the parts you like](/essays-and-editorials/webdev/absolute-beginners/what-you-like/) and avoiding the parts you don't.
