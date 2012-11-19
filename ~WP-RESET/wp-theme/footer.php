		<footer>
			<div class="center">
				<p>&copy; <?= date('Y'); ?> <a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a> &bull; <a href="http://monzilla.biz/" title="WordPress Theme Design">H5 Theme</a> &bull; <a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform">WordPress <?php bloginfo('version'); ?></a> &bull; <a href="<?php bloginfo('rss2_url'); ?>" title="Subscribe to Posts Feed">Entries (RSS)</a> &bull; <a href="<?php bloginfo('comments_rss2_url'); ?>" title="Subscribe to Comments Feed">Comments (RSS)</a></p>
			</div>
		</footer>
		<?php wp_footer(); ?>


		<script src="<?php bloginfo('template_directory'); ?>/js/site.js"></script>
	</body>
</html>