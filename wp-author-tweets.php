<?php
/**
 * @package WP Author Tweets
 */
/*
Plugin Name: WP Author's Tweets
Plugin URI: http://www.webdesigncreare.co.uk/blog/videos/wp-author-tweets.html
Description: Gives you the ability to add your Twitter username to Author profile and display latest tweets.
Version: 1.2
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
   return '<a rel="nofollow" target="_blank" href="'.wp_remote_retrieve_body(wp_remote_get($url)).'">'.wp_remote_retrieve_body(wp_remote_get($url)).'</a>'; } 
}

function getLatestTweetWP() {
	$tweet_list_id = get_option('tweet_list_id'); // if no ID assigned, echo out <ul>
		if($tweet_list_id == false) {
			$list_id = "<ul>";
		} else { 
			$tweet_id = get_option('tweet_list_id');
			$list_id = '<ul id="'. $tweet_id .'">';	 
		}
	$tweeted = stripslashes(get_option('tweeted_title'));
	$bad_chars = array("\\", "'", "''", "\"", ";", ":", "/", "//", "|", );
	$escape_chars   = array("");
	$tweeted_new = str_replace($bad_chars, $escape_chars, $tweeted); // Replace any bad chars with nothing, if not used, default is 'Tweeted'
	if($tweeted_new == false) {
		$tweeted_new = "Tweeted";
	}
	$tweets_default_user = get_option('tweets_default_user'); // get default username
	$tweets_default_count = get_option('tweets_default_count'); // get default number of tweets
		if(!empty($contactmethods['twitter'])) {
			$username = get_the_author_meta('twitter');
		} else { 
			$username = $tweets_default_user; 
		}
		if(!empty($contactmethods['twitter'])) {
			$numtweets = get_the_author_meta('twitter_count');
		} else {
			$numtweets = $tweets_default_count; 
		}
	$rss = fetch_feed('http://api.twitter.com/1/statuses/user_timeline.rss?screen_name=' .$username. ''); // get out twitter feed
			if (!is_wp_error( $rss ) ) : // Checks that the object is created correctly 
				$maxitems = $rss->get_item_quantity($numtweets); // defines number of tweets
				$rss_items = $rss->get_items(0, $maxitems); // build array of tweets
			endif;
			if ($maxitems == 0) echo '<li>No items.</li>'; // if no twitter user information entered
			else // loop through tweets
				echo $list_id; // open ul tag with or without ID
					foreach ( $rss_items as $item ) : 	
						$title = $item->get_item_tags('','title');
						$titledata = $title[0]['data'];
						$description = $item->get_item_tags('','description');
						$descriptiondata = $description[0]['data'];
						$rt = strpos($descriptiondata, 'RT');
						$descriptiondata = str_replace($username.': ', '', $descriptiondata);	
						// $descriptiondata = preg_replace_callback('|http://([a-z0-9?./=%#]{1,500})|i', 'shorten_url', $descriptiondata);	 
						$descriptiondata = preg_replace_callback('|http://([a-z0-9?\-_./=%#]{1,500})|i', 'shorten_url', $descriptiondata); 
						// $descriptiondata = preg_replace('/@(\w+)/', '@<a rel="nofollow" href="http://www.twitter.com/$1" title="Follow $1 on Twitter">$1</a>', $descriptiondata); // use for email link up (mailto:)
						$descriptiondata = preg_replace('/( @|^@)(\w+)/', '$1<a rel="nofollow" href="http://www.twitter.com/$2" title="Follow $2 on Twitter">$2</a>', $descriptiondata); // fixes the username in an email address problem // Link up @ Links
						$descriptiondata = preg_replace('/( #|^#)(\w+)/', '$1<a rel="nofollow" href="https://twitter.com/#!/search?q=%23$2" title="$2">$2</a>', $descriptiondata); // links up #hashtags and trends
				
				$templateurl = get_bloginfo("template_url"); // Insert RT Icon
				// $descriptiondata = str_replace('RT', '<span class="rt-icon"><img src="'.get_bloginfo("template_url").'/inc/img/RT.png" height="16" width="16" alt=" " /><span> RT</span></span>', $descriptiondata); // use this when integrate cutom RT icon
				echo '<li><p class="wp_tweet_text"> '. $descriptiondata .' </p>'; // echo tweets content
				echo '<p ="wp_tweet_date">'. $tweeted_new .': '.$item->get_date('j.n.y | g:i a') .' </p></li>'; // echo time and date
				endforeach;
				echo "</ul>"; // closing ul tag
} ?>