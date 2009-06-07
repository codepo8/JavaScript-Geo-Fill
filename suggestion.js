(function(){
  geofill.find(
    {
      callback:function(o){
        var ad = document.getElementById('address');
        var html = '<h3>Is this where you are?</h3>';
        html+='<p>We think you are in '+o.city+', '+
              o.country+'</p>';
        html+='<p>Is this right?</p>';
        var div = document.createElement('div');
        div.setAttribute('id','suggest');
        div.innerHTML = html;
        var but = document.createElement('input');
        but.setAttribute('type','button');
        but.setAttribute('value','Yes, use this');
        div.appendChild(but);
        but.onclick = function(){
          $('usercity').value = o.city;
          $('usercountry').value = o.country;
          $('userlat').value = o.latitude;
          $('userlon').value = o.longitude;
          function $(id){
            return document.getElementById(id);
          }
          var mom = this.parentNode;
          mom.parentNode.removeChild(mom);
        }    
        ad.parentNode.insertBefore(div,ad.nextSibling);
      }
    }
  );
})();
