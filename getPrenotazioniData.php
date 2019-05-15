<?php


  include "dbInfo.php";

  class Prenotazione {

    private $id;
    private $stanzaId;
    private $configurazioneId;
    private $createdAt;


    public function __construct($id,$stanzaId,$configurazioneId,$createdAt){

      $this->setId($id);
      $this->setStanzaId($stanzaId);
      $this->setConfiguranzioneId($configurazioneId);
      $this->setCreatedAt($createdAt);
    }

    public function setId($id){

      if(is_Numeric($id)){

        $this->id = $id;
      }
      else{

        echo "invalid Id - from function setId in class Prenotazione"; die();
      }

    }

    public function getId(){

      return $this->id;
    }

    public function setStanzaId($stanzaId){

      $this->stanzaId = $stanzaId;
    }

    public function getStanzaId(){

      return $this->stanzaId;
    }

    public function setConfiguranzioneId($configurazioneId){

      $this->configurazioneId = $configurazioneId;
    }

    public function getConfigurazioneId(){

      return $this->configurazioneId;
    }

    public function setCreatedAt($createdAt){

      $this->createdAt = $createdAt;
    }
    public function getCreatedAt(){

      return $this->createdAt;
    }

    public static function getPrenotazioniByMonth($conn,$month){


      if ($month<1 || $month >12){

        return [];
      }

      $sql = "
              SELECT *
              FROM prenotazioni
              WHERE MONTH(created_at) = $month
              AND YEAR(created_at) = 2018
              ORDER BY created_at DESC
      ";

      $result = $conn->query($sql);

      $prenotazioni=[];

      if ($result->num_rows > 0) {

        // output data of each row
        while($row = $result->fetch_assoc()) {
          // var_dump($row); echo "<br>" ;
          $prenotazioni[] = new Prenotazione(
                                  $row["id"],
                                  $row["stanza_id"],
                                  $row["configurazione_id"],
                                  $row["created_at"]
          );

        }


      } else {
        echo "0 results";
      }
      return $prenotazioni;
    }

    public function getOspiti($conn){


      return Ospite::getOspitiByPrenotazione($conn,$this->id);


    }

    public function getInfoStanza($conn){

      return Stanza::getStanzaById($conn,$this->stanzaId);
    }

    public function getInfoConfigurazione($conn){

      return Configurazione::getConfigurazioneById($conn,$this->configurazioneId);
    }

    public function getInfoPagamento($conn){


      return Pagamento::getPagamentoById($conn,$this->id);
    }

    public function getJsonData(){

      return [

        "id" => $this->id,
        "date"=> $this->createdAt
      ];
    }

  }

  class Persona {

    protected $name;
    protected $lastname;


    public function __construct($name,$lastname){

      $this-> setName($name);
      $this-> setLastname($lastname);
    }

    public function setName($name){

      $this->name = $name;

    }

    public function getName(){

      return $this->name;
    }

    public function setLastname($lastname){

      $this->lastname = $lastname;

    }

    public function getLastname(){

      return $this->lastname;
    }


  }

  class Ospite extends Persona {

    private $id;
    private $dateOfBirth;
    private $documentType;
    private $documentNumber;

    public function __construct($id,$name,$lastname,$dateOfBirth,$documentType, $documentNumber){

      parent::__construct($name,$lastname);

      $this->setId($id);
      $this->setDateOfBirth($dateOfBirth);
      $this->setDocumentType($documentType);
      $this->setDocumentNumber($documentNumber);

    }

    public function setId($id){

      $this->id = $id;

    }

    public function getId(){

      return $this->id;
    }

    public function setDateOfBirth($dateOfBirth){

      $this->dateOfBirth = $dateOfBirth;

    }

    public function getDateOfBirth(){

      return $this->dateOfBirth;
    }

    public function setDocumentType($documentType){

      $this->documentType = $documentType;

    }

    public function getDocumentType(){

      return $this->documentType;
    }

    public function setDocumentNumber($documentNumber){

      $this->documentNumber = $documentNumber;

    }

    public function getDocumentNumber(){

      return $this->documentNumber;
    }

    public static function getOspitiByPrenotazione($conn,$id){

      $sql = "
              SELECT ospiti.id, ospiti.name,ospiti.lastname,ospiti.date_of_birth,ospiti.document_type,ospiti.document_number
              FROM ospiti
              JOIN prenotazioni_has_ospiti
              ON prenotazioni_has_ospiti.ospite_id = ospiti.id
              WHERE prenotazioni_has_ospiti.prenotazione_id = $id
      ";

      $result = $conn->query($sql);

      $ospiti=[];

      if ($result->num_rows > 0) {

        // output data of each row
        while($row = $result->fetch_assoc()) {
          // var_dump($row); echo "<br>" ;
          $ospiti[] = new Ospite(
                                  $row["id"],
                                  $row["name"],
                                  $row["lastname"],
                                  $row["date_of_birth"],
                                  $row["document_type"],
                                  $row["document_number"]
          );

        }

      } else {
        echo "0 results";
      }
      return $ospiti;


    }

    public function getJsonData(){

      return [

        "name" => $this->name,
        "lastname" => $this->lastname
      ];

    }

  }

  class Stanza{

    private $id;
    private $roomNumber;
    private $floor;
    private $beds;

    function __construct($id,$roomNumber,$floor,$beds){

      $this->setId($id);
      $this->setRoomNumber($roomNumber);
      $this->setFloor($floor);
      $this->setBeds($beds);

    }

    function setId($id){

      if(is_Numeric($id)){

        $this->id = $id;
      }
      else{

        echo "invalid Id - from function setId in class Stanza"; die();
      }
    }

    function getId(){

      return $this->id;
    }

    function setRoomNumber($roomNumber){

      $this->roomNumber = $roomNumber;
    }

    function getRoomNumber(){

      return $this->roomNumber;
    }


    function setFloor($floor){

      $this->floor = $floor;
    }

    function getFloor(){

      return $this->floor;
    }

    function setBeds($beds){

      $this->beds = $beds;
    }

    function getBeds(){

      return $this->beds;
    }

    function getStanzaById($conn,$id){

      $sql = "
                SELECT *
                FROM stanze
                WHERE id = $id
      ";

      $result = $conn->query($sql);

      $stanza;

      if ($result->num_rows > 0) {

        // output data of each row
        while($row = $result->fetch_assoc()) {
          // var_dump($row); echo "<br>" ;
          $stanza = new Stanza(
                                  $row["id"],
                                  $row["room_number"],
                                  $row["floor"],
                                  $row["beds"]
          );

        }

      } else {
        echo "0 results";
      }
      return $stanza;
    }

    public function getJsonData(){

      return [

        "room_number" => $this->id,
        "floor" => $this->floor,
        "beds"  => $this->beds
      ];
    }
  }

  class Configurazione{

    private $id;
    private $title;
    private $description;


    function __construct($id,$title,$description){

      $this->setId($id);
      $this->setTitle($title);
      $this->setDescription($description);

    }

    function setId($id){

      if(is_Numeric($id)){

        $this->id = $id;
      }
      else{

        echo "invalid Id - from function setId in class Configurazione"; die();
      }
    }

    function getId(){

      return $this->id;
    }

    function setTitle($title){

      $this->title = $title;
    }

    function getTitle(){

      return $this->title;
    }


    function setDescription($description){

      $this->description = $description;
    }

    function getDescription(){

      return $this->description;
    }

    public static function getConfigurazioneById($conn,$id){

      $sql = "
                SELECT *
                FROM configurazioni
                WHERE id = $id
      ";

      $result = $conn->query($sql);

      $conf;

      if ($result->num_rows > 0) {

        // output data of each row
        while($row = $result->fetch_assoc()) {
          // var_dump($row); echo "<br>" ;
          $conf = new Configurazione(
                                  $row["id"],
                                  $row["title"],
                                  $row["description"]
          );

        }

      } else {
        echo "0 results";
      }
      return $conf;
    }

    public function getJsonData(){

      return [

        "conf_title" => $this->title,
        "conf_desc" => $this->description,
      ];
    }


  }

  class Pagamento{

    private $id;
    private $status;
    private $price;
    private $prenotazioneId;
    private $paganteId;

    function __construct($id,$status,$price,$prenotazioneId,$paganteId){

      $this->setId($id);
      $this->setStatus($status);
      $this->setPrice($price);
      $this->setPrenotazioneId($prenotazioneId);
      $this->setPaganteId($paganteId);


    }

    function setId($id){

      if(is_Numeric($id)){

        $this->id = $id;
      }
      else{

        echo "invalid Id - from function setId in class Pagamento"; die();
      }
    }

    function getId(){

      return $this->id;
    }

    function setStatus($status){

      $this->status = $status;
    }

    function getStatus(){

      return $this->status;
    }


    function setPrice($price){

      $this->price = $price;
    }

    function getPrice(){

      return $this->price;
    }

    function setPrenotazioneId($prenotazioneId){

      $this->prenotazioneId = $prenotazioneId;
    }

    function getPrenotazioneId(){

      return $this->prenotazioneId;
    }

    function setPaganteId($paganteId){

      $this->paganteId = $paganteId;
    }

    function getPaganteId(){

      return $this->paganteId;
    }

    public static function getPagamentoById($conn,$id){

      $sql = "
                SELECT *
                FROM pagamenti
                WHERE prenotazione_id = $id
      ";

      $result = $conn->query($sql);

      $pagamento;

      if ($result->num_rows > 0) {

        // output data of each row
        while($row = $result->fetch_assoc()) {
          // var_dump($row); echo "<br>" ;
          $pagamento = new Pagamento(
                                  $row["id"],
                                  $row["status"],
                                  $row["price"],
                                  $row["prenotazione_id"],
                                  $row["pagante_id"]
          );

        }

      } else {
        echo "0 results";
      }
      return $pagamento;
    }

    public function getJsonData(){

      return [

        "pay_status" => $this->status,
        "pay_price" => $this->price
      ];
    }

  }


  // Connessione al Database---------------------------

  $conn = new mysqli($servername, $username, $password, $dbname);

  // Check connection - controlla la connessione
  if ($conn->connect_errno) {
    echo ("Connection failed: " . $conn->connect_error);
    return;
  }

  // Get all $prenotazioni


  $prenotazioni = Prenotazione::getPrenotazioniByMonth($conn,5);

  //Stampa su pagina delle info richieste------------

