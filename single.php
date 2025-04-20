<?php
/**
 * The template for displaying all single posts
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header();
?>

<div class="container mx-auto px-4 py-8">
    <div class="content-area">
        <?php
        while (have_posts()) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header mb-6">
                    <?php the_title('<h1 class="entry-title text-3xl font-bold">', '</h1>'); ?>
                    
                    <div class="entry-meta text-gray-600 mt-2">
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
                </header>

                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-thumbnail mb-6">
                        <?php the_post_thumbnail('large', ['class' => 'w-full h-auto rounded']); ?>
                    </div>
                <?php endif; ?>

                <div class="entry-content">
                    <?php
                    the_content(
                        sprintf(
                            /* translators: %s: Name of current post */
                            esc_html__('Continue reading %s', 'transpro'),
                            the_title('<span class="screen-reader-text">"', '"</span>', false)
                        )
                    );

                    wp_link_pages(
                        array(
                            'before' => '<div class="page-links">' . esc_html__('Pages:', 'transpro'),
                            'after'  => '</div>',
                        )
                    );
                    ?>
                </div>

                <footer class="entry-footer mt-6 pt-4 border-t border-gray-200">
                    <?php
                    // Display categories
                    if (has_category()) :
                        echo '<div class="cat-links mb-2">';
                        /* translators: used between list items, there is a space after the comma */
                        $categories_list = get_the_category_list(esc_html__(', ', 'transpro'));
                        printf(
                            /* translators: %s: list of categories */
                            '<span class="font-medium">' . esc_html__('Categories:', 'transpro') . '</span> %s',
                            $categories_list
                        );
                        echo '</div>';
                    endif;

                    // Display tags
                    if (has_tag()) :
                        echo '<div class="tags-links">';
                        /* translators: used between list items, there is a space after the comma */
                        $tags_list = get_the_tag_list('', esc_html__(', ', 'transpro'));
                        printf(
                            /* translators: %s: list of tags */
                            '<span class="font-medium">' . esc_html__('Tags:', 'transpro') . '</span> %s',
                            $tags_list
                        );
                        echo '</div>';
                    endif;
                    
                    edit_post_link(
                        sprintf(
                            /* translators: %s: Name of current post */
                            esc_html__('Edit %s', 'transpro'),
                            the_title('<span class="screen-reader-text">"', '"</span>', false)
                        ),
                        '<div class="edit-link mt-4">',
                        '</div>'
                    );
                    ?>
                </footer>
            </article>

            <div class="post-navigation border-t border-b border-gray-200 py-4 my-8">
                <div class="flex flex-wrap justify-between">
                    <div class="prev-post w-full md:w-1/2 mb-4 md:mb-0 md:pr-2">
                        <?php
                        $prev_post = get_previous_post();
                        if (!empty($prev_post)) :
                            ?>
                            <span class="text-sm text-gray-600 block"><?php esc_html_e('Previous Post', 'transpro'); ?></span>
                            <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" rel="prev" class="text-blue-600 hover:text-blue-800 font-medium">
                                <?php echo esc_html(get_the_title($prev_post->ID)); ?>
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="next-post w-full md:w-1/2 text-right md:pl-2">
                        <?php
                        $next_post = get_next_post();
                        if (!empty($next_post)) :
                            ?>
                            <span class="text-sm text-gray-600 block"><?php esc_html_e('Next Post', 'transpro'); ?></span>
                            <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" rel="next" class="text-blue-600 hover:text-blue-800 font-medium">
                                <?php echo esc_html(get_the_title($next_post->ID)); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;

        endwhile; // End of the loop.
        ?>
    </div>
</div>

<?php
get_footer();