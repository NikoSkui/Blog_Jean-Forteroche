
<nav class="tabs is-fullwidth is-medium">
  <ul>
    <?php foreach($adminNavbar as $nav): ?>
      <li class="<?= ($prefixName === $nav['prefixName']) ? 'is-active' : '' ?>">
        <a href="<?= $router->generateUri($nav['prefixName'] . '#Read')?>"><span><?= $nav['name'] ?></span></a>
      </li>
    <?php endforeach ?>

  </ul>
</nav>
