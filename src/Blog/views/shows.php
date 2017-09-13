<section class="hero is-medium" style="background:url(../bgheader.jpg);background-size:cover;height:100%;">
  <div class="hero-body">
    <div class="container">
      <h1 class="title has-text-centered has-text-white"><?= $slug ?></h1>
      <h2 class="subtitle has-text-centered has-text-white">sommaire</h2>
    </div>
  </div>
</section>
<section class="section">
  <nav class="level">
    <?php foreach ($chapitres as $chapitre):?>
      <a class="level-item has-text-centered" href="<?= $router->generateUri('Blog#show', ['id' => $chapitre['id'], 'slug' => $chapitre['slug']]) ?>">
        <div>
          <p class="heading">Chapitre</p>
          <p class="title"><?= $chapitre['id'] ?></p>
        </div>
      </a>
    <?php endforeach?>
  </nav>
</section>
