<!--Form -->
<form class="media" action="<?= $router->generateUri('Front#Comment#Create', [
                                'slugBook' => $commentsFormAction['slugBook'],
                                'chapters_order' => $commentsFormAction['chapters_order'],
                                'slugChapter' => $commentsFormAction['slugChapter'],
                                'id' => $commentsFormAction['chapter_id']]) ?>" 
                    method="post" 
                    id="form-comment">
  <input type="hidden" name="parent_id" value="0" id="parent_id">
  <figure class="media-left">
    <p class="image is-64x64">
      <img src="<?= $urlHelper->baseUrl() ?>/img/avatar.png">
    </p>
  </figure>
  <div class="media-content">
    <div class="field ">
      <div class="field-body">
        <div class="field">
            <label class="label">Pseudo</label> 
          <div class="control has-icons-left">
            <input class="input is-medium" type="text" placeholder="" name="pseudo" required>
            <span class="icon is-small is-left"><i class="fa fa-user"></i></span>
          </div>
        </div>
        <div class="field">
            <label class="label">Email</label> 
          <div class="control is-expanded has-icons-left ">
            <input class="input is-medium" type="email" placeholder="" value="" name="email" required>
            <span class="icon is-small is-left"><i class="fa fa-envelope"></i></span>
          </div>
        </div>
      </div>
    </div>
    <div class="field">
      <p class="control">
        <textarea class="textarea" name="content" id="content" placeholder="Ajouter un commentaire..." required ></textarea>
      </p>
    </div>
    <div class="field">
      <p class="control">
        <button name="form-comment" type="submit" class="button">Poster le commentaire</button>
      </p>
    </div>
  </div>
</form>