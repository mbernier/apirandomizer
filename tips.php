<?php
require_once 'apis.php';
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>API Randomizer Tips to randomize Your Hackathon Challenge</title>
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
            <ul class="breadcrumb">
              <li>
                <a href="/">Home</a> <span class="divider">/</span>
              </li>
              <li>
                <a href="#" class="active">Tips</a> <span class="divider">/</span>
              </li>
            </ul>
            <h1>API Randomizer Tips</h1>
            <?php
            if (!isset($_POST['choose'])) {
               ?>
               <p class="lead">
                  Tips to help make your next hackathon more interesting!
               </p>
               <?php
            }
            ?>
         </div>
      </div>
      <div class="row-fluid">
           <div class="span2"></div>
           <div class="span8">
              <h2>Hackathon Structure Tips</h2>
              <ol>
                 <li>Before people split off into teams, you can "roll the dice" and have API Randomizer choose the type of projects, theme, beneficiary, and APIs taht will be used for all the groups. The winner can be chosen based on whoever creates the most well liked (best) app within these constraints.</li>
                 <li>After teams are split off, each team can "roll the dice" to find out waht their app will be for.</li>
                 <li>You can give bonus points to any teams that are willing to accept the API Randomizer challenge instead of choosing their own projects ahead of time</li>
              </ol>
              <h2>How to Feature a Hackathon Sponsor</h2>
              <p>
                 You can make sure that <strong>one</strong> of your sponsors shows up in every refresh of the page. To do this, simply add the name of the api to the end of the URL. 
              </p>
              <?php
              $rand = getRandomApi();
              ?>
              <p><strong>Example:</strong> <a href="http://apirandomizer.com/<?php echo strtolower($rand[0]);?>" target="_blank">http://apirandomizer.com/<?php echo strtolower(removeSpaces($rand[0]));?></a> - Will cause every click of the button to show the <?php echo $rand[0];?> API as the first item in the suggested APIs to use.</p>
           </div>
      </div>
      <div class="row-fluid" id="footer">
         <div class="span12">
            <a href="tips.php">Find out API Randomizer tips for your hackathon</a><hr /><br />
            To make a suggestion or ask a question, send a tweet to <a href="http://twitter.com/mbernier">@mbernier</a><br />
            Created by <a href="http://mkbernier.com">Matt Bernier</a>
         </div>
      </div>
      <script src="assets/js/jquery.js"></script>
      <script src="assets/js/bootstrap.js"></script>
   </body>
</html>