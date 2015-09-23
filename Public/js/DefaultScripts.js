function addslashes(str) {
  //  discuss at: http://phpjs.org/functions/addslashes/
  // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: Ates Goral (http://magnetiq.com)
  // improved by: marrtins
  // improved by: Nate
  // improved by: Onno Marsman
  // improved by: Brett Zamir (http://brett-zamir.me)
  // improved by: Oskar Larsson Högfeldt (http://oskar-lh.name/)
  //    input by: Denny Wardhana
  //   example 1: addslashes("kevin's birthday");
  //   returns 1: "kevin\\'s birthday"

  return (str + '')
    .replace(/[\\"']/g, '\\$&')
    .replace(/\u0000/g, '\\0');
}


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

            var Url             = This.attr('href').split('/'),
                DeleteIcon      = false,
                Element         = $('[target="' + This.attr('for') + '"]');

            if( Element.find('.header i.openThisWindow, .title i.openThisWindow').length > 0 ){
                DeleteI = true;
            } else {
                Element.find('.header, .title').append('<i class="material-icons openThisWindow fL" href="/' + Url[1] + '" for="' + This.attr('for') + '">arrow_back</i>');
            }

            Element.find('.content').html( Page );

            if( DeleteIcon === true ){
                Element.find('.header i.openThisWindow, .title i.openThisWindow').remove();
            }
        }
    });
    
    return false;
});

function editRegister( This ){
    $.ajax({ 
        type: "POST",
        dataType: "html",
        cache: false,
        url: This.attr('href'),
        success: function(Page){
            var Url             = This.attr('href').split('/'),
                DeleteIcon      = false,
                Element         = $('[target="' + This.attr('for') + '"]');
                console.log( Element, This );
            if( Element.find('.header i.openThisWindow, .title i.openThisWindow').length > 0 ){
                DeleteI = true;
            } else {
                Element.find('.header, .title').append('<i class="material-icons openThisWindow fL" href="/' + Url[1] + '" for="' + This.attr('for') + '">arrow_back</i>');
            }

            Element.find('.content').html( Page );

            if( DeleteIcon === true ){
                Element.find('.header i.openThisWindow, .title i.openThisWindow').remove();
            }
        }
    });
}

