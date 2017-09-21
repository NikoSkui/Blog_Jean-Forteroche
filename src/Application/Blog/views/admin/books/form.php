      <div class="field">
        <label class="label">Titre du livre</label>
        <div class="control">
          <input class="input" type="text" name="name" placeholder="Titre" value="<?= $element->name ?>">
        </div>
      </div>
      <div class="field">
        <label class="label">Slug du livre</label>
        <div class="control">
          <input class="input" type="text" name="slug" placeholder="Slug" value="<?= $element->slug ?>">
        </div>
      </div>
      <div class="field">
        <label class="label">Sommaire</label>
        <div class="control">
          <textarea class="textarea" placeholder="Textarea" name="excerpt"  ><?= $element->excerpt ?></textarea>
        </div>
      </div>