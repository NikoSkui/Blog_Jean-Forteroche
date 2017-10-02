<?php
$params = [
  'title' => isset($slug) ? $slug . ' | Jean Foreteroche à livre ouvert' : 'Admin'
];
?>

<?= $renderer->render('head', compact('params','header')) ?>

<?= $renderer->render('@admin/template/header', compact('header')) ?>

<?= $content ?>

<?= $renderer->render('footer',compact('header')) ?>