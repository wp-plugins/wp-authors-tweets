=== WP Author's Tweets  ===
Contributors: crearecomm
Tags: twitter,follow me,twitter feed,
Requires at least: 2.8
Tested up to: 3.2.1
Stable tag: trunk

WP Author's Tweets allows you to add your Twitter username to individual author profile pages along with a feed count.

== Description ==

WP Author's Tweets allows you to add your Twitter username to individual author profile pages along with a feed count, which enables you to echo out a 'follow me' button and twitter feed on your blog posts, dynamically for each author.

[Support](http://www.webdesigncreare.co.uk/blog/videos/wp-author-tweets.html) |
[FAQ](http://www.webdesigncreare.co.uk/blog/videos/wp-author-tweets.html)

WP Author's Tweets allows you to add your Twitter username to individual author profile pages along with a feed count, which enables you to echo out a 'follow me' button and twitter feed on your blog posts, dynamically for each author.

You can also set a default twitter username and feed count, which will overwrite any empty author fields. This is useful if some of your blog author's don't have twitter profiles, or if you want to only show your companies twitter feed and follow me button.

To start you need to enter your username and feed count, then on your single.php echo out the following code:

<?php echo get_followme(); ?>

<?php echo getLatestTweetWP(); ?>

**WP Author's Tweets updates?**

We are currently working to improve WP Author's Tweets. The next release will feature the ability to wrap the twitter feed in custom HTML to take styling to the next level.

**If upgrading, please back up your database first!**

== Installation ==

Please visit the [WP Author's Tweets plugin page](http://www.webdesigncreare.co.uk/blog/videos/wp-author-tweets.html) on Web Design Creare for installation details.

== Frequently Asked Questions ==

Please visit the [WP Author's Tweets plugin page](http://www.webdesigncreare.co.uk/blog/videos/wp-author-tweets.html) on Web Design Creare, and check out the comments section for frequently asked questions. If your question hasn't been asked, feel free to leave a comment!

== Changelog ==

= 0.1 =
* Fixes bug when mentioning email addresses in Tweets
* Allows you to add an ID to latest tweet list
* Tweet content and 'Tweeted' wrapped in <p> tags
* Ability to change 'Tweeted" text 

== Upgrade Notice ==

= 0.1 =
This version fixes a security related bug.  Upgrade immediately.

**If upgrading, please back up your database first!**