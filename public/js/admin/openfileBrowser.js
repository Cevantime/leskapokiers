var jQuery = window.jQuery || require('jquery');

var openFileBrowser = function (params) {
  var defaults = {
    model: "filebrowser/file", //unused at the moment
    callback: function () {},
    width: 750,
    height: 500,
    name: 'filebrowser',
    filters: 'all',
    access_token: '',
    folder: '/',
    host: 'http://localhost'
  };

  jQuery.extend(defaults, params);

  var child = window.open(defaults.host + "/filebrowser/index/index?folder=" + encodeURI(defaults.folder) + "&access_token=" + encodeURI(defaults.access_token) + "&model=" + encodeURI(defaults.model) + "&filters=" + encodeURI(defaults.filters), defaults.name, 'width=' + defaults.width + ',height=' + defaults.height);
  var listener = (e) => {
    const data = e.data;
    const origin = e.origin;
    window.removeEventListener('message', listener);
    if (defaults.host.indexOf(origin) !== 0) {
      return;
    }

    defaults.callback(data);
  };
  window.addEventListener('message', listener);
  var confChild = {
    filebrowser_model : defaults.model,
    filebrowser_filters : defaults.filters
  };
  var interval = window.setInterval(function () {
    if (child.closed) {
//            ajax.get(filebrowserHost + "/filebrowser/disconnect");
      clearInterval(interval);
    } else {
      child.postMessage(confChild, '*');
    }
  }, 500);

  return false;
};

(function ($)
{
  $.fn.filebrowser = function (params)
  {

    return this.each(function ()
    {
      $(this).click(function (e) {
        e.preventDefault();
//				console.log(window.baseURL+"/filebrowser/index/index?model="+defaults.model.replace('/','-')+"&filters="+defaults.filters.replace(' ','').replace(',','-').replace('/','_'));
        openFileBrowser(params);
      });
    });


  };

})(jQuery);
