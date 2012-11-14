<?php
/*
Plugin Name: ZOMIGOSH
Plugin URI: http://github.com/rclosner/zomigosh
Description: Adds a widget with tweets from a public timeline - loaded in JS.
Version: 0.1
Author: Ryan Closner
Author URI: http://ryanclosner.com
*/

// Initialize the plugins directory
define( 'ZMG_ABS_URL',  WP_CONTENT_URL . '/plugins/' . plugin_basename( dirname(__FILE__) ) . '/' );
define( 'ZMG_REL_URL',  dirname( plugin_basename(__FILE__) ) );
define( 'ZMG_ABS_PATH', WP_PLUGIN_DIR . '/' . plugin_basename( dirname(__FILE__) ) . '/' );

class ZOMIGOSH extends WP_Widget {

  function ZOMIGOSH() {
    $widget_opts = array( 'classname' => 'widget_zomigosh', 'description' => 'Displays latest tweets' );
    $this->WP_Widget( 'ZOMIGOSH', 'ZOMIGOSH', $widget_opts );
  }

  function widget($args, $instance) {
    extract($args);

    $title         = esc_attr( $instance['title'] );
    $username      = esc_attr( $instance['username'] );
    $avatar_size   = esc_attr( $instance['avatar_size'] );
    $num_of_tweets = esc_attr( $instance['num_of_tweets'] );
    $loading_text  = esc_attr( $instance['loading_text'] );

    ?>
      <?php echo $before_widget; ?>
        <?php if ( ! empty($title) ) {
          echo $before_title . $title . $after_title;
        }?>
        <div class="tweets"></div>
      <?php echo $after_widget; ?>

      <script type="text/javascript" charset="utf-8">
        jQuery(function($) {
          $(".tweets").tweet({
            username:     "<?php echo($username); ?>",
            join_text:    "auto",
            avatar_size:  "<?php echo($avatar_size); ?>",
            count:        <?php echo($num_of_tweets); ?>,
            loading_text: "<?php echo($loading_text); ?>"
          });
        });
      </script>
    <?php
  }

  function update($new_instance, $old_instance) {
    return $new_instance;
  }

  function form($instance) {
    $title         = esc_attr( $instance['title'] );
    $username      = esc_attr( $instance['username'] );
    $avatar_size   = esc_attr( $instance['avatar_size'] );
    $num_of_tweets = esc_attr( $instance['num_of_tweets'] );
    $loading_text  = esc_attr( $instance['loading_text'] );

    ?>
      <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
      </p>

      <p>
        <label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Username:'); ?></label>
        <input type="text" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" value="<?php echo $username; ?>" />
      </p>

      <p>
        <label for="<?php echo $this->get_field_id('avatar_size'); ?>"><?php _e('Avatar Size:'); ?></label>
        <input type="text" id="<?php echo $this->get_field_id('avatar_size'); ?>" name="<?php echo $this->get_field_name('avatar_size'); ?>" value="<?php echo $avatar_size; ?>" />
      </p>

      <p>
        <label for="<?php echo $this->get_field_id('num_of_tweets'); ?>"><?php _e('Number of Tweets to Display'); ?></label>
        <input type="text" id="<?php echo $this->get_field_id('num_of_tweets'); ?>" name="<?php echo $this->get_field_name('num_of_tweets'); ?>" value="<?php echo $num_of_tweets ?>" />
      </p>

      <p>
        <label for="<?php echo $this->get_field_id('loading_text'); ?>"><?php _e('Loading Text:'); ?></label>
        <input type="text" id="<?php echo $this->get_field_id('loading_text'); ?>" name="<?php echo $this->get_field_name('loading_text'); ?>" value="<?php echo $loading_text; ?>" />
      </p>

    <?php
  }
}

function ZMGInit() {
  wp_register_script('zmg-twitter', (ZMG_ABS_URL . 'js/jquery.tweet.js'), array('jquery'), '', true);
  wp_enqueue_script('zmg-twitter');

  return register_widget("ZOMIGOSH");
}

add_action('widgets_init', 'ZMGInit')

?>
