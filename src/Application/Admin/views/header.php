<section class="hero is-medium" style="background:url(<?= $urlHelper->baseUrl() ?>/bgheader.jpg);background-size:cover;height:100%;">
  <div class="hero-body">
    <div class="container">
      <div class="columns is-vcentered">
        <div class="column">
          <p class="title has-text-white">
            Administration
          </p>
          <?php if(isset($headerDatas->subtitle)): ?>
          <p class="subtitle has-text-white">
            <?= $headerDatas->subtitle ?>
          </p>
          <?php endif ?>       
        </div>
        <?php if(isset($headerDatas->btnTxt)): ?>
          <div class="column is-narrow">
              <a class="button is-info is-medium" href="<?= $router->generateUri($prefixName.'#Create') ?>" style="box-shadow: 0 2px 3px rgba(10, 10, 10, .1), 0 0 0 1px rgba(10, 10, 10, .1);">
                <?= $headerDatas->btnTxt ?>
              </a>
          </div>
        <?php endif ?> 
        <?php if($headerDatas->typePage === 'update'): ?>
          <div class="column is-narrow has-text-white" >
            <div class="title has-text-white" data-editable data-name="name">
              <p><?= $headerDatas->name ?></p>
            </div>
          </div>   
        <?php endif ?>
        <?php if($headerDatas->typePage === 'create'): ?>
          <div class="column is-narrow has-text-white" >
            <div class="title has-text-white" data-editable data-name="name">
              <p>Entrez le titre du chapitre</p>
            </div>
          </div>   
        <?php endif ?>

      </div>
    </div>
  </div>
</section>
  <?php if($headerDatas->typePage === 'read'): ?>
  <?= $renderer->render('@admin/navbar', ['adminNavbar'=>$headerDatas->adminNavbar]) ?>
  <?php endif ?>