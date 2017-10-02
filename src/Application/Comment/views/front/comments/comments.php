<article class="media" id="media-<?= $comment->id ?>">
  <figure class="media-left">
    <?= $comment->gravatar('64') ?>
  </figure>
  <div class="media-content">
    <div class="content" id="comment-<?= $comment->id ?>">
      <p>
        <strong><?= $comment->pseudo ?></strong>
        <br>
        <?= $comment->content ?>
        <br>
        <small id="action">
          <a class="report" data-id="<?= $comment->id ?>">Signaler</a> 
          <?php if ($comment->depth < 2): ?> 
          · <a class="reply" data-id="<?= $comment->id ?>">Répondre</a>
          <?php endif ?>
          <!--  · 3 hrs -->
        </small>
      </p>
    </div>
    <?php if (isset($comments[$comment->id])): ?>          
      <?php foreach ($comments[$comment->id] as $comment):?>
        <?= $renderer->render('@comment/front/comments/comments',compact('comment','comments')) ?>
      <?php endforeach?>
    <?php endif ?>
  </div>
</article>