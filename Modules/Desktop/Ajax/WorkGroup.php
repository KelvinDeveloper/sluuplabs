<?php $WP = $Database->Search('work_groups', false, "id_work_group='" . $Url[4] . "'"); ?>

<div class="mdl-layout mdl-js-layout itens-pjc">
  <header class="mdl-layout__header mdl-layout__header--scroll">
    <div class="mdl-layout__header-row">
      <span class="mdl-layout-title"><input class="edit" value="<?=$WP->name?>"></span>
      <div class="mdl-layout-spacer"></div>
      <nav class="mdl-navigation">

      </nav>
    </div>
  </header>
  <div class="mdl-layout__drawer">
    <nav class="mdl-navigation">
    </nav>
  </div>
  <main class="mdl-layout__content">
    <div class="page-content">
    
      <label for="sUser"><h1>Adicionar um usuário ao grupo de trabalho:</h1> </label> <br>
      <div class="mdl-textfield mdl-js-textfield">
        <input class="mdl-textfield__input" type="text" id="sUser" />
        <label class="mdl-textfield__label" for="sUser">Nome ou email do usuário</label>
      </div>

      <ul class="listSUsers"></ul>

    </div>
  </main>
</div>

<div class="item-content"></div>

<script type="text/javascript">
  $('.mdl-layout-title .edit').blur(function(){
    
    var Val = $(this).val();

    $.ajax({ 
      type: "POST",
      dataType: "json",
      data: {
        name: Val
      },
      cache: false,
      url: '/Desktop/Ajax/UpdateWGName', 
      success: function(json){ 
        if( json.Status == true ){
          $('[href="/Desktop/Ajax/WorkGroup/<?=$Url[4]?>"]').parents('li').find('span.titleGroup').text( Val );
        } else {
          Alert(false, 'Ops.. Erro ao salvar registro');
        }
      }
    });
  });

  $('#sUser').keyup(function(){
    $.ajax({ 
      type: "POST",
      dataType: "json",
      data: {
        value: $(this).val()
      },
      cache: false,
      url: '/Desktop/Ajax/SerachUser', 
      success: function(json){ 

        $('.listSUsers').html('');

        if( json.Status == true ){
          $.each(json.users, function(id, Data) {
            $('.listSUsers').append( '<li><div class="img" style="background-image:url(\'' + Data.ImagePerfil + '\')"></div> <span class="name">' + Data.Nome + '</span></li>' );
          });
        }
      }
    });
  });

  $('.mdl-layout-title .edit').keyup(function(e){
    if( e.keyCode == 13 ){
      $(this).blur();
    }
  });

  upgradeMDL();
</script>