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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <?php if(isset($headerDatas->typePage) && in_array($headerDatas->typePage,['update','create'])): ?>
      <script src="<?= $urlHelper->baseUrl() ?>/contentTools/content-tools.min.js"></script>
      <script src="<?= $urlHelper->baseUrl() ?>/contentTools/editor.js"></script>
    <?php endif ?>
    <script src="<?= $urlHelper->baseUrl() ?>/js/app.js"></script>
  </body>
</html>