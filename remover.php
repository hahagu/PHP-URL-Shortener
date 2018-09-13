<title>URL shortener</title>
<meta name="robots" content="noindex, nofollow">
</html>
<body>
  <form method="post" action="remove.php" id="remover">
    <label for="longurl">Shortlink Alias to remove</label> <input type="text" name="shorturl" id="shorturl"> <input type="submit" value="Remove">
  </form>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

  <script>
  $(function () {
    $('#remover').submit(function () {
      $.ajax({data: {shorturl: $('#shorturl').val()}, url: 'remove.php', complete: function (XMLHttpRequest, textStatus) {
        $('#shorturl').val(XMLHttpRequest.responseText);
      }});
      return false;
    });
  });
  </script>
</body>
