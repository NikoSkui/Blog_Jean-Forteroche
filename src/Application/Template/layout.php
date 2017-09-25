<?php 
$params = [
  'title' => isset($slug) ? $slug . ' | Jean Foreteroche à livre ouvert' : 'Jean Foreteroche à livre ouvert'
];
?>

<?= $renderer->render('header', compact('params')) ?>

<?= $content ?>

<?= $renderer->render('footer') ?>