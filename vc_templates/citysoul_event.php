<?php 
$option = $list_event_title = $list_event_description = $list_event_link = $id_category = $event_id = $max_items =  $css = '';
$title_color = $description_color = $date_color = $border_event_hover_color = $title_event_color = $description_event_color = $button_ticket_color = $icon_button_ticket_color = $button_ticket_background = $artist_event_color = $button_today_ticket_background = $enable_link = $text_option = '';
extract(shortcode_atts(array(
    'option'                            =>  '',
    'list_event_title'                  =>  '',
    'list_event_description'            =>  '',
    'list_event_link'                   =>  '',
    'id_category'                       =>  '',
    'event_id'                          =>  '',
    'max_items'                         =>  '',
    'title_color'                       =>  '',
    'description_color'                 =>  '',
    'date_color'                        =>  '',
    'border_event_hover_color'          =>  '',
    'title_event_color'                 =>  '',
    'description_event_color'           =>  '',
    'button_ticket_color'               =>  '',
    'icon_button_ticket_color'          =>  '',
    'button_ticket_background'          =>  '',
    'artist_event_color'                =>  '',
    'button_today_ticket_background'    =>  '', 
    'enable_link'                       =>  '',   
    'text_option'                       =>  '',
    'css'                               =>  '',
), $atts));

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

// Make a random ID for shortcode
$id_ran = rand(1, 99999);
$randomID   =  'upcomming_'.$id_ran;

$event_id_list = '';
if(!empty($event_id)) {
    $event_id_list = explode(',', $event_id);
}

if($option == ''){
    $option = 'slide';
}

$href = vc_build_link( $list_event_link );
if ($href['title'] == '') {
    $href['title'] = $href['url'];
}
if ($href['url'] == '') {
    $href['url'] = '#';
}

//Loop event
$args = array(
    'post_type'         => 'event',
    'posts_per_page'    => $max_items,
    'order'             => 'ASC',
    'orderby'           => 'meta_value_num',
    'meta_key'          => 'date_event',
);
if( $id_category != '' && $id_category != 'All') {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'category_event',
            'field' => 'slug',
            'terms' => $id_category
        )
    );
}
if($list_event_link == ''){
    $list_event_link = '#';
}

if($enable_link == '') {
    $enable_link = 'enable';
}

if($text_option == '') {
    $text_option = 'left';
}

if($text_option == 'center') {
    $custom_css = 'text-center-event';
} else {
    $custom_css = '';
}
$loop = new WP_Query( $args );
wp_reset_postdata();
//end loop event

//Setup style for shortcode
$setup      = array(
    '.citysoul-title' => array(
        'color'                 => $title_color,
    ),
    '.citysoul-desc' => array(
        'color'                 => $description_color,
    ),
    '.citysoul-date .text-more' => array(
        'color'                 => $date_color,
    ),
    '.citysoul-date .text-title' => array(
        'color'                 => $date_color,
    ),
    '.upcomming-item .info-slide:before' => array(
        'border-color'            => $border_event_hover_color,
        'background'            => $button_today_ticket_background,
    ),
    '.title-small' => array(
        'color'                 => $title_event_color,
    ),
    '.text-title a' => array(
        'color'                 => $title_event_color,
    ),
    
    '.citysoul-event-list .event-date .detail-event-day .dj-play' => array(
        'color'                 => $description_event_color,
    ),
    '.desc-small' => array(
        'color'                 => $artist_event_color,
    ),
    '.btn-buy' => array(
        'color'                 => $button_ticket_color,
        'background'            => $button_ticket_background,
    ),
    '.btn-buy i' => array(
        'color'                 => $icon_button_ticket_color,
    ),
    '.citysoul-event-list .event-date .detail-event-day' => array(
        'background'            => $button_today_ticket_background,
    ),
    '.event-row.active-event'   => array(
        'background'            => $button_today_ticket_background,
    ),
);
// Make css style for shortcode
echo citysoul_css_shortcode($randomID, $setup);
include(dirname(__FILE__).'/event-list/'.$option.'.php');