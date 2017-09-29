
<article class="media container" style="width:auto">
  <figure class="media-left">
    <p class="image is-24x24">
      <img src="http://bulma.io/images/placeholders/128x128.png">
    </p>
  </figure>
  <div class="media-content">
    <div class="content" id="comment-<?= $comment->id ?>">
      <p>
        <strong><?= $comment->pseudo ?> : </strong><?= $comment->email ?>
      </p>
    </div>
    <?php if (isset($elements[$comment->id])): ?>         
      <?php foreach ($elements[$comment->id] as $comment):?>
        <?= $renderer->render('@comment/admin/reports/comment',compact('comment','elements')) ?>
      <?php endforeach?>
    <?php endif ?>
  </div>
  <div class="media-right">
    <span class="icon">
      <a class="is-info" href="<?= $router->generateUri($prefixName.'#Update', ['id' => $comment->id]) ?>">
        <i class="fa fa-eye"></i>
      </a>
    </span>
  </div>
  <div class="media-right">
    <form action="<?= $router->generateUri($prefixName.'#Delete', ['id' => $comment->id]) ?>" method="post" onsubmit="return confirm('êtes vous sûr de vouloir supprimer ce chapitre ?')">
      <input type="hidden" name="_method" value ="DELETE">
      <button class="delete " type="submit"></button>
    </form>
  </div>
</article>