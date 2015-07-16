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

/* save reg */
function reg( Module, Key, Value ){
    $.ajax({ 
        type: "POST",
        dataType: "html",
        data: {
            Module: Module,
            Key: Key,
            Value: Value
        },
        cache: false,
        url: '/Action/save_reg',
    });
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

$(document).on('click', '.tableDefault tbody tr', function(){

    var This = $(this);

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
    // $(this).parents('.content').load( $(this).attr('href') );
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



// per css-tricks restarting css animations
// http://css-tricks.com/restart-css-animation/
$(document).on('click', '.checkbox label', function() {
  
  // find the first span which is our circle/bubble
  var el = $(this).children('span:first-child');
  
  // clone it
  var newone = el.clone(true);  
  
  // add the cloned version before our original
  el.before(newone);  
  
  // remove the original so that it is ready to run on next click
  $(this).find("." + el.attr("class") + ":last").remove();
}); 

$(document).on('ready')
/* Ends Post Form */