```php
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php wp_title('|', true, 'right'); ?></title>
  <!-- Cargar style.css -->
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/style.css">
  <!-- Cargar custom.css -->
  <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/custom.css">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

  <header>
    <h1><?php bloginfo('name'); ?></h1>
    <nav>
      <?php wp_nav_menu(array('theme_location' => 'primary')); ?>
    </nav>
  </header>

  <main>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <article>
        <h2><?php the_title(); ?></h2>
        <div><?php the_content(); ?></div>
      </article>
    <?php endwhile; endif; ?>
  </main>

  <footer>
    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
  </footer>

  <?php wp_footer(); ?>
</body>
</html>
```
