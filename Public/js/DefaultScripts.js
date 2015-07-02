var ImageOnLoad = function(){
    $('img').each(function(i){
        if (this.complete){
            $(this).fadeIn(200);
        } else {
            $(this).load(function(){
                $(this).fadeIn(200);
            });
        }
    });
};

$(document).ready(function(){
    ImageOnLoad();
});

/* Alert */
function Alert( thisClass, dataContent, thisWidth ){
    clearTimeout( setTimeStatus );
    $('#infoStatus').stop().remove();
    $('body').prepend('<div id="infoStatus" class="' + ( thisClass != undefined ? thisClass : false ) + '" style="' + ( thisWidth != undefined ? 'width:' + thisWidth + '; left: 50%; margin-left: -' + thisWidth / 2 : false ) + '">' + dataContent + '</div>');
    $('#infoStatus').fadeIn( 100 );
    $('#infoStatus').css('top', '5px');

    var setTimeStatus 
        setTimeout(function(){
            $('#infoStatus').fadeOut( 100 );
            $('#infoStatus').css('top', '-70px');
            setTimeout(function() { 
                $('#infoStatus').delay(300).remove(); 
            }, 1000 );
        }, 3000);
}

$(document).on('click', '#infoStatus', function(){
    $('#infoStatus').fadeOut( 100 );
});
/* Ends Alert */

/* Grid */
$(document).on('click', '.openThisWindow', function(){
    
    var This = $(this);

    $.ajax({ 
        type: "POST",
        dataType: "html",
        cache: false,
        url: $(this).attr('href'),
        success: function(Page){
            var Url = This.attr('href').split('/'),
                DeleteI = false;
            
            if( This.parents('.window').find('.header i.openThisWindow').length > 0 ){
                DeleteI = true;
            } else {
                This.parents('.window').find('.header').append('<i class="material-icons openThisWindow fL" href="/' + Url[1] + '">arrow_back</i>');
            }

            This.parents('.window').find('.content').html( Page );

            if( DeleteI === true ){
                This.parents('.window').find('.header i.openThisWindow').remove();
            }
        }
    });
    
    return false;
});

$(document).on('mousedown', '.tableDefault tbody tr', function(e){


    var This = $(this);

    if( e.button == 1 ){
        $.ajax({ 
            type: "POST",
            dataType: "html",
            cache: false,
            url: This.attr('href'),
            success: function(Page){
                var Url = This.attr('href').split('/'),
                    DeleteI = false;
                
                if( This.parents('.window').find('.header i.openThisWindow').length > 0 ){
                    DeleteI = true;
                } else {
                    This.parents('.window').find('.header').append('<i class="material-icons openThisWindow fL" href="/' + Url[1] + '">arrow_back</i>');
                }

                This.parents('.window').find('.content').html( Page );

                if( DeleteI === true ){
                    This.parents('.window').find('.header i.openThisWindow').remove();
                }
            }
        });
    } else {
        console.log('direito');
        e.preventDefault();
        return false;
    }   
});

$(document).on("contextmenu", '.tableDefault tbody tr', function(e){
   return false;
}); 
/* Ends Grid */
/* Post Form */
$(document).on('click', '[target="defaultForm"] button[type="submit"]', function(){
    $.ajax({ 
        type: "POST",
        dataType: "json",
        cache: false,
        data: $(this).parents('form').serialize(),
        url: $(this).parents('form').attr('action'),
        success: function(Page){

        }
    });
    return false;
});
/* Ends Post Form */