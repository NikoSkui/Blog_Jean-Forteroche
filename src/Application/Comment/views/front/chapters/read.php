<section class="section">
  <div class="container">
    <h2 class="title">Commentaires</h2>   

    <?php foreach ($comments[0] as $comment):?>
      <?= $renderer->render('@comment/front/chapters/comments',compact('comment','comments')) ?>
    <?php endforeach?>

    <?= $renderer->render('@comment/admin/chapters/create', compact('commentsFormAction')) ?>

  </div>
</section>