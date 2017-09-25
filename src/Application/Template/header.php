<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $params['title'] ?></title>
    <link rel="icon" type="image/png" href="<?= $urlHelper->baseUrl() ?>/favicon.png" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.5.1/css/bulma.min.css">
    
    <?php if(isset($headerDatas->typePage) && in_array($headerDatas->typePage,['update','create'])): ?>
      <link rel="stylesheet" href="<?= $urlHelper->baseUrl() ?>/contentTools/content-tools.min.css">
      <link rel="stylesheet" href="<?= $urlHelper->baseUrl() ?>/contentTools/content-editor.css">
    <?php endif ?>
    
  </head>
  <body>
  <?= $renderer->render('navbar') ?>