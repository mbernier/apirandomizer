<?php

require_once 'apis.php';
require_once 'functions.php';
require_once './lib/Unirest.php';

$limit = 3;

$sponsors = array();

/*
Code for making an event sponsor always display as an API
*/
if (strlen($_SERVER['REQUEST_URI']) !== false) {
   //handles local dev and live version
   $path = str_replace('/apirandomizer', '', strtolower($_SERVER['REQUEST_URI']));
   if (substr($path, 0,1) == '/') {
      $path = substr($path, 1, strlen($path));
   }
   if (substr_count($path, '/') != 0) {
      //there's more than one
      $sponsors = explode($path, '/');
   } elseif(strlen($path) > 0) {
      //there's only one
      $sponsors = array($path);
   }
}
$sponsorCount = count($sponsors);
$sponsors = pullOutSponsors($sponsors);
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>The API Randomizer - Randomize Your Hackathon Challenge</title>
      <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
      <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
      <link href="css/style.css" rel="stylesheet">      
      <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-1007375-44']);
        _gaq.push(['_trackPageview']);

        (function() {
          var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
          ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
          var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

      </script>
   </head>
   <body>
      <div class="row-fluid" id="header-box">
         <div class="span2"></div>
         <div class="span8">
            <div class="page-header">
               <h1>API Randomizer</h1>
            </div>
            <?php
            if (!isset($_POST['choose'])) {
               ?>
               <p class="lead">
                  Click the button for <?php echo (strlen($sponsors) > 0 ? 'two' : 'three');?> randomly chosen APIs. Then go build an app!
               </p>
               <?php
            }
               ?>
         </div>
      </div>
      <div class="row-fluid">
           <?php
               if (isset($_POST['choose'])) {
                  $type = random($type, true);
                  $subject = random($subject, true);
                  ?>
                  <div class="row-fluid meta-box">
                     <div class="span2"></div>
                     <div class="span8">
                        <div class="span4">
                           <p class="lead">You should build</p>
                            <div class="alert alert-info">
                              <h2><?php echo $type; ?></h2>
                             </div>
                        </div>
                        <div class="span4"><p class="lead"> about</p> 
                           <div class="alert alert-info">
                              <h2><?php echo $subject;?></h2>
                           </div>
                        </div>
                        <div class="span4"><p class="lead"> for <?php 
                           echo str_replace('[br]', '</p><div class="alert alert-info">
                              <h2>', randomBenefit(true));?></h2>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="row-fluid">
                     <span class="span2"></span>
                     <span class="span8" id="api-title"><p class="lead">Using these APIs: </p></span>
                  </div>
                  <div class="row-fluid">
                  <div class="span2"></div>
                  <div class="span8 well" id="api-box">
                     <?php
                     //output any sponsors if there are some
                     echo $sponsors;
                     //var_dump($apis);
                     if ($sponsorCount > 0) {
                        $limit = $limit - $sponsorCount;
                     }
                        /*
                        $rand1      = getRandomApi();
                        echo outputApi($rand1);
                        if ($sponsorCount < 2) {
                           $rand2      = getRandomApi();
                           echo outputApi($rand2);
                           if ($sponsorCount < 1) {
                              $rand3      = getRandomApi();
                              echo outputApi($rand3);
                           }
                        }
                     }*/
                     $api = new getMashape();
                     $api->query($subject.','.$type);
                     $api->offset(rand(0,15));
                     //echo $api->ec();
                     $api->output();
                     //show "Give me new APIs"
                     ?>
                  </div>
               </div>
                  <div class="row-fluid" id="button-box">
                     <div class="span12">
                        <form action="" method="post"> 
                           <input type="hidden" name="choose" value="YAY" />
                           <input class="btn btn-primary btn-large" type="submit" value="OMG! Give me different APIs!" />
                        </form>
                     </div>
                  </div>
                  <?php
               } else {
                  //show the "Give me some APIs"
                  ?>
                  <div class="span4"></div>
                  <div class="span4" id="button-box">
                     <form action="" method="post"> 
                        <input type="hidden" name="choose" value="YAY" />
                        <input class="btn btn-primary btn-large" type="submit" value="Give me some of that sweet API action!" />
                     </form>
                  </div>
                  <?php
               }
           ?>
        </div>
      </div>
         <?php
         if (strlen($sponsors) > 0 && !isset($_POST['choose'])) {
            ?>
            <hr />
            <div class="row-fluid">
               <div class="span2"></div>
               <div class="span4" id="sponsor-box">
                  <p class="lead">This Hackathon is using:</p>
               </div>
            <?php
            echo $sponsors;
            echo '</div><hr />';
         }
      ?>
      <div class="row-fluid" id="what-is-it">
         <div class="span4"></div>
         <div class="span4">
            <p>This tool helps you come up with ideas for a new project or to help you create a developer challenge for your hackathon! See the <a href="tips.php">tips</a> for more ideas!</p>
         </div>
      </div>
      <div class="row-fluid" id="footer">
         <div class="span12">
            <?php
              //<a href="tips.php">Tips for your hackathon</a><br /> 
            ?>
            Built using <a href="http://mashape.com" target="_blank">Mashape</a> and <a href="http://twitter.github.io/bootstrap/" target="_blank">Twitter Bootstrap</a>.<br />
            To make a suggestion or ask a question, send a tweet to <a href="http://twitter.com/mbernier">@mbernier</a><br />
            Created by <a href="http://mkbernier.com">Matt Bernier</a>
         </div>
      </div>
      <script src="bootstrap/js/jquery.js"></script>
      <script src="bootstrap/js/bootstrap.js"></script>
      <?php
      echo $api->outJs();
      ?>
   </body>
</html>