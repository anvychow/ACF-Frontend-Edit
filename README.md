ACF-Frontend-Edit
=================
Janky Front End Editing for Wordpress + Advanced Custom Fields
-----------------

1. Install ACF
2. Add Fields
3. When adding fields to your theme, you must give the field an ID that is equivalent to the field name, and a class of "editable-field"
eg
```<div id="title" class="editable-field"><?php the_field("title"); ?></div>```
4. Add the following id and class to your the_content and the_title, and they become editable!
eg
```	<h1 id="the-title" class="editable-field"><?php the_title(); ?></h1>```
```<div id="the-content" class="editable-field"><?php the_content(); ?></div>```


-- August 6th 2013 --
Version: 0.1.1

* Added support for the_content and the_title
* Started using tinyMCE.triggersave(); - other code could probably be refactored using this
* Issue: Had to make an altered version of acf_form(); - acf_form_finch();

-- Sometime in July 2013 --
Version: 0.1.0

* Converted to a crappy plugin
