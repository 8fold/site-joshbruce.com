# Running PHP on macOS

{!! dateblock !!}

Bottom line up front.

If you want to use the PHP-related things from a [MAMP](https://www.mamp.info/en/mac/) installation, add the following to the `.profile` file:

```
export PATH="/Applications/MAMP/bin/php/php8.1.13/bin:${PATH}"
alias php='/Applications/MAMP/bin/php/php8.1.13/bin/php -c "/Library/Application Support/appsolute/MAMP PRO/conf/php8.1.13.ini"'
alias composer='/Applications/MAMP/bin/php/composer'
alias php-config='/Applications/MAMP/bin/php/php8.1.13/bin/php-config'
alias phpdbg='/Applications/MAMP/bin/php/php8.1.13/bin/phpdbg'
alias phpize='/Applications/MAMP/bin/php/php8.1.13/bin/phpize'
alias pear='/Applications/MAMP/bin/php/php8.1.13/bin/pear'
alias peardev='/Applications/MAMP/bin/php/php8.1.13/bin/peardev'
alias pecl='/Applications/MAMP/bin/php/php8.1.13/bin/pecl'
```

If you don't know where the `.profile` file is, a complete path is:

1. Hard drive.
2. Your user folder.
3. [Show hidden files](https://apple.stackexchange.com/questions/406762/keyboard-shortcut-to-show-hidden-files-on-macos-big-sur). (There's a way to do this all the Terminal app, but I'm not that guy.)
4. Edit in a text editor.
5. Save changes.
6. Launch a terminal (or the Terminal app).
7. Type `source ~/.profile` (to refresh the profile contents).

## What had happened was

My MacBook Pro was having power issues. I sent it in for diagnostic and repair. They replaced the logic board. Replacing the logic board means I basically got a new laptop back. Right down to the version of macOS installed. 

I usually don't restore from a backup when stuff like this happens. I start over. It's like packing all your things in boxes as if you were going to move (or moving), then only unpacking what you need.

I finally hit the point of getting PHP working.

For those who don't know, macOS used to ship with a version of PHP preinstalled. So if you wanted to use a different version of PHP, you would install PHP, most likely using Homebrew, if your internet search goes anything like mine.

A few macOS versions ago, Apple renamed their install and let developers know that PHP, any version of it, would eventually no longer come preinstalled. So, at some point, you'd always have to resort to putting it on the machine yourself. 

Apple's last PHP version with macOS was 7.4 (if memory serves). When I wanted to start using PHP 8, I needed to overwrite their version with the one I installed. In the beginning, I used Homebrew because that's what the Internet said to do. After a while, I realized I only used Homebrew to install PHP, which seemed a bit silly.

I don't customize my setup much. I like being less dependent on my setup when going from computer to computer. But, of course, this only works if someone doesn't customize the heck out of their setup.

macOS is also transitioning from a `.bash_profile` for custom things to just `.profile`. (`.bash_profile` is still available; it just points to or includes `.profile`. Unfortunately, I'm not a Terminal human, so that's the best I got.)

Anyway.

I get the laptop back. I update the operating system. But, unfortunately, there's no PHP installed. So I cracked open `.profile` and did what I thought needed doing:

```
alias php='/Applications/MAMP/bin/php/php8.1.13/bin/php'
alias composer='php ~/composer.phar'
export PATH=/Applications/MAMP/bin/php/${PHP_VERSION}/bin:$PATH
```

This enabled it to run things like `composer install` and `update`. It also gave me the expected responses for things like `php -v` and `which php`. However, when I ran something like `./vendor/bin/phpunit`, I'd get a "file not found" error. When I tried running anything in `./vendor/bin`, I'd get the same error. Whether I was in the Terminal or my [.Integrated Development Environment](IDE).

I was frustrated. [Tooted](https://phpc.social/@itsjoshbruce/109775464933883291) about it. And gave up for the rest of the day.

The next day I checked on the Mac mini to see how it was set up. I verified I could run the tests for the project. I confirmed Homebrew was not installed. I opened the `.profile` file and found the lines listed above. Saved a copy of the file to iCloud. Hopped and the laptop. A copy, paste, and `source ~/.profile` later, I tried rerunning the tests.

Boom!

And now, I need to get back to the project.