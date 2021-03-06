# Changelog

## 1.0.9 - 2020-03-16

* Show latest, top and random URLs
* Lower timeout per fetch
* Fix paths for scraped images (both `picture` and `img`)
* Added more URL validation

## 1.0.8 - 2020-02-27

* Added brute force protection
* Added even more URL validation

## 1.0.7 - 2020-02-27

* Added even more URL validation
* Added test suite
* Added sitemap

## 1.0.6 - 2020-02-24

* Added even more URL validation

## 1.0.5 - 2020-02-20

* Added more URL validation
* Showing 404 for invalid URLs

## 1.0.4 - 2020-02-20

* Fixed redirect loop for non-ascii characters
* Added donation buttons
* Footer improvements

## 1.0.3 - 2020-02-20

* Improved error logging for unsuccessful fetch attempts
* Use SSL over non-SSL when fetching

## 1.0.2 - 2020-02-19

* Notifying Bugsnag on unsuccessful fetch attempts
* Trying to fetch URLs both with SSL and non-SSL
* Improved database (saving non-prettified body to db, caching more debug data, updating current cache if it already exists)
* Displaying images relative to scraped URL

## 1.0.1 - 2020-02-18

* Added twitter link
* Changed bookmarklet label
* Adjustments for small screens
* Prepended URL on not found page with anonymizer

## 1.0 - 2020-02-17

* Inital release based on [gonedjur/unvis.it](https://github.com/gonedjur/unvis.it)
