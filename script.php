<?php
/* ASCII constants */
const ESC = "\x1b";
const GS="\x1d";
const NUL="\x00";

function blank_line($count)
{
  return ESC."d".chr($count);
}

function susun_max_char_in_row($text_arr,$max_char_in_row){
  // inisialisasi 2 variable.
  $char_length = 0;
  $result_text = "";
  
  foreach($text_arr as $text)
  {
    // kalau jumlah karakter sekarang + jumlah karakter kata berikutnya masih kurang dari batas karakter 1 baris, 
    if($char_length + strlen($text) < $max_char_in_row) 
    {
       // tampung textnya dan hitung jumlah karakter sekarang.
      $result_text .= $text;
      $char_length += strlen($text);
      
      // kalau jumlah karakter sekarang + 1 karakter masih kurang dari batas karakter 1 baris,
      if($char_length + 1 < $max_char_in_row)
      {
        // tambah karakter spasi dan hitung jumlah karakter sekarang
        $result_text .= " ";
        $char_length += 1;
      }
    }
    // else -> kalau jumlah karakter sekarang + jumlah karakter kata berikutnya sudah mencapai batas karakter 1 baris atau lebih, 
    else
    {
      // tambahkan karakter "new line" dan reset jumlah karakter sekarang.
      $result_text .= "\n";
      $char_length = 0;
      
      // tampung textnya dan hitung jumlah karakter sekarang.
      $result_text .= $text;
      $char_length += strlen($text);
      
      // kalau jumlah karakter sekarang + 1 karakter masih kurang dari batas karakter 1 baris,
      if($char_length + 1 < $max_char_in_row)
      {
        // add space and count char lenght
        $result_text .= " ";
        $char_length += 1;
      }
    }
  }
  
  return $result_text;
}

$response = file_get_contents('http://quotesondesign.com/wp-json/posts?filter[orderby]=rand&filter[posts_per_page]=1'); //request wise word

// uncomment for testing data.
//$response = '[{"ID":1515,"title":"Francis Bacon","content":"<p>There is no excellent beauty that hath not some strangeness in the proportion.<\/p>\n","link":"https:\/\/quotesondesign.com\/francis-bacon\/"}]';
$response = json_decode($response,true);
//$konten =strip_tags($response[0]['content']);
//$titel =strip_tags($response[0]['title']);
$konten = str_replace('&#8217;', "'", strip_tags($response[0]['content']));
$titel = str_replace('&#8217;', "'", strip_tags($response[0]['title']));
$konten_array = explode(" ", $konten); // explode -> a function to split string using " " string into array of string
$konten_susun = susun_max_char_in_row($konten_array,33);



echo ESC."@"; // Reset to defaults
echo ESC."a".chr(1); // Center
//echo $konten; // Company
//echo blank_line(1); // Blank line
echo $konten_susun; // Print konten
echo blank_line(1); // Blank line
echo "-"; 
echo $titel; //pritn the author
echo "-";
echo blank_line(4); // Blank line

//print_r($konten);
?>
