<section class="section">
  <div class="container">
    <h2 class="title">Commentaires</h2>   
    <?php if (isset($comments) && !empty($comments)):?>
    <?php foreach ($comments[0] as $comment):?>
      <?= $renderer->render('@comment/front/comments/comments',compact('comment','comments')) ?>
    <?php endforeach?>
    <?php endif?>

    <?= $renderer->render('@comment/admin/comments/create', compact('commentsFormAction')) ?>
    <?= $renderer->render('@comment/front/comments/modal', compact('commentsFormAction')) ?>

  </div>
</section>