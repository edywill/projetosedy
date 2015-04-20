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

					<h2><span class="entry-date alignright"><?php the_time('d-m-Y'); ?></span><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

				</div>

				<div class="entry-wrap">

					<div class="entry-content">

						<?php the_content('Ler Mais...'); ?>

						<?php edit_post_link('Editar', '<p>', '</p>'); ?>

						<!-- <?php trackback_rdf(); ?> -->

						<p class="entry-meta">

							<span class="cat-links">Categoria: <?php the_category(' ,') ?> | Tags: <?php the_tags('' ,' ,' ,''); ?></span> | <span class="comments-link"><?php comments_popup_link('Deixe 1 Comentário', '1 Comentário', '% Comentários'); ?></span>

						</p>

					</div>

					<div class="rc"></div>

				</div>

			</div>

			<?php endwhile; ?>



			<div class="navigation">

				<?php posts_nav_link(); ?>

			</div>



		</div>

	</div>