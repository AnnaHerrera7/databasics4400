<?php
include 'database_con.php';
session_start();
?>
<html>
  <head>
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
          crossorigin="anonymous"/>

    <meta charset ='utf-8'/>
    <title>GTtravel</title>
  </head>
  <body>
      <div class="container text-center">
        <div class="jumbotron">
          <h2>Country Search</h2>
          <?php
          error_reporting(E_ALL);
          ini_set("display_errors", 1);
          $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
          if(isset($_POST['country'])
            && isset($_POST['minimum'])
            && isset($_POST['maximum'])
            && isset($_POST['language'])) {
                $country = $_POST['country'];
                $min = $_POST['minimum'];
                $max = $_POST['maximum'];
                $lang = $_POST['language'];
                $sql = "SELECT DISTINCT CoName, CName, Country.Population, LanguageName
                     FROM Country, CountryLanguage, Review, Reviewable, City
                     WHERE Country.CoName = \"$country\"
                     AND City.CountryName = Country.CoName AND City.Capital = 1
                     AND Country.Population BETWEEN \"$min\" AND \"$max\"
                     AND Country.CoName IN
                     (SELECT CountryLanguage.CountryName
                       FROM CountryLanguage
                       WHERE CountryLanguage.LanguageName = \"$lang\")
                     AND Country.CoName = CountryLanguage.CountryName;";
                $result = mysqli_query($con, $sql);
                if(mysqli_num_rows($result) > 0) {
                    //$_SESSION['country_search'] = $result;
                    //echo "<script>window.location.href='country_search_results.php'</script>";
                    echo "<table>";
                    echo "<tr>";
                    $count = 0;
                    while($val = mysqli_fetch_array($result)) {
                        echo "<th>" . $val[$count++] . "</th>";
                    }
                    echo "</tr>";
                    echo "</table>";


                } else {
                    echo "No results found!";
                }
            }
           ?>
            <form action="" method="POST">
              <?php
                  $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
                  $query = "SELECT * FROM Country";
                  $result = mysqli_query($con, $query);
                  echo "<select name=\"country\">";
                  while($row = mysqli_fetch_array($result)) {
                    echo "<option value = '" . $row['CoName'] . "'>" . $row['CoName'] . "</option>";
                  }
                  echo "</select>";
               ?>
               <br />
               <b>Population</b>
               <input type="text" name="minimum" placeholder="Minimum"/> to
               <input type="text" name="maximum" placeholder="Maximum"/><br />
               <b class="text-center">Languages</b>
               <?php
                  $con = mysqli_connect($db_host, $db_user, $db_password, $db_database) or die("Connection Failed");
                  $query = "SELECT * FROM Languages";
                  $result = mysqli_query($con, $query);
                  echo "<fieldset id=\"languages\">";
                  while($row = mysqli_fetch_array($result)) {
                      echo "<input type = \"radio\" name=\"language\" value = '" . $row['LanguageName'] . "'>" .  $row['LanguageName'] . "</input><br />";
                  }
                ?>
                <input type="submit" name="submit" value="Search">
            </form>
  </body>
</html>
