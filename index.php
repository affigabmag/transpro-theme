<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header();
?>

<div class="container mx-auto px-4 py-8">
    <?php
    if (have_posts()) :

        if (is_home() && !is_front_page()) :
            ?>
            <header>
                <h1 class="page-title text-2xl font-bold mb-6"><?php single_post_title(); ?></h1>
            </header>
            <?php
        endif;

        /* Start the Loop */
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('mb-8 pb-8 border-b border-gray-200'); ?>>
                <header class="entry-header mb-4">
                    <?php
                    the_title('<h2 class="entry-title text-xl font-bold"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                    
                    if ('post' === get_post_type()) :
                        ?>
                        <div class="entry-meta text-gray-600 text-sm mt-2">
                            <?php
                            printf(
                                /* translators: %s: post date */
                                esc_html__('Posted on %s', 'transpro'),
                                '<time datetime="' . esc_attr(get_the_date('c')) . '">' . esc_html(get_the_date()) . '</time>'
                            );
                            
                            if (get_the_author()) {
                                printf(
                                    /* translators: %s: post author */
                                    esc_html__(' by %s', 'transpro'),
                                    '<span class="author">' . esc_html(get_the_author()) . '</span>'
                                );
                            }
                            ?>
                        </div>
                    <?php endif; ?>
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-thumbnail mb-4">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium', ['class' => 'rounded']); ?>
                        </a>
                    </div>
                <?php endif; ?>

                <div class="entry-content">
                    <?php
                    the_excerpt();
                    ?>
                </div>

                <footer class="entry-footer mt-4">
                    <a href="<?php the_permalink(); ?>" class="text-blue-600 hover:text-blue-800 font-medium">
                        <?php esc_html_e('Read more', 'transpro'); ?>
                    </a>
                </footer>
            </article>
            <?php
        endwhile;

        the_posts_pagination(array(
            'mid_size'  => 2,
            'prev_text' => esc_html__('Previous', 'transpro'),
            'next_text' => esc_html__('Next', 'transpro'),
            'class'     => 'mt-8',
        ));

    else :
        ?>
        <div class="no-results">
            <h2 class="text-xl font-bold mb-4"><?php esc_html_e('Nothing Found', 'transpro'); ?></h2>
            <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'transpro'); ?></p>
            
            <div class="search-form max-w-md mt-6">
                <?php get_search_form(); ?>
            </div>
        </div>
        <?php
    endif;
    ?>
</div>

<?php
get_footer();