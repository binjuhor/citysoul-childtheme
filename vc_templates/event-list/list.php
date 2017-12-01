<section class="list-event-of-month <?php echo esc_attr( $css_class ); ?>" id="<?php echo esc_html($randomID) ?>">
    <div class="citysoul-list-event citysoul-event-month">
        <div class=" container title-section">
            <?php if ($list_event_title != ''): ?>
                <div class="citysoul-title text-title text-white <?php echo esc_attr($custom_css); ?>">
                    <?php echo esc_html($list_event_title) ?>
                </div>
            <?php endif ?>
            <?php if ($list_event_description != ''): ?>
                <div class="citysoul-desc text-title text-active <?php echo esc_attr($custom_css); ?>">
                    <?php echo esc_html($list_event_description) ?>
                </div>
            <?php endif ?>
        </div><!--End .title-section-->
        <ul class="citysoul-event-list grid-list-full">
            <?php 
            while ($loop->have_posts())  : $loop->the_post() ;
            $id_event = get_the_ID();
            $unixtimestamp = $choose_artis = $start_date = $end_date = $location = '';
            if (function_exists('get_field')) {
                $choose_artis = get_field('choose_artis');
                $unixtimestamp = strtotime(get_field('date_event'));
                $start_date = get_field('start_date');
                $end_date = get_field('end_date');
                $location = get_field('location');
            }
            $today = date( 'm/d/Y', current_time( 'timestamp', 0 ) );
            $timestamp_today = strtotime($today);

            $active_event = '';
            if($unixtimestamp == $timestamp_today){
                $active_event = 'active-event';
            }

            $link = get_field('buy_link', $id_event);
            if($link != ''){
                $buy_link = $link;
            } else {
                $buy_link = get_the_permalink($id_event);
            }
            ?>
                <li class="event-date event-row <?php echo esc_html($active_event) ?>">
                    <div class="citysoul-date date-event date-full col-md-2 col-sm-2 col-xs-12">
                        <em class="text-more"><?php echo date_i18n(( get_option('date_format') ), $unixtimestamp) ; ?></em>
                    </div>
                     <div class="event-cover col-md-2 col-sm-4">
                        <div class="img-event-list">
                            <a href="<?php the_permalink() ?>">
                                <?php 
                                  if( has_post_thumbnail() ) {
                                    echo citysoul_get_the_post_lazyload_thumbnail(get_the_ID(), 'full');
                                  }
                                ?>
                            </a>
                        </div>
                    </div><!--End .event-cover-->
                    <div class="title-event title-full col-md-4 col-sm-4 citysoul-event-title">
                        <?php 
                        $event_title = get_the_title();
                        if ('' != $event_title): ?>
                            <span class="title-event text-title text-white">
                                <a href="<?php the_permalink() ?>" class="event-title citysoul-title text-16x text-active text-title">
                                    <?php echo esc_html($event_title) ?>
                                </a>
                            </span>
                            <div class="clearfix"></div>
                        <?php endif ?>

                        <?php if ($start_date != ''): ?>
                            <span class="dj-play start-at text-1x">
                                <strong class="text-title"><?php echo esc_html_e('Start','citysoul') ?> :</strong>
                                <em class="text-more text-16x"><?php echo esc_html($start_date) ?></em>
                            </span>
                        <?php endif ?>

                        <?php if ($end_date != ''): ?>
                            <span class="dj-play start-at text-1x">
                                <strong class="text-title"><?php echo esc_html_e('End','citysoul') ?> :</strong>
                                <em class="text-more text-16x"><?php echo esc_html($end_date) ?></em>
                            </span>
                        <?php endif ?>

                        <?php if ($location != ''): ?>
                            <span class="dj-play start-at text-1x">
                                <strong class="text-title"><?php echo esc_html_e('Location','citysoul') ?> :</strong>
                                <em class="text-more text-16x"><?php echo esc_html($location) ?></em>
                            </span>
                        <?php endif ?>
                        
                        <?php 
                            if($choose_artis != '') {
                        ?>
                        <span class="dj-play dj-name text-1x">
                            <strong class="text-title"><?php echo esc_html_e('Artist','citysoul') ?> :</strong>
                            <?php 
                                $args_artis = array(
                                    'post_type' => 'artist',
                                    'post__in' => $choose_artis,
                                );
                                $loop_artis = new WP_Query( $args_artis );
                                wp_reset_postdata();
                                while ($loop_artis->have_posts())  : $loop_artis->the_post() ; ?>
                                    <em class="text-more text-16x">
                                        <?php echo get_the_title(); ?>
                                    </em>
                                <?php 
                                    endwhile; 
                                    wp_reset_postdata();
                                ?>
                         </span>
                         <?php } ?>
                        <span class="tag-event text-1x">
                            <span class="tags-list">
                                <?php if( have_rows('tags_list',$id_event) ): ?>
                                    <span class="tags-list">
                                        <?php while ( have_rows('tags_list', $id_event) ) : the_row();
                                            $tags = get_sub_field('tags');
                                        ?>
                                            <a class="text-more"><?php echo esc_html($tags) ?></a>
                                        <?php 
                                        endwhile; 
                                        ?>
                                    </span>
                                <?php endif; ?>
                            </span>
                        </span>
                    </div>
                    <div class="buy-ticket-event">
                    <?php if($enable_link == 'enable'): ?>
                        <a class="citysoul-button citysoul-button-o text-active text-title btn-buy" href="<?php echo esc_url($buy_link); ?>"><?php echo esc_html_e('Book Now','citysoul') ?> <i class="fa fa-ticket"></i></a>
                    <?php endif; ?>
                    </div><!--End .buy-ticket-event-->
                </li>
            <?php 
                endwhile; 
                wp_reset_postdata();
            ?>

        </ul>

    </div><!--End .citysoul-event-month-list-->
</section>