# Styles

{!! dateblock !!}

In the beginning!

Just kidding. 

Let's work on the about page.

```html
<!-- About /my-site/about/index.html -->
<!doctype html>
<html lang="en-US">
  <head>
    <title>About | My site</title>
  </head>
  <body>
    <nav>
      <ul>
        <li><a href="../index.html">Home</a></li>
        <li>About</li>
      </ul>
    </nav>
    <h1>About me</h1>
    <p>Some interesting things about me.</p>
  </body>
</html>
```

The focus is demonstration and education, so don't worry about style points.

There are three ways to style web pages:

1. inline,
2. internal, and
3. external.

Inline means we're going to define styles using attributes inside the elements. Let's start with the level one header:

```html
<!-- About /my-site/about/index.html -->
...

    <h1 style="font-family:sans-serif;">About me</h1>
    
...
```

Go ahead and refresh the browser. You should see the headline has gone from a serifed font (has feet) to a sans-serifed font (no feet). Inline styles only affect the element they are attached to and their descendants.

The level one heading doesn't have any children, so let's add the same style definition to the navigation element (`nav`):

```html{}{1,8-13}
<!-- About /my-site/about/index.html -->
<!doctype html>
<html lang="en-US">
  <head>
    <title>About | My site</title>
  </head>
  <body>
    <nav style="font-family:sans-serif;">
      <ul>
        <li><a href="../index.html">Home</a></li>
        <li>About</li>
      </ul>
    </nav>
    <h1 style="font-family:sans-serif;">About me</h1>
    <p>Some interesting things about me.</p>
  </body>
</html>
```

When you refresh the browser, you should see that the navigation also went from a serifed font to a sans-serifed font.

The style "cascaded" from the parent down to the children.

Good times.

Now let's look at internal styles. Applying styles piecemeal would be frustrating, to say the least; however, inline styles can be a good way to apply a style to a specific element to override internal and external styles. 

Let's go ahead and make it so we can change the styles in one place and have them apply to everything in the document.

As you might have guessed, there's an element for that. We'll place the `style` element in the `head` of the document:

```html{}{1,6-10}
<!-- About /my-site/about/index.html -->
<!doctype html>
<html lang="en-US">
  <head>
    <title>About | My site</title>
    <style type="text/css">
      * {
        font-family: sans-serif;
      }
    </style>
  </head>
  <body>
    <nav>
      <ul>
        <li><a href="../index.html">Home</a></li>
        <li>About</li>
      </ul>
    </nav>
    <h1>About me</h1>
    <p>Some interesting things about me.</p>
  </body>
</html>
```

