<?php
function generateString($chars, $length) {
  $str = "";
  for ($x = 0; $x < $length; $x++) {
    $str .= substr($chars, rand(0, strlen($chars) - 1), 1);
  }
  return $str;
}

$link = $_POST["link"];
$chars = "0123456789abcdefghijklmnopqrstufvxyz";

$expire = (time() + ($_POST["expire"] * 60 * 60)) * 1000;
while (!isset($str) || file_exists($slDir)) {
  $str = generateString($chars, 4);
  $slDir = "../d/" . $str;
}

$sl = $_SERVER['SERVER_NAME'] . substr(dirname($_SERVER['REQUEST_URI']), 0, strlen(dirname($_SERVER['REQUEST_URI'])) - 4) . "/" . substr($slDir, 3);
$slFile = $slDir . "/index.html";
$analytics = "<!-- Global Site Tag (gtag.js) - Google Analytics -->
<script async src=\"https://www.googletagmanager.com/gtag/js?id=UA-106596258-1\"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments)};
  gtag('js', new Date());

  gtag('config', 'UA-106596258-1');
</script>";
$slFileData = $analytics . '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
  var current = new Date();
  if (current.getTime() > ' . $expire . ') {
    $.post("../../php/delete.php", { dir: "' . $slDir . '" });
    window.location = "./";
  } else {
    window.location = "' . $link . '";
  }
</script>';

mkdir($slDir);
$handle = fopen($slFile, 'w');
fwrite($handle, $slFileData);
fclose($handle);

echo($sl);
?>