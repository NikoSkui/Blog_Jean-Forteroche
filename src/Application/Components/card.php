<div class="card">
  <div class="card-image">
    <a href="<?= $router->generateUri('Front#Chapters#List', ['slugBook' => $book->slug])?>">
    <figure class="image is-4by3">
      <img src="<?= $urlHelper->baseUrl() ?>/img/<?= $book->slug ?>.jpg" alt="Image">
    </figure>
    </a>
  </div>
  <?= $book->url(['slug'=> $book->slug]) ?>
  <div class="card-content">
    <div class="media">
      <div class="media-content">
        <p class="title is-4"><?= $book->name ?></p>
        <p class="subtitle is-6">@ Jean Forteroche</p>
      </div>
    </div>
    <div class="content">
      <?= $book->excerpt ?>
      <br>
    </div>
  </div>
</div>