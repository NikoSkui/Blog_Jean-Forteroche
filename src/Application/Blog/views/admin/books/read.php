<section class="section">
    <div class="section">
      <article class="media ">
        <div class="media-content">
          <div class="content">
            <p><strong>Mes livres</strong></p>
          </div>
          <?php foreach ($elements as $book):?>              
            <article class="media  container">
              <!-- <div class="box"> -->
              <figure class="media-left">
                <p class="image is-24x24">
                  <img src="http://bulma.io/images/placeholders/96x96.png">
                </p>
              </figure>
              <div class="media-content">
                <div class="content">
                  <p>
                    <strong><?= $book->name ?> : </strong>
                    <?= $book->excerpt ?>
                  </p>
                </div>
              </div>
              <div class="media-right">
                <span class="icon">
                  <a class="is-info" href="<?= $router->generateUri($prefixName.'#Update', ['id' => $book->id]) ?>">
                    <i class="fa fa-edit"></i>
                  </a>
                </span>
              </div>
              <div class="media-right">
                <form action="<?= $router->generateUri($prefixName.'#Delete', ['id' => $book->id]) ?>" method="post" onsubmit="return confirm('êtes vous sûr de vouloir supprimer ce chapitre ?')">
                  <input type="hidden" name="_method" value ="DELETE">
                  <button class="delete " type="submit"></button>
                </form>
              </div>
            </article>
          <?php endforeach?>
        </div>
      </article>
    </div>
 </section>