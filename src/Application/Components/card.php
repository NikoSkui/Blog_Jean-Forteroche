<div class="card">
  <div class="card-image">
    <figure class="image is-4by3">
      <img src="http://bulma.io/images/placeholders/1280x960.png" alt="Image">
    </figure>
  </div>
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
      <?= $book->url(['slug'=> $book->slug]) ?>
    </div>
  </div>
</div>