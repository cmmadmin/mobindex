<html>
 <head>
  <title>Compare Cultures</title>
 </head>
 <body>
 <?php 
echo '<p>Compare Cultures</p>';
var_dump($_POST);
 ?> 
 </body>

<button onclick="goBack()">Return</button>

<script>
function goBack() {
    window.history.back();
}
</script>

</html>