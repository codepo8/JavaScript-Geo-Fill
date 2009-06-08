/*
  GeoFill by Christian Heilmann
  Version: 1.1
  Homepage: http://icant.co.uk/geofill
  Copyright (c) 2009, Christian Heilmann
  Code licensed under the BSD License:
  http://wait-till-i.com/license.txt
*/
geofill = function(){
  var fieldstofill = null;
  var postcode = null;
  var ipdata = null;
  function find(o){
    fieldstofill = o;
    get('http://geoip.pidgets.com/?format=json&callback=geofill.getpc');
  }
  function lookup(pc){
    postcode = pc;
    var getcode = null;
    if(typeof arguments[1] === 'string'){
      getcode = arguments[1];
    } else {
      var code = document.getElementById(pc.postcode);
      if(code){
        getcode = code.value;
      }
    }
    if(getcode){
      var url= 'http://query.yahooapis.com/v1/public/yql?q=select%20*'+
               '%20from%20geo.places%20where%20text%3D%22'+getcode+
               '%22&format=json&callback=geofill.pc';
      get(url);        
    }
  }
  function setPostcode(o){
    if(o.query.results){
      var place = o.query.results.place;
      if(place[1]){
        place = place[0];
      }
      if(place.postal){
        var filtered = {
          postcode:place.postal.content,
          city:place.locality1.content,
          country:place.country.content,
          latitude:place.centroid.latitude,
          longitude:place.centroid.longitude  
        }
        for(var i in postcode){
          var x = document.getElementById(postcode[i]);
          if(x){
            x.value = filtered[i];
          }
        }
      } else {
        var filtered = {error:'postcode'};
      }
    } else {
      var filtered = {error:404};
    }
    if(typeof postcode.callback === 'function'){
      postcode.callback(filtered);
    }
  }
  function get(url){
    var s = document.createElement('script');
    s.setAttribute('src',url);
    document.getElementsByTagName('head')[0].appendChild(s);
  }
  function getPostalfromIP(o){
    ipdata = o;
    // god I friggin love YQL
    var url = 'http://query.yahooapis.com/v1/public/yql?q=select'+
              '%20postal%20from%20geo.places%20where%20woeid%20in%20'+
              '(select%20place.woeid%20from%20flickr.places%20where'+
              '%20lat%3D%22'+o.latitude+'%22%20and%20lon%3D%22'+
              o.longitude+'%22)&format=json&callback=geofill.set';
    get(url);
  }
  
  function set(o){
    var filtered = {
      city:ipdata.city,
      country:ipdata.country_name,
      postcode:o.query.results.place.postal.content,
      latitude:ipdata.latitude,
      longitude:ipdata.longitude
    }
    for(var i in fieldstofill){
      var x = document.getElementById(fieldstofill[i]);
      if(x){
        x.value = filtered[i];
      }
    }
    if(typeof fieldstofill.callback === 'function'){
      fieldstofill.callback(filtered);
    }
  }
  return {
    set:set,
    find:find,
    pc:setPostcode,
    lookup:lookup,
    getpc:getPostalfromIP
  }
}();
