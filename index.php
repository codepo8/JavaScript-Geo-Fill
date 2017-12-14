<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
 "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">  
  <title>GeoFill - automatically filling form data with geo information</title>
  <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/reset-fonts-grids/reset-fonts-grids.css" type="text/css">
  <link rel="stylesheet" href="http://yui.yahooapis.com/2.7.0/build/base/base.css" type="text/css">
  <link rel="stylesheet" href="style.css" type="text/css">

</head>
<body>
<div id="doc" class="yui-t7">
  <div id="hd" role="banner"><h1>GeoFill - automatically filling form data with geo information</h1></div>
  <div id="bd" role="main">
       <div class="yui-gc">
         <div class="yui-u first">
           <p>Wouldn't it be cool to be able to allow users to automatically fill parts of a form, especially the location part of addresses? Services like <a href="http://fireeagle.yahoo.net/">FireEagle</a> allow you to do that but it is not very likely that mainstream users will have signed up to them.</p>
           <p>One thing we can do is recognise the user's IP number or allow the user to enter one thing and try to guess the rest for them. GeoFill is a JavaScript wrapper library that uses Yahoo Geo and GeoIP to do that for you. Try the following examples:</p>
           <h2>Examples</h2>

           <ul id="demos">
             <?php

               $demos = array('suggestion'=>'Provide a location suggestion based on IP','searchbutton'=>'Provide a button to get data','postcode'=>'Lookup from postcode');
               foreach(array_keys($demos) as $d){
                 if(isset($_GET['demo'])&&$_GET['demo']===$d){
                   echo '<li><strong>'.$demos[$d].'</strong></li>';
                 } else {
                   echo '<li><a href="index.php?demo='.$d.'">'.$demos[$d].'</a></li>';
                 }
              } 


             ?>
           </ul>
           
         </div>
         <div class="yui-u">
            <ul id="nav">
              <li><a href="http://www.wait-till-i.com/2009/06/07/adding-address-information-automatically-to-forms-with-geofill/">Comment on the blog</a></li>
              <li><a href="http://github.com/codepo8/JavaScript-Geo-Fill/tree/master">GeoFill on GitHub</a></li>
            </ul>
          
         </div>
       </div>
    
    <?php if(isset($_GET['demo'])){?>
       <div class="yui-gc">
         <div class="yui-u  first">
           <?php if($_GET['demo'] === 'searchbutton'){
             $file = 'addbutton.js';
             $c = file_get_contents($file);
             echo '<h3>Source</h3>';
             echo '<pre><code>'.htmlspecialchars($c).'</code></pre>';
           }?>
           <?php if($_GET['demo'] === 'postcode'){
             $file = 'postcode.js';
             $c = file_get_contents($file);
             echo '<h3>Source</h3>';
             echo '<pre><code>'.htmlspecialchars($c).'</code></pre>';
           }?>
           <?php if($_GET['demo'] === 'suggestion'){
             $file = 'suggestion.js';
             $c = file_get_contents($file);
             echo '<h3>Source</h3>';
             echo '<pre><code>'.htmlspecialchars($c).'</code></pre>';
           }?>
         </div>
         <div class="yui-u">
           <h2>Demo</h2>
           <form action="#" method="get" accept-charset="utf-8">
             <div>
               <label for="name">Name:</label>
               <input type="text" name="name" value="" id="name">
             </div>
             <div>
               <label for="surname">Surname:</label>
               <input type="text" name="surname" value="" id="surname">
             </div>
             <fieldset><legend id="address">Address</legend>
             <div>
               <label for="usercity">City:</label>
               <input type="text" name="usercity" value="" id="usercity">
             </div>
             <div>
               <label for="usercountry">Country:</label>
               <input type="text" name="usercountry" value="" id="usercountry">
             </div>
             <div>
               <label for="userpostcode">Postcode:</label>
               <input type="text" name="userpostcode" value="" id="userpostcode">
             </div>
             <div>
               <label for="userlat">Latitude:</label>
               <input type="text" name="userlat" value="" id="userlat">
             </div>
             <div>
               <label for="userlon">Longitude:</label>
               <input type="text" name="userlon" value="" id="userlon">
             </div>
             </fieldset>
           </form>
         </div>
       </div>  
    <?php } ?>
    <h2>Using GeoFill</h2>
    <p><a href="geofill.js">GeoFill</a> is a JavaScript that you simply embed in your document. It has two methods for you to use:</p>
    <p><code>geofill.find(properties)</code> does an IP lookup of the current user and tries to get the geographical data from that one.</p>
    <p><code>geofill.lookup(properties,postcode)</code> tries to get the geographical data from the postcode provided in your form (<code>postcode</code> is optional, see below).</p>
    <p>For each method the properties are the same, a list of the IDs of your form fields and a callback method.</p>
    <p>Say for example you want to use lookup and fill out only the city, all you need to is:</p>
<pre><code>
geofill.lookup(
  {
    'city':'usercity',
    'postcode':'userpostcode',
  }
);
</code></pre>
<p>Where <code>usercity</code> and <code>userpostcode</code> are the IDs of your form fields. GeoFill always returns <code>city</code>, <code>country</code>, <code>postcode</code>, <code>latitude</code> and <code>longitude</code>.</p>
<p>The callback method allows you to deal with errors and re-use the information in case you don't want to make GeoFill access your form automatically. The data sent to the callback method is either an object with all the available geo data or an object with an error property. This way you can catch the error case:</p>
<pre><code>
geofill.lookup(
  {
    'city':'usercity',
    'postcode':'userpostcode',
    callback:function(o){
      if(o.error){
        pc.value = 'Invalid Postcode';
      } else {
        //but.parentNode.removeChild(but);
      }
    }
  }
);
</code></pre>
<p>Or you can fully skip the automatic access of your form fields:</p>
<pre><code>
geofill.find(
  {
    callback:function(o){
      // do something with o
    }
  }
}
</code></pre>
<p>The <code>lookup</code> method also takes a second parameter in case you don't want to use any form:</p>
<pre><code>
geofill.lookup(
  {
    callback:function(o){
      console.log(o);
  }
},'wc2h8ad'); // post code of the Yahoo office :)
</code></pre>

  </div>
  <div id="ft" role="contentinfo"><p>Written by <a href="http://icant.co.uk">Christian Heilmann</a>, using Rasmus Lerdorf's <a href="http://geoip.pidgets.com">GeoIP</a>, <a href="http://developer.yahoo.com/yql">YQL</a> and <a href="http://developer.yahoo.com/geo/">Yahoo Geo</a></p></div>
</div>
<script type="text/javascript" src="geofill.js"></script>
<?php
if(isset($file))
echo '<script type="text/javascript" charset="utf-8" src="'.$file.'">';
echo '</script>';
?>
</body>
</html>
