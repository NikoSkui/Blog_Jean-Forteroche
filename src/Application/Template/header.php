<header class="hero is-medium " style="background:url(<?= $urlHelper->baseUrl() ?>/img/<?= isset($header->imgName) ? 'header_'.$header->imgName : 'bgheader' ?>.jpg);background-size:cover;height:100%;">
  <div class="hero-header">
      <?= $renderer->render('navbar') ?>
  </div>
  <div class="hero-body">
    <div class="container">
      <h1 class="title has-text-centered has-text-white"><?= $header->title ?></h1>
      <h2 class="subtitle has-text-centered has-text-white"><?= $header->subtitle ?></h2>
    </div>
  </div>
</header>