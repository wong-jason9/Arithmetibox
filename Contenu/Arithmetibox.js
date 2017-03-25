//console.log("Programme attaque vient d'être chargé");
$(document).ready(function(){
	//console.log("Document prêt");

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
				$("#message_subtitution").append(mes);
				//$(".message").text(mes);
			});

	});
	//console.log("En attente d'événements...");
});