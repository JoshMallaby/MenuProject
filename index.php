<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <title>Menu</title>
    <style>

    </style>
  </head>
  <body>
    <div class='mx-auto' style='width: 350px;'> 
    <div class='container3' id='HeadContainer'>
    <h1>Menu</h1>
    <br>

    <?php
    if (isset($_GET['table'])) {
      echo "<br><h2>Table " . $_GET['table'] . "</h2>";
    } else {
        // Fallback behaviour goes here
        echo "<br><h2>No table</h2>";
    }
    echo "</div>";
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "idea";

    $conn = @mysqli_connect($host, $user, $password, $database);
    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit();
      }
    $query = "SELECT * from menu";
    $result = mysqli_query($conn, $query);

    if(!$result)
    {
        echo"<p>Unable to execute the query.</p>" . "<p>Error code " . mysqli_errno($conn) . ": " . mysqli_error($conn) . "</p>";
    }
    else
    {
        $arr = [];
        $qtyArray = [];
        $z = 0;
        while ($row = mysqli_fetch_assoc($result))
        {
          $tmpArray = array('qtyId' => $row['itemId'], 'qty' => 0);
          array_push($arr, $row);
          array_push($qtyArray, $tmpArray);

        }
        
        echo "<div class='container1' id='menuContainer'>";
        foreach($arr as $value){
            $z++;
            $p = substr_replace($value['itemPrice'] ,"", -2);
            $q = (double)$p;

            $x = $value['itemId'];
            $counter[$x] = 0;

            echo "<br> <label style='visibility: hidden;' id = name$x>$value[itemName]</label>
            <input id='price$x' style='visibility: hidden;' value= '$q' />
            <h5>$value[itemName] - $$p</h5>

            <img src='IMMC.PNG' alt='Menu Item'> <button type='button' class='btn btn-success' onclick='increment($x)'>+</button>
            <input id='$x' value='0' style='width:30px; border-top-style: hidden;
            border-right-style: hidden;
            border-left-style: hidden;
            border-bottom-style: hidden;
            background-color: #eee; outline: none;' readonly/> 
            <button type='button' class='btn btn-danger' onclick='decrement($x)'>-</button>     
            <br>";
                        
        }
        echo "</div>";
        echo "<div class='container1' id='submissionContainer'><br></div>";
        echo "<br><button type='button' class='btn btn-primary' id='btn'>Order</button><br><br>";
    }

    mysqli_close($conn);
    
    ?>
    </div>
    <script>
    function increment(x) {
      var txtNumber = document.getElementById(x);
      if(txtNumber.value < 10){
        var newNumber = parseInt(txtNumber.value) + 1;
        txtNumber.value = newNumber;
        <?php  ?>
      }
    }
    function decrement(x) {
      var txtNumber = document.getElementById(x);
      if(txtNumber.value > 0){
        var newNumber = parseInt(txtNumber.value) - 1;
        txtNumber.value = newNumber;
      }
    }
    </script>
    <script>
      $(document).ready(function() {
        $("#btn").click(function() { 
    
          var cardText = "";
          var menuItems = <?php echo $z ?>;
          var price = 0;
          var validOrder = false;

          for (i = 0; i <= menuItems; i++) {
            if($('#' + i).val() != null && $('#' + i).val() > 0){
              validOrder = true;
              cardText += $('#name' + i).text() + ": " + $('#' + i).val() + "<br />";
              var tmpPrice = parseFloat($('#price' + i).val()) * parseFloat($('#' + i).val());
              price = price + tmpPrice;
            }
          }
          price = price.toFixed(2);

          if(validOrder){
            $("#menuContainer").hide();
            $("#HeadContainer").hide();
            $("#btn").hide();
            $("#cardId").remove();
            $("#submissionContainer").append("<div class='card' style='width: 18rem;' id='cardId'>\
            <div class='card-body'><h5 class='card-title'>Confirm your Order</h5>\
            <p class='card-text'>" + cardText + "\</p>\
            <p class='card-text'>Total: $"+price+"\</p>\
            <button type='button' class='btn btn-success' id='confirmButton' onclick='confirm()'>Confirm</button>\
            <button type='button' class='btn btn-danger' id='backButton' onclick='back()'>Back</button>\
            </div>\
            </div>"
            );
          }  
          else{
            $("#cardId").remove();
            $("#submissionContainer").append("<div class='card text-white bg-warning mb-3' style='max-width: 18rem;' id='cardId'>\
            <div class='card-body'>\
              <p class='card-text'>Select Items Before Ordering.</p>\
            </div>\
          </div>"
            );
          }         
        })
      });
      function back(){
          $("#cardId").remove();
          $("#menuContainer").show();
          $("#HeadContainer").show();
          $("#btn").show();
      }
      function confirm(){
        $("#cardId").remove();
        $("#HeadContainer").hide();
        $("#submissionContainer").append("<div class='card text-white bg-success mb-3' style='max-width: 18rem;'>\
        <div class='card-body'>\
          <h5 class='card-title'>Thank you. Your order has been placed.</h5>\
          <p class='card-text'>Order Number: 1234567</p>\
        </div>\
      </div>");
      }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <!-- Load React. -->
    <!-- Note: when deploying, replace "development.js" with "production.min.js". -->
    <script src="https://unpkg.com/react@17/umd/react.development.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@17/umd/react-dom.development.js" crossorigin></script>
    
  </body>
</html>