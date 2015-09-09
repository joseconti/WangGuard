<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<form method="post">
		<?php $table->search_box( __( 'Search', 'wangguard' ), 'signup-search' ); ?>
	</form>

	<form id="wangguard-signup-moderation" method="post">
		<?php $table->display(); ?>
	</form>
</div>