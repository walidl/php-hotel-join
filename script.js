function getPrenotazioni(){


  $.ajax({

    url:"getPrenotazioniData.php",
    method: "GET",
    success: function (data){

      var prenotazioni = JSON.parse(data);

      console.log(prenotazioni);

      var cont = $(".container");

      var template = $("#prenotazione-template").html();
      var compiled = Handlebars.compile(template);

      for (var i = 0; i < prenotazioni.length; i++) {

        var pren = compiled(prenotazioni[i]);
        var tag = $(pren);        
        var ospiti = prenotazioni[i].ospiti;

        for (var j = 0; j < ospiti.length; j++) {

          tag.find(".ospiti").append("<li>" +ospiti[j].name + " " + ospiti[j].lastname +" </li>")

        }
        cont.append(tag);


      }
    },
    error: function (){

      console.log("errore recupero dati");


    }
  })
}


function init(){

  getPrenotazioni();

}

$(document).ready(init);
