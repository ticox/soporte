$(document).ready(function(){




$(".logo_centro").attr("src",base_url+"public/img/logox1.png");
$(".logo_centro").css("width", "35%");


			$(function() {
				/* 
				 * just for this demo:
				 */
				$('#showcode').toggle(
					function() {
						$(this).addClass('up').removeClass('down').next().slideDown();
					},
					function() {
						$(this).addClass('down').removeClass('up').next().slideUp();
					}
				);
				$('#panel').toggle(
					function() {
						$(this).addClass('show').removeClass('hide');
						$('#overlay').stop().animate( { left : - $('#overlay').width() + 20 + 'px' }, 300 );
					},
					function() {
						$(this).addClass('hide').removeClass('show');
						$('#overlay').stop().animate( { left : '0px' }, 300 );
					}
				);
				
				var $container 	= $('#am-container'),
					$imgs		= $container.find('img').hide(),
					totalImgs	= $imgs.length,
					cnt			= 0;
				
				$imgs.each(function(i) {
					var $img	= $(this);
					$('<img/>').load(function() {
						++cnt;
						if( cnt === totalImgs ) {
							$imgs.show();
							$container.montage({
								liquid 	: false,
								fillLastRow : true
							});
							
							/* 
							 * just for this demo:
							 */
							$('#overlay').fadeIn(500);
						}
					}).attr('src',$img.attr('src'));
				});	
				
			});


$(document).on("click", "#ver_niña", function(){
	id_nina=$(this).data("id");
	location.href=base_url+'nina/individual/'+id_nina;
})

















});