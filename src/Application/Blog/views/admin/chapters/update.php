<section class="hero is-danger is-bold">
  <div class="hero-body">
    <div class="container">
      <div class="columns is-vcentered">
        <div class="column">
          <p class="title">
            Administration
          </p>
          <p class="subtitle">
            Editer le chapitre <?= $element->chapters_order ?> : <strong><?= $chapter->name ?></strong>
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <form action="" method="post" >
      <input type="hidden" name="_method" value="PUT">

      <?php include('form.php')?>
      <div class="field is-grouped">
        <div class="control">
          <button class="button is-primary" type="submit">Modifier</button>
        </div>
        <div class="control">
          <a class="button is-light" href="<?= $router->generateUri($prefixName.'#Read',['slugBook'=> $slugBook])?>">Annuler</a>
        </div>
      </div>
    </form>
  </div>
</section>
