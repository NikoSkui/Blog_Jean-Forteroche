<?php if ($this->hasView('@comment/admin/chapters/comments')): ?>
  <section class="section">
    <?php foreach ($elements[0] as $k => $comment):?>

      <?php $comment->setIndexes($elements,$k) ?>

      <!--Start boucle to each book  -->
      <?php if (isset($comment->indexBook) && $comment->index === $comment->indexBook): ?>
        <div class="section">
          <article class="media">
            <div class="media-content">
              <div class="content" id="comment-<?= $comment->id ?>">
                <p><strong><?= $comment->books_name ?></strong></p>
              </div>
      <?php endif ?> 

      <!--Start boucle to each chapter  --> 
      <?php if (isset($comment->indexChapter) && $comment->index === $comment->indexChapter): ?>
        <article class="media" style="margin-left:30px">
          <div class="media-content">
            <div class="content" id="comment-<?= $comment->id ?>">
              <p><strong>Chapitre <?= $comment->chapters_order ?></strong></p>
            </div>
      <?php endif ?>

      <!--Insertion Comment  -->
      <?= $renderer->render('@comment/admin/chapters/comments',compact('comment','elements','index', 'comment->indexChapter','this->indexBook','indexComment')) ?>
    

      <!--End boucle to each chapter  -->
      <?php if (isset($comment->indexComment) && $comment->indexComment === -1): ?>
          </div>
        </article>
      <?php endif ?>

      <!--End boucle to each book  -->
      <?php if (isset($comment->indexBook) && $comment->indexBook === -1): ?>
            </div>
          </article>
        </div>
      <?php endif ?>

    <?php endforeach?>
  </section>
<?php endif ?>


