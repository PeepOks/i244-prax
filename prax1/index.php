<!DOCTYPE html>
<html>
<head>
<title>I244-praktikum</title>
<meta charset="utf-8" />

<link href="/~poks/i244-prax/css/kujundus.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div id="sisu">
    <h2>Esimene praktikum</h2>
      <p> Esimene praktimumi kogemus. Siiani lihtne.</p>
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQrHKExhesBv3B1aUA-l6_ajU2PQXGwMtBMC7ygY34njVL0nreaPg" alt="Pilt">
      <p>
     <a href="http://validator.w3.org/check?uri=referer">
      <img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" />
     </a>
    </p>
    
  <div id="clockdiv">
  <div>
    <span class="days"></span>
    <div class="smalltext">Days</div>
  </div>
  <div>
    <span class="hours"></span>
    <div class="smalltext">Hours</div>
  </div>
  <div>
    <span class="minutes"></span>
    <div class="smalltext">Minutes</div>
  </div>
  <div>
    <span class="seconds"></span>
    <div class="smalltext">Seconds</div>
  </div>
  </div>
  <script src="/~poks/i244-prax/js/kell.js"></script>
  
  <?php
    include 'counter.php';
  ?>
  <p>Külastamiste arv: <?php echo file_get_contents($file); ?>
</div>

</body>
</html>
