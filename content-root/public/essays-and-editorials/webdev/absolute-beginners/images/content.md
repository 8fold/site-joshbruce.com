# Images

{!! dateblock !!}

It may not feel like it, but you have almost everything you need to get started. As such, we're mainly expanding and reinforcing your knowledge from reading the [introduction to this series](/essays-and-editorials/webdev/absolute-beginners/).

We left off having created an `index.html` file with the following content:

<pre class="shiki" style="background-color: #22272e"><code><span class="line"><span style="color: #ADBAC7">&lt;!</span><span style="color: #8DDB8C">doctype</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">html</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">&lt;</span><span style="color: #8DDB8C">html</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">lang</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;en-US&quot;</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">head</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">title</span><span style="color: #ADBAC7">&gt;My site&lt;/</span><span style="color: #8DDB8C">title</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;/</span><span style="color: #8DDB8C">head</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">body</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">p</span><span style="color: #ADBAC7">&gt;Hello, World!&lt;/</span><span style="color: #8DDB8C">p</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">p</span><span style="color: #ADBAC7">&gt;How are you?&lt;/</span><span style="color: #8DDB8C">p</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;/</span><span style="color: #8DDB8C">body</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">&lt;/</span><span style="color: #8DDB8C">html</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"></span></code></pre>

We wanted to add an image.

1. Pick an image on your computer.
2. Put a copy of the image in the `/my-site` directory.

The `/my-site` directory structure should look something like this now:

<pre class="shiki" style="background-color: #22272e"><code><span class="line"><span style="color: #F69D50">/my-site</span></span>
<span class="line"><span style="color: #F69D50">├─</span><span style="color: #ADBAC7"> </span><span style="color: #96D0FF">image.png</span></span>
<span class="line"><span style="color: #F69D50">└─</span><span style="color: #ADBAC7"> </span><span style="color: #96D0FF">index.html</span></span>
<span class="line"></span></code></pre>

We need to be able to reference the image from inside the `index.html` page. We'll need an element. This time we'll use a self-closing element, a technical way of saying, "It doesn't have a closing tag," unlike the paragraph element.

The image element uses the `img` tag and two attributes. The first attribute is the source (`src`), and the second is an alternative description (`alt`). The `src` tells the browser where the image is. The `alt` describes the image. It will often be displayed if the image doesn’t load for reason, might also be displayed if you hover over the image, and (most importantly, will be read by screen readers).

Let's add the following somewhere inside the `body` element in the `index.html` file:

<pre class="shiki" style="background-color: #22272e"><code><span class="line"><span style="color: #ADBAC7">&lt;</span><span style="color: #8DDB8C">img</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">src</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;image.png&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">alt</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;A screenshot of my file explorer.&quot;</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"></span></code></pre>

You can put these attributes in any order. The content of each can be whatever is necessary for your context. If your image isn't named `image.png`, use whatever the file name is. If your image isn't a screenshot of your file explorer, describe the image. The general rules of thumb for `alt` attributes are:

1. describe the image itself,
2. call out important details, and
3. if there's text in the image, include it in the `alt` attribute or reference it within the body copy (or both).

Once you've added the above to the `index.html` file, refresh your browser.

It's possible the image is huge compared to your browser window, like laughably large. (Every solution comes with at least one new problem.) Let's use the `width` and `height` attributes to fix that; play around with the numbers (try percents even), and don't worry if the image gets distorted:

<pre class="shiki" style="background-color: #22272e"><code><span class="line"><span style="color: #ADBAC7">&lt;</span><span style="color: #8DDB8C">img</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">src</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;image.png&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">alt</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;A screenshot of my file explorer.&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">width</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;200&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">height</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;200&quot;</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"></span></code></pre>

Again, the order of these attributes can be whatever you want them to be. The values can be whatever you want them to be.

Another principle:

> It's difficult to break the Internet. It's easy to not get what you want or expect from the Internet.

To automatically maintain the image's aspect ratio, try setting one of the attributes to "auto" and adjusting the other:

