<nav class="navbar">
  <div class="navbar-brand">
    <a class="navbar-item" href="<?= $router->generateUri('FrontBase#index') ?>">
       <img src=" <?= $urlHelper->baseUrl() ?>/favicon.png" alt="Bulma: a modern CSS framework based on Flexbox" width="28" height="28">  
       <span> Jean Forteroche</span>
    </a>

    <a class="navbar-item is-hidden-desktop" href="https://github.com/NikoSkui/Blog_Jean-Forteroche" target="_blank">
      <span class="icon" style="color: #333;">
        <i class="fa fa-github"></i>
      </span>
    </a>

    <div class="navbar-burger burger" data-target="navMenubd-example">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>

  <div id="navMenubd-example" class="navbar-menu">
    <div class="navbar-end">
      <a class="navbar-item is-hidden-desktop-only" href="https://github.com/NikoSkui/Blog_Jean-Forteroche" target="_blank">
        <span class="icon" style="color: #333;">
          <i class="fa fa-github"></i>
        </span>
      </a> 
      <?php if ($this->hasView('@admin/')): ?> 
        <?php if ($this->getLayoutNamespace() === 'admin'): ?>
          <div class="navbar-item">      
            <p class="control">
              <a class="button is-danger" href="<?= $router->generateUri('FrontBase#index') ?>">
                <span>Déconnexion</span>
              </a>
            </p>
          </div>
        <?php else : ?>
          <div class="navbar-item">      
            <p class="control">
              <a class="button is-primary" href="<?= $router->generateUri('AdminChapters#Read') ?>">
                <span>Connexion</span>
              </a>
            </p>
          </div>
        <?php endif ?>
      <?php endif ?>
    </div>
  </div>
</nav>