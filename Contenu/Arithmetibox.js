$(document).ready(function(){
	var n = 1;	//n represente le nombre de fois ou l'utilisateur a cliquer sur changer, cela nous sera utile pour faire après les permutations
	var alphabet_freq_depart = [];
	var i = 0;
	while(i < 26){
		alphabet_freq_depart[i] = $(".freq_alphabet").children().children('tr').eq(i).children('td').eq(2).text();
		i = i + 1;
	}
	
	//Gestionnaire lorsqu'on clique sur le bouton changer
	$('#change').click(function(){
		n = n + 1;
		var message = $('.message').text();
		
		var tab = [];
		var i=0;
		while(i < 3*26){
			tab[i] = $('table tr').children().eq(i).text();
			i = i + 1;
		}
		$.post("Contenu/changerSubstitution.php",
			{
				message: message,
				tab: tab,
				alphabet_freq: alphabet_freq_depart,
				repeter_n: n
			},
			function(reponse){
				var mes = $('<p>'+reponse.message+'</p>');
				$(".message").html(mes);
				MAJ_tab_alphabet(reponse.resultat_alphabet);

				console.log('message:'+reponse.message);
				console.log('alphabet permuter:'+reponse.resultat_alphabet);
			});
	});

	function MAJ_tab_alphabet(tab_alphabet){
		var i = 0;
		while(i < 26){	//26 car le tableau est composer de 26 ligne
			$(".freq_alphabet").children().children('tr').eq(i).children('td').eq(2).text(tab_alphabet[i]);
			i = i + 1;	//y permet de parcourir les 26 ligne du tableau
		}
	}
});