<pre class="shiki" style="background-color: #22272e"><code><span class="line"><span style="color: #ADBAC7">&lt;</span><span style="color: #8DDB8C">img</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">src</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;image.png&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">alt</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;A screenshot of my file explorer.&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">width</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;200&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">height</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;auto&quot;</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"></span></code></pre>

Adding a caption (or giving credit) for the image might be nice. First, let's add some text after the image (would like to demonstrate something).

<pre class="shiki focus" style="background-color: #22272e"><code><span class="line"><span style="color: #ADBAC7">&lt;</span><span style="color: #8DDB8C">img</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">src</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;image.png&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">alt</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;A screenshot of my file explorer.&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">width</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;200&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">height</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;auto&quot;</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"></span>
<span class="line focus"><span style="color: #ADBAC7">Image by Josh Bruce around 2023</span></span>
<span class="line"></span></code></pre>

Go ahead and refresh the browser.

Chances are you'll notice that the text is on the same line and butted up against the image. That's because [.Hypertext Markup Language](HTML) elements fall into two categories related to how they are displayed on the page by default:

1. inline and
2. block.

Inline elements are like the words you're reading now. Each word can be seen as an element. And each word continues from the previous word on the same line.

Block elements, by default, are like paragraphs. They will take the entire screen width and not let other elements be to their left or right.

Plain text, `img`, and similar content are all inline elements of a page. Paragraphs (`p`), headings (`h*`), and similar content are all block elements.

What's our intent? How can we best communicate that intent to the browser?

We want to display an image with a caption. The image and caption are directly related; they are a unit. So, we probably want to wrap both of them in something.

What is the most semantically appropriate element to accomplish this?

The `figure` element should suffice:

<pre class="shiki focus" style="background-color: #22272e"><code><span class="line focus"><span style="color: #ADBAC7">&lt;</span><span style="color: #8DDB8C">figure</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">img</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">src</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;image.png&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">alt</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;A screenshot of my file explorer.&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">width</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;200&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">height</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;auto&quot;</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">  Image by Josh Bruce around 2023</span></span>
<span class="line focus"><span style="color: #ADBAC7">&lt;/</span><span style="color: #8DDB8C">figure</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"></span></code></pre>

`figure` is a block-level element, so if you add some free-floating text after the closing tag, it will appear on the next line of the page. `img` is still an inline element, so, we still have the problem of our caption appearing right next to the image. Luckily, the `figure` element can accept child elements.

What is the most semantically appropriate element to communicate the intent behind this piece of content to the browser?

The `figcaption` element:

<pre class="shiki focus" style="background-color: #22272e"><code><span class="line"><span style="color: #ADBAC7">&lt;</span><span style="color: #8DDB8C">figure</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">img</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">src</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;image.png&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">alt</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;A screenshot of my file explorer.&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">width</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;200&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">height</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;auto&quot;</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"></span>
<span class="line focus"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">figcaption</span><span style="color: #ADBAC7">&gt;Image by Josh Bruce around 2023&lt;/</span><span style="color: #8DDB8C">figcaption</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">&lt;/</span><span style="color: #8DDB8C">figure</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"></span></code></pre>

`figcaption` is a block level, which will cause it to appear on a new line under the image. What happens if you put `figcaption` above the `img` tag?

First, nothing breaks. Second, the caption text appears above the image.

You may have noticed I kept saying "semantically" back there. That's because it's easy to get things to display how we want them on the Internet with very few elements. There is a generic block-level element (called `div`) and a generic inline element (called `span`). If we wanted to accomplish a similar default layout, we could have done the following:

<pre class="shiki focus" style="background-color: #22272e"><code><span class="line focus"><span style="color: #ADBAC7">&lt;</span><span style="color: #8DDB8C">div</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">img</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">src</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;image.png&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">alt</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;A screenshot of my file explorer.&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">width</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;200&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">height</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;auto&quot;</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"></span>
<span class="line focus"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">div</span><span style="color: #ADBAC7">&gt;Image by Josh Bruce around 2023&lt;/</span><span style="color: #8DDB8C">div</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line focus"><span style="color: #ADBAC7">&lt;/</span><span style="color: #8DDB8C">div</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"></span></code></pre>

