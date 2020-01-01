include('search_engine.php');

$search_level = 6; // search level is set to 6 out of 6 since the database we are searching through is relatively small
$sd_composers_name = null; // search database that contains the name of composers
 
// the pdo functions referenced here (pdo_query, pdo_fetch_array) are explained and available at
// http://danbarbulescu.com/php-functions-that-simplify-working-with-a-pdo-database-connector/
$sql_query = "SELECT id_composer, name FROM table_composers";
$result = pdo_query($sql_query);
while ($row = pdo_fetch_array($result))
{
 $sd_composers_name[$row['id_composer']] = $row['name'];
}
 
if ($search_query != "") $composers_results = custom_search($sd_composers_name, $search_query, $search_level);
else
{
 $composers_results = null;
 foreach ($sd_composers_name as $id_composer => $name)
 {
  $composers_results[] = $id_composer;
 }
}
 
$composers_found = count($composers_results);
if ($composers_found == 0) echo '<p>No composers found.</p>';
if ($composers_found == 1) echo '<p>1 composer found:</p>';
if ($composers_found > 1) echo '<p>'.$composers_found.' composers found:</p>';
 
if ($composers_found > 0)
{
    echo '<ul>';
    foreach ($composers_results as $key => $id_composer)
    {
     echo '<li><a href="http://www.hdclassicalmusic.com/browse/?by=composer&id_composer='.$id_composer.'">'.$sd_composers_name[$id_composer].'</a></li>';
    }
    echo '</ul>';
}
