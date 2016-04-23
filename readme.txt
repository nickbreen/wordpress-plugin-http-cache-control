=== HTTP Cache-Control ===
Contributors: nickbreennz
Donate link: http://example.com/
Tags: comments, spam
Requires at least: 2.8.0
Tested up to: 4.5
Stable tag: v1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Specifies sensible HTTP  headers for all pages, including `/wp-admin`!

== Description ==

In general, `no-store`, and `no-cache` are never sent and `max-age=0, s-maxage=0, must-revalidate` is used instead.

`Pragma` and `Expires` are stripped in favour of only using `Cache-Control`.
