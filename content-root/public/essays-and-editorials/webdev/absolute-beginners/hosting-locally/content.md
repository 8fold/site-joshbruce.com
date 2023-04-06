# Hosting (locally)

{!! dateblock !!}

We're going to get technical for a second. That's not the right word. We're going to get a bit semantic for a second.

Web host, web server, and registrar.

A registrar can register a human-friendly domain name with the folks who govern that sort of thing; technically, you could do it yourself, but there are so many low-cost service providers we tend to pay those folks to do it (around 20 [.United States Dollars](USD) per year). The governing organization has a name, and much like that person you dated in high school, it's not important until it is (like at reunions). We'll discuss that later; the registrar part, not the high school reunion part.

A web server, for our purposes, is a software application running on a computer. The software allows the computer to accept requests from software on another computer and respond to those requests using web-based protocols. The computer is referred to as the "client," the software making the requests is the "user agent," and the computer accepting the requests and *serving* the responses is the "server." If you use iCloud, your Apple device is the client, your application is the user agent, and iCloud (generically speaking) is the server. Dropbox. Google Drive. Office 365. And so on, they're all servers.

A web host, again, for our purposes, is a service company who runs web servers that you can effectively rent.

Here's the confusing part.

The same computer can be the client *and* the web server. This setup type is often called a "local host." The local computer is hosting (holding on to) the files and directories *and* processing requests from and sending responses to an application running on the same device.

All right, let's get practical.

Up to this point, the URL in your browser looked something like this:

<pre class="shiki" style="background-color: #22272e"><code><span class="line"><span style="color: #ADBAC7">file:///Users/{your user}/Desktop/my-site/index.html</span></span>
<span class="line"></span></code></pre>

The `file` is the protocol. The `://` separates the protocol from the path. By creating a "local host," we can host your website on your computer and have it *be* a website. So, we can make the address bar look like this:

<pre class="shiki" style="background-color: #22272e"><code><span class="line"><span style="color: #ADBAC7">http://localhost:8888/</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">http://localhost:8888/about/</span></span>
<span class="line"></span></code></pre>

HTTP stands for hypertext transfer protocol, and it's the main web-based protocol used by websites.

In the spirit of this series, we're looking for free and minimal technical knowledge required to make this happen.

