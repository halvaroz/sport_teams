'use strict'

document.addEventListener("DOMContentLoaded", function(event) {
  let chiffres = Array('Un','Deux','Trois','Quatre','Cinq','Six','Sept','Huit','Neuf')
  
  for(let i=1; i<=11; i++){
  	let team = document.getElementById(i);
    
  	team.addEventListener('mouseover', function() {
  		let idElt = this.getAttribute('id');
  		let eventsClass = 'team-' + idElt;
  		let teamEvents = document.getElementsByClassName(eventsClass);
  		let eventsNumber = teamEvents.length;

  			/*Génération de l'attribut title*/
  			let club = this.textContent;

	  		let eltTitle = '';

	  		let plural ='';
	  		if (eventsNumber>1){
	  			plural="es";
	  		}

	  		if (eventsNumber === 0) {
	  			eltTitle = 'Aucun de match du '+ club + ' sur cette page :(';
	  		} else {
	  			eltTitle = chiffres[eventsNumber-1] +' match'+ plural +' du '+ club +' sur cette page !'
	  		}

  			this.setAttribute('title', eltTitle);

  		for(let j=0; j<teamEvents.length; j++){
  			teamEvents[j].classList.add('event-light');
  		}
  	});

  	team.addEventListener('mouseleave', function() {
  		let idElt = this.getAttribute('id');
  		let eventsClass = `team-${idElt}`;
  		let teamEvents = document.getElementsByClassName(eventsClass);

  		for(let j=0; j<teamEvents.length; j++){
  			teamEvents[j].classList.remove('event-light');
  		}
  	})
  }

  for(let i=1; i<=11; i++){
  	let index = 'team-'+i;
  	let events = document.getElementsByClassName(index);
  	
  	for(let j=0; j<events.length; j++){
  		events[j].addEventListener('mouseover', function() {
          /*à voir si utiliter de reboucler*/
  			for(let k=0; k<events.length; k++){
  			  events[k].classList.add('event-light');
  			}
  			document.getElementById(i).classList.add('club-light');
  		})

  		events[j].addEventListener('mouseout', function() {
  			for(let l=0; l<events.length; l++){
  			  events[l].classList.remove('event-light');
  			}
  		document.getElementById(i).classList.remove('club-light');
  	})
  	}
}
});