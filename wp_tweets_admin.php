<?php if($_POST['tweets_hidden'] == "Y") {	
	// On form submit
	$tweets_default_user = $_POST['tweets_default_user'];
	update_option( 'tweets_default_user', $tweets_default_user );
	$tweets_default_count = $_POST['tweets_default_count'];
	update_option( 'tweets_default_count', $tweets_default_count ); 
    $tweeted_title = $_POST['tweeted_title'];
	update_option( 'tweeted_title', $tweeted_title );
	$tweet_list_id = $_POST['tweet_list_id'];
	update_option( 'tweet_list_id', $tweet_list_id ); ?>
<div class="updated">
  <p><strong>
    <?php _e('Options saved.' ); ?>
    </strong></p>
</div>
<?php } else {
	// Normal page view
	$tweeted_title = get_option('tweeted_title');
	$tweet_list_id = get_option('tweet_list_id');
	$tweets_default_user = get_option('tweets_default_user');
	$tweets_default_count = get_option('tweets_default_count');
} ?>
<div class="wrap"><?php echo "<h2>" . __( 'WP Author\'s Tweets Options', 'tweets_opt' ) . "</h2>"; ?>
  <p>Add a default twitter username and show count below.</p>
  <form name="tweets_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    <input type="hidden" name="tweets_hidden" value="Y">
    <table class="form-table">
      <tbody>
        <tr valign="top">
          <th scope="row"><label for="tweets_default_user">Default Twitter Username:</label></th>
          <td><input type="text" name="tweets_default_user" value="<?php echo $tweets_default_user; ?>" size="30">
            <span class="description">Adding a default username will overwrite all empty Authors Tweet settings</span></td>
        </tr>
        <tr valign="top">
          <th scope="row"><label for="tweets_default_count">Number of tweets:</label></th>
          <td><input type="text" name="tweets_default_count" value="<?php echo $tweets_default_count; ?>" size="20">
            <span class="description">Enter a number of how many latest tweets you want to show.</span></td>
        </tr>
        <tr valign="top">
          <th scope="row"><label for="tweeted_title">Tweeted Title:</label></th>
          <td><input type="text" name="tweeted_title" value="<?php echo $tweeted_title; ?>" size="20">
            <span class="description">Shows the title 'Tweeted:' by default. Change accordingly. You cannot change the ':'</span></td>
        </tr>
        <tr valign="top">
          <th scope="row"><label for="tweet_list_id">Tweet List ID:</label></th>
          <td><input type="text" name="tweet_list_id" value="<?php echo $tweet_list_id; ?>" size="20">
            <span class="description">By default there is no ID on the latest tweets UL</span></td>
        </tr>
      </tbody>
    </table>
    <p class="submit">
      <input type="submit" name="Submit" value="<?php _e('Update Options', 'tweets_opt' ) ?>" />
    </p>
  </form>
  <h3>Usage Instructions</h3>
  <p>When using this plugin there are a variety of options you can choose from. You can either set a a different 'follow me' button and twitter feed for each author on your blog, or set a default username and count here to overwrite all authors profiles.</p>
  <p>To use the plugin simply enter your twitter username and how many tweets you'd like to be shown on your user profile page. If you want to use a default username and count, simply enter the information above.</p>
  <p>Please note, default username and count WILL overwrite any author's details you have entered.</p>
  <p>The codes to use are as follows:</p>
  <style type="text/css">
code { padding:5px 10px; border:1px dashed #ccc }
dd { margin:10px 10px 15px; }
</style>
  <dl>
    <dt><strong>Follow me</strong> <em>(the code below will add a 'follow me' button to your blog posts)</em></dt>
    <dd><code>&lt;?php echo get_followme(); ?&gt;</code></dd>
    <dt><strong>Twitter feed</strong> <em>(the code below will add a twitter feed to your blog posts)</em></dt>
    <dd><code>&lt;?php echo getLatestTweetWP(); ?&gt;</code></dd>
  </dl>
</div>