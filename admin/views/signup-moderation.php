<div class="wrap">
	<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

	<form method="post">
		<?php $table->search_box( __( 'Search', 'wangguard' ), 'signup-search' ); ?>
	</form>

	<form id="wangguard-signup-moderation" method="post">
		<?php $table->display(); ?>
	</form>
</div>

<style>
	span.splog a {
		color:#a00;
	}
</style>
<script>
	jQuery(document).ready( function( $ ) {
		$( 'span.splog a' ).on( 'click', function( e ) {
			return confirm( '<?php _e( "Mark user as splogger. Are you sure?", "wangguard" ); ?>' );
		});

		$( 'span.unsplog a' ).on( 'click', function( e ) {
			return confirm( '<?php _e( "Approve user. Are you sure?", "wangguard" ); ?>' );
		});
	});
</script>