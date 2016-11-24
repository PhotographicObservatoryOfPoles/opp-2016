<?php
/**
 * The template for displaying all posts sharing same taxonomy term
 */

get_header(); 


$term = get_queried_object(); 
$taxonomy = $term->taxonomy;

$items = new WP_Query( array(
    'orderby'        => 'date',
    'order'          => 'DESC',
    'posts_per_page' => -1,
    'post_type'      => array( 'photos-gallery', 'expedition' ),
    'post_status'    => 'publish',
    'meta_query'     => array(array(
                'key' => $taxonomy,
                'value' => '"' . $term->term_id . '"',
                'compare' => 'LIKE'
            )
        )
    )
);
$index = 0;

?>

<!-- Title -->
<section class="main-title main-title--page">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <h2><?php echo $term->name; ?></h2>
            </div>
        </div>
    </div>
</section>

<?php if ( $items->have_posts() ) : ?>
    <section class="container">
        <div class="row transitions-enabled fluid masonry js-masonry grid">
            <?php while ( $items->have_posts() ) : $index++;
                    // Post
                    $item = get_post( $items->the_post() );
                    // Thumbnail
                    $thumbnail = get_the_post_thumbnail( $item, 'large' );
                    // Auhtors
                    $authors = get_authors( $item, $locale );
                    // Terms (theme & region)
                    $terms = get_theme_region_terms( $item, true );
                    // Description
                    $description = $item->post_type === 'photos-gallery' ? get_field( 'description', $item, false ) :
                                    wp_strip_all_tags( get_post_field( 'post_content', $item ) );
                    $description = strlen($description) > 200 ? mb_substr( $description, 0, 200 ) . '...' : $description;
            ?>
                <div class="col-sm-6 col-md-6 <?php echo $index % 2 !== 0 ? 'break' : ''; ?> grid-item">
                    <div class="thumbnail">
                        <div class="image">
                            <?php if ( $thumbnail ) : ?>
                                <?php echo $thumbnail; ?>
                            <?php else: ?>
                                <img src="<?php bloginfo('template_directory'); ?>/img/default/cover_image.jpg" alt="" />
                            <?php endif; ?>
                            <button class="read-more-button" role="button">
                                <span class="btn btn-default"><?php echo __( 'See more', 'opp' ); ?></span>
                            </button>
                        </div>
                        <div class="caption">
                            <small class="post-type"><?php echo $item->post_type === 'photos-gallery' ? __( 'gallery', 'opp' ) : __( 'expedition', 'opp' ); ?></small>
                            <h3><?php echo $item->post_title; ?></h3>
                            <h4>
                                <?php foreach ( $authors['posts'] as $key => $author ) : ?>
                                    <a href="<?php echo get_permalink( $author->ID ); ?>"><?php echo $author->post_title; ?></a><?php echo $key !== $authors['lastKey'] ? ',' : ''; ?>
                                <?php endforeach; ?>
                            </h4>
                            <p><?php echo $description; ?></p>
                            <a class="read-more-link" href="<?php echo get_permalink( $item ); ?>">
                                <?php echo __( 'See more', 'opp' ); ?>
                                <span class="glyphicon glyphicon-menu-right"></span>
                            </a>
                        </div>
                        <div class="caption tags">
                            <?php foreach ( $terms as $key => $termID ) : $term = get_term( $termID ); ?>
                                <a href="<?php echo get_term_link( $termID ); ?>" class="label label-primary"><?php echo $term->name; ?></a>
                            <?php endforeach; ?>
                        </div>
                        <a class="read-more-link" href="<?php echo get_permalink( $item ); ?>" title="<?php echo __( 'See more', 'opp' ); ?>"></a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

    </section>
<?php endif; ?>
<?php wp_reset_postdata(); ?>
<?php $post = null; ?>

<?php get_footer(); ?>