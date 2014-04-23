<?php
// add_action("widgets_init", array('TopRatedProductsWidget', 'register') );
class TopRatedProductsWidget extends WP_Widget 
{
	function __construct() {
		$widget_ops = array('classname' => 'TopRatedProductsWidget', 'description' => __(''));
		$control_ops = array('width' => 400, 'height' => 350);
		parent::__construct('TopRatedProductsWidget', __('Top Rated Products'), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, trpw_default() );
		
		// print_r($instance);
		$title 					= strip_tags($instance['title']);
		$showposts				= strip_tags($instance['showposts']);
		$tags					= strip_tags($instance['tags']);
		$cat 					= strip_tags($instance['cat']);
		$orderby				= strip_tags($instance['orderby']);
		$order					= strip_tags($instance['order']);
		$show_buy_button		= strip_tags($instance['show-buy-button']);
		$show_read_more_button	= strip_tags($instance['show-read-more-button']);
		$show_star_ratings		= strip_tags($instance['show-star-ratings']);
		
		// Order by 	
		$orderby_array = array("meta_value" => "Post Rank","title" => "Title", "date" => "Date", "ID" => "ID", "rand" => "Random", "comment_count" => "Comment Count");

		// Order by type
		$order_array = array("asc" => "Ascending ( A-Z )","desc" => "Descending ( Z-A )");
		
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>


		<p><label for="<?php echo $this->get_field_id('showposts'); ?>"><?php _e('Number of posts to show:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('showposts'); ?>" name="<?php echo $this->get_field_name('showposts'); ?>" type="text" value="<?php echo esc_attr($showposts); ?>" /></p>
		<p><label for="<?php echo $this->get_field_id('cat'); ?>"><?php _e('Category To Use:'); ?></label><?php 
			$args = array( 
							'name'		=>	$this->get_field_name('cat'),
							'selected' 	=> 	$cat,
						);
			wp_dropdown_categories( $args ); 
		?></p>

		<p><label for="<?php echo $this->get_field_id('tags'); ?>"><?php _e('Posts Tagged With:'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('tags'); ?>" name="<?php echo $this->get_field_name('tags'); ?>" type="text" value="<?php echo esc_attr($tags); ?>" /></p>

		<p><label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Order By:'); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>" >
			<?php foreach($orderby_array as $key=>$value ) { ?>
			<option value="<?php echo $key;?>" <?php echo $orderby=="$key"?'selected="selected"':'';?> ><?php echo $value;?></option>
			<?php } ?>
		</select></p>

		<p><label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Order Type:'); ?></label>
		<select class="widefat" id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>" >
			<?php foreach($order_array as $key=>$value ) { ?>
			<option value="<?php echo $key;?>" <?php echo $order=="$key"?'selected="selected"':'';?> ><?php echo $value;?></option>
			<?php } ?>
		</select></p>
		
		<p><label for="<?php echo $this->get_field_id('show-buy-button'); ?>"><input type="checkbox" id="<?php echo $this->get_field_id('show-buy-button'); ?>" name="<?php echo $this->get_field_name('show-buy-button'); ?>"  value="yes" <?php echo $show_buy_button=='yes'?'checked="checked"':'';?> ><?php _e('Show Buy Button'); ?></label>

		<p><label for="<?php echo $this->get_field_id('show-read-more-button'); ?>"><input type="checkbox" id="<?php echo $this->get_field_id('show-read-more-button'); ?>" name="<?php echo $this->get_field_name('show-read-more-button'); ?>"  value="yes" <?php echo $show_read_more_button=='yes'?'checked="checked"':'';?> ><?php _e('Show Read More Button'); ?></label>

		<p><label for="<?php echo $this->get_field_id('show-star-ratings'); ?>"><input type="checkbox" id="<?php echo $this->get_field_id('show-star-ratings'); ?>" name="<?php echo $this->get_field_name('show-star-ratings'); ?>"  value="yes" <?php echo $show_star_ratings=='yes'?'checked="checked"':'';?> ><?php _e(' Show Star Ratings'); ?></label>

		<?php
	}

	function update( $new_instance, $old_instance ) {
	
		$instance = $old_instance;
		$instance['title'] 					= strip_tags($new_instance['title']);
		$instance['showposts']				= strip_tags($new_instance['showposts']);
		$instance['tags']					= strip_tags($new_instance['tags']);
		$instance['cat']					= strip_tags($new_instance['cat']);
		$instance['orderby']				= strip_tags($new_instance['orderby']);
		$instance['order']					= strip_tags($new_instance['order']);
		$instance['show-buy-button']		= strip_tags($new_instance['show-buy-button']);
		$instance['show-read-more-button']	= strip_tags($new_instance['show-read-more-button']);
		$instance['show-star-ratings']		= strip_tags($new_instance['show-star-ratings']);

		return $instance;
	}

	function widget( $args, $instance ) 
	{
		extract($args);
		
		// plugin options
		$trp 					= get_option("trp",trp_default());
		
		$no_follow 				= $trp['no-follow'];
		$new_window				= $trp['new-window'];
		$buy_button_url 		= $trp['buy-button-url'];
		$read_more_button_url 	= $trp['read-more-button-url'];
		
		// get widget options
		$title 					= strip_tags($instance['title']);
		$showposts				= strip_tags($instance['showposts']);
		$tags					= strip_tags($instance['tags']);
		$cat 					= strip_tags($instance['cat']);
		$orderby				= strip_tags($instance['orderby']);
		$order					= strip_tags($instance['order']);
		$show_buy_button		= strip_tags($instance['show-buy-button']);
		$show_read_more_button	= strip_tags($instance['show-read-more-button']);
		$show_star_ratings		= strip_tags($instance['show-star-ratings']);


		if ($orderby =='meta_value')
		{
		 	$orderby = $orderby . '&meta_key=trp_aff_rank';
		}
		
		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; } 
		?>
		<div class="trp-sidebar">
			<?php
				$arg = array(
								'showposts' => $showposts,
								'cat'		=> $cat,
								'orderby'	=> $orderby,
								'order'		=> $order,
								'tag'		=> $tags
							);
				
				$topposts_query = new WP_Query($arg);
				while ($topposts_query->have_posts()) : $topposts_query->the_post(); 
					
					$trp_aff_url 	= get_post_meta(get_the_ID(), 'trp_aff_url', true); 
					$trp_aff_rating = get_post_meta(get_the_ID(), 'trp_aff_rating', true); 
					$image 			= wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail' ); // thumbnail, medium, large or full
					?>
					<!-- top product -->
					<div class="trp-sidebar-item">
						<div class="trp-sidebar-item-left">
							<a href="<?php echo $trp_aff_url; ?>" rel="nofollow"><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>"></a>
						</div>
							
						<div class="trp-sidebar-item-right">
							<div class="trp-sidebar-item-title" >
								<a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a>
							</div>
							<div class="trp-sidebar-item-rating" >
							<?php if($show_star_ratings=="yes" && $trp_aff_rating) { ?>
								<img src="<?php echo plugins_url( "images/{$trp_aff_rating}-star.png" , __FILE__ );?>"  border="0" />
							<?php } ?>
							</div>
							<div class="trp-sidebar-item-buttons" >
								<?php if($show_read_more_button=="yes") { ?><a class="readmore" href="<?php the_permalink(); ?>" ><img src="<?php echo $read_more_button_url;?>" class="readbtn" /></a><?php } ?><?php if($show_buy_button=="yes") { ?><a href="<?php echo $trp_aff_url; ?>" <?php echo ($no_follow=="yes")?'rel="nofollow"':'';?>  <?php echo ($new_window=="yes")?'target="_blank"':'';?> ><img src="<?php echo $buy_button_url;?>" class="buybtn" /></a><?php } ?>
							</div>
						</div>
						<div class="trp-item-clear"></div>
					</div>
					<div class="trp-clear"></div>
					<!-- end top product -->
					<?php 
				endwhile;
			?>
		</div>
		<?php
		echo $after_widget;

	}
}

function trp_widgets_init() 
{
	if ( !is_blog_installed() )
		return;
	register_widget('TopRatedProductsWidget');
}
add_action('init', 'trp_widgets_init', 1);



?>