      <div class="field">
        <label class="label">Titre du chapitre</label>
        <div class="control">
          <input class="input" type="text" name="name" placeholder="Titre" value="<?= $element->name ?>">
        </div>
      </div>
      <div class="field">
        <label class="label">Slug du chapitre</label>
        <div class="control">
          <input class="input" type="text" name="slug" placeholder="Slug" value="<?= $element->slug ?>">
        </div>
      </div>
      <div class="field">
        <label class="label">Contenu</label>
        <div class="control">
          <textarea class="textarea" placeholder="Textarea" name="content"  ><?= $element->content ?></textarea>
        </div>
      </div>