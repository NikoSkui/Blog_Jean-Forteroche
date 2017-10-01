<?php
$params = [
  'title' => isset($slug) ? $slug . ' | Jean Foreteroche à livre ouvert' : 'Admin'
];
?>

<?= $renderer->render('head', compact('params','headerDatas')) ?>

<?= $renderer->render('@admin/template/header', compact('headerDatas')) ?>

<?= $content ?>

<?= $renderer->render('footer',compact('headerDatas')) ?>