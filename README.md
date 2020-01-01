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

$search_database = ['Ludwig van Beethoven', 'Johann Sebastian Bach', 'Wolfgang Amadeus Mozart', 'Antonio Vivaldi']; // search database that contains the name of composers

$search_level = 6; // search level is set to 6 out of 6 since the database we are searching through is relatively small

$search_query = 'mozart';
 
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
