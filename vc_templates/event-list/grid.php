<section class="list-event-of-month <?php echo esc_attr( $css_class ); ?>" id="<?php echo esc_html($randomID) ?>">
    <div class="container">
        <div class="title-section">
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
        <div class="citysoul-list-event citysoul-event-month">
            <ul class="citysoul-event-list grid-list">
                <?php   
                while ($loop->have_posts())  : $loop->the_post() ;
                $unixtimestamp = $choose_artis = '';
                $id_event = get_the_ID();
                if (function_exists('get_field')) {
                    $unixtimestamp = strtotime(get_field('date_event'));
                    $choose_artis = get_field('choose_artis');

                    $link = get_field('buy_link');
                    if($link != '') {
                        $buy_link = $link;
                    } else{
                        $buy_link = get_the_permalink($id_event);
                    }
                }
                ?>
                    <li class="event-date col-md-3 col-sm-6 col-xs-12">
                        <div class="event-cover-name">
                            <a href="<?php the_permalink() ?>">
                                <?php 
                                  if( has_post_thumbnail() ) {
                                    echo citysoul_get_the_post_lazyload_thumbnail(get_the_ID(), 'full');
                                  }
                                ?>
                            </a>
                        </div><!--End .event-cover-name-->
                        <div class="detail-event-day">
                            <div class="info-event">
                                <p class="citysoul-date text-white">
                                     <em class="text-more"><?php echo date_i18n(( get_option('date_format') ), $unixtimestamp) ; ?></em> 
                                </p>
                                <?php 
                                $event_title = get_the_title();
                                if ('' != $event_title): ?>
                                    <span class="title-event text-title text-white">
                                        <a href="<?php the_permalink($id_event) ?>" class="title-small text-title">
                                            <?php echo esc_html($event_title) ?>
                                        </a>
                                    </span>
                                    <div class="clearfix"></div>
                                <?php endif ?>
                                <?php 
                                    if($choose_artis != '') {
                                ?>
                                 <span class="dj-play">
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
                                        ?>
                                 </span>
                                 <?php } ?>
                            <?php if($enable_link == 'enable'): ?>
                                 <a class="citysoul-button text-title btn-buy" href="<?php echo esc_url($buy_link); ?>"><?php echo esc_html_e('Book Now','citysoul') ?> <i class="fa fa-ticket"></i></a>
                            <?php endif; ?>
                            </div><!--End .info-event-->
                        </div>
                    </li>
                <?php 
                    endwhile; 
                    wp_reset_postdata();
                ?>
            </ul>
        </div>
    </div>
</section>