$(document).on('mousedown', '.tableDefault tbody tr', function(e){


    var This = $(this);

    if( e.button == 1 ){
        editRegister( This );
    } else {
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

    var 
        post = '',
        This = $(this),
        Form = $(this).parents('form');

    Form.find('input[type="text"]').each(function(){
        if( $(this).val() != undefined && $(this).attr('name') != undefined  ){
            post  += ( post != '' ? '#&#' : '' ) + $(this).attr('name') + '#=#' + $(this).val() ;
        }
    });

    // password
    Form.find('input[type="password"]').each(function(){
        if( $(this).val() != undefined && $(this).attr('name') != undefined && $(this).val() != ''  ){
            post  += ( post != '' ? '#&#' : '' ) + $(this).attr('name') + '#=#' + $(this).val() ;
        }
    });
    // hidden
    Form.find('input[type="hidden"]').each(function(){
        if( $(this).val() != undefined && $(this).attr('name') != undefined  ){
            post  += ( post != '' ? '#&#' : '' ) + $(this).attr('name') + '#=#' + $(this).val() ;
        }
    });
    // select
    Form.find('select').each(function(){
        if( $(this).val() != undefined && $(this).attr('name') != undefined  ){
            post  += ( post != '' ? '#&#' : '' ) + $(this).attr('name') + '#=#' + $(this).val() ;
        }
    });
    // textarea
    Form.find('textarea').each(function(){
        if( $(this).val() != undefined && $(this).attr('name') != undefined && $(this).hasClass('tinymce') == false  ){
            post  += ( post != '' ? '#&#' : '' ) + $(this).attr('name') + '#=#' + $(this).val() ;
        }
    });
    // radio
    Form.find('input[type="radio"]').each(function(){
        if( $(this).val() != undefined && $(this).attr('name') != undefined  ){
            post  += ( post != '' ? '#&#' : '' ) + $(this).attr('name') + '#=#' + $(this).val() ;
        }
    });
    // checkbox
    Form.find('input[type="checkbox"]:checked').each(function(){
        if( $(this).val() != undefined && $(this).attr('name') != undefined  ){
            post  += ( post != '' ? '#&#' : '' ) + $(this).attr('name') + '#=#' + $(this).val() ;
        }
    }); 
    // tinymce
    Form.find('textarea.tinymce').each(function(){
        if( $(this).val() != undefined && $(this).attr('name') != undefined  ){
            post  += ( post != '' ? '#&#' : '' ) + $(this).attr('name') + '#=#' + tinyMCE.get( $(this).attr('id') ).getContent();
        }
    });

    $.ajax({ 
        type: "POST",
        dataType: "json",
        cache: false,
        data: {post: post},
        url:  $(this).parents('form').attr('action'),
        success: function(Page){
            if( Page.message != false ){
                console.log( '[target="' + This.attr('for') + '"]', This );
                $('[target="' + This.attr('for') + '"] .content').load( Page.Location );
            } else {
                alert('Erro ao salvar, contate o administrador');
            }
        }
    });
    return false;
});

$(document).on('click', '.tableDefault .item_delete', function(){
    var Confirm = confirm( 'Tem certeza que deseja deletar este registro? Esta comando não pode ser desfeito!' );

    if( Confirm == true ){

        var This = $(this);

        $.ajax({ 
            type: "POST",
            dataType: "json",
            cache: false,
            data: {
                Id: This.parents('tr').data('id'),
            },
            url:  '/' + This.parents('tr').data('module') + '/Deletar/' + This.parents('tr').data('id'),
            success: function(Page){
                
                if( Page.message == true ){
                    This.parents('tr').remove();
                } else {
                    alert('Erro ao salvar, contate o administrador');
                }
            }
        });
    }
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

function RemoveAccents(varString) {
    var stringAcentos = new String('áàâãèêéíìîóõòôúûùçÁÀÃÂÉÈÊÍÌÎÔÓÕÒÚÛÙÇ');
    var stringSemAcento = new String('aaaaeeeiiioooouuucAAAAEEEIIIOOOOUUUC');  
      
    var i = new Number();  
    var j = new Number();  
    var cString = new String();  
    var varRes = '';  
      
    for (i = 0; i < varString.length; i++) {  
        cString = varString.substring(i, i + 1);  
        for (j = 0; j < stringAcentos.length; j++) {  
    
            if (stringAcentos.substring(j, j + 1) == cString){  
                cString = stringSemAcento.substring(j, j + 1);  
            }  
        }  
        varRes += cString;  
    }  
    return varRes;
};

/* Projects */
$(document).on('click', '#p-pages .edit input', function(e){

    e.stopPropagation();
});

$(document).on('keyup', '#p-pages .edit input', function(e){
    if( e.keyCode == 13 ){

        var This = $(this);

        $.ajax({ 
            type: "POST",
            dataType: "json",
            cache: false,
            data: {
                page: This.parents('li').attr('id'),
                pjc : $('.pMenuRigth').data('pjc'),
                title: $(this).val()
            },
            url: '/Projects/Ajax/Rename',
            success: function(Page){

                if( Page.Status == true ){

                    This.parents('li').attr('id', Page.File).attr('data-title', Page.Title).attr('data-info', JSON.stringify( Page ) ).find('.view').html('<i class="material-icons fL">&#xE5CC;</i> ' + Page.Title);
                    This.parents('li').find('.edit').hide();
                    This.parents('li').find('.view').show();

                } else {
                    alert( Page.Message );
                    This.focus();
                }
            }
        });
    }
});

$(document).on('click', '#p-pages li', function(){

    var This = $(this);

    $('#p-pages li.active').removeClass('active');
    This.addClass('active');

    LoadPage();
    setTimeout(function(){
        $('#pDefaultMenu a[href="/' + This.attr('id').replace('.pjc', '') + '"] li').addClass('active');
    }, 200);

    $('#ModuleProjects .mdl-layout__drawer-button').click();
    $('#ModuleProjects .mdl-layout-title').html( This.find('.view').html() );
    $('#ModuleProjects .mdl-layout-title').find('i').remove();

});

$(document).on('click', '#stage a', function(){
    return false;
});

$(document).on('mouseenter', '#stage .grid div', function(){ 
    $(this).append(   '<button id="addBlock" class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored openModal" href="/Projects/Ajax/ItemsModal/' + $('.pMenuRigth:visible').data('pjc') + '" title="<i class=\'material-icons fL mR\'>&#xE02E;</i> Adicionando item" data-parent="#ModuleProjects" data-size="large">' +
                        '<i class="material-icons">add</i>' +
                    '</button>' );
});

$(document).on('mouseleave', '#stage .grid div', function(){ 
    $(this).find('#addBlock').remove();
});

$(document).on('click', '#addBlock', function(){
    $('#stage .itemEdit').removeClass('itemEdit');
    $(this).parent('div').addClass('itemEdit');
    // alert('ok');

});

/* Ends Projects */

/* Modal */
function Modal ( This ){
    
    var Size        = ( This.data('size')       != undefined ? This.data('size')        : 'medium'  ),
        Url         = ( This.attr('href')       != undefined ? This.attr('href')        : false     ),
        Draggable   = ( This.data('draggable')  != undefined ? This.data('draggable')   : true      ),
        Shadow      = ( This.data('shadow')     != undefined ? This.data('shadow')      : true      ),
        Parent      = ( This.data('parent')     != undefined ? This.data('parent')      : 'body'    ),
        Title       = ( This.attr('title')      != undefined ? This.attr('title')       : false     ),
        Target      = ( This.attr('for')        != undefined ? This.attr('for')         : ''        ),

        HTML = '';

    $('#modal, .shadowModal').remove();

    HTML += '<div class="modal ' + Size + '" id="modal" target="' + Target + '">';

        HTML += '<div class="title">' + ( Title != false ? Title : '' ) + ' <i class="material-icons close fR mL">&#xE14C;</i></div>';
        HTML += '<div class="content"></div>';

    HTML += '</div>';

    $(Parent).append( HTML );

    switch( Size ){

        case 'large' :
            $('#modal').css({
                width: ( $(window).width() / 2 ),
                height: ( $(window).height() / 1.5 ),
                marginLeft: - ( $(window).width() / 2 ) / 2,
                marginTop: - ( $(window).height() / 1.5 ) / 2
            });
            break;

        case 'medium' :
            $('#modal').css({
                width: ( $(window).width() / 3 ),
                height: ( $(window).height() / 2.5 ),
                marginLeft: - ( $(window).width() / 3 ) / 2,
                marginTop: - ( $(window).height() / 2.5 ) / 2
            });
            break;

        case 'small' :
            $('#modal').css({
                width: ( $(window).width() / 4 ),
                height: ( $(window).height() / 3.5 ),
                marginLeft: - ( $(window).width() / 4 ) / 2,
                marginTop: - ( $(window).height() / 3.5 ) / 2
            });
            break;
    }


    if( Draggable == true ){
        $('#modal').draggable({
            handle: ( Title != false ? '.title' : false ),
            containment: Parent,
            scroll: false
        });
    }

    if( Shadow == true ){
        $(Parent).append('<div class="shadowModal"></div>');
    }

    $('#modal .content').load( Url );

    return false;
}

$(document).on('click', '.openModal', function(){
    Modal( $(this) );
    return false;
});

$(document).on('click', '#modal .close', function(){
    $(this).parents('#modal').remove();
    $('.shadowModal').remove();
    return false;
});

/* Ends Modal */

function editorHTML( Array ){

    var editorHTML = new tinymce.Editor( Array.Element, {
                plugins: [ "autolink charmap emoticons hr insertdatetime link lists paste table textcolor textpattern autoresize "],
                toolbar: [ "undo redo | bold italic underline fontsizeselect forecolor backcolor | alignleft aligncenter alignright alignjustify " ],
                insertdatetime_formats: ["%d/%m/%Y", "%Y-%m-%d", "%H:%M", "%H:%M:%S"],
                fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
                menubar: "edit insert format table",

                language  : 'pt_BR',
                selector  : '.tinymce',
                skin      : 'lightgray',
                statusbar: false,
                width     : Array.Width,
                height    : Array.Height,

    }, tinymce.EditorManager);

    editorHTML.render();
}

/* Explorer */

$(document).on('dblclick', '.eIcons:visible li', function(){

   var JSON = $(this).data('info');

    switch( JSON.Type ){

        case 'FOLDER':
            $('.eIcons').parent('div').load( ( $('.eIcons').data('location') + $(this).find('span').text() + '?' + $('.eIcons').data('filtro') ) );
            break;
    }

    return false;
});

$(document).on('click', '#navPrev', function(){

    var Location = $('.eIcons').data('location'),
        Array    = Location.split('/'),
        NewUrl   = '';

    /* Preparando array */
    Location = '';
    for( var i = 0; i <= Array.length; i++ ){
        if( Array[ i ] != '' && Array[ i ] != undefined ){
            Location += Array[ i ] + '/';
        }
    }

    Array    = Location.split('/');

    for( var i = 0; i < ( Array.length ) - 2 ; i++ ){
        if( Array[ i ] != '' && Array[ i ] != undefined ){
            NewUrl += Array[ i ] + '/';
        }
    };

    $('.eIcons').parent('div').load( NewUrl + '?' + $('.eIcons').data('filtro') );
});

$(document).on('click', '#explorerContent', function(){
    $('#explorerContent .rCliked').removeClass('rCliked');
});

$(document).on('click', '.eIcon', function(e){
    e.stopPropagation();
    $('#explorerContent .rCliked').removeClass('rCliked');
    $(this).parent('li').addClass('rCliked');
});
/* Ends Explorer */