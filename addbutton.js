(function(){
  var addto = document.getElementById('address');
  var but = document.createElement('input');
  but.setAttribute('type','button');
  but.setAttribute('value','Find Location');
  but.onclick = function(){
    geofill.find(
      {
        'city':'usercity',
        'latitude':'userlat',
        'longitude':'userlon',
        'country':'usercountry'
      }
    );
  }    
  addto.parentNode.insertBefore(but,addto.nextSibling);
})();
