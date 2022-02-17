<?php
/**
 * Header-v3 template.
 *
 * @author     ThemeFusion
 * @copyright  (c) Copyright by ThemeFusion
 * @link       https://theme-fusion.com
 * @package    Avada
 * @subpackage Core
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<div class="fusion-header-sticky-height"></div>
<div class="fusion-header">
	<div class="fusion-row">
		<?php if ( 'flyout' === Avada()->settings->get( 'mobile_menu_design' ) ) : ?>
			<div class="fusion-header-has-flyout-menu-content">
		<?php endif; ?>
		<?php avada_logo(); ?>
		<div class="c-btns">
    		<a href="https://www.fresha.com/providers/id7x9ky5?pId=452325" class="book-now-btn book-btn">Book Now</a>
    		<a href="/contact-us" class="contact-us-btn">Contact Us</a>
		</div>
		<?php avada_main_menu(); ?>
		<?php avada_mobile_menu_search(); ?>
		<?php if ( 'flyout' === Avada()->settings->get( 'mobile_menu_design' ) ) : ?>
			</div>
		<?php endif; ?>
	</div>
</div>
