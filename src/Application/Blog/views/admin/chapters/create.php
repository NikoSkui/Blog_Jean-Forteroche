<section class="hero is-danger is-bold">
  <div class="hero-body">
    <div class="container">
      <div class="columns is-vcentered">
        <div class="column">
          <p class="title">
            Administration
          </p>
          <p class="subtitle">
            Ajouter un nouveau <strong>chapitre</strong>
          </p>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="section">
  <div class="container">
    <form action="" method="post" >
      <input type="hidden" name="created_at" value="<?= $element->created_at ?>">
      <input type="hidden" name="books_id" value="<?= $element->books_id ?>">
      <input type="hidden" name="chapters_order" value="<?= $element->chapters_order ?>">
      <?php include('form.php')?>
      <div class="field is-grouped">
        <div class="control">
          <button class="button is-primary" type="submit">Ajouter</button>
        </div>
        <div class="control">
          <a class="button is-light" href="<?= $router->generateUri($prefixName.'#Read',['slugBook'=> $slugBook])?>">Annuler</a>
        </div>
      </div>
    </form>
  </div>
</section>
