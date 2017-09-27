<section class="hero is-medium"  style="background:url(../../../bgheader.jpg);background-size:cover;height:100%;">
  <div class="hero-body" >
    <div class="container">
      <h1 class="title has-text-centered has-text-white" ><p>Chapitre <?= $chapter->chapters_order ?></p></h1>
    </div>
    <div class="container">
      <h2 class="subtitle has-text-centered has-text-white"><?= $chapter->name ?></h2>
    </div>
  </div>
</section>

<section class="section" >


  <div class="container" >
    <p><?= $chapter->content?></p>
  </div>
</section>

<?php if ($this->hasView('@comment/')): ?>
<?= $renderer->render('@comment/front/chapters/read',compact('comments','commentsFormAction')) ?>
<?php endif ?>
