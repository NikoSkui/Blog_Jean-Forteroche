<section class="section">
  <div class="container">
      <div class="columns is-centered" >
        <div class="column is-three-quarters" >
          <p><?= $element->content?><p>
        </div>
      </div>
  </div>
</section>
<a class="return fadeIn animated " href="<?= $router->generateUri($prefixName.'#Read')?>" >
  <?= $renderer->render('@component/btn_return')?>
</a>