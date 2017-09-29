<?= $renderer->render('@comment/admin/reports/read',compact('additionnals')) ?>
<section class="section">
  <?php foreach ($elements[0] as $k => $comment):?>

    <?php $comment->setIndexes($elements,$k) ?>
    <!--Start boucle to each book  -->
    <?php if (isset($comment->indexBook) && $comment->index === $comment->indexBook): ?>
      <div class="section">
        <article class="media">
          <div class="media-content">
            <div class="content" id="comment-<?= $comment->id ?>">
              <h2><?= $comment->books_name ?></h2>
            </div>
    <?php endif ?> 

    <!--Start boucle to each chapter  --> 
    <?php if (isset($comment->indexChapter) && $comment->index === $comment->indexChapter): ?>
      <article class="media" style="margin-left:30px">
        <div class="media-content">
          <div class="content" id="comment-<?= $comment->id ?>">
            <h3>Chapitre <?= $comment->chapters_order ?></h3>
          </div>
    <?php endif ?>

    <!--Insertion Comment  -->
    <?= $renderer->render('@comment/admin/comments/comment', compact('comment','elements','index', 'comment->indexChapter','indexComment')) ?>
  
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