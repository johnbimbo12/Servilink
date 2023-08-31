<!-- Web Application Manifest -->
<link rel="manifest" href="<?php echo e(route('laravelpwa.manifest')); ?>">
<!-- Chrome for Android theme color -->
<meta name="theme-color" content="<?php echo e($config['theme_color']); ?>">

<!-- Add to homescreen for Chrome on Android -->
<meta name="mobile-web-app-capable" content="<?php echo e($config['display'] == 'standalone' ? 'yes' : 'no'); ?>">
<meta name="application-name" content="<?php echo e($config['short_name']); ?>">

<!-- Add to homescreen for Safari on iOS -->
<meta name="apple-mobile-web-app-capable" content="<?php echo e($config['display'] == 'standalone' ? 'yes' : 'no'); ?>">
<meta name="apple-mobile-web-app-status-bar-style" content="<?php echo e($config['status_bar']); ?>">
<meta name="apple-mobile-web-app-title" content="<?php echo e($config['short_name']); ?>">

<link rel="apple-touch-icon" sizes="57x57" href="<?php echo e(asset('img/apple-icon-57x57.png')); ?>">
<link rel="apple-touch-icon" sizes="60x60" href="<?php echo e(asset('img/apple-icon-60x60.png')); ?>">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo e(asset('img/apple-icon-72x72.png')); ?>">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo e(asset('img/apple-icon-76x76.png')); ?>">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo e(asset('img/apple-icon-114x114.png')); ?>">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo e(asset('img/apple-icon-120x120.png')); ?>">
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo e(asset('img/apple-icon-144x144.png')); ?>">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo e(asset('img/apple-icon-152x152.png')); ?>">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('img/apple-icon-180x180.png')); ?>">
<link rel="icon" href="<?php echo e(asset('img/favicon.ico')); ?>">
<link rel="icon" type="image/png" sizes="192x192" href="<?php echo e(asset('img/android-icon-192x192.png')); ?>">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('img/favicon-32x32.png')); ?>">
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo e(asset('img/favicon-96x96.png')); ?>">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('img/favicon-16x16.png')); ?>">




<!-- Tile for Win8 -->
<meta name="msapplication-TileColor" content="<?php echo e($config['background_color']); ?>">
<meta name="msapplication-TileImage" content="<?php echo e(data_get(end($config['icons']), 'src')); ?>">

<script type="text/javascript">
    // Initialize the service worker
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/serviceworker.js', {
            scope: '.'
        }).then(function (registration) {
            // Registration was successful
            console.log('Laravel PWA: ServiceWorker registration successful with scope: ', registration.scope);
        }, function (err) {
            // registration failed :(
            console.log('Laravel PWA: ServiceWorker registration failed: ', err);
        });
    }
</script><?php /**PATH /home/ocqv5p3q51h2/Servilink/resources/views/vendor/laravelpwa/meta.blade.php ENDPATH**/ ?>