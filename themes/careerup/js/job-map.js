(function($) {
    "use strict";
    
    var map, mapSidebar, markers, CustomHtmlIcon, group;
    var markerArray = [];

    $.extend($.apusThemeCore, {
        /**
         *  Initialize scripts
         */
        job_map_init: function() {
            var self = this;

            if ($('#jobs-google-maps').length) {
                L.Icon.Default.imagePath = 'wp-content/themes/careerup/images/';
            }
            
            setTimeout(function(){
                self.mapInit('jobs-google-maps');

                self.getJobs('jobs-google-maps');
            }, 50);
            
        },
        getJobs: function(map_e_id) {
            var self = this;
            if ( $('.widget-jobs-maps .jobs-google-maps').length ) {
                $('.widget-jobs-maps .jobs-google-maps').each(function(e){
                    var $this = $(this);
                    
                    $this.addClass('loading');
                    var $settings = $(this).data('settings');

                    var ajaxurl = careerup_job_opts.ajaxurl;
                    if ( typeof wp_job_board_opts.ajaxurl_endpoint !== 'undefined' ) {
                        var ajaxurl =  wp_job_board_opts.ajaxurl_endpoint.toString().replace( '%%endpoint%%', 'careerup_get_ajax_jobs' );
                    }
                    
                    $.ajax({
                        url: ajaxurl,
                        type:'POST',
                        dataType: 'html',
                        data: {
                            action: 'careerup_get_ajax_jobs',
                            settings: $settings,
                        }
                    }).done(function(data) {
                        $this.removeClass('loading');
                        $this.closest('.widget-jobs-maps').find('.main-items-wrapper').html(data);
                        setTimeout(function(){
                            self.updateMakerCards(map_e_id);
                        });
                    });
                });
            }
        },
        mapInit: function(map_e_id) {
            var self = this;

            var $window = $(window);

            if (!$('#' + map_e_id).length) {
                return;
            }

            map = L.map(map_e_id, {
                scrollWheelZoom: false
            });

            markers = new L.MarkerClusterGroup({
                showCoverageOnHover: false
            });

            CustomHtmlIcon = L.HtmlIcon.extend({
                options: {
                    html: "<div class='map-popup'></div>",
                    iconSize: [30, 30],
                    iconAnchor: [22, 30],
                    popupAnchor: [0, -30]
                }
            });

            $window.on('pxg:refreshmap', function() {
                map._onResize();
                setTimeout(function() {
                    if(markerArray.length > 0 ){
                        group = L.featureGroup(markerArray);
                        map.fitBounds(group.getBounds()); 
                    }
                }, 100);
            });

            $window.on('pxg:simplerefreshmap', function() {
                map._onResize();
            });

            $(window).resize(function(){
                map._onResize();
                setTimeout(function() {
                    if(markerArray.length > 0 ){
                        group = L.featureGroup(markerArray);
                        map.fitBounds(group.getBounds()); 
                    }
                }, 100);
            });
            
            if ( careerup_job_map_opts.map_service == 'mapbox' ) {
                var tileLayer = L.tileLayer('https://api.mapbox.com/styles/v1/mapbox/'+careerup_job_map_opts.mapbox_style+'/tiles/{z}/{x}/{y}?access_token='+ careerup_job_map_opts.mapbox_token, {
                    attribution: " &copy;  <a href='https://www.mapbox.com/about/maps/'>Mapbox</a> &copy;  <a href='http://www.openstreetmap.org/copyright'>OpenStreetMap</a> <strong><a href='https://www.mapbox.com/map-feedback/' target='_blank'>Improve this map</a></strong>",
                    maxZoom: 18,
                });
            } else {
                if ( careerup_job_map_opts.custom_style != '' ) {
                    try {
                        var custom_style = $.parseJSON(careerup_job_map_opts.custom_style);
                        var tileLayer = L.gridLayer.googleMutant({
                            type: 'roadmap',
                            styles: custom_style
                        });

                    } catch(err) {
                        var tileLayer = L.gridLayer.googleMutant({
                            type: 'roadmap'
                        });
                    }
                } else {
                    var tileLayer = L.gridLayer.googleMutant({
                        type: 'roadmap'
                    });
                }
                $('#apus-listing-map').addClass('map--google');
            }

            map.addLayer(tileLayer);

            // check archive/single page
            if ( !$('#' + map_e_id).is('.single-job-map') ) {
                self.updateMakerCards(map_e_id);
            } else {
                var $item = $('.single-listing-wrapper');
                
                if ( $item.data('latitude') !== "" && $item.data('latitude') !== "" ) {
                    var zoom = (typeof MapWidgetZoom !== "undefined") ? MapWidgetZoom : 15;
                    self.addMakerToMap($item);
                    map.addLayer(markers);
                    //map.setActiveArea('active-area');
                    map.setView([$item.data('latitude'), $item.data('longitude')], zoom);
                    $(window).on('update:map', function() {
                        map.setView([$item.data('latitude'), $item.data('longitude')], zoom);
                    });
                } else {
                    $('#' + map_e_id).hide();
                }
            }
        },
        updateMakerCards: function(map_e_id) {
            var self = this;
            var $items = $('.jobs-listing-wrapper .job_listing');
            if ($('#' + map_e_id).length && typeof map !== "undefined") {

                if (!$items.length) {
                    map.setView([careerup_job_map_opts.default_latitude, careerup_job_map_opts.default_longitude], 12);
                    return;
                }
                
                map.removeLayer(markers);
                markers = new L.MarkerClusterGroup({
                    showCoverageOnHover: false
                });
                $items.each(function(i, obj) {
                    self.addMakerToMap($(obj), true);
                });
                // map.fitBounds(markers, {
                //     padding: [50, 50]
                // });

                map.addLayer(markers);

                if(markerArray.length > 0 ){
                    group = L.featureGroup(markerArray);
                    map.fitBounds(group.getBounds()); 
                }
            }
        },
        addMakerToMap: function($item, archive) {
            var self = this;
            var marker;

            if ( $item.data('latitude') == "" || $item.data('longitude') == "") {
                return;
            }

            var mapPinHTML = "<div class='map-popup'><div class='icon-wrapper'></div></div>";

            marker = L.marker([$item.data('latitude'), $item.data('longitude')], {
                icon: new CustomHtmlIcon({ html: mapPinHTML })
            });

            if (typeof archive !== "undefined") {

                $item.on('mouseenter', function() {
                    $(marker._icon).find('.map-popup').addClass('map-popup-selected');
                }).on('mouseleave', function(){
                    $(marker._icon).find('.map-popup').removeClass('map-popup-selected');
                });

                var logo_html = '';
                if ( $item.find('.employer-logo img').length ) {
                    logo_html =  "<div class='image-wrapper image-loaded'>" +
                                "<img src='" + $item.find('.employer-logo img').attr('src') + "' alt=''>" +
                            "</div>";
                }

                var title_html = '';
                if ( $item.find('.job-title').length ) {
                    title_html = "<div class='job-title'>" + $item.find('.job-title').html() + "</div>";
                }
                var meta_html = '';
                if ( $item.find('.job-metas').length ) {
                    meta_html = "<div class='job-metas'>" + $item.find('.job-metas').html() + "</div>";
                }

                marker.bindPopup(
                    "<div class='job-grid-style'>" +
                        "<div class='listing-image'>" + logo_html +
                            "<div class='listing-title-wrapper'>" + title_html + meta_html + "</div>" +
                        "</div>" + 
                    "</div>").openPopup();
            }

            markers.addLayer(marker);
            markerArray.push(L.marker([$item.data('latitude'), $item.data('longitude')]));
        },
        
    });

    $.apusThemeExtensions.job_map = $.apusThemeCore.job_map_init;

    
})(jQuery);
