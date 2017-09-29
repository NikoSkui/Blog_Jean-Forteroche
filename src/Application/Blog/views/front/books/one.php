<section class="hero is-medium" style="background:url(../bgheader.jpg);background-size:cover;height:100%;">
  <div class="hero-body">
    <div class="container">
      <h1 class="title has-text-centered has-text-white">Jean Forteroche</h1>
      <h2 class="subtitle has-text-centered has-text-white">à livre ouvert</h2>
    </div>
  </div>
</section>
<section class="section">
  <div class="container">
    <h1 class="title">Le livre</h1>
    <h2 class="subtitle">En détail</h2>
    <hr>
    <div class="columns is-multiline">
      <div class="column is-offset-one-quarter-mobile is-half-mobile is-one-third">
        <div class="card">
          <div class="card-image">
            <figure class="image is-4by3">
              <img src="http://bulma.io/images/placeholders/1280x960.png" alt="Image">
            </figure>
          </div>
          <div class="card-content">
            <div class="media">
              <div class="media-left">
                <figure class="image is-48x48">
                  <img src="http://bulma.io/images/placeholders/96x96.png" alt="Image">
                </figure>
              </div>
              <div class="media-content">
                <p class="title is-4"><?= $book->id;?></p>
                <p class="subtitle is-6">@Jean Forteroche</p>
              </div>
            </div>

            <div class="content">
              <?= $prefixNameChapters;?>
              <a href="<?= $router->generateUri($prefixNameChapters . '#List', ['slugBook' => $book->slug]) ?>">Détail</a>
              <br>
               <small>11:09 PM - 1 Jan 2016</small> 
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</section>