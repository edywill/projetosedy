	<div class="sidebar">

		<ul>

			<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : // begin primary sidebar widgets ?>

			<li id="search">
				<form method="get" id="searchform" action="<?php bloginfo('home'); ?>/">
				<input type="text" value="Pesquisar..." name="s" id="s" onfocus="if (this.value == 'Pesquisar...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Pesquisar...';}" />
				</form>
			</li>

			<?php wp_list_categories('show_count=0&hierarchical=1&title_li=<h3>' . __('Categorias') . '</h3>') ?> 

			<li id="archives">
				<h3><?php _e('Arquivos') ?></h3>
				<ul>
					<?php wp_get_archives('type=monthly') ?>
				</ul>
			</li>

			<?php wp_list_bookmarks('title_before=<h3>&title_after=</h3>') ?>

			<li id="meta">
				<h3><?php _e('Meta'); ?></h3>
				<ul>
					<?php wp_register() ?>
					<li><?php wp_loginout() ?></li>
					<?php wp_meta() ?>
				</ul>
			</li>

			<?php endif; ?>

		</ul>

	</div>