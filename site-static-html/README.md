# Static HTML from PHP

The static site is generated from the `amos` CLI tool, which uses the [Dynamic site using PHP](https://github.com/8fold/site-joshbruce.com/blob/main/site-dynamic-php/README.md) classes.

The `content` folder is queried. Each path is used to generate a request. The response from the request is used to generate the file inside the `public` directory.
