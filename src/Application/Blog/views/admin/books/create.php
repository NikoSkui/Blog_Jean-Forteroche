<section class="section">
  <div class="container">
    <form action="" method="post" >
      <input type="hidden" name="created_at" value="<?= $element->created_at ?>">
      <?php include('form.php')?>
      <div class="field is-grouped">
        <div class="control">
          <button class="button is-primary" type="submit">Ajouter</button>
        </div>
        <div class="control">
          <a class="button is-light" href="<?= $router->generateUri($prefixName.'#Read')?>">Annuler</a>
        </div>
      </div>
    </form>
  </div>
</section>