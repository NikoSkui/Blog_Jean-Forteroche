<?php 

$params = [
  'title' => isset($slug) ? $slug . ' | Jean Foreteroche à livre ouvert' : 'Jean Foreteroche à livre ouvert'
];
?>

<?= $renderer->render('header', $params) ?>

<?= $content ?>

<?= $renderer->render('footer') ?>