<section class="hero is-medium" style="background:url(../../bgheader.jpg);background-size:cover;height:100%;">
  <div class="hero-body">
    <div class="container">
      <h1 class="title has-text-centered has-text-white">Chapitre <?= $id ?></h1>
      <h2 class="subtitle has-text-centered has-text-white"><?= $slug ?></h2>
    </div>
  </div>
</section>
<section class="section">
  <div class="container">
    <?= nl2br($content)?>
  </div>
</section>
<section class="section">
  <div class="container">
    <h2 class="title">Commentaires</h2>
    <article class="media">
      <figure class="media-left">
        <p class="image is-64x64">
          <img src="http://bulma.io/images/placeholders/128x128.png">
        </p>
      </figure>
      <div class="media-content">
        <div class="content">
          <p>
            <strong>Barbara Middleton</strong>
            <br>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis porta eros lacus, nec ultricies elit blandit non. Suspendisse pellentesque mauris sit amet dolor blandit rutrum. Nunc in tempus turpis.
            <br>
            <small><a>Signaler</a> · <a>Répondre</a> · 3 hrs</small>
          </p>
        </div>

        <article class="media">
          <figure class="media-left">
            <p class="image is-48x48">
              <img src="http://bulma.io/images/placeholders/96x96.png">
            </p>
          </figure>
          <div class="media-content">
            <div class="content">
              <p>
                <strong>Sean Brown</strong>
                <br>
                Donec sollicitudin urna eget eros malesuada sagittis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam blandit nisl a nulla sagittis, a lobortis leo feugiat.
                <br>
                <small><a>Signaler</a> · <a>Répondre</a> · 2 hrs</small>
              </p>
            </div>

            <article class="media">
              <figure class="media-left">
                <p class="image is-48x48">
                  <img src="http://bulma.io/images/placeholders/96x96.png">
                </p>
              </figure>
              <div class="content">
                <p>
                  <strong>Sonia Brown</strong>
                  <br>
                  Vivamus quis semper metus, non tincidunt dolor. Vivamus in mi eu lorem cursus ullamcorper sit amet nec massa.
                </p>
              </div>

            </article>

            <article class="media">
              Morbi vitae diam et purus tincidunt porttitor vel vitae augue. Praesent malesuada metus sed pharetra euismod. Cras tellus odio, tincidunt iaculis diam non, porta aliquet tortor.
            </article>
          </div>
        </article>

        <article class="media">
          <figure class="media-left">
            <p class="image is-48x48">
              <img src="http://bulma.io/images/placeholders/96x96.png">
            </p>
          </figure>
          <div class="media-content">
            <div class="content">
              <p>
                <strong>Kayli Eunice </strong>
                <br>
                Sed convallis scelerisque mauris, non pulvinar nunc mattis vel. Maecenas varius felis sit amet magna vestibulum euismod malesuada cursus libero. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Phasellus lacinia non nisl id feugiat.
                <br>
                <small><a>Signaler</a> · <a>Répondre</a> · 2 hrs</small>
              </p>
            </div>
          </div>
        </article>
      </div>
    </article>
    <article class="media">
      <figure class="media-left">
        <p class="image is-64x64">
          <img src="http://bulma.io/images/placeholders/128x128.png">
        </p>
      </figure>
      <div class="media-content">
        <div class="field">
          <p class="control">
            <textarea class="textarea" placeholder="Add a comment..."></textarea>
          </p>
        </div>
        <div class="field">
          <p class="control">
            <button class="button">Post comment</button>
          </p>
        </div>
      </div>
    </article>
  </div>
</section>

