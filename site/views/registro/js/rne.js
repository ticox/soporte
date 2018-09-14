$(document).ready(function(){



$( "#fecha_nacimiento" ).datepicker({
  dateFormat: 'yy-mm-dd'
});

function archivo(input)
{
  $("div#prevista").remove();
  $('#list').addClass('active');
  reader=Array();
  for (var i = 0; i < input.files.length ;  i++)
  {
    reader[i] = new FileReader();
    reader[i].numero= i;
    reader[i].onloadstart= function(){

      $('#list').after('<div id="cargarr'+this.numero+'" class="col-xs-6 col-sm-4 col-md-3 col-lg-2 ">img ==='+this.numero+'</div>' );

    }
    reader[i].onloadend= function(){

      $('div#cargarr'+this.numero).remove();
    }
    reader[i].onload= function()
    {
      $('#list').after('<div id="prevista" class="prviuw"><img class="" width="100px" height="100px" src="'+this.result+' " ></div>' );
    }
    reader[i].readAsDataURL(input.files[i]);
  }

  console.log(input);
  
}

$('#files').change(function()
{
  archivo(this);
});
//................................................................................................




});
		

	