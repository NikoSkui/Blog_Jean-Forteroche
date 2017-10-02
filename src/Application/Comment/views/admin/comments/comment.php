<article class="media container" style="width:auto">
  <div class="media-left" style="position:absolute; right:30px">
    <span class="icon">
      <a class="is-info" href="<?= $router->generateUri($prefixName.'#Update', ['id' => $comment->id]) ?>">
        <i class="fa fa-lg fa-eye"></i>
      </a>
    </span>
  </div>
  <div class="media-left" style="position:absolute; right:0px; padding-top:3px;">
    <form action="<?= $router->generateUri($prefixName.'#Delete', ['id' => $comment->id]) ?>" method="post" onsubmit="return confirm('êtes vous sûr de vouloir supprimer ce chapitre ?')">
      <input type="hidden" name="_method" value ="DELETE">
      <button class="delete " type="submit"></button>
    </form>
  </div>
  <figure class="media-left">
    <?= $comment->gravatar('24') ?>
  </figure>
  <div class="media-content">
    <div class="content" id="comment-<?= $comment->id ?>">
      <p>
        <strong> <?= $comment->pseudo ?> : </strong><?= $comment->email ?>
      </p>
    </div>
    <?php if (isset($elements[$comment->id])): ?>         
      <?php foreach ($elements[$comment->id] as $comment):?>
        <?= $renderer->render('@comment/admin/comments/comment',compact('comment','elements')) ?>
      <?php endforeach?>
    <?php endif ?>
  </div>
</article>    