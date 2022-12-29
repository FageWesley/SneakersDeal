export default $(document).on('click',"#product-like", function(e){
    e.preventDefault();

    var url = $(this).attr('href');
    var entityId = $(this).attr('data-entity-id')
    var csrfToken = $(this).attr('data-csrf-token')
    var isLiked = $(this).attr('data-liked')

    if (isLiked === "0"){
        $(this).attr('data-liked',1);
        $('.fa-thumbs-up').addClass("liked").text("Unlike")
    }else{
        $(this).attr('data-liked',0);
        $('.fa-thumbs-up').removeClass("liked").text("Like")
    }
    $.ajax({
        type: 'POST',
        dataType:'json',
        data:{'entityId' : entityId, 'csrfToken' : csrfToken},
        url:url,
        success:function(){
            console.log('succes')
        },
        error: function(){
            //do something like reset icon
        }
    });
});