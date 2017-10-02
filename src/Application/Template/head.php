<!DOCTYPE html>
<html>
  <head>
  
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $params['title'] ?></title>

    <!--FAVICON  -->
    <link rel="apple-touch-icon" sizes="57x57" href="<?= $urlHelper->baseUrl() ?>/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= $urlHelper->baseUrl() ?>/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= $urlHelper->baseUrl() ?>/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= $urlHelper->baseUrl() ?>/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= $urlHelper->baseUrl() ?>/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= $urlHelper->baseUrl() ?>/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= $urlHelper->baseUrl() ?>/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= $urlHelper->baseUrl() ?>/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $urlHelper->baseUrl() ?>/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?= $urlHelper->baseUrl() ?>/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $urlHelper->baseUrl() ?>/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= $urlHelper->baseUrl() ?>/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $urlHelper->baseUrl() ?>/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?= $urlHelper->baseUrl() ?>/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    
    <!--CSS BULMA + ICON  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.5.3/css/bulma.min.css">
    
    <?php if(isset($header->typePage) && in_array($header->typePage,['update','create'])): ?>
      <!--CSS CONTENT TOOLS EDITOR  --> 
      <link rel="stylesheet" href="<?= $urlHelper->baseUrl() ?>/libraries/contentTools/content-tools.min.css">
      <link rel="stylesheet" href="<?= $urlHelper->baseUrl() ?>/libraries/contentTools/content-editor.css">
    <?php endif ?>
     <!--CSS ANIMATE  -->    
    <link rel="stylesheet" href="http://anijs.github.io/lib/anicollection/anicollection.css"> 
    <link rel="stylesheet" href="<?= $urlHelper->baseUrl() ?>/css/animate.css">
     <!--CSS CUSTOM  -->    
    <link rel="stylesheet" href="<?= $urlHelper->baseUrl() ?>/css/app.css">

  </head>
  <body>