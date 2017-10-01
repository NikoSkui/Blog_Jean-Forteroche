<section class="section" >
  <div class="container content" >
    <?= $chapter->content?>
  </div>
</section>
<?php if ($this->hasView('@comment/')): ?>
<?= $renderer->render('@comment/front/comments/list',compact('comments','commentsFormAction')) ?>
<?php endif ?>