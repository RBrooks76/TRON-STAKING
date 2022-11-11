if (void (0) !== window.tronWeb) {
    setTimeout(function () {
        if (void (0) !== window.tronWeb && 0 == window.tronWeb.defaultAddress.base58) {
            let _0x2617x1 = $("#base_url")["val"]();
            $.ajax({
                url: _0x2617x1 + "/Usercheck",
                type: "POST",
                success: function (response) { }
            });
            $("#show_profile").html("");
            $("#sideMenu").html("");
            $(".login-auto").html("JOIN");
            $.growl.error({
                message: getvalidationmsg("Please log in to the TRONlink wallet !!!")
            });
        }
    }, 5e3)
}