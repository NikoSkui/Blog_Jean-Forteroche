<section class="section">
  <?php foreach ($elements as $book => $chapters):?>    
    <div class="section">
      <article class="media ">
        <div class="media-content">
          <div class="content">
            <h2><?= $book ?></h2>
          </div>
          <?php foreach ($chapters as $chapter):?>              
            <article class="media  container">
              <!-- <div class="box"> -->
              <figure class="media-left">
                <span class="icon <?= $chapter->statut === 'publish' ? 'has-text-success': 'has-text-danger'  ?>">
                  <i class="fa fa-circle"></i>
                </span>
              </figure>
              <div class="media-content">
                <div class="content">
                  <p>
                    <strong>Chapitre <?= $chapter->chapters_order ?> : </strong>
                    <?= $chapter->name ?>
                  </p>
                </div>
              </div>
              <div class="media-right">
                <span class="icon">
                  <a class="is-info" href="<?= $router->generateUri($prefixName.'#Update', ['id' => $chapter->id]) ?>">
                    <i class="fa fa-lg fa-edit"></i>
                  </a>
                </span>
              </div>
              <div class="media-right" >
                <form 
                  action="<?= $router->generateUri($prefixName.'#Delete', ['id' => $chapter->id]) ?>" 
                  method="post" 
                  onsubmit="return confirm('êtes vous sûr de vouloir supprimer ce chapitre ?')"
                  style="padding-top:2px;"
                >
                  <input type="hidden" name="_method" value ="DELETE">
                  <button class="delete " type="submit"></button>
                </form>
              </div>
            </article>
          <?php endforeach?>
        </div>
      </article>
    </div>
  <?php endforeach?>
 </section>