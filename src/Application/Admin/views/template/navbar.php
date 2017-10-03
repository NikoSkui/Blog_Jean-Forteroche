
<nav class="tabs is-fullwidth is-medium">
  <ul>
    <?php foreach($header->navbar as $nav): ?>
      <li class="<?= ($header->prefixName === $nav['prefixName']) ? 'is-active' : '' ?>">
        <a href="<?= $router->generateUri($nav['prefixName'] . '#Read')?>"><span><?= $nav['name'] ?></span></a>
      </li>
    <?php endforeach ?>

  </ul>
</nav>
