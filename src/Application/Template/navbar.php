<nav class="navbar">
  <div class="navbar-brand">
    <a class="navbar-item" href="<?= $router->generateUri('Front#Base#Index') ?>">
       <img src=" <?= $urlHelper->baseUrl() ?>/favicon.png" alt="Bulma: a modern CSS framework based on Flexbox" width="28" height="28">  
       <span class="sitename"> Jean Forteroche</span>
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
        <?php if ($session->get('user')): ?> 
          <a class="navbar-item is-hidden-desktop-only is-warning" href="<?= $router->generateUri('Admin#Chapters#Read') ?>" >
            <span class="icon" style="color: #333;">
              <i class="fa fa-tachometer"></i>
            </span>
          </a> 
          <div class="navbar-item">      
            <p class="control">
              <a class="button is-danger" href="<?= $router->generateUri('User#Control#Logout') ?>">
                <span>Déconnexion</span>
              </a>
            </p>
          </div>
        <?php else : ?>
          <div class="navbar-item">      
            <p class="control">
              <a class="button is-primary" href="<?= $router->generateUri('Admin#Chapters#Read') ?>">
                <span>Connexion</span>
              </a>
            </p>
          </div>
        <?php endif ?>
      <?php endif ?>
    </div>
  </div>
</nav>