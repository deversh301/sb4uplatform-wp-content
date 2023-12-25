(function($) {
    "use strict";
    
    var ajax_filter_request;

    $.extend($.apusThemeCore, {
        /**
         *  Initialize scripts
         */
        job_init: function() {
            var self = this;

            if ( self.message_form_html == null && $('.send-private-message-wrapper-hidden').length > 0 ) {
                self.message_form_html = $('.send-private-message-wrapper-hidden').html();
                $('.send-private-message-wrapper-hidden').html('');
            }

            self.select2Init();

            self.sendPrivateMessage();

            self.searchAjaxInit();

            self.listingDetail();

            self.filterListingFnc();

            self.userRegister();

            self.listingBtnFilter();

            setTimeout(function(){
                self.changePaddingTopContent();
            }, 100);
            
            $(window).resize(function(){
                setTimeout(function(){
                    self.changePaddingTopContent();
                }, 100);
            });

            self.showContentSidebarListing();

            if ( $('.jobs-listing-wrapper.main-items-wrapper, .employers-listing-wrapper.main-items-wrapper, .candidates-listing-wrapper.main-items-wrapper').length ) {
                $(document).on('change', 'form.filter-listing-form input, form.filter-listing-form select', function (e) {
                    var form = $(this).closest('form.filter-listing-form');
                    if ( $(this).attr('name') == 'filter-salary-type' ) {
                        form.find('input[name=filter-salary-from]').val('');
                        form.find('input[name=filter-salary-to]').val('');
                    }
                    setTimeout(function(){
                        form.trigger('submit');
                    }, 200);
                });

                $(document).on('submit', 'form.filter-listing-form', function (e) {
                    e.preventDefault();
                    
                    var url = $(this).attr('action');

                    var formData = $(this).find(":input").filter(function(index, element) {
                                return $(element).val() != '';
                            }).serialize();

                    if( url.indexOf('?') != -1 ) {
                        url = url + '&' + formData;
                    } else{
                        url = url + '?' + formData;
                    }
                    self.jobsGetPage( url );
                    return false;
                });
            }
            // Sort Action
            $(document).on('change', 'form.jobs-ordering select.orderby', function(e) {
                e.preventDefault();
                $('form.jobs-ordering').trigger('submit');
            });
            
            $(document).on('submit', 'form.jobs-ordering', function (e) {
                var url = $(this).attr('action');
                var formData = $(this).find(":input").filter(function(index, element) {
                            return $(element).val() != '';
                        }).serialize();
                
                if( url.indexOf('?') != -1 ) {
                    url = url + '&' + formData;
                } else{
                    url = url + '?' + formData;
                }
                
                self.jobsGetPage( url );
                return false;
            });
            // ajax pagination
            if ( $('.ajax-pagination').length ) {
                self.ajaxPaginationLoad();
            }

        },
        select2Init: function() {
            // select2
            if ( $.isFunction( $.fn.select2 ) && typeof wp_job_board_select2_opts !== 'undefined' ) {
                var select2_args = wp_job_board_select2_opts;
                select2_args['allowClear']              = true;
                select2_args['minimumResultsForSearch'] = 10;
                
                $( 'select[name=filter-location]' ).select2( select2_args );
                $( 'select[name=filter-type]' ).select2( select2_args );
                $( 'select[name=filter-category]' ).select2( select2_args );
            }
        },
        changePaddingTopContent: function() {
            if ($(window).width() >= 1200) {
                var header_h = $('#apus-header').outerHeight();
                if ( $('.candidate-single-v4').length ) {
                    $('.candidate-detail-header-inner').css({
                        'padding-top': header_h
                    });
                }
            } else {
                var header_h = $('#apus-header-mobile').outerHeight();
            }
            if ($('#jobs-google-maps').is('.fix-map')) {
                $('#jobs-google-maps').css({ 'top': header_h, 'height': 'calc(100vh - ' + header_h+ 'px)' });
                $('#apus-main-content').css({ 'padding-top': header_h });
            }
            
            $('.layout-type-half-map .filter-sidebar').css({ 'padding-top': header_h + 20 });
            $('.layout-type-half-map .filter-scroll').perfectScrollbar();
            // offcanvas-filter-sidebar
            $('.offcanvas-filter-sidebar').css({ 'padding-top': header_h + 10 });

        },
        listingChangeMarginTopAffix: function() {
            var affix_height = 0;
                if ( $('.panel-affix').length > 0 ) {
                    affix_height = $('.panel-affix').outerHeight();
                    $('.panel-affix-wrapper').css({'height': affix_height});
                }
            return affix_height;
        },
        sendPrivateMessage: function() {
            var self = this;
            $(document).on('click', '.send-private-message-btn', function() {
                $.magnificPopup.open({
                    mainClass: 'wp-job-board-mfp-container popup-private-message',
                    items    : {
                        src : self.message_form_html,
                        type: 'inline'
                    }
                });
            });
        },
        searchAjaxInit: function() {
            if ( $.isFunction( $.fn.typeahead ) ) {
                $('.apus-autocompleate-input').each(function(){
                    var $this = $(this);
                    $this.typeahead({
                            'hint': true,
                            'highlight': true,
                            'minLength': 2,
                            'limit': 10
                        }, {
                            name: 'search',
                            source: function (query, processSync, processAsync) {
                                processSync([careerup_job_opts.empty_msg]);
                                $this.closest('.twitter-typeahead').addClass('loading');

                                var values = {};
                                $.each($this.closest('form').serializeArray(), function (i, field) {
                                    values[field.name] = field.value;
                                });
                                return $.ajax({
                                    url: careerup_job_opts.ajaxurl, 
                                    type: 'GET',
                                    data: {
                                        'search': query,
                                        'action': 'careerup_autocomplete_search_jobs',
                                        'data': values
                                    },
                                    dataType: 'json',
                                    success: function (json) {
                                        $this.closest('.twitter-typeahead').removeClass('loading');
                                        $this.closest('.has-suggestion').removeClass('active');
                                        return processAsync(json);
                                    }
                                });
                            },
                            templates: {
                                empty : [
                                    '<div class="empty-message">',
                                    careerup_job_opts.empty_msg,
                                    '</div>'
                                ].join('\n'),
                                suggestion: Handlebars.compile( careerup_job_opts.template )
                            },
                        }
                    );
                    $this.on('typeahead:selected', function (e, data) {
                        e.preventDefault();
                        setTimeout(function(){
                            $('.apus-autocompleate-input').val(data.title);    
                        }, 5);
                        
                        return false;
                    });
                });


                $('.apus-autocompleate-candidate-input').each(function(){
                    var $this = $(this);
                    $this.typeahead({
                            'hint': true,
                            'highlight': true,
                            'minLength': 2,
                            'limit': 10
                        }, {
                            name: 'search',
                            source: function (query, processSync, processAsync) {
                                processSync([careerup_job_opts.empty_msg]);
                                $this.closest('.twitter-typeahead').addClass('loading');

                                var values = {};
                                $.each($this.closest('form').serializeArray(), function (i, field) {
                                    values[field.name] = field.value;
                                });
                                return $.ajax({
                                    url: careerup_job_opts.ajaxurl, 
                                    type: 'GET',
                                    data: {
                                        'search': query,
                                        'action': 'careerup_autocomplete_search_candidates',
                                        'data': values
                                    },
                                    dataType: 'json',
                                    success: function (json) {
                                        $this.closest('.twitter-typeahead').removeClass('loading');
                                        $this.closest('.has-suggestion').removeClass('active');
                                        return processAsync(json);
                                    }
                                });
                            },
                            templates: {
                                empty : [
                                    '<div class="empty-message">',
                                    careerup_job_opts.empty_msg,
                                    '</div>'
                                ].join('\n'),
                                suggestion: Handlebars.compile( careerup_job_opts.template )
                            },
                        }
                    );
                    $this.on('typeahead:selected', function (e, data) {
                        e.preventDefault();
                        setTimeout(function(){
                            $('.apus-autocompleate-input').val(data.title);    
                        }, 5);
                        
                        return false;
                    });
                });
            }
        },
        listingDetail: function() {
            var self = this;
            // download candidate

            // affix
            var affix_height = 0;
            var affix_height_top = 0;
            setTimeout(function(){
                affix_height = affix_height_top = self.listingChangeMarginTopAffix();
            }, 50);
            $(window).resize(function(){
                affix_height = affix_height_top = self.listingChangeMarginTopAffix();
            });

            //Function from Bluthemes, lets you add li elemants to affix object without having to alter and data attributes set out by bootstrap
            setTimeout(function(){
                // name your elements here
                var stickyElement   = '.panel-affix',   // the element you want to make sticky
                    bottomElement   = '#apus-footer'; // the bottom element where you want the sticky element to stop (usually the footer) 

                // make sure the element exists on the page before trying to initalize
                if($( stickyElement ).length){
                    $( stickyElement ).each(function(){
                        var header_height = 0;
                        if ($(window).width() >= 1200) {
                            if ($('.main-sticky-header').length > 0) {
                                header_height = $('.main-sticky-header').outerHeight();
                                affix_height_top = affix_height + header_height;
                            }
                        } else {
                            header_height = $('#apus-header-mobile').outerHeight();
                            affix_height_top = affix_height + header_height;
                            header_height = 0;
                        }
                        affix_height_top = affix_height_top + 10;
                        // let's save some messy code in clean variables
                        // when should we start affixing? (the amount of pixels to the top from the element)
                        var fromTop = $( this ).offset().top, 
                            // where is the bottom of the element?
                            fromBottom = $( document ).height()-($( this ).offset().top + $( this ).outerHeight()),
                            // where should we stop? (the amount of pixels from the top where the bottom element is)
                            // also add the outer height mismatch to the height of the element to account for padding and borders
                            stopOn = $( document ).height()-( $( bottomElement ).offset().top)+($( this ).outerHeight() - $( this ).height()); 
            
                        // if the element doesn't need to get sticky, then skip it so it won't mess up your layout
                        if( (fromBottom-stopOn) > 200 ){
                            // let's put a sticky width on the element and assign it to the top
                            $( this ).css('width', $( this ).width()).css('top', 0).css('position', '');
                            // assign the affix to the element
                            $( this ).affix({
                                offset: { 
                                    // make it stick where the top pixel of the element is
                                    top: fromTop - header_height,  
                                    // make it stop where the top pixel of the bottom element is
                                    bottom: stopOn
                                }
                            // when the affix get's called then make sure the position is the default (fixed) and it's at the top
                            }).on('affix.bs.affix', function(){
                                var header_height = 0;
                                if ($(window).width() >= 1200) {
                                    if ($('.main-sticky-header').length > 0) {
                                        header_height = $('.main-sticky-header').outerHeight();
                                        affix_height_top = affix_height + header_height;
                                    }
                                } else {
                                    header_height = $('#apus-header-mobile').outerHeight();
                                    affix_height_top = affix_height + header_height;
                                }
                                affix_height_top = affix_height_top + 10;
                                $( this ).css('top', header_height).css('position', header_height);
                            });
                        }
                        // trigger the scroll event so it always activates 
                        $( window ).trigger('scroll'); 
                    }); 
                }

                //Offset scrollspy height to highlight li elements at good window height
                $('body').scrollspy({
                    target: ".header-tabs-nav",
                    offset: affix_height_top + 20
                });
            }, 50);
    
            //Smooth Scrolling For Internal Page Links
            $('.panel-affix a[href*="#"]:not([href="#"])').on('click', function() {
                if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                  var target = $(this.hash);
                  target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                  if (target.length) {
                    $('html,body').animate({
                      scrollTop: target.offset().top - affix_height_top
                    }, 1000);
                    return false;
                  }
                }
            });

            $(document).on('click', '.add-a-review', function(e) {
                e.preventDefault();
                var $id = $(this).attr('href');
                if ( $($id).length > 0 ) {
                    $('html,body').animate({
                      scrollTop: $($id).offset().top - 100
                    }, 1000);
                }
            });
        },
        listingBtnFilter: function(){
            $('.btn-view-map').on('click', function(e){
                e.preventDefault();
                $('#jobs-google-maps').removeClass('hidden-sm').removeClass('hidden-xs');
                $('.content-listing .jobs-listing-wrapper').addClass('hidden-sm').addClass('hidden-xs');
                $('.btn-view-listing').removeClass('hidden-sm').removeClass('hidden-xs');
                $(this).addClass('hidden-sm').addClass('hidden-xs');
                $('.jobs-pagination-wrapper').addClass('p-fix-pagination');
                setTimeout(function() {
                    $(window).trigger('pxg:refreshmap');
                });
            });
            $('.btn-view-listing').on('click', function(e){
                e.preventDefault();
                $('#jobs-google-maps').addClass('hidden-sm').addClass('hidden-xs');
                $('.content-listing .jobs-listing-wrapper').removeClass('hidden-sm').removeClass('hidden-xs');
                $('.btn-view-map').removeClass('hidden-sm').removeClass('hidden-xs');
                $(this).addClass('hidden-sm').addClass('hidden-xs');
                $('.jobs-pagination-wrapper').removeClass('p-fix-pagination');
            });

            $('.show-filter-jobs, .filter-in-sidebar').on('click', function(e){
                e.stopPropagation();
                $('.layout-type-half-map .filter-sidebar').toggleClass('active');
                $('.filter-sidebar + .over-dark').toggleClass('active');
            });
            $(document).on('click', '.filter-sidebar + .over-dark', function(){
                $('.layout-type-half-map .filter-sidebar').removeClass('active');
                $('.filter-sidebar + .over-dark').removeClass('active');
            });
        },

        

        userRegister: function(){
            $('body').on('click', '.role-tabs > li', function(){
                $('.role-tabs > li').removeClass('active');
                $(this).addClass('active');
            });
        },

        filterListingFnc: function(){
            $('body').on('click', '.btn-show-filter, .offcanvas-filter-sidebar + .over-dark', function(){
                $('.offcanvas-filter-sidebar, .offcanvas-filter-sidebar + .over-dark').toggleClass('active');
                $('.offcanvas-filter-sidebar').perfectScrollbar();
            });
            $('.tax-radios-field .form-group-inner > ul, .tax-checklist-field .form-group-inner > ul').scrollbar();
            $('body').on('click', '.tax-radios-field .form-group-inner ul span.caret-wrapper, .tax-checklist-field .form-group-inner ul span.caret-wrapper', function(){
                var con = $(this).closest('.list-item');
                con.find('> ul').slideToggle();
            });
        },

        showContentSidebarListing: function(){
            $('form .toggle-field.hide-content .heading-label i').removeClass('fa-angle-down').addClass('fa-angle-up');
            $('body').on('click', 'form .toggle-field .heading-label', function(){
                $(this).find('i').toggleClass('fa-angle-down fa-angle-up');
            });
        },
        jobsGetPage: function(pageUrl, isBackButton){
            var self = this;

            if ( self.filterAjax ) {
                self.filterAjax.abort();
            }
            
            self.jobsSetCurrentUrl();

            if (pageUrl) {
                // Show 'loader' overlay
                self.jobsShowLoader();
                
                // Make sure the URL has a trailing-slash before query args (301 redirect fix)
                pageUrl = pageUrl.replace(/\/?(\?|#|$)/, '/$1');
                
                if (!isBackButton) {
                    self.setPushState(pageUrl);
                }

                self.filterAjax = $.ajax({
                    url: pageUrl,
                    data: {
                        load_type: 'full'
                    },
                    dataType: 'html',
                    cache: false,
                    headers: {'cache-control': 'no-cache'},
                    
                    method: 'POST', // Note: Using "POST" method for the Ajax request to avoid "load_type" query-string in pagination links
                    
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log('Apus: AJAX error - jobsGetPage() - ' + errorThrown);
                        
                        // Hide 'loader' overlay (after scroll animation)
                        self.jobsHideLoader();
                        
                        self.filterAjax = false;
                    },
                    success: function(response) {
                        // Update jobs content
                        self.jobsUpdateContent(response);
                        
                        self.filterAjax = false;
                    }
                });
                
            }
        },
        jobsHideLoader: function(){
            $('body').find('.main-items-wrapper').removeClass('loading');
        },
        jobsShowLoader: function(){
            $('body').find('.main-items-wrapper').addClass('loading');
        },
        setPushState: function(pageUrl) {
            window.history.pushState({apusShop: true}, '', pageUrl);
        },
        jobsSetCurrentUrl: function() {
            var self = this;
            
            // Set current page URL
            self.searchAndTagsResetURL = window.location.href;
        },
        /**
         *  Properties: Update jobs content with AJAX HTML
         */
        jobsUpdateContent: function(ajaxHTML) {
            var self = this,
                $ajaxHTML = $('<div>' + ajaxHTML + '</div>');

            var $jobs = $ajaxHTML.find('.main-items-wrapper'),
                $pagination = $ajaxHTML.find('.main-pagination-wrapper'),
                $filterForm = $ajaxHTML.find('form.filter-listing-form');

            // Replace jobs
            if ($jobs.length) {
                $('.main-items-wrapper').replaceWith($jobs);
            }
            // Replace pagination
            if ($pagination.length) {
                $('.main-pagination-wrapper').replaceWith($pagination);
            }
            // Replace filter form
            // if ($filterForm.length) {
            //     $('form.filter-listing-form').replaceWith($filterForm);
            //     self.filterListing();
            // }
            // Load images (init Unveil)
            self.layzyLoadImage();
            // pagination
            if ( $('.ajax-pagination').length ) {
                self.infloadScroll = false;
                self.ajaxPaginationLoad();
            }

            if ( $.isFunction( $.fn.select2 ) && typeof wp_job_board_select2_opts !== 'undefined' ) {
                var select2_args = wp_job_board_select2_opts;
                select2_args['allowClear']              = false;
                select2_args['minimumResultsForSearch'] = 10;
                select2_args['width'] = 'auto';
                
                $('select.orderby').select2( select2_args );
            }

            self.updateMakerCards('jobs-google-maps');
            setTimeout(function() {
                // Hide 'loader'
                self.jobsHideLoader();
            }, 100);
        },

        /**
         *  Shop: Initialize infinite load
         */
        ajaxPaginationLoad: function() {
            var self = this,
                $infloadControls = $('body').find('.ajax-pagination'),                   
                nextPageUrl;

            self.infloadScroll = ($infloadControls.hasClass('infinite-action')) ? true : false;
            
            if (self.infloadScroll) {
                self.infscrollLock = false;
                
                var pxFromWindowBottomToBottom,
                    pxFromMenuToBottom = Math.round($(document).height() - $infloadControls.offset().top);
                    //bufferPx = 0;
                
                /* Bind: Window resize event to re-calculate the 'pxFromMenuToBottom' value (so the items load at the correct scroll-position) */
                var to = null;
                $(window).resize(function() {
                    if (to) { clearTimeout(to); }
                    to = setTimeout(function() {
                        var $infloadControls = $('.ajax-pagination'); // Note: Don't cache, element is dynamic
                        pxFromMenuToBottom = Math.round($(document).height() - $infloadControls.offset().top);
                    }, 100);
                });
                
                $(window).scroll(function(){
                    if (self.infscrollLock) {
                        return;
                    }
                    
                    pxFromWindowBottomToBottom = 0 + $(document).height() - ($(window).scrollTop()) - $(window).height();
                    
                    // If distance remaining in the scroll (including buffer) is less than the pagination element to bottom:
                    if (pxFromWindowBottomToBottom < pxFromMenuToBottom) {
                        self.ajaxPaginationGet();
                    }
                });
            } else {
                var $productsWrap = $('body');
                /* Bind: "Load" button */
                $productsWrap.on('click', '.main-pagination-wrapper .apus-loadmore-btn', function(e) {
                    e.preventDefault();
                    self.ajaxPaginationGet();
                });
                
            }
            
            if (self.infloadScroll) {
                $(window).trigger('scroll'); // Trigger scroll in case the pagination element (+buffer) is above the window bottom
            }
        },
        /**
         *  Shop: AJAX load next page
         */
        ajaxPaginationGet: function() {
            var self = this;
            
            if (self.filterAjax) return false;
            
            // Get elements (these can be replaced with AJAX, don't pre-cache)
            var $nextPageLink = $('.apus-pagination-next-link').find('a'),
                $infloadControls = $('.ajax-pagination'),
                nextPageUrl = $nextPageLink.attr('href');
            
            if (nextPageUrl) {
                // Show 'loader'
                $infloadControls.addClass('apus-loader');
                
                self.setPushState(nextPageUrl);

                self.filterAjax = $.ajax({
                    url: nextPageUrl,
                    data: {
                        load_type: 'items'
                    },
                    dataType: 'html',
                    cache: false,
                    headers: {'cache-control': 'no-cache'},
                    method: 'GET',
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log('APUS: AJAX error - ajaxPaginationGet() - ' + errorThrown);
                    },
                    complete: function() {
                        // Hide 'loader'
                        $infloadControls.removeClass('apus-loader');
                    },
                    success: function(response) {
                        var $response = $('<div>' + response + '</div>'), // Wrap the returned HTML string in a dummy 'div' element we can get the elements
                            $gridItemElement = $('.items-wrapper', $response).html(),
                            $resultCount = $('.results-count .last', $response).html(),
                            $display_mode = $('.main-items-wrapper').data('display_mode');
                        

                        // Append the new elements
                        if ( $display_mode == 'grid' || $display_mode == 'simple') {
                            $('.main-items-wrapper .items-wrapper .row').append($gridItemElement);
                        } else {
                            $('.main-items-wrapper .items-wrapper').append($gridItemElement);
                        }
                        
                        // Append results
                        $('.main-items-wrapper .results-count .last').html($resultCount);

                        // Update Maps
                        self.updateMakerCards('jobs-google-maps');

                        // Load images (init Unveil)
                        self.layzyLoadImage();
                        
                        // Get the 'next page' URL
                        nextPageUrl = $response.find('.apus-pagination-next-link').children('a').attr('href');
                        
                        if (nextPageUrl) {
                            $nextPageLink.attr('href', nextPageUrl);
                        } else {
                            $('.main-items-wrapper').addClass('all-jobs-loaded');
                            
                            if (self.infloadScroll) {
                                self.infscrollLock = true;
                            }
                            $infloadControls.find('.apus-loadmore-btn').addClass('hidden');
                            $nextPageLink.removeAttr('href');
                        }
                        
                        self.filterAjax = false;
                        
                        if (self.infloadScroll) {
                            $(window).trigger('scroll'); // Trigger 'scroll' in case the pagination element (+buffer) is still above the window bottom
                        }
                    }
                });
            } else {
                if (self.infloadScroll) {
                    self.infscrollLock = true; // "Lock" scroll (no more products/pages)
                }
            }
        },
        filterListing: function() {
            var self = this;
            
            $('.tax-radios-field .form-group-inner > ul, .tax-checklist-field .form-group-inner > ul').scrollbar();

            if ( $.isFunction( $.fn.slider ) ) {
                $('.search-distance-slider').each(function(){
                    var $this = $(this);
                    var search_distance = $this.closest('.search-distance-wrapper').find('input[name^=filter-distance]');
                    var search_wrap = $this.closest('.search_distance_wrapper');
                    $(this).slider({
                        range: "min",
                        value: search_distance.val(),
                        min: 0,
                        max: 100,
                        slide: function( event, ui ) {
                            search_distance.val( ui.value );
                            $('.text-distance', search_wrap).text( ui.value );
                            $('.distance-custom-handle', $this).attr( "data-value", ui.value );
                            search_distance.trigger('change');
                        },
                        create: function() {
                            $('.distance-custom-handle', $this).attr( "data-value", $( this ).slider( "value" ) );
                        }
                    } );
                } );

                $('.main-range-slider').each(function(){
                    var $this = $(this);
                    $this.slider({
                        range: true,
                        min: $this.data('min'),
                        max: $this.data('max'),
                        values: [ $this.parent().find('.filter-from').val(), $this.parent().find('.filter-to').val() ],
                        slide: function( event, ui ) {
                            $this.parent().find('.from-text').text( ui.values[ 0 ] );
                            $this.parent().find('.filter-from').val( ui.values[ 0 ] )
                            $this.parent().find('.to-text').text( ui.values[ 1 ] );
                            $this.parent().find('.filter-to').val( ui.values[ 1 ] );
                            $this.parent().find('.filter-to').trigger('change');
                        }
                    } );
                });

                $('.salary-range-slider').each(function(){
                    var $this = $(this);
                    $this.slider({
                        range: true,
                        min: $this.data('min'),
                        max: $this.data('max'),
                        values: [ $this.parent().find('.filter-from').val(), $this.parent().find('.filter-to').val() ],
                        slide: function( event, ui ) {
                            $this.parent().find('.from-text .price-text').text( self.addCommas(ui.values[ 0 ]) );
                            $this.parent().find('.filter-from').val( ui.values[ 0 ] )
                            $this.parent().find('.to-text .price-text').text( self.addCommas(ui.values[ 1 ]) );
                            $this.parent().find('.filter-to').val( ui.values[ 1 ] );
                            $this.parent().find('.filter-to').trigger('change');
                        }
                    } );
                });
            }

            $('.find-me').on('click', function() {
                $(this).addClass('loading');
                var this_e = $(this);
                var container = $(this).closest('.form-group');

                navigator.geolocation.getCurrentPosition(function (position) {
                    container.find('input[name="filter-center-latitude"]').val(position.coords.latitude);
                    container.find('input[name="filter-center-longitude"]').val(position.coords.longitude);
                    container.find('input[name="filter-center-location"]').val('Location');
                    container.find('.clear-location').removeClass('hidden');

                    var position = [position.coords.latitude, position.coords.longitude];

                    if ( typeof L.esri.Geocoding.geocodeService != 'undefined' ) {
                    
                        var geocodeService = L.esri.Geocoding.geocodeService();
                        geocodeService.reverse().latlng(position).run(function(error, result) {
                            container.find('input[name="filter-center-location"]').val(result.address.Match_addr);
                        });
                    }

                    return this_e.removeClass('loading');
                }, function (e) {
                    return this_e.removeClass('loading');
                }, {
                    enableHighAccuracy: true
                });
            });

            $('.clear-location').on('click', function() {
                var container = $(this).closest('.form-group');

                container.find('input[name="filter-center-latitude"]').val('');
                container.find('input[name="filter-center-longitude"]').val('');
                container.find('input[name="filter-center-location"]').val('');
                container.find('.clear-location').addClass('hidden');
            });
            $('input[name="filter-center-location"]').on('keyup', function(){
                var container = $(this).closest('.form-group');
                var val = $(this).val();
                if ( $(this).val() !== '' ) {
                    container.find('.clear-location').removeClass('hidden');
                } else {
                    container.find('.clear-location').removeClass('hidden').addClass('hidden');
                }
            });
            // search autocomplete location
            if ( typeof L.Control.Geocoder.Nominatim != 'undefined' ) {
                
                if ( typeof wp_job_board_opts != 'undefined' && wp_job_board_opts.geocoder_country ) {
                    var geocoder = new L.Control.Geocoder.Nominatim({
                        geocodingQueryParams: {countrycodes: wp_job_board_opts.geocoder_country, lang: wp_job_board_opts.geocoder_country}
                    });
                } else {
                    var geocoder = new L.Control.Geocoder.Nominatim();
                }

                function delay(fn, ms) {
                    let timer = 0
                    return function(...args) {
                        clearTimeout(timer)
                        timer = setTimeout(fn.bind(this, ...args), ms || 0)
                    }
                }

                $("input[name=filter-center-location]").attr('autocomplete', 'off').after('<div class="leaflet-geocode-container"></div>');
                $("input[name=filter-center-location]").on("keyup", delay(function (e) {
                    var s = $(this).val(), $this = $(this), container = $(this).closest('.form-group-inner');
                    if (s && s.length >= 2) {
                        
                        $this.parent().addClass('loading');
                        geocoder.geocode(s, function(results) {
                            var output_html = '';
                            for (var i = 0; i < results.length; i++) {
                                output_html += '<li class="result-item" data-latitude="'+results[i].center.lat+'" data-longitude="'+results[i].center.lng+'" ><i class="fa fa-map-marker" aria-hidden="true"></i> '+results[i].name+'</li>';
                            }
                            if ( output_html ) {
                                output_html = '<ul>'+ output_html +'</ul>';
                            }

                            container.find('.leaflet-geocode-container').html(output_html).addClass('active');

                            var highlight_texts = s.split(' ');

                            highlight_texts.forEach(function (item) {
                                container.find('.leaflet-geocode-container').highlight(item);
                            });

                            $this.parent().removeClass('loading');
                        });
                    } else {
                        container.find('.leaflet-geocode-container').html('').removeClass('active');
                    }
                }, 500));
                $('.form-group-inner').on('click', '.leaflet-geocode-container ul li', function() {
                    var container = $(this).closest('.form-group-inner');
                    container.find('input[name=filter-center-latitude]').val($(this).data('latitude'));
                    container.find('input[name=filter-center-longitude]').val($(this).data('longitude'));
                    container.find('input[name=filter-center-location]').val($(this).text());
                    container.find('.leaflet-geocode-container').removeClass('active').html('');
                });
            }

        },
        addCommas: function(str) {
            var parts = (str + "").split("."),
                main = parts[0],
                len = main.length,
                output = "",
                first = main.charAt(0),
                i;
            
            if (first === '-') {
                main = main.slice(1);
                len = main.length;    
            } else {
                first = "";
            }
            i = len - 1;
            while(i >= 0) {
                output = main.charAt(i) + output;
                if ((len - i) % 3 === 0 && i > 0) {
                    output = wp_job_board_opts.money_thousands_separator + output;
                }
                --i;
            }
            // put sign back
            output = first + output;
            // put decimal part back
            if (parts.length > 1) {
                output += wp_job_board_opts.money_dec_point + parts[1];
            }
            return output;
        }
        
    });

    $.apusThemeExtensions.job = $.apusThemeCore.job_init;

    
})(jQuery);
