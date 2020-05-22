global.$ = global.jQuery = require('jquery');


$(document).on('click','.delete',function (e){
  if (!confirm("آیا مطمئن هستید؟")) {
      event.preventDefault();
  }
});
