<?php
/*
Plugin Name: Finch Edit
Plugin URI: http://www.tando.us
Description: Front End Editor for Advanced Custom Fields
Version: 0.1
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
		acf_form();
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
?>