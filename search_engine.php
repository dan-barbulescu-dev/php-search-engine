function add_result($result_to_add, &$results, &$found_already)
{
 // If this is the first time you find this search result, add it to the results array
 if (!isset($found_already[$result_to_add]))
 {
  $found_already[$result_to_add] = true;
  $results[] = $result_to_add;
 }
}
 
function custom_search($search_database, $search_query, $depth = 3)
{
 /*
 $search_database - array containing what you want to search through
 $search_query - string search query
 $depth - from 1 to 6
 1. Full phrase - direct match
 2. Full phrase - similar pronunciation
 3. Full phrase - similar spelling
 4. Each individual word - direct match
 5. Each individual word - similar pronunciation
 6. Each individual word - similar spelling
  
 returns array $results;
 */
  
  
 $search_query = strtolower($search_query);
 foreach($search_database as $key => $value)
 {
  $search_database[$key] = strtolower($search_database[$key]);
 }
  
 // note, when translating the project into multiple languages, one should also try to acquire metaphone 3 or other similar algorithms
 
 $results = null;
 $found_already = null;
   
   
 // step 1 = first look for the full match
 if ($depth >= 1)
 {
     foreach($search_database as $key => $value)
     {
      if (stripos($value, $search_query) !== false)
      {
       add_result($key, $results, $found_already);
      }
     }   
 }
 // step 2 = look for metaphone (pronounciation match)
 // add_result("STEP 2", $results, $found_already);
 
 if ($depth >= 2) 
 {
     $search_query_metaphone = metaphone($search_query);
     foreach($search_database as $key => $value)
     {
      if (metaphone($value) == metaphone($search_query_metaphone)) add_result($key, $results, $found_already);
     }
 }   
 // step 3 = look for levenshtein (similar phrase match, 25%)
 //add_result("STEP 3", $results, $found_already);
 
 if ($depth >=3)
 {
     foreach($search_database as $key => $value)
     {
      if ((strlen($search_query) <= 255) && (strlen($value) <= 255))
      {
          $lev = levenshtein($value, $search_query, 1, 1, 1);
               
          $max_char = strlen($search_query) / 2;
          $max_char = (int)$max_char;
          $max_char++;
           
          if (($lev <= $max_char) && ($lev != -1))
          {
           add_result($key, $results, $found_already);
          }
      }
     }
 }
 // step 4 - look for individual words from the search query (at least 4 letters), order results by number of words found;
 //add_result("STEP 4", $results, $found_already);
  
 if ($depth >= 4)
 {
     $words_matched = null;
     $query_words = get_words_from_string($search_query, 4);
     foreach($search_database as $key => $value)
     {
      $words_matched[$key] = 0;
      for ($i = 0; $i < count($query_words); $i++)
      {
       if (stripos($value, $query_words[$i]) !== false) $words_matched[$key]++;
      } 
      }
      arsort($words_matched);
       
      foreach($words_matched as $key => $value)
      {
       if ($value > 0) add_result($key, $results, $found_already);
      }
 }
  
 // step 5 - take each individual word, and compare it to each individual word from database, phonetically;
 if ($depth >= 5)
 {
     $words_matched = null;
     $search_query_metaphone = metaphone($search_query);
      
     foreach($search_database as $key => $value)
     {
      $words_matched[$key] = 0;
      $current_value_words = get_words_from_string($value, 4);
      if (count($current_value_words) > 0)
      {
          foreach ($current_value_words as $key2 => $word)
          {
           if (metaphone($word) == $search_query_metaphone) $words_matched[$key]++;
          }
      }
     }
     
    arsort($words_matched);
       
    foreach($words_matched as $key => $value)
    {
     if ($value > 0) add_result($key, $results, $found_already);
    }
 }
  
 // step 6 - take each individual word, and compare it to each individual word from database, writing-wise;
 if ($depth >= 6)
 {   
     $words_matched = null;
     foreach($search_database as $key => $database_value)
     {
      $words_matched[$key] = 0;
      $current_value_words = get_words_from_string($database_value, 4);
      if (count($current_value_words) > 0)
      {
          foreach ($current_value_words as $key2 => $database_value_word)
          {
               if ((strlen($search_query) <= 255) && (strlen($database_value_word) <= 255))
               {
                   $lev = levenshtein($database_value_word, $search_query, 1, 1, 1);
                    
                   // if ($key == 396) echo $database_value_word. ' - '.$search_query. ' - '.$lev.' <br />';
                   $max_char = strlen($search_query) / 4;
                   $max_char = (int)$max_char;
                   $max_char++;
                   
                   if (($lev <= $max_char) && ($lev != -1))
                   {
                    $words_matched[$key]++;
                   }
               }
          }
      }
     }
     
    arsort($words_matched);
       
    foreach($words_matched as $key => $value)
    {
     if ($value > 0) add_result($key, $results, $found_already);
    }
 }
  
  
 return $results; 
}
