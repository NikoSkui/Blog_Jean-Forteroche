<?php if(isset($book) && $book !== false): ?>
<section class="section">
  <div class="container">
    <h1 class="title">A découvrir</h1>
    <h2 class="subtitle">notre dernier livre</h2>
    <hr>
    <div class="columns is-centered">
      <div class="column is-offset-one-quarter-mobile is-half-mobile is-one-third">
        <?= $renderer->render('@component/card', compact('book')) ?>
      </div>
    </div>
  </div>
</section>
<?php endif ?>