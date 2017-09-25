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
          <a class="button is-light" href="<?= $router->generateUri($prefixName.'#Read')?>">Annuler</a>
        </div>
      </div>
    </form>
  </div>
</section>
