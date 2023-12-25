jQuery(document).ready(function($){
	"use strict";
	
	$( "body" ).on( "click", ".apus-checkbox", function() {
		$('.'+this.id).toggle();
    });

    // Jobs|Employers|Candidate Template
	$(document).on('change', '#page_template', function(){
        var val = $(this).val();
        show_hide_job_setting(val);
    });
    setTimeout(function() {
        if ( $('#page_template').length > 0 ) {
            var val = $('#page_template').val();
            show_hide_job_setting(val);
        }
    }, 100);

    $(document).on('change', '.editor-page-attributes__template .components-select-control__input', function(){
        var val = $(this).val();
        show_hide_job_setting(val);
    });
    setTimeout(function() {
    	if ( $('.editor-page-attributes__template .components-select-control__input').length > 0 ) {
	        var val = $('.editor-page-attributes__template .components-select-control__input').val();
	        show_hide_job_setting(val);
	    }
    }, 100);
    
    $(document).on('change', '#apus_page_display_mode', function(){
        var val = $(this).val();
        show_hide_job_display_mode_setting(val);
    });
    setTimeout(function() {
        if ( $('#apus_page_display_mode').length > 0 ) {
            var val = $('#apus_page_display_mode').val();
            show_hide_job_display_mode_setting(val);
        }
    }, 100);
    
    function show_hide_job_setting(val) {
        if ( val == 'page-jobs.php' ) {
            $('#apus_page_jobs_setting').show();

            $('.cmb2-id-apus-page-layout').hide();
            $('.cmb2-id-apus-page-left-sidebar').hide();
            $('.cmb2-id-apus-page-right-sidebar').hide();
            $('.cmb2-id-apus-page-show-breadcrumb').hide();
            $('.cmb2-id-apus-page-breadcrumb-color').hide();
            $('.cmb2-id-apus-page-breadcrumb-image').hide();
        } else {
            $('#apus_page_jobs_setting').hide();

            $('.cmb2-id-apus-page-layout').show();
            $('.cmb2-id-apus-page-left-sidebar').show();
            $('.cmb2-id-apus-page-right-sidebar').show();
            $('.cmb2-id-apus-page-show-breadcrumb').show();
            $('.cmb2-id-apus-page-breadcrumb-color').show();
            $('.cmb2-id-apus-page-breadcrumb-image').show();
        }
        // Employers template
        if ( val == 'page-employers.php' ) {
            $('#apus_page_employers_setting').show();
        } else {
            $('#apus_page_employers_setting').hide();
        }
        // Candidates template
        if ( val == 'page-candidates.php' ) {
            $('#apus_page_candidates_setting').show();
        } else {
            $('#apus_page_candidates_setting').hide();
        }
    }

    function show_hide_job_display_mode_setting(val) {
        if ( val == 'list' ) {
            $('.cmb2-id-apus-page-inner-style').show();

            $('.cmb2-id-apus-page-inner-grid-style').hide();
        } else {
            $('.cmb2-id-apus-page-inner-grid-style').show();

            $('.cmb2-id-apus-page-inner-style').hide();
        }
    }
});