<?php
/**
 * Template Name: Блог
 */
$options = Helper::get_blog_footer_options();
$current_page = get_query_var('paged') ?: 1;
$posts_query = Helper::get_blog_posts();
$latest_posts = Helper::get_cpt_posts('post', 2, 'DESC');

get_header(); ?>
<?php View::render_breadcrumbs(); ?>
    <main class="blog content">
        <section class="blog-list">
            <div class="container blog-list__container">
                <header class="blog-list-header">
                    <?php foreach ($latest_posts as $post): ?>
                        <div class="blog-list-header__col"
                             style="background-image:url('<?= get_the_post_thumbnail_url($post->ID); ?>')">
                            <div class="blog-list-header__content">
                                <span class="blog-list__date"><?= get_the_date('d.m.Y', $post->ID); ?></span>
                                <h3 class="blog-list__title"><?= $post->post_title; ?></h3>
                                <p class="blog-list__text"><?= $post->post_excerpt; ?></p>
                                <a class="blog-list__link" href="<?= get_the_permalink($post->ID); ?>">Подробнее</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </header>

                <article class="blog-list__content">
                    <ul class="blog-list__list">
                        <?php while ($posts_query->have_posts()) : $posts_query->the_post(); ?>
                            <li class="blog-list__item">
                                <span class="blog-list__date"><?= get_the_date('d.m.Y', $post->ID); ?></span>
                                <h3 class="blog-list__title"><?= $post->post_title; ?></h3>
                                <img class="blog-list__img" src="<?= get_the_post_thumbnail_url($post->ID); ?>"
                                     alt="<?= $post->post_title; ?>">
                                <p class="blog-list__text"><?= get_the_excerpt($post->ID); ?></p>
                                <a class="blog-list__link" href="<?= get_the_permalink($post->ID); ?>">
                                    <?php pll_e('Подробнее'); ?>
                                </a>
                            </li>
                        <?php endwhile; ?>
                    </ul>

                    <?php View::render_pagination($posts_query, $current_page); ?>
                </article>

                <footer class="blog-list-footer">
                    <div class="blog-list-footer__col">
                        <p class="blog-list-footer__title">
                            <?php pll_e('Подписывайтесь на нас в соц. сетях и узнавайте первыми об акциях и новостях.'); ?>
                        </p>
                    </div>
                    <?php if (!empty($options['insta'])): ?>
                        <div class="blog-list-footer__col">
                            <a class="blog-list-footer__social" href="<?= $options['insta'] ?>" target="_blank"
                               rel="nofollow">
                                <svg class="svg-sprite-icon icon-insta blog-list-footer__icon">
                                    <use xlink:href="<?= __SVG__ . '#insta'; ?>"></use>
                                </svg>
                                <p>Instagram</p>
                                <img class="blog-list-footer__img"
                                     src="<?= __IMAGES_DIR__ . 'common/insta-page.jpg'; ?>"
                                     alt="">
                            </a>
                        </div>
                    <?php endif;
                    if (!empty($options['facebook'])): ?>
                        <div class="blog-list-footer__col">
                            <a class="blog-list-footer__social" href="<?= $options['facebook']; ?>" target="_blank"
                               rel="nofollow">
                                <svg class="svg-sprite-icon icon-facebook blog-list-footer__icon">
                                    <use xlink:href="<?= __SVG__ . '#facebook'; ?>"></use>
                                </svg>
                                <p>Facebook</p>
                                <img class="blog-list-footer__img"
                                     src="<?= __IMAGES_DIR__ . 'common/facebook-page.jpg'; ?>"
                                     alt="">
                            </a>
                        </div>
                    <?php endif; ?>
                </footer>
            </div>
        </section>
    </main>
<?php get_footer();