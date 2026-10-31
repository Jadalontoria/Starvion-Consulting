<?php
/**
 * Title: Contact form and details
 * Slug: starvion/contact
 * Categories: starvion
 * Description: Contact form with details card.
 * Inserter: yes
 *
 * @package Starvion
 */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="margin-top:0;margin-bottom:0;padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60)"><!-- wp:columns {"align":"wide"} -->
<div class="wp-block-columns alignwide"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Send us a message</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>We reply to every enquiry within one business day.</p>
<!-- /wp:paragraph -->

<!-- wp:shortcode -->
[starvion_contact_form]
<!-- /wp:shortcode --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:group {"className":"starvion-card","layout":{"type":"default"}} -->
<div class="wp-block-group starvion-card"><!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size">Contact details</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><strong>Email</strong><br>[email address]</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong>Phone</strong><br>[phone number]</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong>Location</strong><br>[City], working Australia-wide</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p><strong>LinkedIn</strong><br>[LinkedIn link]</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
