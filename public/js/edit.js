'use strict'

document.addEventListener("DOMContentLoaded", function(event) {
	let dele = document.getElementById('delete_button');
	dele.addEventListener('click',function(){
		let eventId = this.dataset.id;
	    location.replace("delete.php?id="+eventId);
	});
})