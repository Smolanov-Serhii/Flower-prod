<?php get_header();
View::render_breadcrumbs(true); ?>
    <main class="blog-inside content">
        <div class="container blog-inside__container">
            <p class="blog-inside__date"><?= get_the_date('d.m.Y'); ?></p>
            <div class="blog-inside__content">
                <?php the_content(); ?>
            </div>
        </div>
    </main>
<?php get_footer();