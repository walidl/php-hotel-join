<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet">

    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- JS: CHART-JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js"></script>

    <!-- Js: Handlebar-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.0/handlebars.min.js" charset="utf-8"></script>

      <script id="prenotazione-template" type="text/x-handlebars-template">


        <div class="prenotazione">

          <div class="identity">
            <span>{{id}}</span> <span>{{date}}</span>
          </div>
          <div>
            <h2>Stanza {{room_number}}</h2>
            <ul>
              <li><span class="tit">piano:</span> <span>{{floor}}</span></li>
              <li><span class="tit">letti:</span> <span>{{beds}}</span> </li>
            </ul>
            <div>
              <h2>Configurazione: <i class="fas fa-info-circle"></i></h2>
              <ul>
                <li>{{conf_title}}</li>
              </ul>
            </div>

          </div>
          <div>
            <h2>Pagameto</h2>
            <ul>
              <li><span class="tit">prezzo:</span> <span>${{pay_price}}</span> </li>
              <li><span class="tit">Status:</span> <span>{{pay_status}}</span> </li>
            </ul>
          </div>
          <div>
            <h2>Ospiti</h2>
            <ul class="ospiti">

            </ul>

          </div>
        </div>

      </script>

    <!-- My script and style -->
    <script src="script.js" charset="utf-8"></script>
    <link rel="stylesheet" href="style.css">

    <title></title>
  </head>
  <body>
    <h1>Prenotazioni Maggio 2018</h1>
    <div class="container">
    </div>

  </body>
</html>
