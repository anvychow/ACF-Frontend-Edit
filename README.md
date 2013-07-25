ACF-Frontend-Edit
=================

Janky Front End Editing for Wordpress + Advanced Custom Fields

1. Install ACF
2. Add Fields
3. When adding fields to your theme, you must give the field an ID that is equivalent to the field name, and a class of "editable-field"
eg
<div id="title" class="editable-field"><?php the_field("title"); ?></div>
