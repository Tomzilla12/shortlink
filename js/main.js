$(function(){
  $("#submit").click(function() {
    var link = $('#link').val();
    var expire = $('#expire').val();
    $.post("php/shorten.php", { link: link, expire: expire }, function(data) {
      var html = '                <h2>Shortened link:</h2>';
      html += '								<h1 id="result">' + data + '</h1>';
      html += '								<h4>Expires after ' + expire + ' hours</h4>';
      $("#result-div").html(html);
    });
  });
});