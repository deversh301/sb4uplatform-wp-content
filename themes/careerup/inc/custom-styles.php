<?php
if ( !function_exists ('careerup_custom_styles') ) {
	function careerup_custom_styles() {
		global $post;	
		
		ob_start();	
		?>
		
			<?php
				$main_font = careerup_get_config('main_font');
				$main_font_family = isset($main_font['font-family']) ? $main_font['font-family'] : false;
				$main_font_size = isset($main_font['font-size']) ? $main_font['font-size'] : false;
				$main_font_weight = isset($main_font['font-weight']) ? $main_font['font-weight'] : false;
				$main_color = isset($main_font['color']) ? $main_font['color'] : false;
			?>
			<?php if ( $main_font_family ): ?>
				/* Main Font */
				.btn,
				body
				{
					font-family:  <?php echo '\'' . $main_font_family . '\','; ?> sans-serif;
				}
			<?php endif; ?>
			<?php if ( $main_font_size ): ?>
				/* Main Font Size */
				body
				{
					font-size: <?php echo esc_html($main_font_size); ?>;
				}
			<?php endif; ?>
			<?php if ( $main_font_weight ): ?>
				/* Main Font Weight */
				body
				{
					font-weight: <?php echo esc_html($main_font_weight); ?>;
				}
			<?php endif; ?>

			<?php if ( $main_color ): ?>
				/* Main Color */
				body
				{
					color: <?php echo esc_html($main_color); ?>;
				}
			<?php endif; ?>


			<?php
				$heading_font = careerup_get_config('heading_font');
				$heading_font_family = isset($heading_font['font-family']) ? $heading_font['font-family'] : false;
				$heading_font_weight = isset($heading_font['font-weight']) ? $heading_font['font-weight'] : false;
				$heading_color = isset($heading_font['color']) ? $heading_font['color'] : false;
			?>
			<?php if ( $heading_font_family ): ?>
				/* Heading Font */
				h1, h2, h3, h4, h5, h6, .filter-listing-form .form-group .heading-label, .jobs-listing-wrapper .results-count, .employers-listing-wrapper .results-count
				{
					font-family:  <?php echo '\'' . $heading_font_family . '\','; ?> sans-serif;
				}			
			<?php endif; ?>

			<?php if ( $heading_font_weight ): ?>
				/* Heading Font Weight */
				h1, h2, h3, h4, h5, h6
				{
					font-weight: <?php echo esc_html($heading_font_weight); ?>;
				}			
			<?php endif; ?>

			<?php if ( $heading_color ): ?>
				/* Heading Color */
				h1, h2, h3, h4, h5, h6
				{
					color: <?php echo esc_html($heading_color); ?>;
				}			
			<?php endif; ?>


			<?php if ( careerup_get_config('main_color') != "" ) : ?>
				/* seting background main */
				.candidate-single-v3 .header-tabs-nav .nav li a::before,
				.job-list-v5::before,.job-grid .btn-grid1::before,
				.skill-percents .skill-process > span,.job-applicants .inner-result > div.active,
				ul.page-numbers > li > span.current,
				ul.page-numbers > li > a:hover,
				ul.page-numbers > li > a:focus,
				.cmb-form .cmb2-checkbox-list [type="checkbox"]:checked + label::before,
				.contact_details,.works .number,.cmb-form .cmb2-checkbox-list [type="radio"]:checked + label::before,
				.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce #respond input#submit, .woocommerce input.button, .woocommerce button.button, .woocommerce a.button,
				.product-block.grid .add-cart .added_to_cart,
				.product-block.grid:hover .add-cart .added_to_cart, .product-block.grid:hover .add-cart .button,
				.pagination > span:hover, .pagination > span.current, .pagination > a:hover, .pagination > a.current, .apus-pagination > span:hover, .apus-pagination > span.current, .apus-pagination > a:hover, .apus-pagination > a.current,
				.post-layout .top-image .categories-name,
				.my_resume_eduarea .circle,
				.candidate_resume_skill .progress-box .bar-fill,
				.candidate-list:hover .btn-theme.btn-outline,
				.job_maps_sidebar .map-popup .icon-wrapper::before,
				.btn-add-candidate-shortlist:hover, .btn-add-candidate-shortlist:focus, .btn-shortlist:hover, .btn-shortlist:focus,
				.job-detail-buttons .btn-apply,
				.map-popup .icon-wrapper::before,
				.map-popup .icon-wrapper,
				.leaflet-marker-icon > div > span::before,
				.leaflet-marker-icon > div > span,
				.filter-listing-form .button,
				.filter-listing-form .circle-check .list-item [type="radio"]:checked + label::before, .filter-listing-form .circle-check .list-item [type="checkbox"]:checked + label::before,
				.ui-slider-horizontal .ui-slider-range,
				.pagination > li > span:hover, .pagination > li > span.current, .pagination > li > a:hover, .pagination > li > a.current, .apus-pagination > li > span:hover, .apus-pagination > li > span.current, .apus-pagination > li > a:hover, .apus-pagination > li > a.current,
				.widget-features-box.style3 .item-inner:hover,
				.btn-outline.btn-white:active, .btn-outline.btn-white:hover,
				.job-list:hover .btn-add-job-shortlist,
				.job-list .btn-add-job-shortlist.btn-added-job-shortlist, .job-list .btn-added-job-shortlist.btn-added-job-shortlist,
				.widget-blogs.inner-grid-v4 .slick-carousel .slick-dots li.slick-active,
				.job-grid:hover .btn-theme.btn-outline,
				.employer-grid-v1 .open-job,
				.slick-carousel .slick-arrow:hover, .slick-carousel .slick-arrow:active, .slick-carousel .slick-arrow:focus,
				.subwoo-inner .add-cart .added_to_cart:hover, .subwoo-inner .add-cart .added_to_cart:focus, .subwoo-inner .add-cart .button:hover, .subwoo-inner .add-cart .button:focus,
				.candidate-grid:hover .btn-theme.btn-outline,
				.btn-theme.btn-outline:hover,
				.btn-theme.btn-outline:focus,
				.category-banner-inner:hover::before,
				.widget-features-box .number,
				.job-list-v1:hover .btn-theme.btn-outline,
				.location-banner-inner:hover::before,
				.slick-carousel .slick-dots li.slick-active button,
				.btn-theme,
				.bg-theme,
				.woocommerce .percent-sale, .woocommerce span.onsale, .tabs-v1 .nav-tabs > li > a:before, .details-product .apus-woocommerce-product-gallery-wrapper .woocommerce-product-gallery__trigger:hover, .details-product .apus-woocommerce-product-gallery-wrapper .woocommerce-product-gallery__trigger:active, .btn-readmore:before, .subwoo-inner.style2.highlight, .widget-search .btn:hover, .widget-search .btn:active, .login-form-wrapper .role-tabs li.active, .register-form .role-tabs li.active, .cmb-form .cmb-row[data-fieldtype="wp_job_board_file"] .upload-file-btn, .cmb-form .button-primary, .list-replies .user-reply .post-content,
				.filter-sidebar .filter-in-sidebar, .cmb-form .button-primary:hover, .cmb-form .button-primary:focus, .filter-sidebar .filter-in-sidebar:hover, .filter-sidebar .filter-in-sidebar:focus
				{
					background-color: <?php echo esc_html( careerup_get_config('main_color') ) ?> ;
				}

				.elementor-accordion .elementor-accordion-item .elementor-tab-title.elementor-active, .map-popup .icon-wrapper, .map-popup .icon-wrapper::before {
					background-color: <?php echo esc_html( careerup_get_config('main_color') ) ?> !important;
				}
				/* setting color */
				.nav.tabs-candiate > li.active > a:focus, .nav.tabs-candiate > li.active > a:hover, .nav.tabs-candiate > li.active > a,
				.category-section a:hover, .category-section a:focus,
				.category-section:hover .title-parent, .category-section:hover .number_total,
				.type-job,.job-grid .btn-grid1,
				.widget_pages a:hover, .widget_pages a:focus,.job-applicants .inner-result > div,
				.widget_pages .current_page_item > a,
				.widget_meta ul li.current-cat-parent > a, .widget_meta ul li.current-cat > a, .widget_archive ul li.current-cat-parent > a, .widget_archive ul li.current-cat > a, .widget_recent_entries ul li.current-cat-parent > a, .widget_recent_entries ul li.current-cat > a, .widget_categories ul li.current-cat-parent > a, .widget_categories ul li.current-cat > a,
				.list-options-action [type="radio"]:checked + label,
				.product-block.grid .add-cart .added_to_cart, .product-block.grid .add-cart .button,
				.widget_meta ul li:hover > a, .widget_archive ul li:hover > a, .widget_recent_entries ul li:hover > a, .widget_categories ul li:hover > a,
				.post-navigation .inner:hover, .post-navigation .inner:hover a,
				.my_resume_eduarea .edu_center,
				.job-detail-buttons .deadline-time,
				.employer-detail-detail .icon, .job-detail-detail .icon,
				.form-group-salary .from-to-wrapper,
				.filter-listing-form .terms-list + .toggle-filter-list,
				.search_distance_wrapper .search-distance-label,
				.widget-features-box.style3 .features-box-image,
				.job-list .btn-add-job-shortlist, .job-list .btn-added-job-shortlist,
				.btn-gradient-theme,
				.testimonials-item::before,
				.subwoo-inner .add-cart .added_to_cart, .subwoo-inner .add-cart .button,
				.btn-theme.btn-outline,
				.category-banner-inner .category-icon,
				.job-list-v1 .btn-theme.btn-outline,
				.add-fix-top, .apus-loadmore-btn,
				a:focus,a:hover, .filter-top-sidebar-wrapper .widget-job-search-form .trending-keywords a:focus, .filter-top-sidebar-wrapper .widget-job-search-form .trending-keywords a:hover, #jobs-google-maps .job-grid-style a:hover, #jobs-google-maps .job-grid-style a:focus, .sharing-popup .action-button:hover, .sharing-popup .action-button:focus, .sharing-popup .share-popup-box a:hover, .sharing-popup .share-popup-box a:focus, .job-single-v5 .content-job-detail .sharing-popup .share-popup-box a:hover, .job-single-v5 .content-job-detail .sharing-popup .share-popup-box a:focus, .candidate-grid .candidate-information a:not([class]):focus, .candidate-grid .candidate-information a:not([class]):hover, .tabs-v1 .nav-tabs > li.active > a, .post-layout .top-info a:hover, .post-layout .top-info a:focus, .highlight, .login-form-wrapper .role-tabs li, .register-form .role-tabs li, .topmenu-menu > li.active > a, .user-job-packaged [type="radio"]:checked + label, .list-options-action label:hover, .list-options-action label:focus{
					color: <?php echo esc_html( careerup_get_config('main_color') ) ?>;
				}

				/* setting border color */
				.nav.tabs-candiate > li.active > a:focus, .nav.tabs-candiate > li.active > a:hover, .nav.tabs-candiate > li.active > a,
				.employee-team:hover,
				.widget-testimonials.style3 .testimonials-item:hover,.job-list-v4:hover,
				.job-applicants .inner-result,
				.product-block.grid .add-cart .added_to_cart, .product-block.grid .add-cart .button,
				.product-block.grid:hover,
				.product-block.grid:hover .add-cart .added_to_cart, .product-block.grid:hover .add-cart .button,
				blockquote,
				.candidate-list:hover .btn-theme.btn-outline,
				.candidate-list:hover,
				.employer-list:hover,
				.employer-grid:hover,
				.btn-add-candidate-shortlist:hover, .btn-add-candidate-shortlist:focus, .btn-shortlist:hover, .btn-shortlist:focus,
				.job-detail-buttons .btn-apply,
				.ui-slider-horizontal .ui-slider-handle,
				.job-list:hover,
				.btn-outline.btn-white:active, .btn-outline.btn-white:hover,
				.job-list-v3:hover,
				.job-list .btn-add-job-shortlist, .job-list .btn-added-job-shortlist,
				.job-grid:hover .btn-theme.btn-outline,
				.job-grid:hover,
				.subwoo-inner .add-cart .added_to_cart:hover, .subwoo-inner .add-cart .added_to_cart:focus, .subwoo-inner .add-cart .button:hover, .subwoo-inner .add-cart .button:focus,
				.subwoo-inner .add-cart .added_to_cart, .subwoo-inner .add-cart .button,
				.candidate-grid:hover .btn-theme.btn-outline,
				.candidate-grid:hover,
				.btn-theme.btn-outline,
				.job-list-v1 .btn-theme.btn-outline,
				.job-list-v1:hover .btn-theme.btn-outline,
				.job-list-v1:hover,
				.slick-carousel .slick-dots li,
				.btn-theme, .apus-loadmore-btn,
				.border-theme, .details-product .apus-woocommerce-product-gallery-wrapper .woocommerce-product-gallery__trigger:hover, .details-product .apus-woocommerce-product-gallery-wrapper .woocommerce-product-gallery__trigger:active, .login-form-wrapper .role-tabs li, .register-form .role-tabs li{
					border-color: <?php echo esc_html( careerup_get_config('main_color') ) ?>;
				}
				.select2-container--default .select2-results__option[aria-selected="true"], .select2-container--default .select2-results__option[data-selected="true"],
				.subwoo-inner.highlight .add-cart .added_to_cart, .subwoo-inner.highlight .add-cart .button,
				.text-theme{
					color: <?php echo esc_html( careerup_get_config('main_color') ) ?> !important;
				}
				.employer-grid .featured::before,
				.candidate-grid .featured::before,
				.job-grid .featured::before{
					border-color: <?php echo esc_html( careerup_get_config('main_color') ) ?> <?php echo esc_html( careerup_get_config('main_color') ) ?> transparent transparent;
				}
				.woocommerce .percent-sale:before, .woocommerce span.onsale:before {
					border-color: <?php echo esc_html( careerup_get_config('main_color') ) ?> <?php echo esc_html( careerup_get_config('main_color') ) ?> transparent transparent;
				}

			<?php endif; ?>

			<?php if ( careerup_get_config('button_hover_color') != "" ) : ?>
				/* seting background main */
				.job-detail-buttons .btn-apply:focus, .job-detail-buttons .btn-apply:hover,
				.filter-listing-form .button:hover,
				.filter-listing-form .button:focus,
				.btn-theme:hover,
				.btn-theme:focus,
				.btn-theme.btn-outline:hover,
				.btn-theme.btn-outline:focus, .apus-loadmore-btn{
					border-color: <?php echo esc_html( careerup_get_config('button_hover_color') ) ?> ;
					background-color: <?php echo esc_html( careerup_get_config('button_hover_color') ) ?> ;
				}
			<?php endif; ?>

			<?php if ( careerup_get_config('second_color') != "" ) : ?>
				.subwoo-inner .price{
					color: <?php echo esc_html( careerup_get_config('second_color') ) ?>;
				}
			<?php endif; ?>

			<?php if ( ( careerup_get_config('main_color') != "" ) && ( careerup_get_config('second_color') != "" ) ) : ?>
				.subwoo-inner.highlight{
					background-image:linear-gradient(60deg,<?php echo esc_html( careerup_get_config('main_color') ) ?>,<?php echo esc_html( careerup_get_config('second_color') ) ?>);
				    background-image:-webkit-linear-gradient(60deg,<?php echo esc_html( careerup_get_config('main_color') ) ?>,<?php echo esc_html( careerup_get_config('second_color') ) ?>);
				    background-image:-ms-linear-gradient(60deg,<?php echo esc_html( careerup_get_config('main_color') ) ?>,<?php echo esc_html( careerup_get_config('second_color') ) ?>);
				}
				.category-banner-inner.style2::after,
				.employer-grid-v1 .open-job::before,
				.btn-gradient-theme .btn::before,
				.btn-gradient-theme{
					background: linear-gradient(to right, <?php echo esc_html( careerup_get_config('main_color') ) ?>, <?php echo esc_html( careerup_get_config('second_color') ) ?>);
					background: -webkit-linear-gradient(to right, <?php echo esc_html( careerup_get_config('main_color') ) ?>, <?php echo esc_html( careerup_get_config('second_color') ) ?>);
					background: -ms-linear-gradient(to right, <?php echo esc_html( careerup_get_config('main_color') ) ?>, <?php echo esc_html( careerup_get_config('second_color') ) ?>);
					background: -o-linear-gradient(to right, <?php echo esc_html( careerup_get_config('main_color') ) ?>, <?php echo esc_html( careerup_get_config('second_color') ) ?>);
				}
			<?php endif; ?>

			<?php if (  careerup_get_config('header_mobile_color') != "" ) : ?>
				#apus-header-mobile {
					background-color: <?php echo esc_html( careerup_get_config('header_mobile_color') ); ?>;
				}
			<?php endif; ?>

			<?php if (  careerup_get_config('job_featured_breadcrumb_color') != "" ) : ?>
				.job-card.is-featured {
					background-color: <?php echo esc_html( careerup_get_config('job_featured_breadcrumb_color') ); ?>;
				}
			<?php endif; ?>

			<?php if (  careerup_get_config('job_urgent_breadcrumb_color') != "" ) : ?>
				.job-card.is-urgent {
					background-color: <?php echo esc_html( careerup_get_config('job_urgent_breadcrumb_color') ); ?>;
				}
			<?php endif; ?>

			<?php if (  careerup_get_config('candidate_featured_breadcrumb_color') != "" ) : ?>
				.candidate-card.is-featured .candidate-grid, .candidate-card.is-featured .candidate-list {
					background-color: <?php echo esc_html( careerup_get_config('candidate_featured_breadcrumb_color') ); ?>;
				}
			<?php endif; ?>

			<?php if (  careerup_get_config('candidate_urgent_breadcrumb_color') != "" ) : ?>
				.candidate-card.is-urgent .candidate-grid, .candidate-card.is-urgent .candidate-list {
					background-color: <?php echo esc_html( careerup_get_config('candidate_urgent_breadcrumb_color') ); ?>;
				}
			<?php endif; ?>
	<?php
		$content = ob_get_clean();
		$content = str_replace(array("\r\n", "\r"), "\n", $content);
		$lines = explode("\n", $content);
		$new_lines = array();
		foreach ($lines as $i => $line) {
			if (!empty($line)) {
				$new_lines[] = trim($line);
			}
		}
		
		return implode($new_lines);
	}
}