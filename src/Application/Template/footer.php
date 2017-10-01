    <footer class="footer">
      <div class="container">
        <div class="content has-text-centered">
          <p>
            © 2017 <strong>réalisé</strong> by <a href="http://www.3desquisse.fr">Niko</a>.
          </p>
          <p>
            <a class="icon" href="https://github.com/NikoSkui/Blog_Jean-Forteroche">
              <i class="fa fa-github"></i>
            </a>
          </p>
        </div>
      </div>
    </footer>
    <!--JS "JQUERY"  --> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!--JS "ANIJS" ANIMATION JS  --> 
    <script src="<?= $urlHelper->baseUrl() ?>/libraries/anijs/anijs-min.js"></script>
    <script src="<?= $urlHelper->baseUrl() ?>/libraries/anijs/helpers/dom/anijs-helper-dom-min.js"></script>
    <?php if(isset($headerDatas->typePage) && in_array($headerDatas->typePage,['update','create'])): ?>
      <!--JS "CONTENTTOOLS" EDITOR WYSWYG  --> 
      <script src="<?= $urlHelper->baseUrl() ?>/libraries/contentTools/content-tools.min.js"></script>
      <script src="<?= $urlHelper->baseUrl() ?>/libraries/contentTools/editor.js"></script>
    <?php endif ?>
    <!--JS CUSTOM  --> 
    <script src="<?= $urlHelper->baseUrl() ?>/js/app.js"></script>
  </body>
</html>