<div class="section">
  <div class="container">
    <div class="columns is-multiline">
    <?php foreach ($books as $book):?>
      <div class="column is-offset-one-quarter-mobile is-half-mobile is-one-third">
        <?= $renderer->render('@component/card', compact('book')) ?>
      </div>
    <?php endforeach?>

    </div>
  </div>

</div>