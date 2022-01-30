<?php
/**
 * Template Name: Политика Конфиденциальности
 */

get_header(); ?>
<?php View::render_breadcrumbs(); ?>
    <main class="policy content">
        <div class="container policy__container">
            <?php the_content(); ?>
        </div>
    </main>
<?php get_footer();