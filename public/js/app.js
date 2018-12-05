'use strict'
let $map = document.querySelector('#map')

class LeafletMap {

  constructor () {
    this.map = null
    this.bounds = []
  }

  async load (element) {
    return new Promise((resolve, reject) => {
      $script(['https://unpkg.com/leaflet@1.3.1/dist/leaflet.js'], () => {
        this.map = L.map(element, {scrollWheelZoom: false})
        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', { //{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png
          attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
          accessToken: 'pk.eyJ1IjoiaGFsdmFybyIsImEiOiJjam1oc24ydTMyZmZ0M3ZueXcyaTlyNzRkIn0.hRTiNf-IooJSeQ0P8SLnWA',
          maxZoom: 18,
          id: 'mapbox.streets'
        }).addTo(this.map)
        resolve()
      })
    })
  }

  addMarker (lat, lng, text, competition) {
    let point = [lat, lng]
    this.bounds.push(point)
    return new LeafletMarker(point, text, this.map, competition)
  }

  center () {
    this.map.fitBounds(this.bounds)
  }

}

class LeafletMarker {
  constructor (point, text, map, competition) {
    text=competition.split(' ');
    let sport = text[0];
    sport.replace(/\s+/g, '_');
    sport = sport.toLowerCase();
    let sexe = (!competition.includes('masculin') ? "women" : "men")

    this.text ='<img class="sexe-logo '+ sexe +'" src="img/'+sport+'.png">'
    this.popup = L.popup({
      autoClose: false,
      closeOnEscapeKey: false,
      closeOnClick: false,
      closeButton: false,
      className: 'marker bis',
      maxWidth: 400
    })
      .setLatLng(point)
      .setContent(this.text)
      .openOn(map)
  }

  setActive () {
    this.popup.getElement().classList.add('is-active')
  }

  unsetActive () {
    this.popup.getElement().classList.remove('is-active')
  }

  addEventListener (event, cb) {
    this.popup.addEventListener('add', () => {
      this.popup.getElement().addEventListener(event, cb)
    })
  }

  createContent (id, logo, name, stadium, address) {
        let splitter = address.split('--')
        return `<button id="js-club-${id}" type="button" class="club__button" title="Aller à la fiche du club"><img class="club__logo" src="img/file.png"></button><button type="button" class="popup-close" aria-label="close"><span class="popup-cross" aria-hidden="true">&times;</span></button><h4>${name}</h4><hr> <div class="localisation"><p><img class="img-icon" src="img/stadium.png" alt="">&nbsp;${stadium}</p><p><img class="img-icon" src="img/gps.png" alt="">${splitter[0]}</p><p>${splitter[1]}</p></div>`
      }
  setContent (text, image='') {
    this.popup.setContent(text)
    this.popup.getElement().style.backgroundImage= image
    this.popup.getElement().classList.add('is-expanded')
    this.popup.update()
  }

  setProperties(){
    this.popup.setContent()
    this.popup.setBackground()
  }

  resetContent () {
    this.popup.setContent(this.text)
    this.popup.getElement().style.backgroundImage=''
    this.popup.getElement().classList.remove('is-expanded')
    this.popup.update()
  }

}

const initMap = async function () {
  let map = new LeafletMap()
  let hoverMarker = null
  let activeMarker = null
  await map.load($map)
  Array.from(document.querySelectorAll('.js-marker')).forEach((item) => {

    let marker = map.addMarker(item.dataset.lat, item.dataset.lng, item.dataset.name, item.dataset.competition )

    /*Survol d'une fiche club*/
    item.addEventListener('mouseover', function () {
      if (hoverMarker !== null) {
        hoverMarker.unsetActive()
      }
      marker.setActive()
      hoverMarker = marker
    })

    /*Arrêt du survol*/
    item.addEventListener('mouseleave', function () {
      if (hoverMarker !== null) {
        hoverMarker.unsetActive()
      }
    })

    /*Clic sur une fiche club*/
    item.addEventListener('click', function () {
      if (activeMarker !== null && !activeMarker.popup._content.includes(`js-club-${this.dataset.id}`)) {
        activeMarker.resetContent()
      }
      
      let content = marker.createContent(item.dataset.id,item.dataset.logo,item.dataset.name,item.dataset.stadium,item.dataset.address)
      let background = `url(img/${item.dataset.logo})`
      marker.setContent(content, background)

      let selection = document.getElementsByClassName('popup-close')
      let closing = selection[0]

      closing.addEventListener('click', function(event){
        event.stopPropagation()
        item.classList.remove('marker-active')
        activeMarker.resetContent()
        
      })

      let iW = window.innerWidth;

      if (iW<1010){
        console.log('here')
        window.scrollTo({ top: document.querySelector('.map').offsetTop, behavior: 'smooth' });
      }

      activeMarker = marker

      let icon = document.getElementById(`js-club-${item.dataset.id}`)
      let target = document.querySelector(`.js-club-${item.dataset.id}`)
      icon.addEventListener('click', function(event){
        event.stopPropagation();
        event.preventDefault();
        window.scrollTo({ top: target.offsetTop, behavior: 'smooth' });
      })
      
    })

    function setMarker(){

    }

    marker.addEventListener('click', function () {
      if (activeMarker !== null) {
        activeMarker.resetContent()
      }

      let content = marker.createContent(item.dataset.id,item.dataset.logo,item.dataset.name,item.dataset.stadium,item.dataset.address)
      let background = `url(img/${item.dataset.logo})`
      marker.setContent(content, background)

      let selection = document.getElementsByClassName('popup-close')
      let closing = selection[0]

      closing.addEventListener('click', function(event){
        event.stopPropagation()
        item.classList.remove('marker-active')
        activeMarker.resetContent()
      })


      let icon = document.getElementById(`js-club-${item.dataset.id}`)
      let target = document.querySelector(`.js-club-${item.dataset.id}`)
      
      icon.addEventListener('click', function(event){
        event.stopPropagation();
        event.preventDefault();
        window.scrollTo({ top: target.offsetTop, behavior: 'smooth' });
      })

      activeMarker = marker

    })

    marker.addEventListener('mouseover', function (){
      item.classList.add('marker-active');
    })

    marker.addEventListener('mouseleave', function (){
      item.classList.remove('marker-active');
    })
  })
  map.center()
}

if ($map !== null) {
  initMap()
}


