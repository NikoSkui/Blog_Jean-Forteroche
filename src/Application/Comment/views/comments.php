<article class="media">
  <figure class="media-left">
    <p class="image is-64x64">
      <img src="http://bulma.io/images/placeholders/128x128.png">
    </p>
  </figure>
  <div class="media-content">
    <div class="content" id="comment-<?= $comment->id ?>">
      <p>
        <strong><?= $comment->pseudo ?></strong>
        <br>
        <?= $comment->content ?>
        <br>
        <small>
          <a>Signaler</a> · 
          <?php if ($comment->depth < 2): ?> 
          <a class="reply" data-id="<?= $comment->id ?>">Répondre</a> ·
          <?php endif ?>
          3 hrs
        </small>
      </p>
    </div>
    <?php if (isset($comments[$comment->id])): ?>          
      <?php foreach ($comments[$comment->id] as $comment):?>
        <?= $renderer->render('@comment/comments',compact('comment','comments')) ?>
      <?php endforeach?>
    <?php endif ?>
  </div>
</article>