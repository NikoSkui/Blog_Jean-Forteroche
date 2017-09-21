<section class="hero is-medium" style="background:url(../../bgheader.jpg);background-size:cover;height:100%;">
  <div class="hero-body">
    <div class="container">
      <h1 class="title has-text-centered has-text-white"><?= $bookName ?></h1>
      <h2 class="subtitle has-text-centered has-text-white">sommaire</h2>
    </div>
  </div>
</section>
<section class="section">
  <nav class="level">
    <?php foreach ($chapters as $chapter):?>

      <a class="level-item has-text-centered" href="<?= $router->generateUri($prefixNameChapters . '#One', ['slugBook' => $chapter->slugBook, 'chapters_order' => $chapter->chapters_order, 'slugChapter' => $chapter->slugChapter]) ?>">
        <div>
          <p class="heading">Chapitre</p>
          <p class="title"><?= $chapter->chapters_order ?></p>
        </div>
      </a>
    <?php endforeach?>
  </nav>
</section>
