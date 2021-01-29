<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Datepicker - Default functionality</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <body>
  Date:
  <input type="text" id="datepicker"/>
  <div>Current Date:</div><span id="displayDate"></span>
  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
    $("#datepicker").on("change",function(){
        var selected = $(this).val();
        $('#displayDate').html(selected);
    });
});

</script>

enter code here


</body>
</html>