console.log("Programme attaque vient d'être chargé");
$(document).ready(function(){
	console.log("Document prêt");

	//Gestionnaire lorsqu'on clique sur le bouton changer
	$('#change').click(function(){
		console.log("appuie sur le bouton changer");
		var message = $('.message').text();
		$.post("Contenu/changerSubstitution.php",
			{
				ok: true,
				message: message,
			},
			function(reponse){
				console.log(reponse);
				var mes = $('<p>'+reponse+'</p>');
				$("#message_subtitution").append(mes);
			});

	});

	console.log("En attente d'événements...");
});