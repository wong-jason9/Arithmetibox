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
				$(".message").text(reponse);
			});

	});

	console.log("En attente d'événements...");
});