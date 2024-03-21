# lmc-user-tutorial Skeleton

## Introduction

This is Laminas MVC Skeleton application with the Album module added as per the MVC Tutorial
found in the Laminas documentation.  The tutorial is [here](https://docs.laminas.dev/tutorials/).

This application is the result of following the tutorial up and including the [Adding laminas-navigation to the Album Module](https://docs.laminas.dev/tutorials/navigation/).

The purpose of this application is to serve as a starting point for the [LmcUser tutorial](https://www.vistomedia.com/laminas-user-authentication-using-lmcuser/) if the student does not want to perform all the
steps of the Album Module tutorial to get the application to the level needed by the LmcUser tutorial.

Development mode is already enabled.

## Installation

This package in not on Packagist and therefore you cannot install it using Composer. You need to clone the repository.

```bash
$ git clone https://github.com/visto9259/lmc-user-tutorial.git
```

Once installed, you can test it out immediately using PHP's built-in web server:

```bash
$ cd path/to/install
$ composer install
$ composer serve
```

This will start the cli-server on port 8080, and bind it to all network
interfaces. You can then visit the site at http://localhost:8080/
- which will bring up Laminas MVC Album List page.


For the purpose of the LmcUser tutorial, using the built-in web server is sufficient. If your want to set it up in a Web Server or a Docker Container, then follow the instructions
from the [Laminas MVC Skeleton README](https://github.com/laminas/laminas-mvc-skeleton).

## Branches

### starting-point
The `starting-point` branch contains the Laminas MVC Skeleton with the Album module added but **BEFORE** the changes on this tutorial
are applied.  This is the starting point of the tutorial.

### lmcuser-tutorial-complete

The `lmcuser-tutorial-complete` branch the Laminas MVC Skeleton with the Album module added and **AFTER** the changes
on this tutorial are applied.

You can use this to compare against your own modifications.

To login in, use `john@example.com` with password `123456`.

