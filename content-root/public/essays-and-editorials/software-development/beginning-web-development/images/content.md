# Images

{!! dateblock !!}

It may not feel like it, but you have almost everything you need to get started. As such, we're mainly expanding and reinforcing your knowledge from reading the [introduction to this series](/essays-and-editorials/software-development/beginning-web-development/).

We left off having created an `index.html` file with the following content:

```html
<!doctype html>
<html lang="en-US">
  <head>
    <title>My site</title>
  </head>
  <body>
    <p>Hello, World!</p>

    <p>How are you?</p>
  </body>
</html>
```

We wanted to add an image.

1. Pick an image on your computer.
2. Put a copy of the image in the `/my-site` directory.

The `/my-site` directory structure should look something like this now:

```bash
/my-site
├─ image.png
└─ index.html
```

We need to be able to reference the image from inside the `index.html` page. We'll need an element. This time we'll use a self-closing element, a technical way of saying, "It doesn't have a closing tag," unlike the paragraph element. 

The image element uses the `img` tag and two attributes. The first attribute is the source (`src`), and the second is an alternative description (`alt`). The `src` tells the browser where the image is. The `alt` describes the image for the visually impaired or will be displayed if the image doesn't load for some reason.

Let's add the following somewhere in the `index.html` file:

```html
<img src="image.png" alt="A screenshot of my file explorer.">
```

You can put these attributes in any order. The content of each can be whatever is necessary for your context. If your image isn't named `image.png`, use whatever the file name is. If your image isn't a screenshot of your file explorer, describe the image. The general rules of thumb for `alt` attributes are:

1. describe the image itself,
2. call out important details, and
3. if there's text in the image, include it in the `alt` attribute or reference it within the body copy (or both).

Once you've added the above to the `index.html` file, refresh your browser.

It's possible the image is huge compared to your browser window, like laughably large. (Every solution comes with at least one new problem.) Let's use the `width` and `height` attributes to fix that; play around with the numbers (try percents even), and don't worry if the image gets distorted:

```html
<img src="image.png" alt="A screenshot of my file explorer." width="200" height="200">
```

Again, the order of these attributes can be whatever you want them to be. The values can be whatever you want them to be. 

Another principle:

> It's difficult to break the Internet. It's easy to not get what you want or expect from the Internet.

To automatically maintain the image's aspect ratio, try setting one of the attributes to "auto" and adjusting the other:

```html
<img src="image.png" alt="A screenshot of my file explorer." width="200" height="auto">
```

Adding a caption (or giving credit) for the image might be nice. First, let's add some text after the image (would like to demonstrate something).

```html
<img src="image.png" alt="A screenshot of my file explorer." width="200" height="auto">

Image by Josh Bruce around 2023
```

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

```html
<figure>
  <img src="image.png" alt="A screenshot of my file explorer." width="200" height="auto">

  Image by Josh Bruce around 2023
</figure>
``` 

`figure` is a block-level element, so if you add some free-floating text after the closing tag, it will appear on the next line of the page. `img` is still an inline element, so, we still have the problem of our caption appearing right next to the image. Luckily, the `figure` element can accept child elements.

What is the most semantically appropriate element to communicate the intent behind this piece of content to the browser?

The `figcaption` element:

```html
<figure>
  <img src="image.png" alt="A screenshot of my file explorer." width="200" height="auto">

  <figcaption>Image by Josh Bruce around 2023</figcaption>
</figure>
``` 

`figcaption` is a block level, which will cause it to appear on a new line under the image. What happens if you put `figcaption` above the `img` tag?

First, nothing breaks. Second, the caption text appears above the image.

You may have noticed I kept saying "semantically" back there. That's because it's easy to get things to display how we want them on the Internet with very few elements. There is a generic block-level element (called `div`) and a generic inline element (called `span`). If we wanted to accomplish a similar default layout, we could have done the following:

```html
<div>
  <img src="image.png" alt="A screenshot of my file explorer." width="200" height="auto">

  <div>Image by Josh Bruce around 2023</div>
</div>
```

However, this hides intent and burdens us to define what we mean when we use a `div` in this context, usually by adding more code. The [living HTML5 standard from the w3c](https://html.spec.whatwg.org) explicitly says of the [`div`](https://html.spec.whatwg.org/#the-div-element) element:

> Authors are strongly encouraged to view the div element as an element of last resort, for when no other element is suitable. Use of more appropriate elements instead of the div element leads to better accessibility for readers and easier maintainability for authors.

The same should also apply to the `span` element.

Markup is for software, and the content is for humans. By using the `figure` and `figcaption` elements, various software applications can interpret our intent and create ways of expressing that intent:

```html
<figure>
  <img src="image.png" alt="A screenshot of my file explorer." width="200" height="auto">

  <figcaption>Image by Josh Bruce around 2023</figcaption>
</figure>
``` 

A search engine may grab all the `figure` elements on a page and display them in a search results grid. A screen reader might allow users to quickly navigate by "landmark" elements.

Speaking of landmark elements, another online convention is to have at least one level-one heading element (`h1`). Let's go ahead and convert the first paragraph to an `h1` element, and `index.html` should look something like this:

```html
<!doctype html>
<html lang="en-US">
  <head>
    <title>My site</title>
  </head>
  <body>
    <h1>Hello, World!</h1>

    <p>How are you?</p>
    
    <figure>
      <figcaption>Some text</figcaption>
      <img src="image.png" alt="A screenshot of my file explorer." width="300" height="auto">
    </figure>
  </body>
</html>
```

While it's possible (technically and according to the specifications) to have more than one `h1` element, the functionality isn't implemented well in all browsers.

You've probably noticed that the `h1` text became larger and bold. This is the default style being applied by the browser. 

We'll get there, but first, we should talk about the next biggest feature that makes the Internet, [linking documents](../links/).
