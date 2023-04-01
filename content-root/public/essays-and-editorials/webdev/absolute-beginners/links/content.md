# Links

{!! dateblock !!}

The Internet ushered in the ability for folks to write something, put it on a computer other people could access, and link to other documents. Arguably, linking from one section of a document to another and even linking one document to another is a defining characteristic of the web.

This brings up another principle:

> When interpreting user intent, the [.Uniform Resource Locator](URL) is the center of the universe.

If you look at the address bar of your browser, you'll probably see something like this:

```html
file://users/{your user}/Desktop/my-site/index.html
```

`file` is the protocol being used. The colon, followed by two forward slashes, separates the protocol from the domain or root. Everything after the first single forward slash is the path. Each part of the path after a forward slash represents a directory on the computer being accessed. The last bit is the name of the file we're looking for.

Under the hood, this is how your operating system works. There aren't directories containing files on the disk. There are relatively human-friendly addresses that point to pieces of data. Your file explorer software converts these addresses into the graphic user interface.

We'll return to this often because the URL is the center of the universe. For this essay, though, we're mainly just interested in the existence of the URL and its parts.

Links are also known as anchors. There are two types of anchors, inline and external. Inline anchors allow you to move from one area of a document to another. External anchors allow you to move from one document to another.

Let's start with inline anchors.

We'll want to modify the `index.html` file in such a way that we have two things:

1. Enough content to warrant having a vertical scrollbar.
2. At least one element with an `id` attribute we'll target.

I'm going to take a somewhat circuitous route. If you want to, go ahead and start writing something "real" and somewhat longer in `index.html`.

