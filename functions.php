<?php

//Custom block for show percentage sale product
function prefix_register_block( $blocks ) {
	// 'Discount' corresponds to the block slug.
	$blocks['discount'] = [
		'name' => __( 'Discount', 'text-domain' ),
		'render_callback' => 'prefix_discount_render',
	];
	return $blocks;
}
add_filter( 'wp_grid_builder/blocks', 'prefix_register_block', 10, 1 );

// The render callback function allows to output content in cards.
function prefix_discount_render( ) {
	$post = wpgb_get_post();
	$regular_price = (float)$post->_regular_price;
	$sale_price = (float)$post->_sale_price;
	$discount_percentage = round( 100 - ( $sale_price / $regular_price * 100 ), 1 ) . '%';
	if ( wpgb_is_on_sale() && $sale_price !== $regular_price ) {
		echo '<h3>' . esc_html( $discount_percentage ) . '</h3>';
	}
}


//Add class to on sale cards
function prefix_card_attributes( $atts, $card ) {
	// We get post in the custom loop of the plugin.
	$post = wpgb_get_post();
	// If current post ID is equal to 1, change number of rows/columns.
	if ( wpgb_is_on_sale() ) {
		$atts['class'][] = 'onsale';
	}
	return $atts;
}
add_filter( 'wp_grid_builder/card/attributes', 'prefix_card_attributes', 10, 2 );
