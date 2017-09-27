jQuery(document).ready(function($){

  $('.reply').click(function(e){
    e.preventDefault()
    var $form = $('#form-comment')
    var $this = $(this)
    var $parent_id = $this.data('id')
    var $comment = $('#comment-' + $parent_id)

    $("#content").attr('placeholder','Répondre à ce commentaire')
    $("#parent_id").val($parent_id)
    $comment.after($form);


  }) 

  $( ".ct-widget" ).addClass("ct-widget--active");
})