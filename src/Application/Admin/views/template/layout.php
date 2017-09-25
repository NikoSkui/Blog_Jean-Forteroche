<?php
$params = [
  'title' => isset($slug) ? $slug . ' | Jean Foreteroche à livre ouvert' : 'Admin'
];
?>

<?= $renderer->render('header', compact('headerDatas','params')) ?>
<?= $renderer->render('@admin/header', compact('headerDatas')) ?>

<?= $content ?>

<?= $renderer->render('footer',compact('headerDatas')) ?>