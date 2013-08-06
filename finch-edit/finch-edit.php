<?php
/*
Plugin Name: Finch Edit
Plugin URI: http://www.tando.us
Description: Front End Editor for Advanced Custom Fields
Version: 0.1.1
Author: Troy Thompson
Author URI: http://www.tando.us
License: GPL2
*/
/*  Copyright 2013  Troy Thompson  (email : troyrthompson@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


/*Remove wp-admin styles from frontend */
add_action( 'wp_print_styles', 'my_deregister_styles', 100 );
 function my_deregister_styles() {
	wp_deregister_style( 'wp-admin' );
}

function tt_edit_button($fieldname, $extraclass) {
		if (is_super_admin()){

			$titleid1 = get_field_object($fieldname);
			$titleid = $titleid1["name"];

			if (is_null($extraclass)){
				echo "<a class='edit-link' href='#acf-";
				echo $titleid;
				echo "'>Edit</a>";
			}else{
				echo "<a class='edit-link ";
				echo $extraclass;
				echo "' href='#acf-";
				echo $titleid;
				echo "'>Edit</a>";
			}
		} 
}
/* Get ACF image */
function tt_get_image($fieldname, $imgsize){

		$attachment_id = get_field($fieldname);
		$image = wp_get_attachment_image_src( $attachment_id, $imgsize );
		echo '<img class="editable-field" id="';
		echo $fieldname;
		echo '" src="';
		echo $image[0];
		echo '" />';

}

/*acf form head - admin check */
function acfAdminCheck(){
	if (is_super_admin()){
 acf_form_head();
		
	}
}
function acfAdminForm(){
	if (is_super_admin()){
		echo "<div id='editform'><div class='formhandle'><div id='formcancel' class='cancel-button'>X</div></div>";
		acf_form_finch();
		echo "</div>";
	}
}
add_action('get_header', 'acfAdminCheck');
add_action('get_footer', 'acfAdminForm');


function finch_scripts() {
if (is_super_admin()){
	
	wp_enqueue_style( 'finch-styles', plugins_url() . '/finch-edit/finch-styles.css' );
  wp_register_script('finch-app', plugins_url() . '/finch-edit/finch-app.js', false, null, true);
 
  wp_enqueue_script('finch-app');

}
}
add_action('wp_enqueue_scripts', 'finch_scripts', 100);

function finch_content(){
	global $post;
    if ( ! wp_is_post_revision( $post->ID ) ){

        // unhook this function so it doesn't loop infinitely
        remove_action('save_post', 'finch_content');

        // update the post, which calls save_post again
        $post = array(
                'ID' => $post->ID,
                'post_title' => $_POST['userposttitle'],
                'post_content' => $_POST['userpostcontent']
                );
        wp_update_post( $post );

        // re-hook this function
        add_action('save_post', 'finch_content');
    }
}
add_action('acf/save_post', 'finch_content');

function acf_form_finch( $options = array() )
{
	global $post;
	
	
	// defaults
	$defaults = array(
		'post_id' => false,
		'field_groups' => array(),
		'form' => true,
		'form_attributes' => array(
			'id' => 'post',
			'class' => '',
			'action' => '',
			'method' => 'post',
		),
		'return' => add_query_arg( 'updated', 'true', get_permalink() ),
		'html_before_fields' => '',
		'html_after_fields' => '',
		'submit_value' => __("Update", 'acf'),
		'updated_message' => __("Post updated", 'acf'), 
	);
	
	
	// merge defaults with options
	$options = array_merge($defaults, $options);
	
	
	// merge sub arrays
	foreach( $options as $k => $v )
	{
		if( is_array($v) )
		{
			$options[ $k ] = array_merge($defaults[ $k ], $options[ $k ]);
		}
	}
	
	
	// filter post_id
	$options['post_id'] = apply_filters('acf/get_post_id', $options['post_id'] );
	
	
	// attributes
	$options['form_attributes']['class'] .= 'acf-form';
	
	
	
	// register post box
	if( empty($options['field_groups']) )
	{
		// get field groups
		$filter = array(
			'post_id' => $options['post_id']
		);
		
		
		if( strpos($options['post_id'], 'user_') !== false )
		{
			$user_id = str_replace('user_', '', $options['post_id']);
			$filter = array(
				'ef_user' => $user_id
			);
		}
		elseif( strpos($options['post_id'], 'taxonomy_') !== false )
		{
			$taxonomy_id = str_replace('taxonomy_', '', $options['post_id']);
			$filter = array(
				'ef_taxonomy' => $taxonomy_id
			);
		}
		
		
		$options['field_groups'] = array();
		$options['field_groups'] = apply_filters( 'acf/location/match_field_groups', $options['field_groups'], $filter );
	}


	// updated message
	if(isset($_GET['updated']) && $_GET['updated'] == 'true' && $options['updated_message'])
	{
		echo '<div id="message" class="updated"><p>' . $options['updated_message'] . '</p></div>';
	}
	
	
	// display form
	if( $options['form'] ): ?>
	<form <?php if($options['form_attributes']){foreach($options['form_attributes'] as $k => $v){echo $k . '="' . $v .'" '; }} ?>>
	<?php endif; ?>
	
	<div style="display:none">
		<input type="hidden" name="acf_nonce" value="<?php echo wp_create_nonce( 'input' ); ?>" />
		<input type="hidden" name="post_id" value="<?php echo $options['post_id']; ?>" />
		<input type="hidden" name="return" value="<?php echo $options['return']; ?>" />
		<?php wp_editor('', 'acf_settings'); ?>
	</div>
	
	<div id="poststuff">
	<?php
	
	// html before fields
	echo $options['html_before_fields'];
	
	
	$acfs = apply_filters('acf/get_field_groups', array());
	
	if( is_array($acfs) ){ foreach( $acfs as $acf ){
		
		// only add the chosen field groups
		if( !in_array( $acf['id'], $options['field_groups'] ) )
		{
			continue;
		}
		
		
		// load options
		$acf['options'] = apply_filters('acf/field_group/get_options', array(), $acf['id']);
		
		
		// load fields
		$fields = apply_filters('acf/field_group/get_fields', array(), $acf['id']);
		
		
		echo '<div id="acf_' . $acf['id'] . '" class="postbox acf_postbox ' . $acf['options']['layout'] . '">';
		echo '<h3 class="hndle"><span>' . $acf['title'] . '</span></h3>';
		echo '<div class="inside">';
							
		do_action('acf/create_fields', $fields, $options['post_id']);

		echo '<div id="acf-the-title" class="field">';
		$titlez = get_the_title();
		echo "<input name='userposttitle' type='text' value='".$titlez."'></input>";
		echo "</div>";

		echo '<div id="acf-the-content" class="field">';
		$shtuff = get_the_content();

		wp_editor($post->post_content, 'userpostcontent', array( 'textarea_name' => 'userpostcontent' ) );
		echo "</div>";
		echo '</div></div>';
		
	}}
	
	
	// html after fields
	echo $options['html_after_fields'];
	
	?>
	
	<?php if( $options['form'] ): ?>
	<!-- Submit -->
	<div class="field">
		<input type="submit" value="<?php echo $options['submit_value']; ?>" />
	</div>
	<!-- / Submit -->
	<?php endif; ?>
	
	</div><!-- <div id="poststuff"> -->
	
	<?php if( $options['form'] ): ?>
	</form>
	<?php endif;
}
?>