<nav class="navbar is-transparent">
  <div class="navbar-brand">
    <a class="navbar-item logo " href="<?= $router->generateUri('Front#Base#Index') ?>">
       <img src="<?= $urlHelper->baseUrl() ?>/favicon/favicon-96x96.png" alt="My book par Jean Forteroche : Un livre en ligne">  
    </a>
      <?php if ($this->hasView('@admin/')): ?> 
        <?php if ($session->get('user')): ?> 
          <a class="navbar-item is-hidden-desktop-only admin-access" href="<?= $router->generateUri('Admin#Base#Index') ?>" >
            <?= $renderer->render('@component/btn_admin')?>
          </a>
        <?php endif ?>
      <?php endif ?>

    <a class="navbar-item is-hidden-desktop" href="https://github.com/NikoSkui/Blog_Jean-Forteroche" target="_blank">
      <span class="icon has-text-white" >
        <i class="fa fa-github "></i>
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
        <span class="icon has-text-light">
          <i class="fa fa-lg fa-github"></i>
        </span>
      </a> 
      <?php if ($this->hasView('@admin/')): ?> 
        <?php if ($session->get('user')): ?> 
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
              <a class="button is-primary is-outlined" href="<?= $router->generateUri('Admin#Base#Index') ?>">
                <span>Connexion</span>
              </a>
            </p>
          </div>
        <?php endif ?>
      <?php endif ?>
    </div>
  </div>
</nav>