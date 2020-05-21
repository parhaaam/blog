global.$ = global.jQuery = require('jquery');


$(document).on('click','.delete',function (e){
  if (!confirm("آیا از حذف کردن این کاربر اطمینان دارید؟")) {
      event.preventDefault();
  }
});
