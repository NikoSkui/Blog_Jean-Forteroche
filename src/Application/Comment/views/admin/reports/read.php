<?php if (!empty($additionnals)): ?>
  <section class="section">
      <div class="section">
        <article class="media">
          <div class="media-content">
            <div class="content">
                <h2 class="has-text-danger" >Les commentaires signalés</h2>
            </div>
            <?php foreach ($additionnals as $comment):?>
            <div class="animated zoomIn notification is-warning">

              <span class="icon" style="position: absolute;right: 3.3em;top: .43em">
                <a class="is-info" href="<?= $router->generateUri($prefixName.'#Update', ['id' => $comment['id']]) ?>">
                  <i class="fa fa-eye"></i>
                </a>
              </span>

              <form style="position: absolute;right: 1.8em;top: 0em" 
                    action="<?= $router->generateUri('Admin#Reports#Delete', ['id' => $comment['id']]) ?>" 
                    onsubmit="return confirm('êtes vous sûr de vouloir restaurer ce commentaire ?')"
                    method="post">
                <input type="hidden" name="_method" value ="DELETE">
                <button class="icon" style="background:transparent;border:0px;" >
                  <a class="is-info" >
                    <i class="fa fa-check"></i>
                  </a>
                </button>
              </form>
              
              <form style="position: absolute;right: .5em;top: .5em" 
                    action="<?= $router->generateUri($prefixName.'#Delete', ['id' => $comment['id']]) ?>" 
                    onsubmit="return confirm('êtes vous sûr de vouloir supprimer ce commentaire ?')"
                    method="post">
                <input type="hidden" name="_method" value ="DELETE">
                <button class="delete" type="submit"></button>
              </form>

              <article class="media" style="border-top:0px;padding-top:10px;">
                <!-- <div class="box"> -->
                <figure class="media-left">
                  <p class="image is-24x24">
                    <img src="http://bulma.io/images/placeholders/96x96.png">
                  </p>
                </figure>
                <div class="media-content">
                  <div class="content" style="padding-right:50px;">
                    <p>
                      <strong><?= $comment['book_name'] ?>: </strong>
                      <strong>Chapitre <?= $comment['chapter_name'] ?> </strong><br>
                      <strong>@ <?= $comment['pseudo'] ?> </strong><br>
                      <?= $comment['content'] ?>
                    </p>
                  </div>
                  <?php foreach ($comment['reports'] as $reports):?>  
                  <?php foreach ($reports as $count => $report):?>  
                    <article class=" ">
                      <div class="media-content">
                        <div class="content">
                          <p >
                            - <?= $report->count($count)?> <?= $report->report_msg ?> 
                          </p>
                        </div>
                      </div>  
                    </article>                        
                  <?php endforeach?>
                  <?php endforeach?>
                </div>
              </article>
            </div>              
            <?php endforeach?>
          </div>
        </article>
      </div>
  </section>
 <?php endif ?>