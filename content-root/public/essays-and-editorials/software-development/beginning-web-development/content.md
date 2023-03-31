# Web development for absolute beginners

{!! dateblock !!}

This series takes the magic out of web development that many can find so intimidating. This series presumes a certain level of understanding of computers in general (navigating files and directories) and no knowledge of web development.

This is me, so values and principles are more important than any single implementation. I am short on binary decisions and long on flexibility.

With that said, you might run into some strong opinions loosely held.

For example, a principle (or core belief) is that making a website is relatively easy. A value is to favor the most constrained.

Every computer operating system comes with some form of a [command line or terminal application](https://en.wikipedia.org/wiki/Command-line_interface) for free. Most users don't know what they are, don't want to learn how to use them, and may not realize that they're not needed (at least for developing and launching a website). This lack of knowledge constrains these users, which is okay.

Another principle is that creators should be able to opt into complexity; it should not be a fundamental aspect of participation. Experts (or even the competent) in a field can tend to emphasize all the complexities and nuance, which causes beginners to run away and think they're incapable of participating.

And one more principle before we move on is that most people don't want or need a website, even businesses. Most of those who create a website don't want to spend (or feel like they need to spend) a lot of time maintaining them. Even if they say something like, "I want a site I can update myself," that often quickly turns into delegating that responsibility to someone else.

Let's start by creating a website that "runs" locally. "Locally" is a slightly technical term that means on your computer.

What you'll need:

1. A plain text editor: All operating systems come with one for free.
	1. For macOS, [TextEdit](https://support.apple.com/guide/textedit/welcome/mac) will do just fine. In the menu, go to Format and click Make Plain Text.
	2. For Windows, [Notepad](https://support.microsoft.com/en-us/windows/help-in-notepad-4d68c388-2ff2-0e7f-b706-35fb2ab88a8c) will do just fine.
	3. Linux is beyond my wheelhouse, and from a cursory glance, there are many to choose from.
2. An internet browser: This doesn't need to be connected to the Internet. There are many to choose from, and one, most likely, came preinstalled on your computer.

That's it.

1. Create a directory called `/my-site` somewhere on your computer; recommend the desktop.
2. Open your plain text editor.
3. Type "Hello, World!"
4. Save the file in the `/my-site` directory and name it `index.html`.
	1. You may need to confirm that you want to use `html` as the extension.
5. Open the `/my-site` directory.
6. Double-click the `index.html` file. If it doesn't automatically open in your default browser:
	1. Open your browser.
	2. Got to file.
	3. Click open.
	4. Find the `/my-site` directory.
	5. Click on the `index.html` file.
	6. Click open.

You should see the words "Hello, World!" in the browser.

Congratulations!

Another set of principles is:

1. There are very few unique problems.
2. There are infinite possible solutions to a given problem.
3. Almost every solution introduces at least one new problem.

Let's add another paragraph to the `index.html` file:

```html
Hello, World!

How are you?
```

Refresh your browser.

You'll probably see something like this:

```bash
Hello, World! How are you?
```

That's not what we wanted; that's a problem.

It's happening because the browser does its best to interpret your intent. Browsers tend to ignore whitespace characters. So we need a way to communicate our intent to the browser (or client, if you're fancy). Our only expressed goal to the browser is we want those five words to appear on the screen.

Enter [.Hypertext Markup Language](HTML), specifically the paragraph element.

We want to tell the browser when a paragraph starts and ends. Let's modify the `index.html` file again:

```html
<p>Hello, World!</p>

<p>How are you?</p>
```

Refresh your browser, and you should see something like this:

```bash
Hello, World!

How are you?
```

Every HTML element (sometimes referred to as a tag) starts with a [left angle bracket](https://en.wikipedia.org/wiki/Bracket) (less than sign), followed by one or more letters, and followed by a right angle bracket. This describes the opening tag.

The content may be plain text or other HTML elements for elements that may also contain content. For content elements, we want to create a closing tag. Closing tags are very similar to their opening tag. The only difference is adding a [forward slash](https://www.thesaurus.com/e/grammar/slash/) after the left angle bracket.

The Internet is built on atomic concepts that are repeated and combined to do amazing things. The construction of elements is a perfect example.

Right now, our `index.html` file is not what we call a well-formed HTML document. However, it works because most browsers try hard to make pages work.

A well-formed HTML document starts with a document-type declaration.

It's an element that won't be rendered on screen. In the early 2000s, there were lots of these available. Since around 2008, it became simplified with the [release of HTML5](https://en.wikipedia.org/wiki/HTML5). Let's add a document-type declaration to the top of `index.html`:

```html
<!doctype html>
<p>Hello, World!</p>

<p>How are you?</p>
```

Refresh your browser, and nothing should change.

Notice that you can't *see* the document-type declaration on screen? That's because it's a hidden element.

Still not well-formed, but we're getting there.

We need what's called a root element. A root element is an HTML element containing (wrapping) all the other content, plain text, or other elements. For HTML pages, the root element is `html`:

```html
<!doctype html>
<html>
  <p>Hello, World!</p>

  <p>How are you?</p>
</html>
```

This tells the browser that our HTML will start at the opening tag and end at the closing tag.

Refresh your browser. Still, nothing changed, but it works, and that's the critical part.

Still not well-formed.

Something we value in web development is separating content from [metadata](https://en.wikipedia.org/wiki/Metadata). We do this at the page level with two more elements; `head` and `body`. `head` is for metadata, and `body` is for content.

Our paragraphs are content, so let's wrap them in a `body` element:

```html
<!doctype html>
<html>
  <body>
    <p>Hello, World!</p>

    <p>How are you?</p>
  </body>
</html>
```

Refresh the browser. Still works. Good times.

Still not well-formed because we're missing a piece of required metadata; the `title`.

Even though the order of these elements doesn't matter, by convention, we put metadata at the top of a document. Let's add the title "My site" inside a `title` element, wrapped in the `head` element.

```html
<!doctype html>
<html>
  <head>
    <title>My site</title>
  </head>
  <body>
    <p>Hello, World!</p>

    <p>How are you?</p>
  </body>
</html>
```

Refresh the browser. Something changed. It might not be obvious.

If you look at the top of your browser, you might see the title displayed. If not, you may need to hover your mouse over the window or tab you have the page in. If you use a screen reader, you should have it start from the top.

This is a well-formed HTML page because:

1. It starts with a document-type declaration.
2. It has a root `html` element.
3. It has a `head` element with a `title` element; technically, it could be empty and still well-formed.
4. It has a `body` element.
5. All elements are opened and closed correctly.

The [w3c](https://www.w3.org) is a nonprofit organization that creates recommendations (sometimes called standards) for the web. The w3c offers a [markup validation service](https://validator.w3.org/#validate_by_input) that was all the rage in the early 2000s; we had badges and everything to let users know our site complied with the recommendations. If you go there and select "Validate by Direct Input" and paste the contents of your `index.html` file, it will come up with no errors. It will have a warning, though. Errors are bigger than warnings.

The warning should be something like this:

> Consider adding a lang attribute to the html start tag to declare the language of this document.

An element may contain any number of attributes. An attribute is a fancy way of saying "Key-value pair," which is a technical way of saying, "If you ask for this key, you will get this value." Attributes come after the element label of the opening tag and end before the opening tag's right angle bracket.

There are [standards](https://developer.mozilla.org/en-US/docs/Web/HTML/Global_attributes/lang) (shocker) regarding how to note which language you're referring to or using. For example, I'm in the United States and using United States English; this is indicated as "en-US" if you want to be less specific and still use English, it would just be "en."

So, let's add a language to the `index.html` file. We'll add it to the `html` element; however, we could add it to any element:

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

Our HTML page is well-formed (no errors) and has no warnings.

Text is lovely, but many like adding images to web pages. Seriously, it's one of the first things most people want to do online.

[Let's add an image!](/essays-and-editorials/software-development/beginning-web-development/images/)


