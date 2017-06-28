<html>
 <head>
  <title>Compare to UPG</title>
 </head>
 <body>

 <?php 
echo '<p>Compare UPG</p>';
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