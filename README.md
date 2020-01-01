# PHP Search Engine

A PHP search function that searches through an array (usually the result of a database query) at 6 depth levels:

1. Full phrase – direct match
2. Full phrase – similar pronunciation
3. Full phrase – similar spelling
4. Each individual word – direct match
5. Each individual word – similar pronunciation
6. Each individual word – similar spelling

## Sample usage

```php

$search_database = []; // search database that contains the name of composers
$search_database[1] = 'Ludwig van Beethoven';
$search_database[2] = 'Johann Sebastian Bach';
$search_database[3] = 'Wolfgang Amadeus Mozart';
$search_database[4] = 'Antonio Vivaldi';

$search_query = 'mozart';

$search_level = 6; // search level is set to 6 out of 6 since the database we are searching through is relatively small

 
if ($search_query != "") $composers_results = custom_search($search_database, $search_query, $search_level);
else
{
 $composers_results = null;
 foreach ($search_database as $id_composer => $name)
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
```
