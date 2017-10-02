<section class="section" >
  <div class="container content" >
    <?= $chapter->content?>
  </div>
</section>
<?php if ($this->hasView('@comment/')): ?>
<?= $renderer->render('@comment/front/comments/list',compact('comments','commentsFormAction')) ?>
<?php endif ?>
<a class="return fadeIn animated " href="<?= $router->generateUri('Front#Chapters#List', ['slugBook' => $commentsFormAction['slugBook']])?>" >
  <?= $renderer->render('@component/btn_return')?>
</a>