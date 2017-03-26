console.log("test");
$(document).ready(function(){
	var n = 1;	//n represente le nombre de fois ou l'utilisateur a cliquer sur changer, cela nous sera utile pour faire après les permutations
	var alphabet_freq_depart = [];
	var i = 0;
	while(i < 26){
		alphabet_freq_depart[i] = $(".freq_alphabet").children().children('tr').eq(i).children('td').eq(2).text();
		i = i + 1;
	}

	console.log(alphabet_freq_depart);


	//Gestionnaire lorsqu'on clique sur le bouton changer
	$('#change').click(function(){
		n = n + 1;
		console.log("test");
		var message = $('.message').text();
		
		var tab = [];
		var i=0;
		while(i < 3*26){
			tab[i] = $('table tr').children().eq(i).text();
			i = i + 1;
		}

		$.post("Contenu/changerSubstitution.php",
			{
				ok: true,
				message: message,
				tab: tab,
				alphabet_freq: alphabet_freq_depart,
			},
			function(reponse){
				var mes = $('<p>'+reponse.message+'</p>');
				$(".message").html(mes);
				MAJ_tab_alphabet(reponse.tab);

				console.log("test"+reponse.test);
			});

	});

	function MAJ_tab_alphabet(tab_alphabet){
		var i = 0;
		var y = 0;
		while(i < 3*26){	//3 * 26 car le tableau est composer de freq aparation + valeur freq apparition + alphabet
			$(".freq_alphabet").children().children('tr').eq(y).children('td').eq(0).text(tab_alphabet[i]);
			$(".freq_alphabet").children().children('tr').eq(y).children('td').eq(1).text(tab_alphabet[i+1]);
			$(".freq_alphabet").children().children('tr').eq(y).children('td').eq(2).text(tab_alphabet[i+2]);
			i = i + 3;	//i permet de parcourir les 78 element du tableau (contenant la freq aparation + valeur freq apparition + alphabet)
			y = y + 1;	//y permet de parcourir les 26 ligne du tableau
		}
	}
});