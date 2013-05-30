<?php
function outputApi($api) {
   return sprintf('<div class="span4">
               <a href="%s" target="_blank">
                  <img src="logos/%s" />
                  <br /><h3 class="api-name">%s</h3>
               </a>
           </div>',
            $api[1],//$api['url'],
            $api[2],//$api['logo'],
            $api[0]);//$api['name']);
}

//chooses a random value from an array, allows returning key or value
function random($arr, $return = false, $key = false) {
   $val = array_rand($arr, 1);
   if ($key === true) {
         return returnValue($return, $val);
   }
   return returnValue($return, $arr[$val]);
}

//handles picking random "subject" and recipient based on the size of the arrays
function randomBenefit($return = false) {
   global $benefits;
   $temp = array();
   foreach ($benefits as $key => $ben) {
      for ($i=0;$i < count($ben); $i++) {
         $temp[] = $key;
      }
   }
   
   $arr = random($temp, true);
   $val = ($arr == 'random' ? null : $arr)."[br]".random($benefits[$arr], true);
   return returnValue($return, $val);
}

//returns value based on params
function returnValue($return, $val) {
   if ($return == false) {
      echo $val;
      return;
   }
   return $val;
}

function pullOutSponsors($sponsors) {
   if (count($sponsors) == 0) return '';
   global $apis;
   $output = '';
   foreach ($apis as $k => $api) {
      if (in_array(strtolower(removeSpaces($api[0])), $sponsors)) {
         unset($apis[$k]);sort($apis);
         $output .= outputApi($api);
      }
   }
   return $output;
}

//gets the apis randomly, only allows one api for each parent i.e. ebay or mapping
function getRandomApi() {
   global $apis;
   
   $key1 = random($apis, true, true);
   $rand = $apis[$key1];

   if (count($rand) > 1) {
      $key2 = random($rand, true, true);
      //format for the return value -- matt's lazy
      $rand = array($rand[$key2]);
   }
   //remove the parent entry from $apis, so we only get one!
   unset($apis[$key1]);

   return $rand[0];
}

function removeSpaces($str) {
   return str_replace(' ', '', $str);
}

class getMashape{
   protected $query = 'mashape';
   protected $limit = 20;
   protected $offset = '%3Coffset%3E';
   protected $category = '%3Ccategory%3E';
   protected $dashNames = array();
   
   function set($query, $limit, $offset, $category) {
      $this->query($query);
      $this->limit($limit);
      $this->offset($offset);
      $this->category($category);
   }
   
   function query($query) {
      $this->query = urlencode($query);
   }
   
   function limit($limit) {
      $this->limit = $limit;
   }
   
   function offset($offset) {
      $this->offset = $offset;
   }
   
   function category($category) {
      $this->category = urlencode($category);
   }
   
   function ec() {
      return "https://mashape.p.mashape.com/apis?query={$this->query}&limit={$this->limit}&offset={$this->offset}&category={$this->category}";
   }
   
   function call() {
      $response = Unirest::get(
        "https://mashape.p.mashape.com/apis?query={$this->query}&limit={$this->limit}&offset={$this->offset}&category={$this->category}",
        array(
          "X-Mashape-Authorization" => "W5EQVuSmAtyhY2PBZq5XJCcGVd8dDgNn"
        ));
      return $response;
   }
   
   function output() {
      $resp = $this->call();
      $count = 0;
      $name = '';
     foreach ($resp->body->apis as $r) {
        if ($r->name == $name) continue;
        if ($count > 2) break;
        $count++;
        $this->dashNames[] = $dashName = str_replace(' ', '-', $r->name);
      printf('<div class="span4">
                  <a id="%s" href="%s" data-toggle="tooltip" data-placement="bottom" title="%s" target="_blank">
                     <img src="%s" />
                     <br /><h3 class="api-name">%s</h3>
                  </a>
              </div>',
               $dashName,
               $r->url,//$api['url'],
               htmlentities($r->description),
               $r->image,//$api['logo'],
               $r->name);//$api['name']);
      }
   }
   
   function outJs() {
      $out = '<script>';
      foreach ($this->dashNames as $d) {
         $out .= "$('#".$d."').tooltip();";
      }
      $out .= '</script>';
      return $out;
   }
}

?>