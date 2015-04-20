<?php get_header(); ?>

	<div class="maincolumn">

		<div id="menu">

			<ul>

				<li><a href="<?php bloginfo('rss2_url') ?>" title="Subscrever via RSS"><span class="feed">RSS</span></a></li>

			</ul>

		</div>

		<div id="content">



			<div class="clear"></div>





			<?php while(have_posts()) : the_post(); ?>

			<div class="post" id="post-<?php the_ID(); ?>">

				<div class="entry-head">

					<h2><span class="entry-date alignright"><?php the_time('d-m-Y'); ?></span><?php the_title(); ?></h2>

				</div>

				<div class="entry-wrap">

					<div class="entry-content">

						<?php the_content(); ?>

						<?php wp_link_pages('<p><strong>Paginas:</strong> ', '</p>', 'number'); ?>

						<?php edit_post_link('Editar', '<p>', '</p>'); ?>

						<!-- <?php trackback_rdf(); ?> -->



						<div id="comments">

							<?php comments_template(); ?>

						</div>



					</div>

					<div class="rc"></div>

				</div>

			</div>

			<?php endwhile; ?>



		</div>

	</div>