I'm going to grab some "[lorem ipsum](https://en.wikipedia.org/wiki/Lorem_ipsum)" text from [lipsum.com](https://www.lipsum.com/); 20 paragraphs to be exact. I'll copy-paste that into a [markdown converter](https://marked.js.org/demo/?text=Marked%20-%20Markdown%20Parser%0A%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%3D%0A%0A%5BMarked%5D%20lets%20you%20convert%20%5BMarkdown%5D%20into%20HTML.%20%20Markdown%20is%20a%20simple%20text%20format%20whose%20goal%20is%20to%20be%20very%20easy%20to%20read%20and%20write%2C%20even%20when%20not%20converted%20to%20HTML.%20%20This%20demo%20page%20will%20let%20you%20type%20anything%20you%20like%20and%20see%20how%20it%20gets%20converted.%20%20Live.%20%20No%20more%20waiting%20around.%0A%0AHow%20To%20Use%20The%20Demo%0A-------------------%0A%0A1.%20Type%20in%20stuff%20on%20the%20left.%0A2.%20See%20the%20live%20updates%20on%20the%20right.%0A%0AThat%27s%20it.%20%20Pretty%20simple.%20%20There%27s%20also%20a%20drop-down%20option%20above%20to%20switch%20between%20various%20views%3A%0A%0A-%20**Preview%3A**%20%20A%20live%20display%20of%20the%20generated%20HTML%20as%20it%20would%20render%20in%20a%20browser.%0A-%20**HTML%20Source%3A**%20%20The%20generated%20HTML%20before%20your%20browser%20makes%20it%20pretty.%0A-%20**Lexer%20Data%3A**%20%20What%20%5Bmarked%5D%20uses%20internally%2C%20in%20case%20you%20like%20gory%20stuff%20like%20this.%0A-%20**Quick%20Reference%3A**%20%20A%20brief%20run-down%20of%20how%20to%20format%20things%20using%20markdown.%0A%0AWhy%20Markdown%3F%0A-------------%0A%0AIt%27s%20easy.%20%20It%27s%20not%20overly%20bloated%2C%20unlike%20HTML.%20%20Also%2C%20as%20the%20creator%20of%20%5Bmarkdown%5D%20says%2C%0A%0A%3E%20The%20overriding%20design%20goal%20for%20Markdown%27s%0A%3E%20formatting%20syntax%20is%20to%20make%20it%20as%20readable%0A%3E%20as%20possible.%20The%20idea%20is%20that%20a%0A%3E%20Markdown-formatted%20document%20should%20be%0A%3E%20publishable%20as-is%2C%20as%20plain%20text%2C%20without%0A%3E%20looking%20like%20it%27s%20been%20marked%20up%20with%20tags%0A%3E%20or%20formatting%20instructions.%0A%0AReady%20to%20start%20writing%3F%20%20Either%20start%20changing%20stuff%20on%20the%20left%20or%0A%5Bclear%20everything%5D(%2Fdemo%2F%3Ftext%3D)%20with%20a%20simple%20click.%0A%0A%5BMarked%5D%3A%20https%3A%2F%2Fgithub.com%2Fmarkedjs%2Fmarked%2F%0A%5BMarkdown%5D%3A%20http%3A%2F%2Fdaringfireball.net%2Fprojects%2Fmarkdown%2F%0A&options=%7B%0A%20%22async%22%3A%20false%2C%0A%20%22baseUrl%22%3A%20null%2C%0A%20%22breaks%22%3A%20false%2C%0A%20%22extensions%22%3A%20null%2C%0A%20%22gfm%22%3A%20true%2C%0A%20%22headerIds%22%3A%20true%2C%0A%20%22headerPrefix%22%3A%20%22%22%2C%0A%20%22highlight%22%3A%20null%2C%0A%20%22hooks%22%3A%20null%2C%0A%20%22langPrefix%22%3A%20%22language-%22%2C%0A%20%22mangle%22%3A%20true%2C%0A%20%22pedantic%22%3A%20false%2C%0A%20%22sanitize%22%3A%20false%2C%0A%20%22sanitizer%22%3A%20null%2C%0A%20%22silent%22%3A%20false%2C%0A%20%22smartypants%22%3A%20false%2C%0A%20%22tokenizer%22%3A%20null%2C%0A%20%22walkTokens%22%3A%20null%2C%0A%20%22xhtml%22%3A%20false%0A%7D&version=master); select html source from the dropdown. Copy the HTML results into my `index.html` file under the `figure` element. 

If you do this, it will look like a hot mess. Fair warning.

Let's go to the last element you have before the closing `body` tag. We're going to add an `id` attribute to that element.

Something to remember about the `id` attribute is that it must be unique within the `html` element. Like The Highlander, [there can be only one](https://youtu.be/sqcLjcSloXs). If you wind up with duplicates, the browser won't explode. It will just use the first or last one encountered for any references made to that value.

(I'll add another paragraph to keep the code samples relatively clean.)

```html{}{13-14}
<!doctype html>
<html lang="en-US">
  <head>
    <title>My site</title>
  </head>
  <body>
    <h1>Hello, World!</h1>
    <p>How are you?</p>
    <figure>
      <img src="image.png" alt="A screenshot of my file explorer." width="300" height="auto">
      <figcaption>Some text</figcaption>
    </figure>
    <!-- 20 paragraphs of Lorem Ipsum -->
    <p id="last-paragraph">The last paragraph.</p>
  </body>
</html>
```

Let's add a link to the top of the page that will target the last paragraph. We're going to add an unordered list (`ul`) to the top of the page that will have one list item (`li`), and inside the list item, we'll have an anchor (`a`) element. (A table of contents, if you will.)

```html{}{7-11}
<!doctype html>
<html lang="en-US">
  <head>
    <title>My site</title>
  </head>
  <body>
    <ul>
      <li>
        <a>The last paragraph</a>
      </li>
    </ul>

...
```

If you refresh your browser, you should see a bulleted list with the text "The last paragraph" at the top. However, if you click on it, nothing happens. We must finish the anchor by adding a hyperlink reference (`href`) attribute. For inline links, we need to start with a hash (#) symbol, followed by the `id` of the target, `last-paragraph`:

```html{}{9}
<!doctype html>
<html lang="en-US">
  <head>
    <title>My site</title>
  </head>
  <body>
    <ul>
      <li>
        <a href="#last-paragraph">The last paragraph</a>
      </li>
    </ul>

...
```

Refresh the browser. 

You should see a link you can click on. When you click on it, the browser should scroll to a point where the last element of your page is visible. Inline anchors try to bring the target content to the top of the browser. If they can't, they'll get as close as they can.

Look at your address bar now. You should see something like this:

```html
file://users/{your user}/Desktop/my-site/index.html#last-paragraph
```

If you share this URL with someone, their browser will go to the page, then scroll to the specified position on the page.

The URL is the center of the universe.

Let's take a second to recap what we know before layering on top of it.

1. We can reference (and move to) a point inside a document using inline anchors. This adds a hash (or text fragment) to the URL.
2. We can include an image file saved in the same directory as our page by typing in the file's name inside the `src` attribute of the `img` element.

What both of these reference methods have in common is:

1. We're not going outside our current directory.
2. The references don't start with a protocol or slash.

The second one might seem weird, but it's important. There are two additional ways to navigate and reference things that may or may not be in the same directory:

1. A fully-qualified URL.
2. A relative URL.

The following is what some call a fully qualified URL (also known as a [fully qualified name](https://en.wikipedia.org/wiki/Fully_qualified_name#Filenames_and_paths)):

```html
file://users/{your user}/Desktop/my-site/index.html#last-paragraph
```

It defines where something is, from start to finish. A relative URL looks at a current position and moves relative to that position. This is done through the use of forward slashes and dots.

All the dots, slashes, angle brackets, and tags are syntax. Non-human-friendly things we use to communicate with a computer in a standard way. (Syntax is for computers. The words are for humans.)

When it comes to relative references and linking, there are three things to know:

1. A forward slash (/) at the beginning means, "Start from the root."
   1. `file://` in our example URL above.
2. A dot followed by a forward slash (./) means, "Start from here and go down."
	 1. We could have used `./image.png` for the image `src` we did. We could not have used `/image.png` because that would have translated to `file://image.png`, and that's not where the image is.
3. Two dots followed by a forward slash (../) means, "Start from here, go up one directory, then go down from there."
	 1. We create an example of this next.

The main drawback to fully qualified URLs is that all the links break if you move the files and directories. The main benefit is that if the content gets copied to another location and the links aren't altered, the links will return the user to the source of truth.

The main drawback of relative URLs is that if a single page gets copied to another location, all the links are broken because they will be relative to that new location. The main benefit is that you can move the files and directories anywhere, and the links don't break.

We're discussing this now because we're about to create another page. We will link to that other page. We'll want to use relative links because typing in the fully-qualified URL every time in this context would suck.

1. Inside the `/my-site` directory, create another directory called `/about`. 
2. Make a copy of `index.html` and put it into the `/about` directory. 
3. Remove all the content between the opening and closing `body` tags.

Your file structure should look like this:

```bash
/my-site
├─ image.png
├─ index.html
└─ /about
    └─ index.html
```

And the about page HTML should look like this:

```html
<!doctype html>
<html lang="en-US">
  <head>
    <title>My site</title>
  </head>
  <body>
  </body>
</html>
```

Let's start by updating the `title`. There's a convention online to stack titles. It can help orient users similar to breadcrumbs but less divisive. So, let's add "About" in front of "My site" to end up with this:

```html{}{4}
<!doctype html>
<html lang="en-US">
  <head>
    <title>About | My site</title>
  </head>
  <body>
  </body>
</html>
```

Let's add a level one heading:

```html{}{7}
<!doctype html>
<html lang="en-US">
  <head>
    <title>About | My site</title>
  </head>
  <body>
    <h1>About me</h1>
    <p>Some interesting things about me.</p>
  </body>
</html>
```

Let's create a menu to switch between the home page and the about page easily. We're going to introduce the navigation element (`nav`):

```html{}{1,5-10}
<!-- About - /my-site/about/index.html -->
...

  <body>
    <nav>
      <ul>
        <li><a href="../index.html">Home</a></li>
        <li>About</li>
      </ul>
    </nav>
    <h1>About me</h1>

...
```

Go back to the `/my-site/index.html` file and paste the navigation there with a couple of changes:

```html{}{1,5-10}
<!-- Home - /my-site/index.html -->
...

  <body>
    <nav>
      <ul>
        <li>Home</li>
        <li><a href="./about/index.html">About</a></li>
      </ul>
    </nav>    
...
```

Refresh the browser.

At the top of the page, you should see a bulleted list with the first item saying "Home" and the second saying "About." If you're on the home page, you should be able to click on the "About" link and see the about page. If you're on the about page, you should be able to click on the "Home" link and see the home page.

If your operating system uses [backslashes](https://en.wikipedia.org/wiki/Backslash), you must change the forward slashes to backslashes.

Notice how we used the dot forward slash (./) on the home page to move from `/my-site` into `/my-site/about`. Further, we used the double dot forward slash (../) to move from the `/my-site/about` directory into the `/my-site` directory. 

For links to the about page from the home page, the following would have also worked:

```html
<a href="about/index.html">About</a>
```

With that said, I try and prefix directory names with the forward slash to help differentiate them from files. This becomes helpful later.

You might also notice that these URLs don't seem like the ones you see online, and you're right. We need to reference specific file names and extensions. We could have created an `about.html` file in the `/my-site` directory and been able to link to it like this:

```html
<a href="about.html">About</a>
```

We're going this way to prepare you for a "modern" and live setup. Contemporary web URLs no longer use file names; using filenames isn't user-friendly. So, from a file system perspective, the Internet is a bunch of directories with a single file inside. Good times.

All right, the next big thing folks want to do is make the site look better. So, next up, we'll [talk about styles](/essays-and-editorials/webdev/absolute-beginners/styles/).