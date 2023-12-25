<?php

function careerup_job_paid_listing_template_folder_name($folder) {
	$folder = 'template-paid-listings';
	return $folder;
}
add_filter( 'wp-job-board-wc-paid-listings-theme-folder-name', 'careerup_job_paid_listing_template_folder_name', 10 );