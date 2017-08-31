# Url Shortener

Simple php urlshortener based on slimframework3.

No configuration and no more code, this is like a CMS website

## Setup

### Server Requirement

Require PHP 7.0 or higher

Require Mysql 5.5 or higher

### Install with composer

``composer create-project lefuturiste/urlshortener``

#### Import database

Import `urls.sql` witch is the only table you need for this application. Import it on your mysql database.

#### Configuration

Copy `.env.example` to `.env` and fill it with your own values

#### Run application

You must set, in your webserver configuration the root path :  `public`

## Support

Open an issue on this repository.

## Enjoy !