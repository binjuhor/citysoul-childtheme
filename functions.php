<?php
/**
 * Functions for Citysoul child theme
 * @author Binjuhor - <binjuhor@gmail.com>
 */

function citysoul_child_theme_style() {
	wp_enqueue_style( 'citysoul_child-childtheme-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'citysoul_child_theme_style' , 10);

/* Insert custom functions below */
add_action('citysoul_timetable_script_hook', 'citysoul_timetable_script', 10, 2);
if (!function_exists('citysoul_timetable_script')) {
    function citysoul_timetable_script($element, $arr = array())
    {
        ?>
        <script>
            $(document).ready(function() {
                "use strict";
                var $calendar = jQuery("#<?php echo esc_attr($element); ?>");
                var $select_year = jQuery("#select_year_<?php echo esc_attr($element); ?>");
                var $select_month = jQuery("#select_month_<?php echo esc_attr($element); ?>");
                var $select_month_m = jQuery("#select_month_<?php echo esc_attr($element); ?>_m");
                var $select_locale = jQuery("#select_locale_<?php echo esc_attr($element); ?>");
                var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
                var initialLocaleCode = 'en';
                $select_month_m.hide();
                $select_year.selectbox();
                $select_year.change(function() {
                    var year = this.value;
                    if (year) {
                        var data = {
                            action: 'citysoul_timetable_change_event',
                            year : year,
                        };
                        jQuery.post(ajaxurl, data, function(response) {
                            if(response.isEmptyObject != true) {
                                data = JSON.parse(response);
                                $calendar.fullCalendar('gotoDate', data.event[0].start);
                                $calendar.fullCalendar('removeEvents');
                                $calendar.fullCalendar('addEventSource' ,data.event);
                                $calendar.fullCalendar('rerenderEvents');
                                if(data.month.isEmptyObject != true) {
                                    $select_month.empty();
                                    $select_month_m.show();
                                    $select_month_m.attr('year',year);
                                    $.each(data.month, function(key, value) {
                                         $select_month
                                                .append($('<option>', { value : value })
                                                .text(value));
                                    });
                                    $select_month.selectbox();
                                }
                            }
                        });
                    }
                });

                //Month before change
                var currentTime = new Date();
                var year        = currentTime.getFullYear();
                if (year) {
                    var data = {
                        action: 'citysoul_timetable_change_event',
                        year : year,
                    };
                    jQuery.post(ajaxurl, data, function(response) {
                        if(response.isEmptyObject != true) {
                            data = JSON.parse(response);
                            $calendar.fullCalendar('gotoDate', data.event[0].start);
                            $calendar.fullCalendar('removeEvents');
                            $calendar.fullCalendar('addEventSource' ,data.event);
                            $calendar.fullCalendar('rerenderEvents');
                            if(data.month.isEmptyObject != true) {
                                $select_month.empty();
                                $select_month_m.show();
                                $select_month_m.attr('year',year);
                                $.each(data.month, function(key, value) {
                                     $select_month
                                            .append($('<option>', { value : value })
                                            .text(value));
                                });
                                $select_month.selectbox();
                            }
                        }
                    });
                }

                $select_month.change(function() {
                    var month = this.value;
                    if (month) {
                        var year =  $select_month_m.attr('year');
                        var data_m = {
                            action : 'citysoul_timetable_change_event',
                            year : year,
                            month : month,
                        };
                        jQuery.post(ajaxurl, data_m, function(response) {
                            if(response.isEmptyObject != true) {
                                data_m = JSON.parse(response);
                                $calendar.fullCalendar('gotoDate', data_m.event[0].start);
                                $calendar.fullCalendar('removeEvents');
                                $calendar.fullCalendar('addEventSource' ,data_m.event);
                                $calendar.fullCalendar('rerenderEvents');
                            }
                        });
                    }
                });
                $calendar.fullCalendar({
                    theme: true,
                    locale: initialLocaleCode,
                    header: {left: '',center: '',right: ''},
                    windowResize: function(view) {
                    if ($(window).width() < 1280){
                        $calendar.fullCalendar( 'changeView', 'listMonth' );
                    }
                    else {
                        $calendar.fullCalendar( 'changeView', 'month' );
                      }
                    },
                    editable: false,
                    selectable: true,
                    defaultDate: '<?php print(citysoul_timetable_get_event_default($arr));?>',
                    selectHelper: true,
                    defaultView: "month",
                    isRTL : false,
                    events : <?php print(citysoul_timetable_get_event($arr));?>,
                    displayEventEnd: {
                        month: true,
                        basicWeek: true,
                        "default": true
                    },
                    eventRender: function(event, element) {
                         element.find('.fc-content').append('<div class="ev"><div class="ev__cover"><div class="ev__cover_image"><img src="'+event.cover+'" alt="'+event.title+'"></div><div class="ev__cover_buy"><a href="'+event.buy_link+'" title="<?php esc_html_e('Book now', 'citysoul')?>" target="_blank"><?php esc_html_e('Book now', 'citysoul')?></a></div></div><div class="ev__title"><a href="'+event.link+'" title="'+event.title+'" target="_blank">'+event.title+'</a><a href="'+event.buy_link+'" title="'+event.title+'" target="_blank" class="ev__title_buy fa fa-ticket"></a></div><div class="ev__by"><span class="ev__by_job">'+event.jobs+'</span><span class="ev__by_name">'+event.artist+'</span></div><div class="ev__tags"><span>'+event.tags.join('</span> <span>')+'</span></div></div>');
                        element.find('.fc-list-item-title').append('<div class="ev"><div class="ev__title"><a href="'+event.link+'" title="'+event.title+'" target="_blank">'+event.title+'</a><a href="'+event.link+'" title="<?php esc_html_e('Book now', 'citysoul')?>" target="_blank" class="ev__title_buy fa fa-ticket"></a></div><div class="ev__by"><span class="ev__by_job">'+event.jobs+'</span><span class="ev__by_name">'+event.artist+'</span></div></div>');
                        element.find('.fc-content .fc-title').remove();
                    },
                });
                $.each($.fullCalendar.locales, function(localeCode) {
                    $select_locale.append(
                        $('<option/>')
                            .attr('value', localeCode)
                            .text(localeCode)
                    );
                });
                $select_locale.selectbox();
                $select_locale.change(function() {
                    if (this.value) {
                        $calendar.fullCalendar('option', 'locale', this.value);
                    }
                });
            });
        </script>
        <?php
	}
}
