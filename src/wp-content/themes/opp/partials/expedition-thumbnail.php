<div class="col-sm-6 col-md-6 grid-item">
  	<div class="thumbnail">
        <div class="image">
            <?php if ( $thumbnail ) : ?>
               <?php echo $thumbnail; ?>
            <?php else : ?>
                <img src="<?php bloginfo('template_directory'); ?>/img/default/cover_image.jpg" alt="<?php echo $post->post_title; ?>" />
            <?php endif; ?>
            <button class="read-more-button" role="button">
                <span class="btn btn-default"><?php echo __( 'See more', 'opp' ); ?></span>
            </button>
        </div>
        <div class="caption">
            <h3><?php echo $post->post_title; ?></h3>
            <h4>
                <?php foreach ( $authors['posts'] as $key => $author ) : ?>
                    <a href="<?php echo get_permalink( $author->ID ); ?>"><?php echo $author->post_title; ?></a><?php echo $key !== $authors['lastKey'] ? ',' : ''; ?>
                <?php endforeach; ?>
            </h4>
            <p><?php echo $description; ?></p>
            <a class="read-more-link" href="<?php echo get_permalink( $post ); ?>">
                <?php echo __( 'See more', 'opp' ); ?>
                <span class="glyphicon glyphicon-menu-right"></span>
            </a>
        </div>
        <div class="caption tags">
            <?php foreach ( $terms as $key => $termID ) : $term = get_term( $termID ); ?>
                <a href="<?php echo get_term_link( $termID ); ?>" class="label label-primary"><?php echo $term->name; ?></a>
            <?php endforeach; ?>
        </div>
        <a class="read-more-link" href="<?php echo get_permalink( $post ); ?>" title="<?php echo __( 'See more', 'opp' ); ?>"></a>
    </div>
</div>