The `type` attribute is optional in this context as many browsers will default to using a plain text (`text`) cascading stylesheet (`css`) as the [MIME-type](https://developer.mozilla.org/en-US/docs/Web/HTTP/Basics_of_HTTP/MIME_types).

The asterisk (`*`) is referred to as a "selector" and means, "Apply this to all elements." The curly brackets are new to us but are common in programming languages. It's a syntax often used to define a "scope." Any styling information we place between the curly brackets will be applied to any element matching the selector.

If you refresh your browser, you should see all the text is now in the same sans-serifed font. As such, we can remove all the inline styles.

Just about any element can have a style applied to it. Whether it causes a visible change is a different story. For example, styling the `head` element probably won't visibly change anything because it's a hidden element.

When styling websites, we tend to favor a mobile-first approach. That means designing and styling the website as if it were on a mobile device first, then alter as needed for the desktop and possibly tablet. There are a couple of ways to do mobile-first design (in no particular order):

1. Make the browser narrow, like a mobile device.
2. Use a mobile device.
3. Enter a mobile design mode on the browser.

The first is pretty easy because you change the width of the browser. The second is to have your mobile device able to open files stored on your desktop; then open the files on the device when you save them (iPhone + iCloud, for example). The last is more "robust" because it simulates different mobile devices more accurately. However, it can be a little more difficult to get there, depending on the browser.

With [Safari for macOS](https://developer.apple.com/safari/tools/), you need to have macOS, and you need to enable the "Develop" menu item in Safari's settings. [Firefox](https://www.mozilla.org/en-US/firefox/) has it under browser tools; no changes to settings are required. [Chrome has it](https://developer.chrome.com/docs/devtools/device-mode/). Microsoft's Edge browser has it by way of an add-on. 

You get the idea.

Let's change the background color of the `html` element (the whole screen):

```html{}{1,6,11-14}
<!-- About /my-site/about/index.html -->
<!doctype html>
<html lang="en-US">
  <head>
    <title>About | My site</title>
    <style type="text/css">
      * {
        font-family: sans-serif;
      }
      
      html {
        background-color: #dddddd;
      }
    </style>
  </head>
  <body>
    <nav>
      <ul>
        <li><a href="../index.html">Home</a></li>
        <li>About</li>
      </ul>
    </nav>
    <h1>About me</h1>
    <p>Some interesting things about me.</p>
  </body>
</html>
```

When you refresh the browser, you should see a neutral gray background.

There are lots of ways to apply colors. This is called hexadecimal; I know. It starts with a hash (#) symbol and is three or six characters long (hex, meaning six). Each character can be any number from zero to nine or any letter from "a" to "f"; 16 "numbers," so to speak; zero is the darkest and "f" is the lightest. This means you can generate about 16 million colors.

Moving on!

Let's apply a different color to the `body` element:

```html{}{1,2,11-14}
<!-- About /my-site/about/index.html -->
    <style>
      * {
        font-family: sans-serif;
      }
      
      html {
        background-color: #dddddd;
      }
      
      body {
        background-color: #ffffff;
      }      
    </style>
```

When you refresh your browser, you should see a white box floating inside a gray box. The `html` and `body` elements are both block-level elements. Their width will be 100 percent of the viewport, and, in most cases, their height will be the same as the content they contain. When you apply a background color to the `html` element, it will be applied to the whole viewport, even though its height is only enough to contain the content. 

Do you notice the white box (`body`) has some space to the left, right, and top?

That's because of what's referred to as the [box model](https://developer.mozilla.org/en-US/docs/Learn/CSS/Building_blocks/The_box_model#what_is_the_css_box_model) and the default style of your browser. Every element being displayed as a block has four "boxes," and they go in the following order from inside–outside:

1. content,
2. padding,
3. border, and
4. margin.

The content box is a box that hugs the content. Padding will maintain the element's background color but adds space between where the content box ends and where the padding box ends. The border is outside the padding and can be a different color (and other properties). The margin is a transparent area beyond the border box.

All right, let's mess around. Remember, it's the Internet, and it's really hard to break. Let's style the `body` element a bit more:

```html{}{1,2,11-16,18-19}
<!-- About /my-site/about/index.html -->
    <style>
      * {
        font-family: sans-serif;
      }
      
      html {
        background-color: #dddddd;
      }
      
      body {
        margin: 15px;
        padding: 10px;
        border-width: 5px;
        border-style: solid;
        border-color: #000000;
        background-color: #ffffff;
      }      
    </style>
```

We said, "The body should have 15 transparent pixels between it and the edge of its parent (`html`). There should be 10 pixels between the text inside the box and the edge of the box. There should be a 5-pixel wide border that's solid, and the color should be black."

There's a shorthand for defining the border and individual aspects for setting margin and padding. The following will give you the same visual results:

```html{}{1,2,11-20,22-23}
<!-- About /my-site/about/index.html -->
    <style>
      * {
        font-family: sans-serif;
      }
      
      html {
        background-color: #dddddd;
      }
      
      body {
        margin-top: 15px;
        margin-bottom: 15px;
        margin-left: 15px;
        margin-right: 15px;
        padding-top: 10px;
        padding-bottom: 10px;
        padding-left: 10px;
        padding-right: 10px;
        border: 5px solid #000000;
        background-color: #ffffff;
      }      
    </style>
```

You can also be more specific with your selectors. For example, let's make the "About" in the navigation bold:

```html{}{1,2,18-21}
<!-- About /my-site/about/index.html -->
    <style>
      * {
        font-family: sans-serif;
      }
      
      html {
        background-color: #dddddd;
      }
      
      body {
        margin: 15px;
        padding: 10px;
        border: 5px solid #000000;
        background-color: #ffffff;
      }      
      
      nav > ul > li:last-of-type {
        font-weight: bold;
      }
    </style>
```

The selector we want to look at is:

```html
nav > ul > li:last-of-type
```

This one is a bit rough to convert to regular language. We're going to work from right to left (inside–out): Apply this to the last list item (`li:last-of-type`), that's a child (`>`) of an unordered list (`ul`), which is a child (`>`) of a `nav` element.

Let's add some elements to the `body` of the about page to make this a bit clearer:

```html{}{1,11-40}
<!-- About /my-site/about/index.html -->
  <body>
    <nav>
      <ul>
        <li><a href="../index.html">Home</a></li>
        <li>About</li>
      </ul>
    </nav>
    <h1>About me</h1>
    <p>Some interesting things about me.</p>
    <ul>
      <li>List A</li>
      <li>Not bold</li>
    </ul>
    <ol>
      <li>List B</li>
      <li>Not bold</li>
    </ol>
    <nav>
      <ol>
        <li>List C</li>
        <li>Not bold</li>
      </ol>
    </nav>
    <nav>
      <ul>
        <li>List D
          <ul>
            <li>List E</li>
            <li>Not bold</li>
          </ul>        
        </li>
        <li>Bold
          <ul>
            <li>List F (bold)</li>
            <li>Bold</li>
          </ul>        
        </li>
      </ul>
    </nav>
  </body>
```

Notice list items in List F are bold? It's not because we selected them, it's because their parent is bold; the style cascades to the children.

We could spend all day playing with styles, and many people do.

But we should move on and wrap this up.

Go ahead and click on the link to the home page.

Notice it doesn't look like the about page. If we meant to make the two pages different, great! Mission accomplished; otherwise, not so much.

Let's create a directory in `/my-site` called `/css`. It will have one file in it for now called `main.css`. Then we'll take the contents of the `style` element and paste it in there.

Our folder structure should look like this:

```bash
/my-site
├─ image.png
├─ index.html
├─ /css
│   └─ main.css
└─ /about
    └─ index.html
```

The `main.css` file should look like this:

```css
* {
  font-family: sans-serif;
}

html {
  background-color: #dddddd;
}

body {
  margin: 15px;
  padding: 10px;
  border: 5px solid #000000;
  background-color: #ffffff;
}      

nav > ul > li:last-of-type {
  font-weight: bold;
}
```

And our about page should be back to looking like it did before we styled it.

We're going to add the style to the home page first. Open `/my-site/idnex.html` and add the `link` element to the `head` with the following attributes:

```html{}{1,6}
<!-- Home /my-site/index.html -->
<!doctype html>
<html lang="en-US">
  <head>
    <title>My site</title>
    <link rel="stylesheet" type="text/css" href="./css/main.css">
  </head>
```

The relationship (`rel`) attribute defines how this linked thing relates to this document; the thing is a stylesheet. The `type` attribute does the same thing it did inside the `style` element. And we've seen the hyperlink reference (`href`) before.

Again, atomic things are used repeatedly to do some amazing things.

Let's head back to the about page. No more styles. Let's modify  the `head` of this document as well:

```html{}{1,6}
<!-- About /my-site/about/index.html -->
<!doctype html>
<html lang="en-US">
  <head>
    <title>About | My site</title>
    <link rel="stylesheet" type="text/css" href="../css/main.css">
  </head>
```
  
The only difference between this and the home page is we had to go up a directory (`../`) to get to the `main.css` file instead of starting where we were (`./`).

## A word of caution

I had a mentor once in the user experience space. I don't know if this was his or someone else he was quoting, but it stuck (another principle):

> No one ever designed a poster. They designed content in the format of a poster. Similarly, no one ever designed a website. They designed content in the format of a website.

Regarding web design and development, especially front-end, we tend to get handed fully fleshed-out designs, and we structure our pages based on the design, not the content. This leads to design-specific HTML and CSS. So, when (not if) we want to change the design, it's a complete overhaul of HTML structure and styles.

It doesn't have to be that way.

Favor starting with the content and semantic markup. Then add to it.

In the early 2000s Dave Shea created a site (and challenge) called [CSS Zen Garden](http://www.csszengarden.com/). The premise was pretty simple. Create a single HTML page with semantic markup and minimal "extra" HTML. Invite people to create stylesheets that modify the look and feel of that HTML. The only hardline rules are that you can't add JavaScript and you can't modify the HTML. Here are some of my favorites for demonstrating the flexibility of a well-formed document and stylesheets:

1. [The original](http://www.csszengarden.com/001/); very 2000s.
2. [Steel](http://www.csszengarden.com/219/); very animated and interactive.
3. [Mid Century Modern](http://www.csszengarden.com/221/); 70's retro and responsive (change the browser size).
4. [Apothecary](http://www.csszengarden.com/218/); 20's woodcut style, also responsive.
5. [Punkass](http://www.csszengarden.com/101/); a fixed-width collage aesthetic with a punk attitude.
6. [Wiggles the Wonderworm](http://www.csszengarden.com/099/); a fixed-width homage to the comic books of the 60s to the 80s.

Yep, it's 20 years old. Its most recent refresh was in 2013. And you can still try and [submit new designs](http://www.csszengarden.com/pages/submit.php). 

Under the hood, over 99 percent of what you interact with online is HTML and CSS. Anything someone else has created or done, you can too. Or at least you can see how they did it.

All right, time for [interaction and animations](/essays-and-editorials/webdev/absolute-beginners/interaction-and-animations/).

