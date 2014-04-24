<?php

add_action( 'add_meta_boxes', 'trp_meta_box_add' );
function trp_meta_box_add()
{
	add_meta_box( 'top-rated-products', 'Affiliate Settings', 'trp_meta_box', 'post', 'normal', 'high' );

}

function trp_meta_box( $post )
{
	$values = get_post_custom( $post->ID );

	$url = isset( $values['trp_aff_url'] ) ? esc_attr( $values['trp_aff_url'][0] ) : '';
	$rating = isset( $values['trp_aff_rating'] ) ? esc_attr( $values['trp_aff_rating'][0] ) : '';
	$rank = isset( $values['trp_aff_rank'] ) ? esc_attr( $values['trp_aff_rank'][0] ) : '';
	
	?>
	<p>
		<label for="trp_aff_url"><strong>Affiliate URL</strong></label><br>
		<textarea type="text" name="trp_aff_url" id="trp_aff_url" style="width:95%" ><?php echo $url; ?></textarea>
	</p>
	<p>
		<label for="trp_aff_rating"><strong>Star Rating</strong></label><br>
		<select name="trp_aff_rating" id="trp_aff_rating" style="width:200px;">
        	<option value="" <?php trp_selected( $rating, '' ); ?>> -- Select -- </option>
			<option value="1" <?php trp_selected( $rating, '1' ); ?>>1</option>
            <option value="1.5" <?php trp_selected( $rating, '1.5' ); ?>>1.5</option>
			<option value="2" <?php trp_selected( $rating, '2' ); ?>>2</option>
            <option value="2.5" <?php trp_selected( $rating, '2.5' ); ?>>2.5</option>
            <option value="3" <?php trp_selected( $rating, '3' ); ?>>3</option>
            <option value="3.5" <?php trp_selected( $rating, '3.5' ); ?>>3.5</option>
            <option value="4" <?php trp_selected( $rating, '4' ); ?>>4</option>
            <option value="4.5" <?php trp_selected( $rating, '4.5' ); ?>>4.5</option>
            <option value="5" <?php trp_selected( $rating, '5' ); ?>>5</option>
		</select>
	</p>
	<p>
		<label for="trp_aff_rank"><strong>Rank</strong></label><br>
		<select name="trp_aff_rank" id="trp_aff_rank" style="width:200px;">
        	<option value="" <?php trp_selected( $rank, '' ); ?>> -- Select -- </option>
			<?php for($x=1;$x<=20;$x++) { ?>
			<option value="<?php echo $x;?>" <?php trp_selected( $rank, "$x" ); ?>><?php echo $x;?></option>
			<?php } ?>
		</select>
	</p>
	<?php	
}

add_action( 'save_post', 'trp_meta_box_save' );
function trp_meta_box_save( $post_id )
{
	// Bail if we're doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	
	// if our current user can't edit this post, bail
	if( !current_user_can( 'edit_post' ) ) return;
	
	// now we can actually save the data
	$allowed = array( 
					'a' => array( // on allow a tags
						'href' => array() // and those anchords can only have href attribute
							)
					);
	$allowed = array( );
	
	// AFFILIATE SETTINGS
	
	// Probably a good idea to make sure your data is set
	if( isset( $_POST['trp_aff_url'] ) )
		update_post_meta( $post_id, 'trp_aff_url', wp_kses( $_POST['trp_aff_url'], $allowed ) );
		
	if( isset( $_POST['trp_aff_rating'] ) )
		update_post_meta( $post_id, 'trp_aff_rating', esc_attr( $_POST['trp_aff_rating'] ) );
		
	if( isset( $_POST['trp_aff_rank'] ) )
		update_post_meta( $post_id, 'trp_aff_rank', esc_attr( $_POST['trp_aff_rank'] ) );

}

?>