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
		//console.log('tab avant requete');
		//console.log(tab);

		$.post("Contenu/changerSubstitution.php",
			{
				ok: true,
				message: message,
				tab: tab,
			},
			function(reponse){
				//console.log('reponse', reponse);
				var mes = $('<p>'+reponse.message+'</p>');
				$(".message").html(mes);
				//console.log(reponse.tab);
				MAJ_tab_alphabet(reponse.tab);
				
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