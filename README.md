# PHPAutotest

This application monitors your tests and executes them whenever you make any changes to them.

It actually supports the main three TDD/BDD frameworks for PHP: PHPUnit, PHPSpec and Behat

##Framework requirements:

*PHPUnit*

(copied from: http://www.phpunit.de/manual/3.0/en/installation.html)

```sh
$ sudo pear channel-discover pear.phpunit.de
$ sudo pear channel-discover pear.symfony.com
$ sudo pear install -a phpunit/PHPUnit
```

*PHPSpec*

(copied from: http://www.phpspec.net/download/)

```sh
$ sudo pear channel-discover pear.phpspec.net
$ sudo pear channel-discover pear.symfony.com
$ sudo pear install -a phpspec/PHPSpec
```

*Behat*

(copied from: http://docs.behat.org/quick_intro.html)

```sh
$ sudo pear channel-discover pear.behat.org
$ sudo pear channel-discover pear.symfony.com
$ sudo pear install behat/behat
```

##Other requirements:

*PHPAutotest requires bash shell*.

*Linux/Gnome*

You'll need to have the notification services installed on your machine

```sh
$ sudo apt-get install libnotify-bin
```

*KDE*

Not yet implemented

*OSX*

Not yet implemented

##Instructions:

You can download the phar file here: https://github.com/downloads/Programania/PHPAutotest/autotest.phar

Just place it somewhere, give it execution permissions and add it to your path.

Also, you can clone this repository and compile the PHAR file yourself:

```sh
$ ./compile
```

##Usage:

You need to provide 2 arguments to the application:

 * The framework to use
 * The test file or directory(Behat only) to run

Example:

```sh
$ ./autotest phpunit demo/PHPUnit/SomeClassTests.php
```

PHPAutotest will execute your tests, idle for 1 second and check if the file has been modified. You can also hit '*r*' key to force an execution.

Also, you can hide the terminal because it will notify you with the results of the test.