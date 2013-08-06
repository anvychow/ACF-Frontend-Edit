=== Plugin Name ===
Contributors: Troy Thompson
Donate link: http://tando.us/
Tags: Advanced Custom Fields, Front End Editor
Requires at least: 3.5.2
Tested up to: 3.5.2
Stable tag: 1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Front end editor for advanced custom fields

== Description ==

Front end editor for advanced custom fields

== Installation ==

1. Install ACF
2. Add Fields
3. When adding fields to your theme, you must give the field an ID that is equivalent to the field name, and a class of "editable-field"
eg
```<div id="title" class="editable-field"><?php the_field("title"); ?></div>```
4. Add the following id and class to your the_content and the_title, and they become editable!
eg
```	<h1 id="the-title" class="editable-field"><?php the_title(); ?></h1>
	<div id="the-content" class="editable-field"><?php the_content(); ?></div>```

== Frequently Asked Questions ==

= Q =

A

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets 
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png` 
(or jpg, jpeg, gif).


== Changelog ==

= 0.1.1 =
* Added support for the_content and the_title
* Started using tinyMCE.triggersave(); - other code could probably be refactored using this
* Issue: Had to make an altered version of acf_form(); - acf_form_finch();

= 0.1.0 =
* Converted to a crappy plugin

== Upgrade Notice ==

= 0.1.1 =
Allows for native WP field front end editing.

== Arbitrary section ==

You may provide arbitrary sections, in the same format as the ones above.  This may be of use for extremely complicated
plugins where more information needs to be conveyed that doesn't fit into the categories of "description" or
"installation."  Arbitrary sections will be shown below the built-in sections outlined above.