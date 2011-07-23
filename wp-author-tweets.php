<?php
/**
 * @package WP Author Tweets
 */
/*
Plugin Name: WP Author's Tweets
Plugin URI: http://www.webdesigncreare.co.uk/blog/videos/wp-author-tweets.html
Description: Gives you the ability to add your Twitter username to Author profile and display latest tweets.
Version: 1.0
Author: Creare Communications Ltd
Author URI: http://www.webdesigncreare.co.uk
License: GPL2
*/ 

/*
This program is free software; you can redistribute it and/or modify 
it under the terms of the GNU General Public License as published by 
the Free Software Foundation; version 2 of the License.

This program is distributed in the hope that it will be useful, 
but WITHOUT ANY WARRANTY; without even the implied warranty of 
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
GNU General Public License for more details. 

You should have received a copy of the GNU General Public License 
along with this program; if not, write to the Free Software 
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA 
*/
function tweet_admin() {  
    include('wp_tweets_admin.php');  
}
function tweet_admin_actions() {
	add_options_page('WP Author\'s Tweets', 'WP Author\'s Tweets', 'administrator', __FILE__, 'tweet_admin',plugins_url('/images/icon.png', __FILE__));
}
add_action('admin_menu', 'tweet_admin_actions');
	function add_twitterUser($contactmethods) {
	$contactmethods['twitter'] = 'Twitter Username'; 
	return $contactmethods; 
	}
	add_filter('user_contactmethods','add_twitterUser',10,1);
	function add_twitterCount($contactmethods) {
	$contactmethods['twitter_count'] = 'Number of Tweets';
	return $contactmethods;
	}
	add_filter('user_contactmethods','add_twitterCount',10,1);	 
	function get_followme() {
		$tweets_default_user = get_option('tweets_default_user');
		if(!empty($contactmethods['twitter'])) {
		$username = get_the_author_meta('twitter');
		} else { $username = $tweets_default_user; }
		 return "<a data-show-count=\"false\" class=\"twitter-follow-button\" href=\"http://twitter.com/" .$username. "\">Follow @" .$username. "</a><script src=\"http://platform.twitter.com/widgets.js\" type=\"text/javascript\"></script>";
	 
	 }
	include_once(ABSPATH . WPINC . '/feed.php');	
	function createTinyUrl($strURL) {
		$tinyurl = file_get_contents("http://tinyurl.com/api-create.php?url=".$strURL);
	return $tinyurl;
	}
	if(!strpos('tinyurl',$url_to_shorten)) {
	function shorten_url($matches) {
   $long_url = $matches[0];
   $url = "http://tinyurl.com/api-create.php?url=$long_url";
   return '<a rel="nofollow" target="_blank" href="'.wp_remote_retrieve_body(wp_remote_get($url)).'">'.wp_remote_retrieve_body(wp_remote_get($url)).'</a>'; } }
	function getLatestTweetWP() {
		$tweets_default_user = get_option('tweets_default_user');
		$tweets_default_count = get_option('tweets_default_count');
		if(!empty($contactmethods['twitter'])) {
		$username = get_the_author_meta('twitter');
		} else { $username = $tweets_default_user; }
		if(!empty($contactmethods['twitter'])) {
		$numtweets = get_the_author_meta('twitter_count');
		} else { $numtweets = $tweets_default_count; }
		// Get a SimplePie feed object from the specified feed source.
		$rss = fetch_feed('http://api.twitter.com/1/statuses/user_timeline.rss?screen_name=' .$username. '');
			if (!is_wp_error( $rss ) ) : // Checks that the object is created correctly 
				// Figure out how many total items there are
				$maxitems = $rss->get_item_quantity($numtweets);		
				// Build an array of all the items, starting with element 0 (first element).
				$rss_items = $rss->get_items(0, $maxitems); 
			endif;
		
			if ($maxitems == 0) echo '<li>No items.</li>';
			else
			// Loop through each feed item and display each item as a hyperlink.
			foreach ( $rss_items as $item ) : 	
				$title = $item->get_item_tags('','title');
				$titledata = $title[0]['data'];
				$description = $item->get_item_tags('','description');
				$descriptiondata = $description[0]['data'];
				$rt = strpos($descriptiondata, 'RT');
				$descriptiondata = str_replace($username.': ', '', $descriptiondata);	
				// $descriptiondata = preg_replace_callback('|http://([a-z0-9?./=%#]{1,500})|i', 'shorten_url', $descriptiondata);	
				$descriptiondata = preg_replace_callback('|http://([a-z0-9?\-_./=%#]{1,500})|i', 'shorten_url', $descriptiondata);
				// Link up @ Links
				$descriptiondata = preg_replace('/@(\w+)/', '@<a rel="nofollow" href="http://www.twitter.com/$1" title="Follow $1 on Twitter">$1</a>', $descriptiondata);
				// Replace @username with link to Twitter
				// $descriptiondata = preg_replace('|http://([a-z0-9?./=%#]{1,500})|i', '<a rel="nofollow" target="_blank" href=https://twitter.com/#!/$mentionedUser>@$mentionUser</a>', $descriptiondata);
				// Insert RT Icon
				$templateurl = get_bloginfo("template_url");
				// $descriptiondata = str_replace('RT', '<span class="rt-icon"><img src="'.get_bloginfo("template_url").'/inc/img/RT.png" height="16" width="16" alt=" " /><span> RT</span></span>', $descriptiondata);
				echo ' '. $descriptiondata .' <br />';
				echo 'Tweeted '.$item->get_date('j.n.y | g:i a') .' <br /><br />';
				endforeach;
} ?>