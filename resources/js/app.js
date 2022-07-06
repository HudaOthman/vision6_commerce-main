require('./bootstrap');

Echo.private('App.Models.User.' + userId)
    .notification((notification) => {
        console.log(notification);
        toastr.success(notification.msg)
    });
