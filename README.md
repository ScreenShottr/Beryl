<p align="center"><img src="https://i.gyazo.com/2d8237cafb8cc5b53f61de27bd88a601.png"></p>

![screenshot](https://i.gyazo.com/ab52688e29711d008472213ebda7af99.png)

## About Beryl ##

**Beryl is a free open source CLI for the ScreenShottr service. Written in pure PHP with the [Symfony Console](https://symfony.com/doc/current/components/console.html) component.**

It's goal is to be:

* **Simple**, it's easy to use, packed full of useful tools and is easy to deploy
* **Powerful**, upload entire directories of images from your PC or server directly to ScreenShottr
* **Extensible**, add commands at will. Beryl is completely customisable...make it yours.


## Installation

> **Beryl is currently in development, so please expect bugs and potential unexpected behaviour**.

Beryl requires **PHP 7+** and you will also need to install [Composer](https://getcomposer.org) in order to setup Beryl's dependencies.

**Run (In Beryl's root directory)**
```
composer install
```

Once composer has installed the dependencies, test Beryl is working by typing:

```
php beryl --help
```

You should be shown the list of commands available.

## Commands
Currently the following commands are available in Beryl:

 - ``` help ``` - Displays help for the given command (e.g. ``` php beryl images:show help```).
 - ``` list ``` - Lists all available commands
 - ``` images:show ``` - Shows all images within a directory.
 
 Example usage:
 ``` php beryl images:show ``` - This will show all images within the **current** directory. You can specify a directory/path after the initial command, like so:
 ``` php beryl images:show Desktop ```. You can also use two flags, they are:
 
 - ``` --just ``` - Limit image list to specific extensions
 
 Example:
 ``` php beryl images:show Desktop --just=png,jpg ```
 - ``` --fullpath ``` - By default Beryl only lists the filenames, for example `image.png`. By calling the `--fullpath` flag Beryl will output the complete path to each image.


----------
***Will be updated continuously***
