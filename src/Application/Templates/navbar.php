<nav class="navbar">
  <div class="navbar-brand">
    <a class="navbar-item" href="<?= $router->generateUri('Base#home') ?>">
      <!-- <img src="http://bulma.io/images/bulma-logo.png" alt="Bulma: a modern CSS framework based on Flexbox" width="112" height="28"> -->
      Jean Forteroche
    </a>

    <a class="navbar-item is-hidden-desktop" href="https://github.com/jgthms/bulma" target="_blank">
      <span class="icon" style="color: #333;">
        <i class="fa fa-github"></i>
      </span>
    </a>

    <a class="navbar-item is-hidden-desktop" href="https://twitter.com/jgthms" target="_blank">
      <span class="icon" style="color: #55acee;">
        <i class="fa fa-twitter"></i>
      </span>
    </a>

    <div class="navbar-burger burger" data-target="navMenubd-example">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>

  <div id="navMenubd-example" class="navbar-menu">
    <div class="navbar-start">
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-item" href="<?= $router->generateUri('Blog#listBooks') ?>">
          Livres
        </a>
      </div>
    </div>

    <div class="navbar-end">
      <a class="navbar-item is-hidden-desktop-only" href="#" target="_blank">
        <span class="icon" style="color: #333;">
          <i class="fa fa-github"></i>
        </span>
      </a>  
    </div>
  </div>
</nav>