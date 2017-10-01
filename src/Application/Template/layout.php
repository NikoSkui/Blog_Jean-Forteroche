<?php 
$params = [
  'title' => isset($slug) ? $slug . ' | Jean Foreteroche à livre ouvert' : 'Jean Foreteroche à livre ouvert'
];
?>

<?= $renderer->render('head', compact('params')) ?>

<?php if(!in_array($header->typePage,['login'])): ?>
<?= $renderer->render('header', compact('header')) ?>
<?php endif ?>

<?= $content ?>


<?= $renderer->render('footer') ?>