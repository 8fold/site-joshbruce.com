One of my favorite principles from The Manifesto for Agile Software Development is:

> Simplicity--the art of maximizing the amount
> of work not done--is essential.

## Work I did not do

1. Admin panel: Over the years, I've created a fair amount of content maanagement systems and methods for making updating websites easier for non-developers. Most of the code I wrote had to do with administration. Whether it was beating out-of-the-box content management systems into submission or creating my onw. I can avoid this by leveraging other platforms.
2. Authentication:  Most of the security issues and concerns involved authenticating users. Instead, I'm hoping to avoid this by leveraging the authentication of platforms for source control, social media, and chat clients.
3. Database connection: Beyond the admin panel and authentication, database connections and querying accounting for the bulk of defects and code. Using a flat-file system, I don't need to create a database connection. Further, the method of content creation solves a few other problems.
4. No transformation: Some of the code I've written has to do with transforming user input into web-safe data (ex. Titles to slugs for the URL). The flat-file method being used reduces the need for this.
5. I did not use a router: Because this strategy is file- and path-based, the URL path *is* the query for content. There may be minimal checking for templates (controllers), but we're not there yet.
6. I did not write any HTML: Not even for templates.

## Minimal dependencies



## History

The primary way to view the history of this project is to look at the [releases](https://github.com/8fold/site-joshbruce.com/releases). The name of each is release indicates the total time spent writing the code found here.

I didn't start this project using the aforementioned method; therefore, prior to the first GitHub release, you can:

1. look at the [commit history](https://github.com/8fold/site-joshbruce.com/commits/main) in general (prior to October 25th, 2021),
2. look at the [closed pull requests](https://github.com/8fold/site-joshbruce.com/pulls?q=is%3Apr+is%3Aclosed), and
3. read the [super details](https://github.com/8fold/site-joshbruce.com/blob/main/SUPER_DETAILS.md).

