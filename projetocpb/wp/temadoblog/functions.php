<?php
if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'before_title' => '<h3>',
        'after_title' => '</h3>',
    ));

function widget_mytheme_search() {
?>

<li id="search">
<form method="get" id="searchform" action="<?php bloginfo('home'); ?>/">
<input type="text" value="Pesquisa" name="s" id="s" onfocus="if (this.value == 'Pesquisa') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Pesquisa';}" />
</form>
</li>

<?php
}
if ( function_exists('register_sidebar_widget') )
    register_sidebar_widget(__('Pesquisa'), 'widget_mytheme_search');

?>