However, this hides intent and burdens us to define what we mean when we use a `div` in this context, usually by adding more code; it’s poor communication. The [living HTML5 standard from the w3c](https://html.spec.whatwg.org) explicitly says of the [`div`](https://html.spec.whatwg.org/#the-div-element) element:

> Authors are strongly encouraged to view the div element as an element of last resort, for when no other element is suitable. Use of more appropriate elements instead of the div element leads to better accessibility for readers and easier maintainability for authors.

The same should also apply to the `span` element.

Markup is for software, and the content is for humans. By using the `figure` and `figcaption` elements, various software applications can interpret our intent and create ways of expressing that intent:

<pre class="shiki" style="background-color: #22272e"><code><span class="line"><span style="color: #ADBAC7">&lt;</span><span style="color: #8DDB8C">figure</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">img</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">src</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;image.png&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">alt</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;A screenshot of my file explorer.&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">width</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;200&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">height</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;auto&quot;</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">figcaption</span><span style="color: #ADBAC7">&gt;Image by Josh Bruce around 2023&lt;/</span><span style="color: #8DDB8C">figcaption</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">&lt;/</span><span style="color: #8DDB8C">figure</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"></span></code></pre>

A search engine may grab all the `figure` elements on a page and display them in a search results grid. A screen reader might allow users to quickly navigate by "landmark" elements.

Speaking of landmark elements, another online convention is to have at least one level-one heading element (`h1`). Let's go ahead and convert the first paragraph to an `h1` element, and `index.html` should look something like this:

<pre class="shiki focus" style="background-color: #22272e"><code><span class="line"><span style="color: #ADBAC7">&lt;!</span><span style="color: #8DDB8C">doctype</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">html</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">&lt;</span><span style="color: #8DDB8C">html</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">lang</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;en-US&quot;</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">head</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">title</span><span style="color: #ADBAC7">&gt;My site&lt;/</span><span style="color: #8DDB8C">title</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;/</span><span style="color: #8DDB8C">head</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;</span><span style="color: #8DDB8C">body</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line focus"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">h1</span><span style="color: #ADBAC7">&gt;Hello, World!&lt;/</span><span style="color: #8DDB8C">h1</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"></span>
<span class="line"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">p</span><span style="color: #ADBAC7">&gt;How are you?&lt;/</span><span style="color: #8DDB8C">p</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    </span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;</span><span style="color: #8DDB8C">figure</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">      &lt;</span><span style="color: #8DDB8C">figcaption</span><span style="color: #ADBAC7">&gt;Some text&lt;/</span><span style="color: #8DDB8C">figcaption</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">      &lt;</span><span style="color: #8DDB8C">img</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">src</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;image.png&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">alt</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;A screenshot of my file explorer.&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">width</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;300&quot;</span><span style="color: #ADBAC7"> </span><span style="color: #6CB6FF">height</span><span style="color: #ADBAC7">=</span><span style="color: #96D0FF">&quot;auto&quot;</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">    &lt;/</span><span style="color: #8DDB8C">figure</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">  &lt;/</span><span style="color: #8DDB8C">body</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"><span style="color: #ADBAC7">&lt;/</span><span style="color: #8DDB8C">html</span><span style="color: #ADBAC7">&gt;</span></span>
<span class="line"></span></code></pre>

While it's possible (technically and according to the specifications) to have more than one `h1` element, the functionality isn't implemented well in all browsers.

You've probably noticed that the `h1` text became larger and bold. This is the default style being applied by the browser.

We'll get there, but first, we should discuss the next biggest feature that makes the Internet the Inernet, [linking documents](/essays-and-editorials/webdev/absolute-beginners/links/).
