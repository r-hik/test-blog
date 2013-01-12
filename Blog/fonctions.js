$(document).ready(function(){

	$("#body").load('accueil.php');

	$("a").click(function(){
		$('a').removeClass('active');
		$(this).addClass('active');

		var page = $(this).attr('href');
		$("#body").load(page);
		return false;
	});

	})