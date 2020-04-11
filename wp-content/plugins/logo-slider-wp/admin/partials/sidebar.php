<?php
if (!defined('WPINC')) {
    die;
}
?>
<div id="postbox-container-1" class="postbox-container">
    <div class="meta-box-sortables">

        <div class="postbox">
            <h3>Plugin Info</h3>
            <div class="inside">
                <p>Plugin Name : <?php echo $plugin_data['Title']; ?> <?php echo $plugin_data['Version']; ?></p>
                <p>Author : <?php echo $plugin_data['Author'] ?></p>
                <p>Website : <a href="http://logichunt.com" target="_blank">logichunt.com</a></p>
            </div>
        </div>

        <div class="postbox">
            <h3>Help & Supports</h3>
            <div class="inside">
                <p>Support : <a class="button" href="http://logichunt.com/support/" target="_blank">Support</a></p>
                <p>website : <a class="button" href="http://logichunt.com/contact-us" target="_blank">Website</a></p>
                <p>Donate Link: <a class="button button-primary" href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=vaspal%2ekt%40gmail%2ecom&lc=US&item_name=LogicHunt&item_number=wp&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHosted" target="_blank">Donate Now</a></p>
                <p>Your contribution always helps us to be more serious and supportive.</p>
            </div>
        </div>

        <div class="postbox">
            <h3><?php _e('More from LogicHunt', 'logo-slider-wp'); ?></h3>
            <div class="inside">
                <?php
                include_once(ABSPATH . WPINC . '/feed.php');
                if (function_exists('fetch_feed')) {
                    $feed = fetch_feed('http://logichunt.com/feed?post_type=product');
                    // $feed = fetch_feed('http://feeds.feedburner.com/logichunt'); // this is the external website's RSS feed URL
                    if (!is_wp_error($feed)) : $feed->init();
                        $feed->set_output_encoding('UTF-8'); // this is the encoding parameter, and can be left unchanged in almost every case
                        $feed->handle_content_type(); // this double-checks the encoding type
                        $feed->set_cache_duration(21600); // 21,600 seconds is six hours
                        $limit = $feed->get_item_quantity(6); // fetches the 18 most recent RSS feed stories
                        $items = $feed->get_items(0, $limit); // this sets the limit and array for parsing the feed

                        $blocks = array_slice($items, 0, 6); // Items zero through six will be displayed here

                        echo '<ul>';

                        foreach ($blocks as $block) {
                            $url = $block->get_permalink();

                            echo '<li style="clear:both;  margin-bottom:5px;"><a target="_blank" href="' . $url . '">';
                            //echo '<img style="float: left; display: inline; width:70px; height:70px; margin-right:10px;" src="http://logichunt.com/wp-content/uploads/productshots/'.$id.'-profile.png" alt="logichuntplugins" />';
                            echo '<strong>' . $block->get_title() . '</strong></a></li>';
                        }//end foreach

                        echo '</ul>';


                    endif;
                }
                ?>
            </div>
        </div>

        <div class="postbox">
            <h3>LogicHunt Updates</h3>
            <div class="inside">
                <?php
                include_once(ABSPATH . WPINC . '/feed.php');
                if (function_exists('fetch_feed')) {
                    $feed = fetch_feed('http://logichunt.com/feed');
                    // $feed = fetch_feed('http://feeds.feedburner.com/logichunt'); // this is the external website's RSS feed URL
                    if (!is_wp_error($feed)) : $feed->init();
                        $feed->set_output_encoding('UTF-8'); // this is the encoding parameter, and can be left unchanged in almost every case
                        $feed->handle_content_type(); // this double-checks the encoding type
                        $feed->set_cache_duration(21600); // 21,600 seconds is six hours
                        $limit = $feed->get_item_quantity(6); // fetches the 18 most recent RSS feed stories
                        $items = $feed->get_items(0, $limit); // this sets the limit and array for parsing the feed

                        $blocks = array_slice($items, 0, 6); // Items zero through six will be displayed here
                        echo '<ul>';
                        foreach ($blocks as $block) {
                            $url = $block->get_permalink();
                            echo '<li><a target="_blank" href="' . $url . '">';
                            echo '<strong>' . $block->get_title() . '</strong></a></li>';
                            //echo $block->get_description();
                            //echo substr($block->get_description(),0, strpos($block->get_description(), "<br />")+4);
                        }//end foreach
                        echo '</ul>';


                    endif;
                }
                ?>
            </div>
        </div>
        <div class="postbox">
            <div class="inside">
                <h3><?php _e('LogicHunt Networks', 'logo-slider-wp') ?></h3>
                <p><a target="_blank" href="http://logichunt.com">LogicHunt</a>: Joomla and Worpress Plugin, Extensions, Theme.</p>
	            <p><a target="_blank" href="http://logichunt.com">ThemEarth</a>: Themes & Templates.</p>
	            <p><a target="_blank" href="http://joomlahunt.com">JoomlaHunt</a>: Joomla Extensions Demo.</p>
            </div>
        </div>

        <div class="postbox">
            <h3>LogicHunt on Facebook</h3>
            <div class="inside">
                <iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Flogichunt&amp;width=260&amp;height=258&amp;show_faces=true&amp;colorscheme=light&amp;stream=false&amp;border_color&amp;header=false&amp;appId=983646805075474" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:260px; height:258px;" allowTransparency="true"></iframe>
            </div>
        </div>

    </div> <!-- .meta-box-sortables -->

</div> <!-- #postbox-container-1 .postbox-container -->