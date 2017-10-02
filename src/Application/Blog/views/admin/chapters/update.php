<section class="section">
  <div class="container">
      <div class="columns is-centered" >
        <div class="column is-three-quarters content" data-editable data-name="content">
          <?= $element->content?>
        </div>
      </div>
  </div>
</section>
<a class="return admin animated fadeIn" href="<?= $router->generateUri($prefixName.'#Read')?>" >
  <?= $renderer->render('@component/btn_return')?>
</a>

