function getPrenotazioni(){


  $.ajax({

    url:"getPrenotazioniData.php",
    method: "GET",
    success: function (data){

      var prenotazioni = JSON.parse(data);

      console.log(prenotazioni);
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
