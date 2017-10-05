<section class="hero is-fullheight" style="background:url(<?= $urlHelper->baseUrl() ?>/img/bgheader.jpg);background-size:cover;height:100%;">
  <div class="hero-header">
    <?= $renderer->render('navbar') ?>
  </div>
  <div class="hero-body">
    <div class="container">
      <h1 class="title is-1 is-spaced has-text-centered has-text-white"><?= $header->title ?></h1>
      <h2 class="subtitle is-5  has-text-centered has-text-white"><?= $header->subtitle ?></h2>
      <div class="section columns is-centered">
          <div class="navbar-item">      
            <p class="control">
              <a class="button is-primary is-outlined" href="<?= $router->generateUri('Front#Base#Index') ?>">
                <span>Retour sur la page d'accueil</span>
              </a>
            </p>
          </div>
      </div>
    </div>
  </div>
</section>