Enter [MAMP](https://www.mamp.info/en/mamp/mac/).

When it comes to locally hosted websites, MAMP has my highest recommendation.

It's user-friendly. If you don't get a lot of joy out of messing around with the inner workings of computers, you won't have to. If you enjoy messing around with the inner workings of computers, you'll most likely be disappointed. You don't need to be a server administrator to make it work. It's flexible. It's available for macOS and Windows. Did I mention the free version is good enough for now?

(There are alternatives, but I won't cover them here.)

1. [Download the free version](https://www.mamp.info/en/mamp/).
2. Install it.
3. Launch it.
4. Click preferences.
5. Click Server.
6. Change the root directory to the `/my-site` folder.
7. Click OK.
8. Click Start (upper right on macOS or start servers on Windows).

Your browser should automatically open to a MAMP promotional page (`http://localhost:8888/MAMP/?language=English`). Remove everything after the `8888` and hit enter.

You should see your home page.

I don't want to be mistaken. The hard part comes if you decide to make this a publicly accessible server and host. You have security threats to contend with. Configurations. All sorts of things. When you expose your hard drive to the Internet, you have all sorts of stuff that could happen. What we're doing here is relatively benign in comparison. Please, don't be one of those people who think companies shouldn't charge for a service (or at least charge less) because "I can do it for free myself." We pay to delegate responsibility to someone more interested in a thing than we are.

With that disclaimer out of the way. Let's change our HTML to take advantage of this "local test environment."

First, we can remove the explicit `index.html` in our links and references:

<pre class="shiki focus" style="background-color: #22272e"><code><span class="line focus"><span style="color: #768390">&lt;!-- Home ---&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">&lt;!</span><span style="color: #8DDB8C">doctype</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">html</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">&lt;</span><span style="color: #8DDB8C">html</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">lang</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;en-US&quot;</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">head</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">title</span><span style="color: #ADBAC7">&gt;My site&lt;/</span><span style="color: #8DDB8C">title</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">link</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">rel</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;stylesheet&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">type</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;text/css&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">href</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;./css/main.css&quot;</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;/</span><span style="color: #8DDB8C">head</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">body</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">      &lt;</span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line focus"><span style="color: #ADBAC7">        &lt;</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">class</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;current&quot;</span><span style="color: #ADBAC7">&gt;&lt;</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">href</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;./&quot;</span><span style="color: #ADBAC7">&gt;Home&lt;/</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7">&gt;&lt;/</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line focus"><span style="color: #ADBAC7">        &lt;</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;&lt;</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">href</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;./about/&quot;</span><span style="color: #ADBAC7">&gt;About&lt;/</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7">&gt;&lt;/</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">      &lt;/</span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;/</span><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7">&gt;  </span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line focus"><span style="color: #768390">&lt;!-- About --&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">&lt;!</span><span style="color: #8DDB8C">doctype</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">html</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">&lt;</span><span style="color: #8DDB8C">html</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">lang</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;en-US&quot;</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">head</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">title</span><span style="color: #ADBAC7">&gt;About | My site&lt;/</span><span style="color: #8DDB8C">title</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">link</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">rel</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;stylesheet&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">type</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;text/css&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">href</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;../css/main.css&quot;</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;/</span><span style="color: #8DDB8C">head</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">body</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">      &lt;</span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line focus"><span style="color: #ADBAC7">        &lt;</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;&lt;</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">href</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;../&quot;</span><span style="color: #ADBAC7">&gt;Home&lt;/</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7">&gt;&lt;/</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line focus"><span style="color: #ADBAC7">        &lt;</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">class</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;current&quot;</span><span style="color: #ADBAC7">&gt;&lt;</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">href</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;./&quot;</span><span style="color: #ADBAC7">&gt;About&lt;/</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7">&gt;&lt;/</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">      &lt;/</span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;/</span><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span></code></pre>

If you refresh your browser, the site should still work.

We can remove the `index.html` part because the default settings of the server software (usually [Apache](https://www.apache.org)) looks for a file called `index` when a user requests a directory-based URL.

We can also remove the relative links and references—the dots (with the caveat of adding any directory names when necessary):

<pre class="shiki focus" style="background-color: #22272e"><code><span class="line focus"><span style="color: #768390">&lt;!-- Home ---&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">&lt;!</span><span style="color: #8DDB8C">doctype</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">html</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">&lt;</span><span style="color: #8DDB8C">html</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">lang</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;en-US&quot;</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">head</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">title</span><span style="color: #ADBAC7">&gt;My site&lt;/</span><span style="color: #8DDB8C">title</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line focus"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">link</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">rel</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;stylesheet&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">type</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;text/css&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">href</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;/css/main.css&quot;</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;/</span><span style="color: #8DDB8C">head</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">body</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">      &lt;</span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line focus"><span style="color: #ADBAC7">        &lt;</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">class</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;current&quot;</span><span style="color: #ADBAC7">&gt;&lt;</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">href</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;/&quot;</span><span style="color: #ADBAC7">&gt;Home&lt;/</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7">&gt;&lt;/</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line focus"><span style="color: #ADBAC7">        &lt;</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;&lt;</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">href</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;/about/&quot;</span><span style="color: #ADBAC7">&gt;About&lt;/</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7">&gt;&lt;/</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">      &lt;/</span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;/</span><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7">&gt;  </span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line focus"><span style="color: #768390">&lt;!-- About --&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">&lt;!</span><span style="color: #8DDB8C">doctype</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">html</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">&lt;</span><span style="color: #8DDB8C">html</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">lang</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;en-US&quot;</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">head</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">title</span><span style="color: #ADBAC7">&gt;About | My site&lt;/</span><span style="color: #8DDB8C">title</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line focus"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">link</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">rel</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;stylesheet&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">type</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;text/css&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">href</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;/css/main.css&quot;</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;/</span><span style="color: #8DDB8C">head</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">body</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">      &lt;</span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line focus"><span style="color: #ADBAC7">        &lt;</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;&lt;</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">href</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;/&quot;</span><span style="color: #ADBAC7">&gt;Home&lt;/</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7">&gt;&lt;/</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line focus"><span style="color: #ADBAC7">        &lt;</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">class</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;current&quot;</span><span style="color: #ADBAC7">&gt;&lt;</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">href</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;/about/&quot;</span><span style="color: #ADBAC7">&gt;About&lt;/</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7">&gt;&lt;/</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">      &lt;/</span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;/</span><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span></code></pre>

We can do this because the server software changes the root directory to `/my-site` instead of your computer's literal root file directory (it wraps your file system).

This local environment is the closest to what it will feel like when (or if) you decide to go with an external web host. (More on that later.)

Also, because the URLs we're using aren't fully qualified (we don't have the protocol and domain), we can upload the files to the external web host, and the site should work just fine.

The drawback is that the site will work without sending people back to your domain if someone takes the content and puts it under a different domain. (We might get to this at some point.) If that's a concern you have, you can make the paths into fully qualified URLs:

<pre class="shiki focus" style="background-color: #22272e"><code><span class="line focus"><span style="color: #768390">&lt;!-- Home ---&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">&lt;!</span><span style="color: #8DDB8C">doctype</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">html</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">&lt;</span><span style="color: #8DDB8C">html</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">lang</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;en-US&quot;</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">head</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">title</span><span style="color: #ADBAC7">&gt;My site&lt;/</span><span style="color: #8DDB8C">title</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line focus"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">link</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">rel</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;stylesheet&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">type</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;text/css&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">href</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;http://localhost:8888/css/main.css&quot;</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;/</span><span style="color: #8DDB8C">head</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">body</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">      &lt;</span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line focus"><span style="color: #ADBAC7">        &lt;</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">class</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;current&quot;</span><span style="color: #ADBAC7">&gt;&lt;</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">href</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;http://localhost:888/&quot;</span><span style="color: #ADBAC7">&gt;Home&lt;/</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7">&gt;&lt;/</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line focus"><span style="color: #ADBAC7">        &lt;</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;&lt;</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">href</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;http://localhost:8888/about/&quot;</span><span style="color: #ADBAC7">&gt;About&lt;/</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7">&gt;&lt;/</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">      &lt;/</span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;/</span><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7">&gt;  </span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line focus"><span style="color: #768390">&lt;!-- About --&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">&lt;!</span><span style="color: #8DDB8C">doctype</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">html</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">&lt;</span><span style="color: #8DDB8C">html</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">lang</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;en-US&quot;</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">head</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">title</span><span style="color: #ADBAC7">&gt;About | My site&lt;/</span><span style="color: #8DDB8C">title</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line focus"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">link</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">rel</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;stylesheet&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">type</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;text/css&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">href</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;http://localhost:8888/css/main.css&quot;</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;/</span><span style="color: #8DDB8C">head</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">body</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">      &lt;</span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line focus"><span style="color: #ADBAC7">        &lt;</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;&lt;</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">href</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;http://localhost:8888/&quot;</span><span style="color: #ADBAC7">&gt;Home&lt;/</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7">&gt;&lt;/</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line focus"><span style="color: #ADBAC7">        &lt;</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">class</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;current&quot;</span><span style="color: #ADBAC7">&gt;&lt;</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">href</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;http://localhost:888/about/&quot;</span><span style="color: #ADBAC7">&gt;About&lt;/</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7">&gt;&lt;/</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">      &lt;/</span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;/</span><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span></code></pre>

The problem that arises because of this solution is that when you upload these files to the external web host, you'll most likely need to change all the `http://localhost:8888` to something else.

Beyond that, stop MAMP when you're done playing with your local host for the day.

Welcome to the Internet! (Kind of.)

Let's discuss [registering a domain and external hosting](/essays-and-editorials/webdev/absolute-beginners/hosting-externally/).
