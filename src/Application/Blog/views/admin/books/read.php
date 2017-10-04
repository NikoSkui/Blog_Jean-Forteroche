<section class="section">
    <div class="section">
      <article class="media ">
        <div class="media-content">
          <div class="content">
            <h2>Mes livres</h2>
          </div>
          <?php foreach ($elements as $book):?>              
            <article class="media  container">
              <!-- <div class="box"> -->
              <figure class="media-left">
               <span class="icon <?= $book->statut === 'publish' ? 'has-text-success': 'has-text-danger'  ?>">
                  <i class="fa fa-circle"></i>
                </span>
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
                    <i class="fa fa-lg fa-edit"></i>
                  </a>
                </span>
              </div>
              <div class="media-right">
                <!-- <form 
                  action="<?= $router->generateUri($prefixName.'#Delete', ['id' => $book->id]) ?>" 
                  method="post" 
                  onsubmit="return confirm('êtes vous sûr de vouloir supprimer ce chapitre ?')"
                  style="padding-top:2px;"
                  >
                  <input type="hidden" name="_method" value ="DELETE">
                  <button class="delete " type="submit"></button>
                </form> -->
              </div>
            </article>
          <?php endforeach?>
        </div>
      </article>
    </div>
 </section>