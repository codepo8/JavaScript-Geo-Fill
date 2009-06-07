(function(){
  var addto = document.getElementById('userpostcode');
  var but = document.createElement('input');
  but.setAttribute('type','button');
  but.setAttribute('value','Get other info');
  but.onclick = function(){
    var pc = document.getElementById('userpostcode');
    geofill.lookup(
      {
        'city':'usercity',
        'latitude':'userlat',
        'longitude':'userlon',
        'country':'usercountry',
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
  }    
  addto.parentNode.insertBefore(but,addto.nextSibling);
})();
