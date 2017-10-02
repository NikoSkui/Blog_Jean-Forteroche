<section class="section">
  <div class="container">
      <div class="columns is-centered" >
        <div class="column is-three-quarters" data-editable data-name="excerpt">
          <p><?= $element->excerpt?><p>
        </div>
      </div>
  </div>
</section>
<a class="return admin fadeIn animated " href="<?= $router->generateUri($prefixName.'#Read')?>" >
  <?= $renderer->render('@component/btn_return')?>
</a>
