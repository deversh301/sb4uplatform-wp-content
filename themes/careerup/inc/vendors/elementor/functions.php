<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( ! class_exists( 'Careerup_Elementor_Extensions' ) ) {
    final class Careerup_Elementor_Extensions {

        private static $_instance = null;

        
        public function __construct() {
            add_action( 'elementor/elements/categories_registered', array( $this, 'add_widget_categories' ) );
            add_action( 'init', array( $this, 'elementor_widgets' ),  100 );
            add_filter( 'careerup_generate_post_builder', array( $this, 'render_post_builder' ), 10, 2 );

            add_action( 'elementor/controls/controls_registered', array( $this, 'modify_controls' ), 10, 1 );
            add_action('elementor/editor/before_enqueue_styles', array( $this, 'style' ) );
        }

        public static function instance () {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }
        
        public function add_widget_categories( $elements_manager ) {
            $elements_manager->add_category(
                'careerup-elements',
                [
                    'title' => esc_html__( 'Careerup Elements', 'careerup' ),
                    'icon' => 'fa fa-shopping-bag',
                ]
            );

            $elements_manager->add_category(
                'careerup-header-elements',
                [
                    'title' => esc_html__( 'Careerup Header Elements', 'careerup' ),
                    'icon' => 'fa fa-shopping-bag',
                ]
            );

        }

        public function elementor_widgets() {
            // general elements
            get_template_part( 'inc/vendors/elementor/widgets/heading' );
            get_template_part( 'inc/vendors/elementor/widgets/posts' );
            get_template_part( 'inc/vendors/elementor/widgets/call_to_action' );
            get_template_part( 'inc/vendors/elementor/widgets/features_box' );
            get_template_part( 'inc/vendors/elementor/widgets/social_links' );
            get_template_part( 'inc/vendors/elementor/widgets/testimonials' );
            get_template_part( 'inc/vendors/elementor/widgets/brands' );
            get_template_part( 'inc/vendors/elementor/widgets/popup_video' );
            get_template_part( 'inc/vendors/elementor/widgets/instagram' );
            get_template_part( 'inc/vendors/elementor/widgets/banner' );
            get_template_part( 'inc/vendors/elementor/widgets/countdown' );
            get_template_part( 'inc/vendors/elementor/widgets/nav_menu' );
            get_template_part( 'inc/vendors/elementor/widgets/team' );

            // header elements
            get_template_part( 'inc/vendors/elementor/header-widgets/logo' );
            get_template_part( 'inc/vendors/elementor/header-widgets/primary_menu' );
            

            if ( careerup_is_mailchimp_activated() ) {
                get_template_part( 'inc/vendors/elementor/widgets/mailchimp' );
            }
            
            if ( careerup_is_revslider_activated() ) {
                get_template_part( 'inc/vendors/elementor/widgets/revslider' );
            }

            if ( careerup_is_wp_job_board_activated() ) {
                get_template_part( 'inc/vendors/elementor/wp-job-board-widgets/jobs' );
                get_template_part( 'inc/vendors/elementor/wp-job-board-widgets/jobs_maps' );
                get_template_part( 'inc/vendors/elementor/wp-job-board-widgets/jobs_tabs' );
                get_template_part( 'inc/vendors/elementor/wp-job-board-widgets/employers' );
                get_template_part( 'inc/vendors/elementor/wp-job-board-widgets/candidates' );
                get_template_part( 'inc/vendors/elementor/wp-job-board-widgets/category_banner' );
                get_template_part( 'inc/vendors/elementor/wp-job-board-widgets/category_list' );
                get_template_part( 'inc/vendors/elementor/wp-job-board-widgets/city_banner' );
                get_template_part( 'inc/vendors/elementor/wp-job-board-widgets/search_form' );
                get_template_part( 'inc/vendors/elementor/wp-job-board-widgets/search_form2' );
                get_template_part( 'inc/vendors/elementor/wp-job-board-widgets/candidate_search_form' );

                get_template_part( 'inc/vendors/elementor/wp-job-board-widgets/user_info' );

                // new
                get_template_part( 'inc/vendors/elementor/wp-job-board-widgets/candidate_category_banner' );
                get_template_part( 'inc/vendors/elementor/wp-job-board-widgets/candidate_category_list' );
                get_template_part( 'inc/vendors/elementor/wp-job-board-widgets/candidates_tabs' );
            }

            if ( careerup_is_wp_job_board_wc_paid_listings_activated() ) {
                get_template_part( 'inc/vendors/elementor/wc-paid-listings-widgets/packages' );
                get_template_part( 'inc/vendors/elementor/wc-paid-listings-widgets/user_packages' );
            }

            if ( careerup_is_wp_private_message() ) {
                get_template_part( 'inc/vendors/elementor/wp-private-message-widgets/header-notification' );
            }
        }
        public function style() {
            wp_enqueue_style('careerup-flaticon',  get_template_directory_uri() . '/css/flaticon.css');
        }

        public function modify_controls( $controls_registry ) {
            // Get existing icons
            $icons = $controls_registry->get_control( 'icon' )->get_settings( 'options' );
            // Append new icons
            $new_icons = array_merge(
                array(
                    'flaticon-search' => 'flaticon-search', 'flaticon-magnifying-glass' => 'flaticon-magnifying-glass', 'flaticon-marker' => 'flaticon-marker', 'flaticon-marker-1' => 'flaticon-marker-1', 'flaticon-marker-2' => 'flaticon-marker-2', 'flaticon-letter' => 'flaticon-letter', 'flaticon-opened-email-outlined-interface-symbol' => 'flaticon-opened-email-outlined-interface-symbol', 'flaticon-telephone' => 'flaticon-telephone', 'flaticon-call' => 'flaticon-call', 'flaticon-fax' => 'flaticon-fax', 'flaticon-newspaper' => 'flaticon-newspaper', 'flaticon-saturn' => 'flaticon-saturn', 'flaticon-career' => 'flaticon-career', 'flaticon-application' => 'flaticon-application', 'flaticon-printer' => 'flaticon-printer', 'flaticon-download' => 'flaticon-download', 'flaticon-close' => 'flaticon-close', 'flaticon-unlocked' => 'flaticon-unlocked', 'flaticon-job' => 'flaticon-job', 'flaticon-trophy' => 'flaticon-trophy', 'flaticon-quotation-mark' => 'flaticon-quotation-mark', 'flaticon-left-quote' => 'flaticon-left-quote', 'flaticon-clock' => 'flaticon-clock', 'flaticon-event' => 'flaticon-event', 'flaticon-alarm' => 'flaticon-alarm', 'flaticon-dashboard' => 'flaticon-dashboard', 'flaticon-profile' => 'flaticon-profile', 'flaticon-paper-plane' => 'flaticon-paper-plane', 'flaticon-analysis' => 'flaticon-analysis', 'flaticon-chat' => 'flaticon-chat', 'flaticon-favorites' => 'flaticon-favorites', 'flaticon-rating' => 'flaticon-rating', 'flaticon-locked' => 'flaticon-locked', 'flaticon-logout' => 'flaticon-logout', 'flaticon-rubbish-bin' => 'flaticon-rubbish-bin', 'flaticon-edit' => 'flaticon-edit', 'flaticon-eye' => 'flaticon-eye', 'flaticon-doc' => 'flaticon-doc', 'flaticon-tag' => 'flaticon-tag', 'flaticon-star' => 'flaticon-star', 'flaticon-paper' => 'flaticon-paper', 'flaticon-graduation-hat' => 'flaticon-graduation-hat', 'flaticon-old-age-man' => 'flaticon-old-age-man', 'flaticon-coupon' => 'flaticon-coupon', 'flaticon-location-pin' => 'flaticon-location-pin', 'flaticon-price' => 'flaticon-price', 'flaticon-wallet' => 'flaticon-wallet', 'flaticon-briefcase' => 'flaticon-briefcase', 'flaticon-cv' => 'flaticon-cv', 'flaticon-resume' => 'flaticon-resume', 'flaticon-open-envelope-with-letter' => 'flaticon-open-envelope-with-letter', 'flaticon-work' => 'flaticon-work', 'flaticon-consulting-message' => 'flaticon-consulting-message', 'flaticon-support' => 'flaticon-support', 'flaticon-video-conference' => 'flaticon-video-conference', 'flaticon-test' => 'flaticon-test', 'flaticon-paper-plane-1' => 'flaticon-paper-plane-1', 'flaticon-2-squares' => 'flaticon-2-squares', 'flaticon-team' => 'flaticon-team', 'flaticon-timeline' => 'flaticon-timeline', 'flaticon-businessman' => 'flaticon-businessman', 'flaticon-user' => 'flaticon-user', 'flaticon-ticket' => 'flaticon-ticket', 'flaticon-label' => 'flaticon-label', 'flaticon-tag-1' => 'flaticon-tag-1', 'flaticon-link' => 'flaticon-link', 'flaticon-mail' => 'flaticon-mail', 'flaticon-phone-call' => 'flaticon-phone-call', 'flaticon-share' => 'flaticon-share', 'flaticon-share-1' => 'flaticon-share-1', 'flaticon-money' => 'flaticon-money', 'flaticon-gender' => 'flaticon-gender', 'flaticon-controls' => 'flaticon-controls', 'flaticon-24-hours-support' => 'flaticon-24-hours-support', 'flaticon-zoom-in' => 'flaticon-zoom-in', 'flaticon-plus-zoom' => 'flaticon-plus-zoom', 'flaticon-businessman-paper-of-the-application-for-a-job' => 'flaticon-businessman-paper-of-the-application-for-a-job', 'flaticon-filter' => 'flaticon-filter', 'flaticon-filter-1' => 'flaticon-filter-1', 'flaticon-line-chart' => 'flaticon-line-chart', 'flaticon-interview' => 'flaticon-interview', 'flaticon-pen' => 'flaticon-pen', 'flaticon-mortarboard' => 'flaticon-mortarboard', 'flaticon-bars' => 'flaticon-bars', 'flaticon-antenna' => 'flaticon-antenna', 'flaticon-customer-support' => 'flaticon-customer-support', 'flaticon-care' => 'flaticon-care', 'flaticon-food' => 'flaticon-food', 'flaticon-bookmark' => 'flaticon-bookmark', 'flaticon-playstore' => 'flaticon-playstore', 'flaticon-play-store' => 'flaticon-play-store', 'flaticon-apple-big-logo' => 'flaticon-apple-big-logo', 'flaticon-certified' => 'flaticon-certified', 'flaticon-company' => 'flaticon-company', 'flaticon-manager' => 'flaticon-manager', 'flaticon-employee' => 'flaticon-employee', 'flaticon-man' => 'flaticon-man', 'flaticon-rocket-launch' => 'flaticon-rocket-launch', 'flaticon-right-arrow' => 'flaticon-right-arrow', 'flaticon-menu' => 'flaticon-menu', 'flaticon-404' => 'flaticon-404', 'flaticon-download-arrow' => 'flaticon-download-arrow', 'flaticon-left-arrow' => 'flaticon-left-arrow', 'flaticon-download-1' => 'flaticon-download-1', 'flaticon-upload' => 'flaticon-upload', 'flaticon-pdf' => 'flaticon-pdf', 'flaticon-bullseye' => 'flaticon-bullseye', 'testimonials-item' => 'testimonials-item', 
                ),
                $icons
            );
            // Then we set a new list of icons as the options of the icon control
            $controls_registry->get_control( 'icon' )->set_settings( 'options', $new_icons );
        }
        public function render_page_content($post_id) {
            if ( class_exists( 'Elementor\Core\Files\CSS\Post' ) ) {
                $css_file = new Elementor\Core\Files\CSS\Post( $post_id );
                $css_file->enqueue();
            }

            return Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $post_id );
        }

        public function render_post_builder($html, $post) {
            if ( !empty($post) && !empty($post->ID) ) {
                return $this->render_page_content($post->ID);
            }
            return $html;
        }
    }
}

if ( did_action( 'elementor/loaded' ) ) {
    // Finally initialize code
    Careerup_Elementor_Extensions::instance();
}