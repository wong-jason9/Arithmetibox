console.log("Programme attaque vient d'être chargé");
$(document).ready(function(){
	console.log("Document prêt");

	$('#change').click(function(){
		console.log("appuie sur le bouton changer");
		$.post("Contenu/changerSubstitution.php",
			{
				ok: true,
			},
			function(reponse){
				console.log(reponse);
				var mes = $('<p>'+reponse+'</p>');
				$("#message_subtitution").append(mes);
			});

	});

	console.log("En attente d'événements...");
});