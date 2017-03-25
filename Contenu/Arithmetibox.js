$(document).ready(function(){
	//Gestionnaire lorsqu'on clique sur le bouton changer
	$('#change').click(function(){
		//console.log("appuie sur le bouton changer");
		var message = $('.message').text();
		
		var tab = [];
		var i=0;
		while(i < 3*26){
			tab[i] = $('table tr').children().eq(i).text();
			i = i + 1;
		}
		console.log(tab);

		$.post("Contenu/changerSubstitution.php",
			{
				ok: true,
				message: message,
				tab: tab
			},
			function(reponse){
				console.log(reponse);
				var mes = $('<p>'+reponse+'</p>');
				$(".message").html(mes);
			});

	});
});