<?php 

$params = [
  'title' => isset($slug) ? $slug . ' | Administration' : 'Administration'
];
?>

<?= $renderer->render('header', $params) ?>

<?= $content ?>

<?= $renderer->render('footer') ?>