# Interaction and animations

{!! dateblock !!}

Believe it or not, we've already been doing interactions and animations. The Internet is inherently an interactive medium. Those anchor (`a`) elements are interactive; you click (interact) and move. If you resize the browser (interact), the layout and flow of text change.

Even though what we have so far is a "static site," it's still interactive. It may not be flashy and in your face about it, though.

Let's start on the home page with the inline anchor.

When we click on the inline anchor, we skip right to the bottom of the page. Wouldn't it be cool if we scrolled smoothly down to it instead?

We can do that, no problem.

Let's open `main.css`. We'll add a property (`scroll-behavior`) to the `html` selector:

<pre class="shiki focus" style="background-color: #22272e"><code><span class="line"><span style="color: #8DDB8C">*</span><span style="color: #ADBAC7"> {</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">font-family</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">sans-serif</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span>
<span class="line focus"><span style="color: #8DDB8C">html</span><span style="color: #ADBAC7"> {</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">background-color</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">#dddddd</span><span style="color: #ADBAC7">;</span></span>
<span class="line focus"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">scroll-behavior</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">smooth</span><span style="color: #ADBAC7">;</span></span>
<span class="line focus"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span>
<span class="line"><span style="color: #8DDB8C">body</span><span style="color: #ADBAC7"> {</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">margin</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">15</span><span style="color: #F47067">px</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">padding</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">10</span><span style="color: #F47067">px</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">border</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">5</span><span style="color: #F47067">px</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">solid</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">#000000</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">background-color</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">#ffffff</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span>
<span class="line"><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">li</span><span style="color: #6CB6FF">:last-of-type</span><span style="color: #ADBAC7"> {</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">font-weight</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">bold</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span></code></pre>

Refresh the browser. Scroll to the top and click the inline anchor again. Your browser should animate down to the bottom of the page.

If it doesn't, one of two things is most likely happening:

1. Your browser doesn't support the `scroll-behavior` property.
	1. If you go to a website called [Can I use...](https://caniuse.com/css-scroll-behavior), you can type in the style property you're interested in (`scroll-behavior`). Look at the table and see if your browser version supports the property.
2. The `main.css` stylesheet might be cached, so you're looking at an older version.
	1. Holding down shift and clicking refresh on the browser should solve the problem.

Woohoo! Problem solved.

A new problem emerges. Some people don't do well with animations and things flying over the screen. Most operating systems can reduce motion and animations. We want to respect the user's preferences. That's another principle:

> Respect user preferences and default behavior as much as possible.

There's a solution for that as well. We'll use a "media query" to remove the smooth scrolling if the user prefers reduced motion. Add the following to the bottom of `main.css`:

<pre class="shiki" style="background-color: #22272e"><code><span class="line"><span style="color: #F47067">@media</span><span style="color: #ADBAC7"> (prefers-reduced-motion) {</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #8DDB8C">html</span><span style="color: #ADBAC7"> {</span></span>
<span class="line"><span style="color: #ADBAC7">    </span><span style="color: #6CB6FF">scroll-behavior</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">auto</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  }</span></span>
<span class="line"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span></code></pre>

We can trust that things will work as expected. Or, we can test to ensure they are:

1. Enable reduced motion on your device (links to how to do it on [macOS](https://support.apple.com/guide/mac-help/reduce-screen-motion-mchlc03f57a1/mac), [iOS](https://support.apple.com/en-us/HT202655), and [Windows](https://support.microsoft.com/en-us/office/turn-off-office-animations-9ee5c4d2-d144-4fd2-b670-22cef9fa025a))
2. Refresh the browser.
3. Click the inline link.
4. It should jump straight to the bottom again.

Around 2020, "dark mode" became a serious craze. It was a marketable feature for all sorts of websites and applications. It must be difficult if the marketing department says, "We must tell the world!" (Magic!)

Maybe, maybe not. If you left the colors the way they were in [the previous article](/essays-and-editorials/webdev/absolute-beginners/interaction-and-animations/), we'd consider that "light" mode. We'll add another media query to the bottom of `main.css` (we'll do this in stages):

<pre class="shiki" style="background-color: #22272e"><code><span class="line"><span style="color: #F47067">@media</span><span style="color: #ADBAC7"> (prefers-color-scheme: dark) {</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #8DDB8C">body</span><span style="color: #ADBAC7"> {</span></span>
<span class="line"><span style="color: #ADBAC7">    </span><span style="color: #6CB6FF">background-color</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">#000000</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">    </span><span style="color: #6CB6FF">color</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">#ffffff</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  }</span></span>
<span class="line"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span></code></pre>

We need to enable dark mode on your device to test it (links to how to do it on [macOS](https://support.apple.com/en-us/HT208976), [iOS](https://support.apple.com/en-us/HT210332), and [Windows](https://support.microsoft.com/en-us/windows/change-colors-in-windows-d26ef4d6-819a-581c-1581-493cfcc005fe)). (If you already have dark mode turned on, you're there.)

This might cause a problem, though. Dark mode isn't just about making all the background colors black and making the font `color` white. It's designing a decent experience. Our border disappeared, and the gray background now seems much brighter than the foreground color. Let's fix that:

<pre class="shiki focus" style="background-color: #22272e"><code><span class="line focus"><span style="color: #F47067">@media</span><span style="color: #ADBAC7"> (prefers-color-scheme: dark) {</span></span>
<span class="line focus"><span style="color: #ADBAC7">  </span><span style="color: #8DDB8C">html</span><span style="color: #ADBAC7"> {</span></span>
<span class="line focus"><span style="color: #ADBAC7">    </span><span style="color: #6CB6FF">background</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">#777777</span><span style="color: #ADBAC7">;</span></span>
<span class="line focus"><span style="color: #ADBAC7">  }</span></span>
<span class="line"></span>
<span class="line focus"><span style="color: #ADBAC7">  </span><span style="color: #8DDB8C">body</span><span style="color: #ADBAC7"> {</span></span>
<span class="line"><span style="color: #ADBAC7">    </span><span style="color: #6CB6FF">border</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">5</span><span style="color: #F47067">px</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">solid</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">#aaaaaa</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">    </span><span style="color: #6CB6FF">background-color</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">#000000</span><span style="color: #ADBAC7">;</span></span>
<span class="line focus"><span style="color: #ADBAC7">    </span><span style="color: #6CB6FF">color</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">#ffffff</span><span style="color: #ADBAC7">;</span></span>
<span class="line focus"><span style="color: #ADBAC7">  }</span></span>
<span class="line focus"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span></code></pre>

That's better. There's another problem. Contrast and colors. (Having dark mode work is easy. Having to design for it that's where the pain can come in. Maybe that's why, as of this writing, the Apple website doesn't support this functionality.)

The body copy is fine, but the links are the problem. In light mode, they're fine as the default, but there doesn't seem to be enough contrast in dark mode.

My browser's default color for an unvisited link is a high-saturation blue (#0300E4). When I use [a contrast ratio](https://contrast-ratio.com/#%230300E4-on-%23000000) tool and enter black (#000000) as the background color and saturated blue as the text color, the ratio comes back as 2.12. The default color for a visited link in my browser is a high-saturation purple (#4E1D86). When I put that in as the text color, the contrast ratio comes back as 1.84. For accessibility reasons (people being able to see the text compared to the background), we want at least 4.5.

We're going to do a couple of things here:

1. We'll set the colors explicitly for light and dark modes.
2. We will introduce the concept of pseudo-classes, which you're already familiar with, at least in concept.

Let's handle the light mode first. From a construction perspective, anything outside the scope of the media queries will be our default. We use the media queries to handle exceptions to the default. So, let's add the following to `main.css`:

<pre class="shiki" style="background-color: #22272e"><code><span class="line"><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7"> {</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">color</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">#0300E4</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span>
<span class="line"><span style="color: #8DDB8C">a</span><span style="color: #6CB6FF">:visited</span><span style="color: #ADBAC7"> {</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">color</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">#4E1D86</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span></code></pre>

`a` is the selector and will apply to all anchor elements; I used the browser's default color. `a:visited` uses a pseudo-class (similar to `last-of-type` we used before) that says, "Apply this to all anchor elements this user has visited." (Technically, it's about whether or not the target URL is in the browser history.)

Now, let's modify dark mode with colors that are similar but achieve an acceptable contrast with the black background:

<pre class="shiki" style="background-color: #22272e"><code><span class="line"><span style="color: #F47067">@media</span><span style="color: #ADBAC7"> (prefers-color-scheme: dark) {</span></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7"> {</span></span>
<span class="line"><span style="color: #ADBAC7">    </span><span style="color: #6CB6FF">color</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">#716fe7</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  }</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #8DDB8C">a</span><span style="color: #6CB6FF">:visited</span><span style="color: #ADBAC7"> {</span></span>
<span class="line"><span style="color: #ADBAC7">    </span><span style="color: #6CB6FF">color</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">#8e5dc7</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  }</span></span>
<span class="line"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span></code></pre>

Same selectors, different contexts, and different properties.

The contrast problem is solved.

Let's add more interaction to the links while we're here. When you hover over the links, let the underline disappear. We'll use another pseudo-class (`hover`). We only need to do this for the default portion of the CSS:

<pre class="shiki focus" style="background-color: #22272e"><code><span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span>
<span class="line"><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7"> {</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">color</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">#0300E4</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span>
<span class="line focus"><span style="color: #8DDB8C">a</span><span style="color: #6CB6FF">:hover</span><span style="color: #ADBAC7"> {</span></span>
<span class="line focus"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">text-decoration</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">none</span><span style="color: #ADBAC7">;</span></span>
<span class="line focus"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span>
<span class="line"><span style="color: #8DDB8C">a</span><span style="color: #6CB6FF">:visited</span><span style="color: #ADBAC7"> {</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">color</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">#4E1D86</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span></code></pre>

Of course, we could have it change color and other things.

Let's fix something that's bothering me.

For the page a user is on, we use plain text to help orient the user. That's the part we want to be bold, not the last element on each page. "About" is bold on the home page, and "About" is bold on the about page. We want "Home" to be bold on the home page and "About" to be bold on the about page. We'll add a `class` attribute to the list item for the page we are on:

<pre class="shiki" style="background-color: #22272e"><code><span class="line"><span style="color: #768390">&lt;!-- Home --&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">&lt;</span><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">class</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;current&quot;</span><span style="color: #ADBAC7">&gt;Home&lt;/</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;&lt;</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">href</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;./about/index.html&quot;</span><span style="color: #ADBAC7">&gt;About&lt;/</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7">&gt;&lt;/</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;/</span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">&lt;/</span><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">....</span></span>
<span class="line"><span style="color: #768390">&lt;!-- About --&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">&lt;</span><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;&lt;</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">href</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;../index.html&quot;</span><span style="color: #ADBAC7">&gt;Home&lt;/</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7">&gt;&lt;/</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">class</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;current&quot;</span><span style="color: #ADBAC7">&gt;About&lt;/</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;/</span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">&lt;/</span><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span></code></pre>

Then we'll update the `main.css`:

<pre class="shiki" style="background-color: #22272e"><code><span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span>
<span class="line"><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">li</span><span style="color: #6CB6FF">.current</span><span style="color: #ADBAC7"> {</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">font-weight</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">bold</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span></code></pre>

The dot in `li.current` means we're looking for a `class` attribute with a value of `current`. We could remove the `li` if we wanted to. If this were an `id` (like the `last-paragraph` for the inline anchor), we would use a hash (#) instead of a dot.

The same class can be applied to multiple elements in a document. Because we have a pretty specific selector, though, if we add the `current` class to, say, a paragraph the font wouldn't become bold.

Let's keep messing with the navigation for a bit.

Let's make the navigation look more like what we might expect from a website. Usually, the main navigation isn't a bulleted list, for example. We'll keep the list from an HTML perspective but override default styles. We'll remove the bullets, padding, and margin:


<pre class="shiki" style="background-color: #22272e"><code><span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span>
<span class="line"><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7"> {</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">list-style</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">none</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">margin</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">0</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">padding</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">0</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span>
<span class="line"><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7"> {</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">margin</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">0</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">padding</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">0</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span></code></pre>

Now the links should be in the top left corner of the `body` box.

Let's center the links and increase the size of the links:

<pre class="shiki" style="background-color: #22272e"><code><span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span>
<span class="line"><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7"> {</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">display</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">block</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">padding</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">20</span><span style="color: #F47067">px</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">0</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">text-align</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">center</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span></code></pre>

The selector specifically targets anchor elements.

We converted the anchor element from an inline to a block element. This causes the anchor to occupy the full width of the list item (which is already a block element). It also allows us to manipulate its padding, margin, border, and so on, like any other block element. The `padding` shorthand says, "I'd like 20 pixels of padding applied to the top and bottom, and 0 padding left and right." Then we center align the text.

You should notice that you can hover anywhere on the same line as the anchor, and the underline on the link goes away.

The current page text seems a bit odd now. Let's convert it to an anchor:

<pre class="shiki focus" style="background-color: #22272e"><code><span class="line focus"><span style="color: #768390">&lt;!--- Home --&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">&lt;</span><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line focus"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">class</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;current&quot;</span><span style="color: #ADBAC7">&gt;&lt;</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">href</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;./index.html&quot;</span><span style="color: #ADBAC7">&gt;Home&lt;/</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7">&gt;&lt;/</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;&lt;</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">href</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;./about/index.html&quot;</span><span style="color: #ADBAC7">&gt;About&lt;/</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7">&gt;&lt;/</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;/</span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">&lt;/</span><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line focus"><span style="color: #768390">&lt;!--- About --&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">&lt;</span><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line focus"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;&lt;</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">href</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;../index.html&quot;</span><span style="color: #ADBAC7">&gt;Home&lt;/</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7">&gt;&lt;/</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">class</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;current&quot;</span><span style="color: #ADBAC7">&gt;&lt;</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">href</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;./index.html&quot;</span><span style="color: #ADBAC7">&gt;About&lt;/</span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7">&gt;&lt;/</span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;/</span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">&lt;/</span><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span></code></pre>

We still have the hyperlink reference (`href`), but we link to the page we're already on. Let's remove the underline from the link to the current page:

<pre class="shiki" style="background-color: #22272e"><code><span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span>
<span class="line"><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">li</span><span style="color: #6CB6FF">.current</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7"> {</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">text-decoration</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">none</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span></code></pre>

The user can still hit the anchor element. They'll refresh the page.

Why not disable the link?

We can, kind of. And the practice we're following is called [progressive enhancement](https://developer.mozilla.org/en-US/docs/Glossary/Progressive_Enhancement). The steps to "disable" the link may not be available to the user looking at the page. Therefore, having the link work and taking them to the correct page is a good default and will work for everyone regardless of browser.

We could add the following to `main.css`:

<pre class="shiki focus" style="background-color: #22272e"><code><span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span>
<span class="line focus"><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">li</span><span style="color: #6CB6FF">.current</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7"> {</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">text-decoration</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">none</span><span style="color: #ADBAC7">;</span></span>
<span class="line focus"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">pointer-events</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">none</span><span style="color: #ADBAC7">;</span></span>
<span class="line focus"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span></code></pre>

And, for people using pointer devices and browsers that support the `pointer-events` property, the link won't work. It won't even register the hover. With that said, a user could still tab to the anchor, hit return, and the link would work. So, good thing we have that default, lowest common denominator in place.

Let's take advantage of the links being boxes.

I think having a transparent background for the current page is good. However, when the user hovers over another link, let's change the background color:

<pre class="shiki" style="background-color: #22272e"><code><span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span>
<span class="line"><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">a</span><span style="color: #6CB6FF">:hover</span><span style="color: #ADBAC7"> {</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">background-color</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">#000000</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">color</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">#ffffff</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span></code></pre>

Back to the atomic concept thing, this should be somewhat readable: When a user hovers over an anchor (`a`) element that is a child of a list item (`li`) that is the child of an unordered list (`ul`) that is the child of a navigation (`nav`) element, change the background color to black and the font color to white.

We need to handle dark mode because only the font color changes in dark mode. So, let's go with a light gray with black text:

<pre class="shiki" style="background-color: #22272e"><code><span class="line"><span style="color: #F47067">@media</span><span style="color: #ADBAC7"> (prefers-color-scheme: dark) {</span></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">a</span><span style="color: #6CB6FF">:hover</span><span style="color: #ADBAC7"> {</span></span>
<span class="line"><span style="color: #ADBAC7">    </span><span style="color: #6CB6FF">background-color</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">#aaaaaa</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">    </span><span style="color: #6CB6FF">color</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">#000000</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  }</span></span>
<span class="line"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span></code></pre>

There we go.

It's doing the blinking thing, though. It could be nice to have the background color fade in:

<pre class="shiki focus" style="background-color: #22272e"><code><span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span>
<span class="line focus"><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7"> {</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">display</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">block</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">padding</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">20</span><span style="color: #F47067">px</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">0</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">text-align</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">center</span><span style="color: #ADBAC7">;</span></span>
<span class="line focus"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">transition</span><span style="color: #ADBAC7">: background-color </span><span style="color: #6CB6FF">0.3</span><span style="color: #F47067">s</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">ease-out</span><span style="color: #ADBAC7">;</span></span>
<span class="line focus"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span>
<span class="line focus"><span style="color: #F47067">@media</span><span style="color: #ADBAC7"> (prefers-reduced-motion) {</span></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line focus"></span>
<span class="line focus"><span style="color: #ADBAC7">  </span><span style="color: #8DDB8C">nav</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">ul</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">li</span><span style="color: #ADBAC7"> </span><span style="color: #F47067">&gt;</span><span style="color: #ADBAC7"> </span><span style="color: #8DDB8C">a</span><span style="color: #ADBAC7"> {</span></span>
<span class="line focus"><span style="color: #ADBAC7">    </span><span style="color: #6CB6FF">transition</span><span style="color: #ADBAC7">: background-color </span><span style="color: #6CB6FF">0.3</span><span style="color: #F47067">s</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">ease-out</span><span style="color: #ADBAC7">;</span></span>
<span class="line focus"><span style="color: #ADBAC7">  }</span></span>
<span class="line"><span style="color: #ADBAC7">}</span></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span></code></pre>

The transition property can be broken down into separate properties. What we're saying here is we want to apply a transition animation when the background color is changed for elements matching this selector. Further, we'd like the transition duration to be one-third of a second. Finally, we would like to use the ease-out keyframe style (starts fast and ends slower).

All right, enough playing with the navigation for now. (You can keep going, but we should do some other things.)

Let's shift to the desktop view for a second.

This website is very wide. Humans are generally comfortable reading lines of text about 70 characters long. Let's set the maximum width of the `body` to 70 characters:

<pre class="shiki focus" style="background-color: #22272e"><code><span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span>
<span class="line focus"><span style="color: #8DDB8C">body</span><span style="color: #ADBAC7"> {</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">margin</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">15</span><span style="color: #F47067">px</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">padding</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">10</span><span style="color: #F47067">px</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">border</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">5</span><span style="color: #F47067">px</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">solid</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">#000000</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">background-color</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">#ffffff</span><span style="color: #ADBAC7">;</span></span>
<span class="line focus"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">max-width</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">70</span><span style="color: #F47067">ch</span><span style="color: #ADBAC7">;</span></span>
<span class="line focus"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span></code></pre>

A precedent has been set that the site's main content area is centered. Let's do that:

<pre class="shiki focus" style="background-color: #22272e"><code><span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span>
<span class="line focus"><span style="color: #8DDB8C">body</span><span style="color: #ADBAC7"> {</span></span>
<span class="line focus"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">margin</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">15</span><span style="color: #F47067">px</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">auto</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">padding</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">10</span><span style="color: #F47067">px</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">border</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">5</span><span style="color: #F47067">px</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">solid</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">#000000</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">background-color</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">#ffffff</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">max-width</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">70</span><span style="color: #F47067">ch</span><span style="color: #ADBAC7">;</span></span>
<span class="line focus"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span></code></pre>

Yep. Added four characters (`auto`) to center the content. Remember what we mentioned above regarding the shorthand; the first number is for the top and bottom, and the second is for the left and right. `auto` (for left and right) applies the same amount to both sides by default; centered.

We have a problem.

On mobile, we lose the 15-pixel margin on the left and right.

Media query to the rescue!

<pre class="shiki focus" style="background-color: #22272e"><code><span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span>
<span class="line focus"><span style="color: #ADBAC7">&lt;!-- Put this back the way it was. --</span><span style="color: #F47067">&gt;</span></span>
<span class="line focus"><span style="color: #8DDB8C">body</span><span style="color: #ADBAC7"> {</span></span>
<span class="line focus"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">margin</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">15</span><span style="color: #F47067">px</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">padding</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">10</span><span style="color: #F47067">px</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">border</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">5</span><span style="color: #F47067">px</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">solid</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">#000000</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">background-color</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">#ffffff</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">max-width</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">70</span><span style="color: #F47067">ch</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span>
<span class="line focus"><span style="color: #ADBAC7">&lt;!-- Move the centering margin property here. --</span><span style="color: #F47067">&gt;</span></span>
<span class="line focus"><span style="color: #F47067">@media</span><span style="color: #ADBAC7"> (</span><span style="color: #6CB6FF">min-width</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">720</span><span style="color: #F47067">px</span><span style="color: #ADBAC7">) {</span></span>
<span class="line focus"><span style="color: #ADBAC7">  </span><span style="color: #8DDB8C">body</span><span style="color: #ADBAC7"> {</span></span>
<span class="line focus"><span style="color: #ADBAC7">    </span><span style="color: #6CB6FF">margin</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">15</span><span style="color: #F47067">px</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">auto</span><span style="color: #ADBAC7">;</span></span>
<span class="line focus"><span style="color: #ADBAC7">  }</span></span>
<span class="line focus"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span></code></pre>

The media query says, "If the viewport width is greater than 720 pixels, do this." We're making a mobile-first approach, so desktop-specific differences can go here. (It's not the type of device that matters, it's the viewport, but we tend to use device language.)

Lorem ipsum isn't easy to read, but it feels *really* hard to read right now. Let's increase the font size (`font-size`), the space between lines (`line-height`), and the space between paragraphs (`margin`):

<pre class="shiki" style="background-color: #22272e"><code><span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span>
<span class="line"><span style="color: #8DDB8C">p</span><span style="color: #ADBAC7"> {</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">margin</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">2</span><span style="color: #F47067">rem</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">0</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">font-size</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">1.25</span><span style="color: #F47067">rem</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">  </span><span style="color: #6CB6FF">line-height</span><span style="color: #ADBAC7">: </span><span style="color: #6CB6FF">1.75</span><span style="color: #F47067">rem</span><span style="color: #ADBAC7">;</span></span>
<span class="line"><span style="color: #ADBAC7">}</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">...</span></span>
<span class="line"></span></code></pre>

We could keep doing this all day. And we should wrap this up to move on to the next topic.

## If you're still here

If you made it this far, you have a solid foundation of how web design and development works. Seriously. That means we've hit a transition point.

Our focus up to now was to expose the simplicity of web design and development. A bunch of atomic concepts that, when combined, are greater than the sum of their parts. Add a bit of plain text written to communicate intent to a computer. And voila, you have the Internet.

Next, we'll discuss getting to a point where people can see this somewhere other than on your computer. (No money required. Why do so many people think everything on the Internet should be free? In part, because most things required to build things for it are free, except the time and dedication of those who build the things—please, support creators.)

That said, I want to give you more resources on HTML and CSS. We'll return to them in future articles (most likely), but these should help you fish for yourself.

Please, don't try and memorize any of this stuff. There won't be a pop quiz (at least not from me) in an environment where you can't just plug in a search term and find the information. (These are literally the search terms I use whenever I hit something I don't remember off the top of my head, which is most things.)

- Search term: html5 spec
	- [The HTML Living Standard](https://html.spec.whatwg.org)
		- I mainly use this to look up the official specification of HTML elements. It can take a minute to get used to reading, but it's consistent, so once you figure out what information is for one element, you don't need to relearn when looking at the next element. (This isn't my neighbor's cousin's best friend's opinion about HTML, this is HTML.)
- Search term: WCAG checklist
	- [How to Meet WCAG quick reference](https://www.w3.org/WAI/WCAG21/quickref/)
		- Another thing that might seem intimidating at first. WCAG is about accessibility online. When it comes to generally good practices and recommendations, this is a good place to start or at least visit occasionally.
- Search term: Mozilla HTML reference
	- [Mozilla's HTML reference](https://developer.mozilla.org/en-US/docs/Web/HTML)
		- Similar to The HTML Living Standard, but put together by the nonprofit organization responsible for the Firefox browser. It's easier to navigate, and they have many good articles and things.
- Search term: uswds
	- [The U.S. Web Design System](https://designsystem.digital.gov)
		- Technically, it's a tool suite. However, I mainly use it as a reference and guidance. I contributed to the project, and they have a lot of good user experience folks who emphasize accessibility because they have to by law. (Next best thing to being able to hire an expert myself.)
- Search term: uk web design system
	- [Gov.UK Design System](https://design-system.service.gov.uk/components/)
		- When The U.S. Web Design System started, it took many cues from the U.K. Design System.
- Search term: andy bell web design
	- [Piccalilli](https://piccalil.li), [personal site](https://andy-bell.co.uk), and [Set Studio](https://set.studio)
		- Andy is one of the people who took up the torch from previous folks leading the charge for the semantic web, progressive enhancement, and genuinely improving the craft of web design and development (in my opinion, if that changes, I'll change this paragraph).

All right, we made a thing. We have the fundamental knowledge to make more things. Let's talk about what some might call [getting real](/essays-and-editorials/webdev/absolute-beginners/hosting-locally/).