/*
  $i = 1;

  foreach ($prenotazioni as $pren) {

    $stanza = $pren->getInfoStanza($conn);
    $config = $pren->getInfoConfigurazione($conn);
    $pagamento = $pren->getInfoPagamento($conn);


    echo "<b>Prenotazione: $i  </b><br>".
    " - Date: " . $pren->getCreatedAt() . "<br>" .
    " - Stanza: " . $stanza->getId() . "; " .
    "Number: " . $stanza->getRoomNumber() . "; " .
    "Floor: " . $stanza->getFloor() . "; " .
    "Beds: " . $stanza->getBeds() . "<br>" .

    " - Configurazione: " . $config->getId() . "; " .
    "Number: " . $config->getId() . "; " .
     $config->getTitle() . ": ' " .
     $config->getDescription() . "'<br>" .

     " - Pagamento: " . $pagamento->getId() . "; " .
     "Status: " . $pagamento->getStatus() . "; " .
     "Price: " . $pagamento->getPrice() . "<br>" .
     " - Ospiti: <br>" ;

     $ospiti = $pren->getOspitiByPrenotazione($conn);


    foreach ($ospiti as $osp) {

      echo "&nbsp&nbsp&nbsp" . $osp->getName() . " " . $osp->getLastname() . "<br>";
    }

    echo "<br>";

    $i++;

  }

 echo "<br><hr><br>";
*/


  $jsReady=[];

  foreach ($prenotazioni as $pren) {

    $stanza = $pren->getInfoStanza($conn);
    $config = $pren->getInfoConfigurazione($conn);
    $pagamento = $pren->getInfoPagamento($conn);
    $ospiti = $pren->getOspiti($conn);

    $groupOsp = [];
    foreach ($ospiti as $osp) {

      $groupOsp["ospiti"][] = $osp->getJsonData();
    }
    // var_dump($ospit); echo "<br>";

    $jsReady[] = array_merge(
                              $pren->getJsonData(),
                              $stanza->getJsonData(),
                              $config->getJsonData(),
                              $pagamento->getJsonData(),
                              $groupOsp
    );

  }

  // Chiusura connessione Database---------------------------

  $conn->close();


  echo json_encode($jsReady);
 ?>
