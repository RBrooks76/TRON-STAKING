localStorage["setItem"]("userAdd", ""), localStorage["setItem"]("browser", "");
const m_plana_address = PlanAinfo.tree_addr,
    m_tree_address = PlanAinfo.addr,
    current_level = 1;
let twss, reff_id = "" == localStorage["getItem"]("Reff") || null == localStorage["getItem"]("Reff") ? referrer : localStorage["getItem"]("Reff"),
    Areff_id = "" == localStorage["getItem"]("AReff") || null == localStorage["getItem"]("AReff") ? Areferrer : localStorage["getItem"]("AReff"),
    user_ref_id = "",
    buyLevel = "",
    buyType = "",
    is_referrer = 1,
    contract_id = 0,
    id_update = 0,
    board_one = 0,
    board_one_time = 0,
    board_two_time = 0,
    board_three_time = 0,
    board_one_re_id = 0,
    board_two_re_id = 0,
    board_three_re_id = 0,
    reff_id_status = 0,
    board_two = 0,
    board_three = 0,
    log_reff_id = "" == localStorage["getItem"]("isReff") || null == localStorage["getItem"]("isReff") ? referrer_id : localStorage["getItem"]("isReff"),
    Alog_reff_id = "" == localStorage["getItem"]("isAReff") || null == localStorage["getItem"]("isAReff") ? Areferrer_id : localStorage["getItem"]("isAReff"),
    curr_lang = $("#curr_lang")["val"](),
    base_urll = $("#base_url")["val"](),
    baseurl = $("#baseurl")["val"]();

function hexToDec(_0x24a7x1d) {
    return parseInt(_0x24a7x1d, 16)
}
async function tronWebFn() {
    try {
        if (void (0) !== window.tronWeb) {
            if (void (0) !== window.tronWeb && 0 == window.tronWeb.defaultAddress.base58) {
                ;
            } else {
                var _0x24a7x1d = getvalidationmsg("TRXCONNECTION");
                if ($.growl["notice"]({
                    message: _0x24a7x1d + window.tronWeb.defaultAddress.base58
                }, {
                    position: {
                        from: "bottom",
                        align: "left"
                    }
                }), 1 == localStorage["getItem"]("isaddlogin")) {
                    ;
                } else {
                    let _0x24a7x1d = 0;
                    $.ajax({
                        url: base_urll + "/checkUser",
                        type: "POST",
                        data: {
                            address: window.tronWeb.defaultAddress.base58
                        },
                        dataType: "JSON",
                        success: function (_0x24a7x1f) {
                            console.log("resp resp resp", _0x24a7x1f);
                            console.log("resp resp.isSection resp.isSection", _0x24a7x1f["isSection"]);
                            1 == _0x24a7x1f["isExist"] ? (
                                localStorage["setItem"]("isaddlogin", 1),
                                2 == _0x24a7x1f["isSection"] ? (
                                    localStorage["setItem"]("isReff", _0x24a7x1f["isReff"]),
                                    localStorage["setItem"]("Reff", _0x24a7x1f.Reff), log_reff_id = _0x24a7x1f["isReff"],
                                    reff_id = _0x24a7x1f["Reff"], _0x24a7x1d = 1
                                ) : 1 == _0x24a7x1f["isSection"] ? (
                                    localStorage["setItem"]("isAReff", _0x24a7x1f["isReff"]),
                                    localStorage["setItem"]("AReff", _0x24a7x1f.Reff),
                                    Alog_reff_id = _0x24a7x1f["isReff"],
                                    Areff_id = _0x24a7x1f["Reff"],
                                    contract_id = _0x24a7x1f["contract_id"],
                                    id_update = _0x24a7x1f["id_update"],
                                    board_one = _0x24a7x1f["board_one"],
                                    board_two = _0x24a7x1f["board_two"],
                                    board_three = _0x24a7x1f["board_three"],
                                    board_one_time = _0x24a7x1f["board_one_time"],
                                    board_two_time = _0x24a7x1f["board_two_time"],
                                    board_three_time = _0x24a7x1f["board_three_time"],
                                    board_one_re_id = _0x24a7x1f["board_one_cu_re_id"],
                                    board_two_re_id = _0x24a7x1f["board_two_cu_re_id"],
                                    board_three_re_id = _0x24a7x1f["board_three_cu_re_id"],
                                    reff_id_status = _0x24a7x1f["reff_id_status"],
                                    localStorage["setItem"]("reff_count", _0x24a7x1f["direct_reff_count"]),
                                    1 == board_one && localStorage["setItem"]("buy_plan", 2),
                                    2 == board_two && localStorage["setItem"]("buy_plan", 3),
                                    3 == board_three && localStorage["setItem"]("buy_plan", 4),
                                    _0x24a7x1d = 2
                                ) : 3 == _0x24a7x1f["isSection"] && (
                                    _0x24a7x1d = 3,
                                    localStorage["setItem"]("isReff", _0x24a7x1f.BisReff),
                                    localStorage["setItem"]("Reff", _0x24a7x1f.BReff),
                                    log_reff_id = _0x24a7x1f["BisReff"],
                                    reff_id = _0x24a7x1f["BReff"],
                                    localStorage["setItem"]("isAReff", _0x24a7x1f.AisReff),
                                    localStorage["setItem"]("AReff", _0x24a7x1f.AReff),
                                    Alog_reff_id = _0x24a7x1f["AisReff"],
                                    Areff_id = _0x24a7x1f["AReff"],
                                    contract_id = _0x24a7x1f["contract_id"],
                                    id_update = _0x24a7x1f["id_update"],
                                    board_one = _0x24a7x1f["board_one"],
                                    board_two = _0x24a7x1f["board_two"],
                                    board_three = _0x24a7x1f["board_three"],
                                    board_one_time = _0x24a7x1f["board_one_time"],
                                    board_two_time = _0x24a7x1f["board_two_time"],
                                    board_three_time = _0x24a7x1f["board_three_time"],
                                    board_one_re_id = _0x24a7x1f["board_one_cu_re_id"],
                                    board_two_re_id = _0x24a7x1f["board_two_cu_re_id"],
                                    board_three_re_id = _0x24a7x1f["board_three_cu_re_id"],
                                    reff_id_status = _0x24a7x1f["reff_id_status"],
                                    localStorage["setItem"]("reff_count", _0x24a7x1f["direct_reff_count"]),
                                    1 == board_one && localStorage["setItem"]("buy_plan", 2),
                                    2 == board_two && localStorage["setItem"]("buy_plan", 3),
                                    3 == board_three && localStorage["setItem"]("buy_plan", 4)),
                                $("#show_profile")["html"]("<div class='profileTrig'><button class='btn noBoxShadow'><div class='profileContent'><span class='profTrigText'>" + getvalidationmsg("My Profile") + "</span><span class='profTrigImage'><img src='" + baseurl + "ajqgzgmedscuoc/front/images/home/profileIcon.png' alt='profileIcon' /></span></div></button></div>"),
                                $("#sideMenu")["load"](base_urll + "/load/" + curr_lang + "/0/0/0/" + tree_id, function () { }), 2 != _0x24a7x1f["isSection"] && 3 != _0x24a7x1f["isSection"] || $(".login-auto")["html"](getvalidationmsg("Deposit"))
                            ) : (
                                _0x24a7x1d = 0, $("#show_profile")["html"](""),
                                $("#sideMenu")["html"](""), $(".login-auto")["html"](getvalidationmsg("JOIN"))
                            );

                            0 == reff_id_status && async function () {
                                try {
                                    (await tronWeb["contract"]()["at"](m_plana_address)).users(window.tronWeb.defaultAddress.base58).call().then((_0x24a7x1d) => {
                                        let _0x24a7x1f = hexToDec(_0x24a7x1d["partnersCount"]._hex);
                                        _0x24a7x1f > 2 && localStorage["setItem"]("reff_count", _0x24a7x1f)
                                    })
                                } catch (_0x24a7x1d) { }
                            }();

                            0 != _0x24a7x1d && 1 != _0x24a7x1d || (
                                start_loader(),
                                async function () {
                                    try {
                                        let _0x24a7x1f = await tronWeb["contract"]()["at"](m_plana_address);

                                        function _0x24a7x1d(_0x24a7x1d) {
                                            return new Promise(function (_0x24a7x20, _0x24a7x21) {
                                                _0x24a7x1f["users_ids"](_0x24a7x1d).call().then((_0x24a7x1d) => {
                                                    let _0x24a7x21 = tronWeb.address.fromHex(_0x24a7x1d);
                                                    _0x24a7x1f.users(_0x24a7x21).call().then((_0x24a7x1d) => {
                                                        _0x24a7x1d["Exist"];
                                                        let _0x24a7x22 = hexToDec(_0x24a7x1d.id._hex),
                                                            _0x24a7x23 = tronWeb.address.fromHex(_0x24a7x1d["inviter"]),
                                                            _0x24a7x24 = (hexToDec(_0x24a7x1d["partnersCount"]._hex), tronWeb.address.fromHex(_0x24a7x1d["userAddress"]), hexToDec(_0x24a7x1d["plan"]._hex)),
                                                            _0x24a7x25 = hexToDec(_0x24a7x1d["treeId"]._hex);
                                                        _0x24a7x22 ? _0x24a7x1f["viewDetails"](_0x24a7x21, _0x24a7x24, _0x24a7x25).call().then((_0x24a7x1d) => {
                                                            let _0x24a7x26 = tronWeb.address.fromHex(_0x24a7x1d["upline"]),
                                                                _0x24a7x27 = hexToDec(_0x24a7x1d["regtime"]._hex);
                                                            _0x24a7x1f["viewDetails"](_0x24a7x26, _0x24a7x24, _0x24a7x25).call().then((_0x24a7x1d) => {
                                                                let _0x24a7x28 = tronWeb.address.fromHex(_0x24a7x1d["firstDownlines"]),
                                                                    _0x24a7x29 = 0;
                                                                _0x24a7x29 = 2 == _0x24a7x28["length"] || "2" == _0x24a7x28["length"] ? 1 : 0, _0x24a7x1f.users(_0x24a7x26).call().then((_0x24a7x1d) => {
                                                                    let _0x24a7x26 = hexToDec(_0x24a7x1d.id._hex);
                                                                    _0x24a7x1f.users(_0x24a7x23).call().then((_0x24a7x1d) => {
                                                                        let _0x24a7x28 = hexToDec(_0x24a7x1d.id._hex);
                                                                        _0x24a7x1f["treeUserCount"](_0x24a7x24, _0x24a7x25).call().then((_0x24a7x1d) => {
                                                                            let _0x24a7x2a = hexToDec(_0x24a7x1d._hex);
                                                                            _0x24a7x1f["profitDetails"](_0x24a7x23, _0x24a7x24, _0x24a7x25).call().then((_0x24a7x1d) => {
                                                                                let _0x24a7x1f = hexToDec(_0x24a7x1d["_Reinvest"]._hex),
                                                                                    _0x24a7x23 = hexToDec(_0x24a7x1d["reinvestTime"]._hex);
                                                                                _0x24a7x20({
                                                                                    address: _0x24a7x21,
                                                                                    ref_address: _0x24a7x28,
                                                                                    affiliate_id: _0x24a7x26,
                                                                                    current_level: _0x24a7x24,
                                                                                    ref_id: _0x24a7x28,
                                                                                    level_exp: 0,
                                                                                    contract_id: _0x24a7x22,
                                                                                    plan_id: 1,
                                                                                    buyPlan: _0x24a7x24,
                                                                                    depAmount: 0,
                                                                                    tree_id: _0x24a7x25,
                                                                                    create_timestamp: _0x24a7x27,
                                                                                    UserCount: _0x24a7x2a,
                                                                                    _Reinvest: _0x24a7x1f,
                                                                                    reinvestId: 0,
                                                                                    reinvestTime: _0x24a7x23,
                                                                                    tree_status: _0x24a7x29
                                                                                })
                                                                            }).catch((_0x24a7x1d) => {
                                                                                console.log("M M _Profi err ", _0x24a7x1d)
                                                                            })
                                                                        }).catch((_0x24a7x1d) => {
                                                                            console.log("M M UserCount err ", _0x24a7x1d)
                                                                        })
                                                                    }).catch((_0x24a7x1d) => {
                                                                        console.log("M M inerr", _0x24a7x1d)
                                                                    })
                                                                }).catch((_0x24a7x1d) => {
                                                                    console.log("M M uperr", _0x24a7x1d)
                                                                })
                                                            }).catch((_0x24a7x1d) => {
                                                                console.log("M M viewerr", _0x24a7x1d)
                                                            })
                                                        }).catch((_0x24a7x1d) => {
                                                            console.log("M M viewerr", _0x24a7x1d)
                                                        }) : console.log("M M mmmmmmmmmmmmmm")
                                                    }).catch((_0x24a7x1d) => {
                                                        console.log("M M errerrerr", _0x24a7x1d)
                                                    })
                                                })
                                            })
                                        }
                                        _0x24a7x1f.users(window.tronWeb.defaultAddress.base58).call().then((_0x24a7x20) => {

                                            let _0x24a7x21 = hexToDec(_0x24a7x20.id._hex),
                                                _0x24a7x22 = tronWeb.address.fromHex(_0x24a7x20["inviter"]),
                                                _0x24a7x23 = (
                                                    hexToDec(_0x24a7x20["partnersCount"]._hex),
                                                    tronWeb.address.fromHex(_0x24a7x20["userAddress"]),
                                                    hexToDec(_0x24a7x20["plan"]._hex)
                                                ),
                                                _0x24a7x24 = hexToDec(_0x24a7x20["treeId"]._hex);
                                            _0x24a7x21 > 0 ? _0x24a7x1f["viewDetails"](window.tronWeb.defaultAddress.base58, _0x24a7x23, _0x24a7x24).call().then((_0x24a7x20) => {
                                                let _0x24a7x25 = tronWeb.address.fromHex(_0x24a7x20["upline"]),
                                                    _0x24a7x26 = hexToDec(_0x24a7x20["regtime"]._hex);
                                                _0x24a7x1f["viewDetails"](_0x24a7x25, 1, _0x24a7x24).call().then((_0x24a7x20) => {
                                                    let _0x24a7x27 = tronWeb.address.fromHex(_0x24a7x20["firstDownlines"]),
                                                        _0x24a7x28 = 0;
                                                    _0x24a7x28 = 2 == _0x24a7x27["length"] || "2" == _0x24a7x27["length"] ? 1 : 0;
                                                    _0x24a7x1f.users(_0x24a7x25).call().then((_0x24a7x20) => {
                                                        let _0x24a7x25 = hexToDec(_0x24a7x20.id._hex);
                                                        _0x24a7x1f.users(_0x24a7x22).call().then((_0x24a7x20) => {
                                                            let _0x24a7x27 = hexToDec(_0x24a7x20.id._hex);

                                                            _0x24a7x1f.treeUserCount(_0x24a7x23, _0x24a7x24).call().then((_0x24a7x20) => {
                                                                let _0x24a7x29 = hexToDec(_0x24a7x20._hex);
                                                                _0x24a7x1f["profitDetails"](_0x24a7x22, _0x24a7x23, _0x24a7x24).call().then((_0x24a7x1f) => {
                                                                    let user_gmail = localStorage.getItem('user_gmail');
                                                                    if (user_gmail) user_gmail = user_gmail.trim();
                                                                    var nameMatch = user_gmail ? user_gmail.split('@gmail.com') : [];

                                                                    let _0x24a7x20 = hexToDec(_0x24a7x1f["_Reinvest"]._hex),
                                                                        _0x24a7x22 = hexToDec(_0x24a7x1f["reinvestTime"]._hex),
                                                                        _0x24a7x2a = {
                                                                            address: window.tronWeb.defaultAddress.base58,
                                                                            ref_address: _0x24a7x27,
                                                                            affiliate_id: _0x24a7x25,
                                                                            current_level: _0x24a7x23,
                                                                            ref_id: _0x24a7x27,
                                                                            level_exp: 0,
                                                                            contract_id: _0x24a7x21,
                                                                            plan_id: 1,
                                                                            buyPlan: _0x24a7x23,
                                                                            depAmount: 0,
                                                                            tree_id: _0x24a7x24,
                                                                            create_timestamp: _0x24a7x26,
                                                                            UserCount: _0x24a7x29,
                                                                            _Reinvest: _0x24a7x20,
                                                                            reinvestId: 0,
                                                                            reinvestTime: _0x24a7x22,
                                                                            tree_status: _0x24a7x28,
                                                                            email: user_gmail && nameMatch.length == 2 && nameMatch[0].length > 0 ? user_gmail : '',
                                                                        };
                                                                    console.log("PAManualregUserData PAManualregUserData", _0x24a7x2a), $.post(base_urll + "/getMissingID/" + _0x24a7x21 + "/" + _0x24a7x24, function (_0x24a7x1f) {
                                                                        if (console.log("body getMissingID", _0x24a7x1f), 0 != _0x24a7x1f["trim"]() && "0" != _0x24a7x1f["trim"]()) {
                                                                            let _0x24a7x20 = JSON["parse"](_0x24a7x1f),
                                                                                _0x24a7x21 = Object["keys"](_0x24a7x20)["map"](function (_0x24a7x1d) {
                                                                                    return _0x24a7x20[_0x24a7x1d]
                                                                                });
                                                                            if (_0x24a7x21["length"] > 0) {
                                                                                let _0x24a7x1f = [];
                                                                                (async () => {
                                                                                    for (var _0x24a7x20 = 0; _0x24a7x20 < _0x24a7x21["length"]; _0x24a7x20++) {
                                                                                        const _0x24a7x23 = await _0x24a7x1d(_0x24a7x21[_0x24a7x20]);
                                                                                        if (_0x24a7x1f["push"](_0x24a7x23), _0x24a7x20 === _0x24a7x21["length"] - 1 && (_0x24a7x1f["push"](_0x24a7x2a), _0x24a7x1f["length"] > 0)) {
                                                                                            for (var _0x24a7x22 = 0; _0x24a7x22 < _0x24a7x1f["length"]; _0x24a7x22++) {
                                                                                                console.log("__insert_value_array", _0x24a7x1f[_0x24a7x22]), socket["emit"]("regUser", base_urll, _0x24a7x1f[_0x24a7x22])
                                                                                            }
                                                                                        }
                                                                                    }
                                                                                })()
                                                                            }
                                                                        } else {
                                                                            socket["emit"]("regUser", base_urll, _0x24a7x2a);
                                                                        }
                                                                    })
                                                                }).catch((_0x24a7x1d) => {
                                                                    console.log("_Profi err ", _0x24a7x1d)
                                                                })
                                                            }).catch((_0x24a7x1d) => {
                                                                console.log("UserCount err ", _0x24a7x1d)
                                                            })
                                                        }).catch((_0x24a7x1d) => {
                                                            console.log("inerr", _0x24a7x1d)
                                                        })
                                                    }).catch((_0x24a7x1d) => {
                                                        console.log("uperr", _0x24a7x1d)
                                                    })
                                                }).catch((_0x24a7x1d) => {
                                                    console.log("viewerr", _0x24a7x1d)
                                                })
                                            }).catch((_0x24a7x1d) => {
                                                console.log("viewerr", _0x24a7x1d)
                                            }) : (stop_loader(), console.log("mmmmmmmmmmmmmm"), localStorage["setItem"]("buy_plan", 1))
                                        }).catch((_0x24a7x1d) => {
                                            console.log("errerrerr", _0x24a7x1d)
                                        })
                                    } catch (_0x24a7x1d) {
                                        console.log("aaa 2 e e e", _0x24a7x1d), stop_loader()
                                    }
                                }())
                        }
                    })
                }
            }
        } else {
            console.log("eeeeeeeeeeeeeeeee")
        };
        if (void (0) !== window.tronWeb && void (0) !== window.tronWeb && "" != window.tronWeb.defaultAddress.base58) {
            let _0x24a7x1d = window.tronWeb.defaultAddress.base58;
            localStorage["setItem"]("address", _0x24a7x1d);
            $(document)["on"]("click", ".show_wallet_address", function () {
                $("#show_wallet_address")["html"](_0x24a7x1d), setTimeout(function () {
                    $("#show_wallet_address")["html"](getvalidationmsg("Show Wallet Address"))
                }, 5e3)
            }), $(document)["on"]("click", ".referral_link", function () {
                let _0x24a7x1d = $(this)["attr"]("data-url");
                var _0x24a7x1f = document["createElement"]("input");
                _0x24a7x1f["style"] = "position: absolute; left: -1000px; top: -1000px", _0x24a7x1f["value"] = _0x24a7x1d, document["body"]["appendChild"](_0x24a7x1f), _0x24a7x1f["select"](), document["execCommand"]("copy"), document["body"]["removeChild"](_0x24a7x1f), $.growl["notice"]({
                    message: getvalidationmsg("Copied the URL: ") + _0x24a7x1d
                })
            }), $(document)["on"]("click", ".referrallink", function () {
                $.growl.error({
                    message: getvalidationmsg("YC7DC")
                }, {})
            }), $(document)["on"]("click", ".partnerreferrallink", function () {
                $(".view_25")[0]["click"]()
            });
            let _0x24a7x23 = await tronWeb["contract"]()["at"](m_plana_address);
            (await tronWeb["contract"]()["at"](m_tree_address))["total_deposited"]().call().then((_0x24a7x1d) => {
                let _0x24a7x1f = parseFloat(hexToDec(_0x24a7x1d._hex) / 1e6)["toFixed"](8);
                _0x24a7x23["total_deposited"]().call().then((_0x24a7x1d) => {
                    let _0x24a7x20 = parseFloat(hexToDec(_0x24a7x1d._hex) / 1e6)["toFixed"](8),
                        _0x24a7x21 = parseFloat(_0x24a7x1f) + parseFloat(_0x24a7x20);
                    $("#trx_value")["val"](parseFloat(_0x24a7x21)["toFixed"](8));
                    var _0x24a7x22 = parseFloat(usd_value) * parseFloat(_0x24a7x21);
                    $("#bcvValue")["html"](_0x24a7x22)
                })
            });
            let _0x24a7x25 = 0,
                _0x24a7x26 = 0,
                _0x24a7x27 = 0,
                _0x24a7x28 = 0,
                _0x24a7x29 = 0,
                _0x24a7x2a = 0,
                _0x24a7x2b = 0,
                _0x24a7x2c = 0,
                _0x24a7x2d = 0;

            function _0x24a7x1f(_0x24a7x1d) {
                return new Promise(function (_0x24a7x1f, _0x24a7x20) {
                    _0x24a7x23["viewDetails"](window.tronWeb.defaultAddress.base58, _0x24a7x1d, tree_id).call().then((_0x24a7x1d) => {
                        let _0x24a7x20 = tronWeb.address.fromHex(_0x24a7x1d["upline"]);
                        _0x24a7x23.users(_0x24a7x20).call().then((_0x24a7x20) => {
                            let _0x24a7x21 = hexToDec(_0x24a7x20.id._hex);
                            _0x24a7x1f([hexToDec(_0x24a7x1d["regtime"]._hex), _0x24a7x21])
                        })
                    })
                })
            }

            function _0x24a7x20() {
                console.log("call getProfitDetails");
                _0x24a7x23["profitDetails"](window.tronWeb.defaultAddress.base58, 1, tree_id).call().then((_0x24a7x1d) => {
                    let _0x24a7x1f = _0x24a7x1d["ReceivedAmount"]["_hex"] / 1e6,
                        _0x24a7x20 = _0x24a7x1d["_Earns"]["_hex"] / 1e6,
                        _0x24a7x21 = _0x24a7x1d["_give"]["_hex"] / 1e6;
                    if (1 != localStorage["getItem"]("one_Reinvest")) {
                        let _0x24a7x1f = 0,
                            _0x24a7x20 = hexToDec(_0x24a7x1d["_Reinvest"]._hex),
                            _0x24a7x21 = hexToDec(_0x24a7x1d["reinvestTime"]._hex);
                        if (board_one_re_id < _0x24a7x20) {
                            let _0x24a7x1d = {
                                address: window.tronWeb.defaultAddress.base58,
                                _Reinvest: _0x24a7x20,
                                reinvestId: _0x24a7x1f,
                                boardType: 1,
                                reinvestTime: _0x24a7x21
                            };
                            board_one_re_id = _0x24a7x20, socket["emit"]("reInvestUpdate", base_urll, _0x24a7x1d), localStorage["setItem"]("one_Reinvest", 1)
                        }
                    };
                    $("#total_1")["html"](_0x24a7x1f);
                    $("#give_1")["html"](_0x24a7x21);
                    $("#Earns_1")["html"](_0x24a7x20)
                });
                _0x24a7x23["profitDetails"](window.tronWeb.defaultAddress.base58, 2, tree_id).call().then((_0x24a7x1d) => {
                    let _0x24a7x1f = _0x24a7x1d["ReceivedAmount"]["_hex"] / 1e6,
                        _0x24a7x20 = _0x24a7x1d["_Earns"]["_hex"] / 1e6,
                        _0x24a7x21 = _0x24a7x1d["_give"]["_hex"] / 1e6;
                    if (1 != localStorage["getItem"]("two_Reinvest")) {
                        let _0x24a7x1f = 0,
                            _0x24a7x20 = hexToDec(_0x24a7x1d["_Reinvest"]._hex),
                            _0x24a7x21 = hexToDec(_0x24a7x1d["reinvestTime"]._hex);
                        if (board_two_re_id < _0x24a7x20) {
                            let _0x24a7x1d = {
                                address: window.tronWeb.defaultAddress.base58,
                                _Reinvest: _0x24a7x20,
                                reinvestId: _0x24a7x1f,
                                boardType: 2,
                                reinvestTime: _0x24a7x21
                            };
                            board_two_re_id = _0x24a7x20, socket["emit"]("reInvestUpdate", base_urll, _0x24a7x1d), localStorage["setItem"]("two_Reinvest", 1)
                        }
                    };
                    $("#total_2")["html"](_0x24a7x1f), $("#give_2")["html"](_0x24a7x21), $("#Earns_2")["html"](_0x24a7x20)
                });
                _0x24a7x23["profitDetails"](window.tronWeb.defaultAddress.base58, 3, tree_id).call().then((_0x24a7x1d) => {
                    let _0x24a7x1f = _0x24a7x1d["ReceivedAmount"]["_hex"] / 1e6,
                        _0x24a7x20 = _0x24a7x1d["_Earns"]["_hex"] / 1e6,
                        _0x24a7x21 = _0x24a7x1d["_give"]["_hex"] / 1e6;
                    if (1 != localStorage["getItem"]("three_Reinvest")) {
                        let _0x24a7x1f = 0,
                            _0x24a7x20 = hexToDec(_0x24a7x1d["_Reinvest"]._hex),
                            _0x24a7x21 = hexToDec(_0x24a7x1d["reinvestTime"]._hex);
                        if (board_three_re_id < _0x24a7x20) {
                            let _0x24a7x1d = {
                                address: window.tronWeb.defaultAddress.base58,
                                _Reinvest: _0x24a7x20,
                                reinvestId: _0x24a7x1f,
                                boardType: 3,
                                reinvestTime: _0x24a7x21
                            };
                            board_three_re_id = _0x24a7x20, socket["emit"]("reInvestUpdate", base_urll, _0x24a7x1d), localStorage["setItem"]("three_Reinvest", 1)
                        }
                    };
                    $("#total_3")["html"](_0x24a7x1f), $("#give_3")["html"](_0x24a7x21), $("#Earns_3")["html"](_0x24a7x20)
                })
            }

            function _0x24a7x21(_0x24a7x1d) {
                return new Promise(function (_0x24a7x1f, _0x24a7x20) {
                    _0x24a7x23["users_ids"](_0x24a7x1d).call().then((_0x24a7x1d) => {
                        let _0x24a7x20 = tronWeb.address.fromHex(_0x24a7x1d);
                        _0x24a7x23.users(_0x24a7x20).call().then((_0x24a7x1d) => {
                            _0x24a7x1d["Exist"];
                            let _0x24a7x21 = hexToDec(_0x24a7x1d.id._hex),
                                _0x24a7x22 = tronWeb.address.fromHex(_0x24a7x1d["inviter"]),
                                _0x24a7x24 = (hexToDec(_0x24a7x1d["partnersCount"]._hex), tronWeb.address.fromHex(_0x24a7x1d["userAddress"]), hexToDec(_0x24a7x1d["plan"]._hex)),
                                _0x24a7x25 = hexToDec(_0x24a7x1d["treeId"]._hex);
                            _0x24a7x21 ? _0x24a7x23["viewDetails"](_0x24a7x20, _0x24a7x24, _0x24a7x25).call().then((_0x24a7x1d) => {
                                let _0x24a7x26 = tronWeb.address.fromHex(_0x24a7x1d["upline"]),
                                    _0x24a7x27 = hexToDec(_0x24a7x1d["regtime"]._hex);
                                _0x24a7x23["viewDetails"](_0x24a7x26, _0x24a7x24, _0x24a7x25).call().then((_0x24a7x1d) => {
                                    let _0x24a7x28 = tronWeb.address.fromHex(_0x24a7x1d["firstDownlines"]),
                                        _0x24a7x29 = 0;
                                    _0x24a7x29 = 2 == _0x24a7x28["length"] || "2" == _0x24a7x28["length"] ? 1 : 0, _0x24a7x23.users(_0x24a7x26).call().then((_0x24a7x1d) => {
                                        let _0x24a7x26 = hexToDec(_0x24a7x1d.id._hex);
                                        _0x24a7x23.users(_0x24a7x22).call().then((_0x24a7x1d) => {
                                            let _0x24a7x28 = hexToDec(_0x24a7x1d.id._hex);
                                            _0x24a7x23["treeUserCount"](_0x24a7x24, _0x24a7x25).call().then((_0x24a7x1d) => {
                                                let _0x24a7x2a = hexToDec(_0x24a7x1d._hex);
                                                _0x24a7x23["profitDetails"](_0x24a7x22, _0x24a7x24, _0x24a7x25).call().then((_0x24a7x1d) => {
                                                    let _0x24a7x22 = hexToDec(_0x24a7x1d["_Reinvest"]._hex),
                                                        _0x24a7x23 = hexToDec(_0x24a7x1d["reinvestTime"]._hex);
                                                    _0x24a7x1f({
                                                        address: _0x24a7x20,
                                                        ref_address: _0x24a7x28,
                                                        affiliate_id: _0x24a7x26,
                                                        current_level: _0x24a7x24,
                                                        ref_id: _0x24a7x28,
                                                        level_exp: 0,
                                                        contract_id: _0x24a7x21,
                                                        plan_id: 1,
                                                        buyPlan: _0x24a7x24,
                                                        depAmount: 0,
                                                        tree_id: _0x24a7x25,
                                                        create_timestamp: _0x24a7x27,
                                                        UserCount: _0x24a7x2a,
                                                        _Reinvest: _0x24a7x22,
                                                        reinvestId: 0,
                                                        reinvestTime: _0x24a7x23,
                                                        tree_status: _0x24a7x29
                                                    })
                                                }).catch((_0x24a7x1d) => {
                                                    console.log("M M _Profi err ", _0x24a7x1d)
                                                })
                                            }).catch((_0x24a7x1d) => {
                                                console.log("M M UserCount err ", _0x24a7x1d)
                                            })
                                        }).catch((_0x24a7x1d) => {
                                            console.log("M M inerr", _0x24a7x1d)
                                        })
                                    }).catch((_0x24a7x1d) => {
                                        console.log("M M uperr", _0x24a7x1d)
                                    })
                                }).catch((_0x24a7x1d) => {
                                    console.log("M M viewerr", _0x24a7x1d)
                                })
                            }).catch((_0x24a7x1d) => {
                                console.log("M M viewerr", _0x24a7x1d)
                            }) : console.log("M M mmmmmmmmmmmmmm")
                        }).catch((_0x24a7x1d) => {
                            console.log("M M errerrerr", _0x24a7x1d)
                        })
                    })
                })
            }
            async function _0x24a7x22(_0x24a7x1d, _0x24a7x1f, _0x24a7x20, _0x24a7x24, _0x24a7x25) {
                console.log(_0x24a7x1d)
                let _0x24a7x26 = await tronWeb.trx.getTransactionInfo(_0x24a7x1d);
                if (void (0) !== _0x24a7x26["receipt"]) {
                    if (void (0) !== _0x24a7x26["receipt"]["result"]) {
                        let _0x24a7x1d = "";
                        if ("FAILED" == _0x24a7x26["result"] && (_0x24a7x1d += "FAILED"), void (0) !== _0x24a7x26["receipt"]["result"]) {
                            if ("SUCCESS" == _0x24a7x26["receipt"]["result"]) {
                                console.log("add", window.tronWeb.defaultAddress.base58);
                                console.log("planValue", _0x24a7x1f);
                                console.log("tree_id", _0x24a7x25);
                                2 != _0x24a7x1f && "2" != _0x24a7x1f || socket["emit"]("count_update", window.tronWeb.defaultAddress.base58, _0x24a7x25);
                                _0x24a7x23.users(window.tronWeb.defaultAddress.base58).call().then((_0x24a7x1d) => {
                                    console.log("Usersresult Usersresult", _0x24a7x1d);
                                    let _0x24a7x22 = hexToDec(_0x24a7x1d.id._hex);

                                    if (_0x24a7x22 > 0) {
                                        let _0x24a7x26 = hexToDec(_0x24a7x1d["plan"]._hex),
                                            _0x24a7x27 = hexToDec(_0x24a7x1d["treeId"]._hex),
                                            _0x24a7x28 = tronWeb.address.fromHex(_0x24a7x1d["inviter"]);
                                        _0x24a7x23["viewDetails"](window.tronWeb.defaultAddress.base58, _0x24a7x1f, _0x24a7x25).call().then((_0x24a7x1d) => {
                                            let _0x24a7x29 = tronWeb.address.fromHex(_0x24a7x1d["upline"]);
                                            _0x24a7x23["viewDetails"](_0x24a7x29, _0x24a7x1f, _0x24a7x25).call().then((_0x24a7x2a) => {
                                                let _0x24a7x2b = tronWeb.address.fromHex(_0x24a7x2a["firstDownlines"]),
                                                    _0x24a7x2c = 0;
                                                _0x24a7x2c = 2 == _0x24a7x2b["length"] || "2" == _0x24a7x2b["length"] ? 1 : 0;
                                                let _0x24a7x2d = hexToDec(_0x24a7x1d["regtime"]._hex);
                                                _0x24a7x23.users(_0x24a7x29).call().then((_0x24a7x1d) => {
                                                    let _0x24a7x29 = hexToDec(_0x24a7x1d.id._hex);
                                                    _0x24a7x23.users(_0x24a7x28).call().then((_0x24a7x1d) => {
                                                        let _0x24a7x2a = hexToDec(_0x24a7x1d.id._hex);
                                                        _0x24a7x23["treeUserCount"](_0x24a7x26, _0x24a7x27).call().then((_0x24a7x1d) => {
                                                            let _0x24a7x26 = hexToDec(_0x24a7x1d._hex);
                                                            _0x24a7x23["profitDetails"](_0x24a7x28, _0x24a7x1f, _0x24a7x25).call().then((_0x24a7x1d) => {
                                                                let user_gmail = localStorage.getItem('user_gmail');
                                                                if (user_gmail) user_gmail = user_gmail.trim();
                                                                var nameMatch = user_gmail ? user_gmail.split('@gmail.com') : [];

                                                                let _0x24a7x23 = hexToDec(_0x24a7x1d["_Reinvest"]._hex),
                                                                    _0x24a7x27 = {
                                                                        address: window.tronWeb.defaultAddress.base58,
                                                                        affiliate_id: _0x24a7x29,
                                                                        current_level: 1,
                                                                        ref_id: _0x24a7x2a,
                                                                        level_exp: 0,
                                                                        contract_id: _0x24a7x22,
                                                                        plan_id: 1,
                                                                        buyPlan: _0x24a7x1f,
                                                                        depAmount: _0x24a7x20,
                                                                        tree_id: _0x24a7x25,
                                                                        create_timestamp: _0x24a7x2d,
                                                                        UserCount: _0x24a7x26,
                                                                        _Reinvest: _0x24a7x23,
                                                                        reinvestId: 0,
                                                                        tree_status: _0x24a7x2c,
                                                                        original_ref_id: _0x24a7x24,
                                                                        email: user_gmail && nameMatch.length == 2 && nameMatch[0].length > 0 ? user_gmail : '',
                                                                    };
                                                                console.log("regUserData regUserData", _0x24a7x27);
                                                                $.post(base_urll + "/getMissingID/" + _0x24a7x22 + "/" + _0x24a7x25, function (_0x24a7x1d) {
                                                                    if (console.log("body getMissingID", _0x24a7x1d), 0 != _0x24a7x1d["trim"]() && "0" != _0x24a7x1d["trim"]()) {
                                                                        let _0x24a7x1f = JSON["parse"](_0x24a7x1d),
                                                                            _0x24a7x20 = Object["keys"](_0x24a7x1f)["map"](function (_0x24a7x1d) {
                                                                                return _0x24a7x1f[_0x24a7x1d]
                                                                            });
                                                                        if (_0x24a7x20["length"] > 0) {
                                                                            let _0x24a7x1d = [];
                                                                            (async () => {
                                                                                for (var _0x24a7x1f = 0; _0x24a7x1f < _0x24a7x20["length"]; _0x24a7x1f++) {
                                                                                    const _0x24a7x23 = await _0x24a7x21(_0x24a7x20[_0x24a7x1f]);
                                                                                    if (_0x24a7x1d["push"](_0x24a7x23), _0x24a7x1f === _0x24a7x20["length"] - 1 && (_0x24a7x1d["push"](_0x24a7x27), _0x24a7x1d["length"] > 0)) {
                                                                                        for (var _0x24a7x22 = 0; _0x24a7x22 < _0x24a7x1d["length"]; _0x24a7x22++) {
                                                                                            console.log("regUser regUser", _0x24a7x1d[_0x24a7x22]);
                                                                                            socket["emit"]("regUser", base_urll, _0x24a7x1d[_0x24a7x22]);
                                                                                        }
                                                                                    }
                                                                                }
                                                                            })()
                                                                            setTimeout(() => { location.reload(); }, 3000)
                                                                        }
                                                                    } else {
                                                                        socket["emit"]("regUser", base_urll, _0x24a7x27)
                                                                        setTimeout(() => { location.reload(); }, 3000)
                                                                    }
                                                                })
                                                            }).catch((_0x24a7x1d) => {
                                                                console.log("_Profi err ", _0x24a7x1d)
                                                            })
                                                        }).catch((_0x24a7x1d) => {
                                                            console.log("_UserCount err ", _0x24a7x1d)
                                                        })
                                                    }).catch((_0x24a7x1d) => {
                                                        console.log("Inerr", _0x24a7x1d)
                                                    })
                                                }).catch((_0x24a7x1d) => {
                                                    console.log("Uperr", _0x24a7x1d)
                                                })
                                            }).catch((_0x24a7x1d) => {
                                                console.log("err", _0x24a7x1d)
                                            })
                                        }).catch((_0x24a7x1d) => {
                                            console.log("err", _0x24a7x1d)
                                        })
                                    }
                                }).catch((_0x24a7x1d) => {
                                    console.log("errerrerrerrerrerrerr", _0x24a7x1d)
                                })
                            } else {
                                let _0x24a7x1f = function (_0x24a7x1d) {
                                    for (var _0x24a7x1f = _0x24a7x1d.toString(), _0x24a7x20 = "", _0x24a7x21 = 0; _0x24a7x21 < _0x24a7x1f["length"]; _0x24a7x21 += 2) {
                                        _0x24a7x20 += String["fromCharCode"](parseInt(_0x24a7x1f["substr"](_0x24a7x21, 2), 16))
                                    };
                                    return _0x24a7x20["trim"]()["replace"](/[^a-zA-Z ]/g, "")
                                }(_0x24a7x26["contractResult"][0]);

                                _0x24a7x1d = getvalidationmsg("Transaction") + " " + _0x24a7x1d + " " + _0x24a7x26["receipt"]["result"] + " " + _0x24a7x1f;
                                $(".show_text")["hide"]();
                                stop_loader();
                                $.growl.error({ message: _0x24a7x1d }, {});
                            }
                        } else { console.log(1); }
                    } else { console.log(2); }
                } else {
                    setTimeout(function () {
                        _0x24a7x22(_0x24a7x1d, _0x24a7x1f, _0x24a7x20, _0x24a7x24, _0x24a7x25)
                    }, 15e3)
                }
            }
            (async () => {
                _0x24a7x23.PlanAndTreeDetails(window.tronWeb.defaultAddress.base58, 1, tree_id).call().then(async (_0x24a7x1d) => {
                    if (1 == _0x24a7x1d["PlanStatus"] && 1 == _0x24a7x1d["treeStatus"]) {
                        _0x24a7x25 = 1;
                        let _0x24a7x1d = await _0x24a7x1f(1);
                        _0x24a7x28 = "userAdd", _0x24a7x29 = ""
                    };
                    _0x24a7x23.PlanAndTreeDetails(window.tronWeb.defaultAddress.base58, 2, tree_id).call().then(async (_0x24a7x1d) => {
                        if (1 == _0x24a7x1d["PlanStatus"] && 1 == _0x24a7x1d["treeStatus"]) {
                            _0x24a7x26 = 2;
                            let _0x24a7x1d = await _0x24a7x1f(2);
                            _0x24a7x2a = "userAdd", _0x24a7x2b = ""
                        };
                        _0x24a7x23.PlanAndTreeDetails(window.tronWeb.defaultAddress.base58, 3, tree_id).call().then(async (_0x24a7x1d) => {
                            if (1 == _0x24a7x1d["PlanStatus"] && 1 == _0x24a7x1d["treeStatus"]) {
                                _0x24a7x27 = 3;
                                let _0x24a7x1d = await _0x24a7x1f(3);
                                _0x24a7x2c = "userAdd", _0x24a7x2d = ""
                            };
                            let _0x24a7x20 = {
                                planOne: _0x24a7x25,
                                create_timestamp: _0x24a7x28,
                                m_aff_id: _0x24a7x29,
                                planTwo: _0x24a7x26,
                                two_create_timestamp: _0x24a7x2a,
                                m_two_aff_id: _0x24a7x2b,
                                m_three_aff_id: _0x24a7x2d,
                                planThree: _0x24a7x27,
                                three_create_timestamp: _0x24a7x2c,
                                address: window.tronWeb.defaultAddress.base58
                            };
                            socket["emit"]("planUpdate", base_urll, _0x24a7x20)
                        })
                    })
                })
            })(), 0 != board_one && 0 == board_one_time && _0x24a7x23["viewDetails"](window.tronWeb.defaultAddress.base58, 1, tree_id).call().then((_0x24a7x1d) => {
                socket["emit"]("updatetime", window.tronWeb.defaultAddress.base58, base_urll, 1, hexToDec(_0x24a7x1d["regtime"]._hex)), board_one_time = 1
            }), 0 != board_two && 0 == board_two_time && _0x24a7x23["viewDetails"](window.tronWeb.defaultAddress.base58, 2, tree_id).call().then((_0x24a7x1d) => {
                socket["emit"]("updatetime", window.tronWeb.defaultAddress.base58, base_urll, 2, hexToDec(_0x24a7x1d["regtime"]._hex)), board_two_time = 1
            }), 0 != board_three && 0 == board_three_time && _0x24a7x23["viewDetails"](window.tronWeb.defaultAddress.base58, 3, tree_id).call().then((_0x24a7x1d) => {
                socket["emit"]("updatetime", window.tronWeb.defaultAddress.base58, base_urll, 3, hexToDec(_0x24a7x1d["regtime"]._hex)), board_three_time = 1
            }), 1 == localStorage["getItem"]("isaddlogin") && _0x24a7x20();

            $(document)["on"]("click", ".hplanAniImageBuy", function () {
                if (is_reff_user_a) {
                    let _0x24a7x1d = $(this)["attr"]("data-id");
                    if (localStorage["getItem"]("buy_plan") == _0x24a7x1d) {
                        let _0x24a7x1f = 0;
                        if (1 == (_0x24a7x1f = localStorage["getItem"]("buy_plan") > 1 ? localStorage["getItem"]("reff_count") >= 2 ? 1 : 0 : 1)) {
                            start_loader();
                            $(".show_text")["show"]();
                            let _0x24a7x1f = $(this)["attr"]("data-amount");
                            console.log("tree_id tree_id", tree_id);
                            _0x24a7x23["currentTrxPriceForOneDoller"]().call().then((_0x24a7x20) => {
                                let _0x24a7x21 = hexToDec(_0x24a7x20._hex) / 1e6,
                                    _0x24a7x25 = parseFloat(_0x24a7x1f * _0x24a7x21)["toFixed"](8);

                                var _0x24a7x26 = function (_0x24a7x1d) {
                                    return "0x" + function (_0x24a7x1d) {
                                        var _0x24a7x1f = _0x24a7x1d;
                                        try {
                                            var _0x24a7x20 = new BigNumber(_0x24a7x1f, 10)
                                        } catch (_0x24a7x1d) { return; };
                                        var _0x24a7x21, _0x24a7x22 = _0x24a7x20.toString(16)["toUpperCase"](),
                                            _0x24a7x23 = (_0x24a7x20.toString(2), new BigNumber("-8000000000000000", 16)),
                                            _0x24a7x25 = new BigNumber("7FFFFFFFFFFFFFFF", 16),
                                            _0x24a7x26 = new BigNumber("10000000000000000", 16);
                                        _0x24a7x20["isInteger"]() && _0x24a7x20["gte"](-32768) && _0x24a7x20["lte"](32767) ? (_0x24a7x21 = new BigNumber(_0x24a7x20, 10), _0x24a7x20["lessThan"](0) && (_0x24a7x21 = _0x24a7x20["plus"]("10000", 16)), _0x24a7x21 = _0x24a7x24(_0x24a7x21.toString(16)["toUpperCase"](), 4)) : _0x24a7x20["isInteger"]() && _0x24a7x20["gte"](-2147483648) && _0x24a7x20["lte"](2147483647) ?
                                            (_0x24a7x21 = new BigNumber(_0x24a7x20, 10), _0x24a7x20["lessThan"](0) && (_0x24a7x21 = _0x24a7x20["plus"]("100000000", 16)), _0x24a7x21 = _0x24a7x24(_0x24a7x21.toString(16)["toUpperCase"](), 8)) : _0x24a7x20["isInteger"]() && _0x24a7x20["gte"](_0x24a7x23) && _0x24a7x20["lte"](_0x24a7x25) ? (_0x24a7x21 = new BigNumber(_0x24a7x20, 10), _0x24a7x20["lessThan"](0) && (_0x24a7x21 = _0x24a7x20["plus"](_0x24a7x26)), _0x24a7x21 = _0x24a7x24(_0x24a7x21.toString(16)["toUpperCase"](), 16)) : _0x24a7x21 = "N/A";
                                        return _0x24a7x22
                                    }(new BigNumber(_0x24a7x1d)["mul"](1e6))
                                }(_0x24a7x25);
                                let _0x24a7x27 = Areff_id;
                                console.log("original_ref_id original_ref_id 1", _0x24a7x27);
                                console.log("Areff_id Areff_id 1", Areff_id);
                                console.log("planA_id planA_id", _0x24a7x1d);
                                console.log("pp_value pp_value", _0x24a7x25);
                                console.log("price_value price_value", _0x24a7x26);

                                _0x24a7x1d > 1 ? $.post(base_urll + "/getRefAddr/" + Areff_id + "/" + tree_id, function (_0x24a7x20) {
                                    let _0x24a7x21 = _0x24a7x20["trim"]();
                                    0 != _0x24a7x21 && "0" != _0x24a7x21 &&
                                        _0x24a7x23.PlanAndTreeDetails(_0x24a7x21, _0x24a7x1d, tree_id).call().then(async (_0x24a7x20) => {
                                            1 == _0x24a7x20["PlanStatus"] && 1 == _0x24a7x20["treeStatus"] || (Areff_id = 1);
                                            console.log("Areff_id Areff_id C 1", Areff_id);
                                            $.post(base_urll + "/findFreeRef/" + Areff_id + "/" + _0x24a7x1d + "/" + tree_id,
                                                function (_0x24a7x20) {
                                                    0 != _0x24a7x20["trim"]() && "0" != _0x24a7x20["trim"]() && (Areff_id = _0x24a7x20["trim"]());
                                                    console.log("Areff_id Areff_id C 2", Areff_id);
                                                    _0x24a7x23.Register(_0x24a7x21, Areff_id, _0x24a7x1d, tree_id).send({
                                                        callValue: _0x24a7x26,
                                                    }).then((_0x24a7x20) => {
                                                        (async () => {
                                                            let _0x24a7x21 = await tronWeb.trx.getTransactionInfo(_0x24a7x20),
                                                                _0x24a7x23 = "";
                                                            void (0) !== _0x24a7x21["result"] ? ("FAILED" == _0x24a7x21["result"] && (_0x24a7x23 += "FAILED"), void (0) !== _0x24a7x21["receipt"]["result"] && (_0x24a7x23 = getvalidationmsg("Transaction") + " " + _0x24a7x23 + " " + _0x24a7x21["receipt"]["result"], $(".show_text")["hide"](), stop_loader(), $.growl.error({
                                                                message: _0x24a7x23
                                                            }, {}))) : _0x24a7x22(_0x24a7x20, _0x24a7x1d, _0x24a7x1f, _0x24a7x27, tree_id)
                                                        })()
                                                    }).catch((_0x24a7x1d) => {
                                                        $(".show_text")["hide"](), stop_loader(), $.growl.error({
                                                            message: getvalidationmsg("Sending Transaction Failed !!!")
                                                        }, {})
                                                    })
                                                })
                                        })
                                }) : $.post(base_urll + "/getRefAddr/" + Areff_id + "/" + tree_id, function (_0x24a7x20) {
                                    let _0x24a7x21 = _0x24a7x20["trim"]();

                                    0 != _0x24a7x21 && "0" != _0x24a7x21 && $.post(base_urll + "/findFreeRef/" + Areff_id + "/" + _0x24a7x1d + "/" + tree_id, function (_0x24a7x20) {
                                        0 != _0x24a7x20["trim"]() && "0" != _0x24a7x20["trim"]() && (Areff_id = _0x24a7x20["trim"]());
                                        console.log("Areff_id Areff_id 2", Areff_id);

                                        _0x24a7x23.Register(_0x24a7x21, Areff_id, _0x24a7x1d, tree_id).send({
                                            callValue: _0x24a7x26,
                                        }).then((_0x24a7x20) => {
                                            (async () => {
                                                let _0x24a7x21 = await tronWeb.trx.getTransactionInfo(_0x24a7x20), _0x24a7x23 = "";

                                                void (0) !== _0x24a7x21["result"] ? (
                                                    "FAILED" == _0x24a7x21["result"] && (_0x24a7x23 += "FAILED"),
                                                    void (0) !== _0x24a7x21["receipt"]["result"] && (
                                                        _0x24a7x23 = getvalidationmsg("Transaction") + " " + _0x24a7x23 + " " + _0x24a7x21["receipt"]["result"],
                                                        $(".show_text")["hide"](),
                                                        stop_loader(),
                                                        $.growl.error({ message: _0x24a7x23 }, {})
                                                    )
                                                ) : _0x24a7x22(_0x24a7x20, _0x24a7x1d, _0x24a7x1f, _0x24a7x27, tree_id)
                                            })()
                                        }).catch((_0x24a7x1d) => {
                                            $(".show_text")["hide"]();
                                            stop_loader();
                                            $.growl.error({ message: getvalidationmsg("Sending Transaction Failed !!!") }, {})
                                        })
                                    })
                                })
                            })
                        } else {
                            $.growl.error({
                                message: getvalidationmsg("YMHTDR")
                            }, {})
                        }
                    } else {
                        localStorage["getItem"]("buy_plan") > _0x24a7x1d ? $.growl.error({
                            message: getvalidationmsg("TBAP")
                        }, {}) : 1 == localStorage["getItem"]("buy_plan") ? $.growl.error({
                            message: getvalidationmsg("KRWIB")
                        }, {}) : localStorage["getItem"]("buy_plan") < _0x24a7x1d && $.growl.error({
                            message: getvalidationmsg("KPPB")
                        }, {})
                    }
                } else {
                    $("#joinModal")["modal"]("show")
                }
            })
        }
    } catch (_0x24a7x1d) {
        console.log("e e e", _0x24a7x1d), stop_loader(), $("#info-modal")["modal"]("show")
    };

    function _0x24a7x23(_0x24a7x1d, _0x24a7x1f) {
        $["ajax"]({
            url: base_urll + "/checkUser",
            type: "POST",
            data: {
                address: window.tronWeb.defaultAddress.base58
            },
            dataType: "JSON",
            success: function (_0x24a7x21) {
                console.log("resp resp resp", _0x24a7x21), 1 == _0x24a7x21["isExist"] && (localStorage["setItem"]("isaddlogin", 1), 2 == _0x24a7x21["isSection"] ? (localStorage["setItem"]("isReff", _0x24a7x21["isReff"]), localStorage["setItem"]("Reff", _0x24a7x21.Reff), log_reff_id = _0x24a7x21["isReff"], reff_id = _0x24a7x21["Reff"], user_section_check = 1) : 1 == _0x24a7x21["isSection"] ? (localStorage["setItem"]("isAReff", _0x24a7x21["isReff"]), localStorage["setItem"]("AReff", _0x24a7x21.Reff), Alog_reff_id = _0x24a7x21["isReff"], Areff_id = _0x24a7x21["Reff"], contract_id = _0x24a7x21["contract_id"], id_update = _0x24a7x21["id_update"], board_one = _0x24a7x21["board_one"], board_two = _0x24a7x21["board_two"], board_three = _0x24a7x21["board_three"], board_one_time = _0x24a7x21["board_one_time"], board_two_time = _0x24a7x21["board_two_time"], board_three_time = _0x24a7x21["board_three_time"], board_one_re_id = _0x24a7x21["board_one_cu_re_id"], board_two_re_id = _0x24a7x21["board_two_cu_re_id"], board_three_re_id = _0x24a7x21["board_three_cu_re_id"], user_section_check = 2) : 3 == _0x24a7x21["isSection"] && (user_section_check = 3, localStorage["setItem"]("isReff", _0x24a7x21.BisReff), localStorage["setItem"]("Reff", _0x24a7x21.BReff), log_reff_id = _0x24a7x21["BisReff"], reff_id = _0x24a7x21["BReff"], localStorage["setItem"]("isAReff", _0x24a7x21.AisReff), localStorage["setItem"]("AReff", _0x24a7x21.AReff), Alog_reff_id = _0x24a7x21["AisReff"], Areff_id = _0x24a7x21["AReff"], contract_id = _0x24a7x21["contract_id"], id_update = _0x24a7x21["id_update"], board_one = _0x24a7x21["board_one"], board_two = _0x24a7x21["board_two"], board_three = _0x24a7x21["board_three"], board_one_time = _0x24a7x21["board_one_time"], board_two_time = _0x24a7x21["board_two_time"], board_three_time = _0x24a7x21["board_three_time"], board_one_re_id = _0x24a7x21["board_one_cu_re_id"], board_two_re_id = _0x24a7x21["board_two_cu_re_id"], board_three_re_id = _0x24a7x21["board_three_cu_re_id"]),
                    $("#show_profile")["html"]("<div class='profileTrig'><button class='btn noBoxShadow'><div class='profileContent'><span class='profTrigText'>My Profile</span><span class='profTrigImage'><img src='" + baseurl + "ajqgzgmedscuoc/front/images/home/profileIcon.png' alt='profileIcon' /></span></div></button></div>"), $("#sideMenu")["load"](base_urll + "/load/" + curr_lang + "/" + _0x24a7x1d + "/0/" + _0x24a7x1f + "/" + tree_id, function () {
                        _0x24a7x20(), $("html, body")["animate"]({
                            scrollTop: 0
                        }, "slow")
                    }), stop_loader())
            }
        })
    }

    function _0x24a7x24(_0x24a7x1d, _0x24a7x1f, _0x24a7x20) {
        return _0x24a7x20 = _0x24a7x20 || "0", (_0x24a7x1d += "")["length"] >= _0x24a7x1f ? _0x24a7x1d : new Array(_0x24a7x1f - _0x24a7x1d["length"] + 1)["join"](_0x24a7x20) + _0x24a7x1d
    }
    socket["on"]("regUser", function (_0x24a7x1d) {
        _0x24a7x1d.address == window.tronWeb.defaultAddress.base58 ? ($.growl["notice"]({
            title: getvalidationmsg("Please Note"),
            message: getvalidationmsg("Sending Transaction Success !!!")
        }, {}), localStorage["setItem"]("isaddlogin", 0), _0x24a7x23(_0x24a7x1d["ref_code"], _0x24a7x1d["core_status"])) : localStorage["getItem"]("userAdd") == _0x24a7x1d.address && _0x24a7x23(_0x24a7x1d["ref_code"], _0x24a7x1d["core_status"])
    });
    socket["on"]("ManualregUser", function (_0x24a7x1d) {
        console.log("data data", _0x24a7x1d), _0x24a7x1d.address == window.tronWeb.defaultAddress.base58 && _0x24a7x23(_0x24a7x1d["ref_code"], _0x24a7x1d["core_status"])
    });
    socket["on"]("NewCurrentMissingId", function (_0x24a7x1d) {
        if ("TXh3v9sibCxArCnKstG2y4RVYRcecozvyp" == window.tronWeb.defaultAddress.base58 && _0x24a7x1d["length"] > 0) {
            let _0x24a7x1f = [];
            (async () => {
                for (var _0x24a7x20 = 0; _0x24a7x20 < _0x24a7x1d["length"]; _0x24a7x20++) {
                    const _0x24a7x23 = await _0x24a7x21(_0x24a7x1d[_0x24a7x20]);
                    if (_0x24a7x1f["push"](_0x24a7x23), _0x24a7x20 === _0x24a7x1d["length"] - 1 && _0x24a7x1f["length"] > 0) {
                        for (var _0x24a7x22 = 0; _0x24a7x22 < _0x24a7x1f["length"]; _0x24a7x22++) {
                            socket["emit"]("regUser", base_urll, _0x24a7x1f[_0x24a7x22])
                        }
                    }
                }
            })()
        }
    }), socket["on"]("checkUser", function (_0x24a7x1d) {
        console.log("data data ", _0x24a7x1d["isExist"])
    }), $(document)["on"]("click", ".withdraw_history", function () {
        $("#planb-withhistory-modal")["modal"]("show")
    }), $("#form_gmail")["validate"]({
        rules: {
            email_field: {
                required: !0
            }
        },
        submitHandler: function (_0x24a7x1d) {
            start_loader();
            let _0x24a7x1f = {
                request_type: 1,
                request_value: $("#email_field")["val"](),
                request_e: 0
            };
            socket["emit"]("LinkRequest", base_urll, _0x24a7x1f), $("#form_gmail")[0]["reset"]()
        }
    }), $("#form_whatsapp")["validate"]({
        rules: {
            email_field: {
                required: !0
            },
            number_field: {
                required: !0
            }
        },
        submitHandler: function (_0x24a7x1d) {
            start_loader();
            let _0x24a7x1f = {
                request_type: 2,
                request_value: $("#Wnumber_field")["val"](),
                request_e: $("#wemail_field")["val"]()
            };
            socket["emit"]("LinkRequest", base_urll, _0x24a7x1f), $("#form_whatsapp")[0]["reset"]()
        }
    }), $("#form_telegram")["validate"]({
        rules: {
            email_field: {
                required: !0
            },
            number_field: {
                required: !0
            }
        },
        submitHandler: function (_0x24a7x1d) {
            start_loader();
            let _0x24a7x1f = {
                request_type: 3,
                request_value: $("#Tnumber_field")["val"](),
                request_e: $("#temail_field")["val"]()
            };
            socket["emit"]("LinkRequest", base_urll, _0x24a7x1f), $("#form_telegram")[0]["reset"]()
        }
    }), socket["on"]("LinkRequest", function () {
        $.growl["notice"]({
            title: getvalidationmsg("Please Note"),
            message: "Your request has been submitted successfully !!!"
        }, {}), stop_loader()
    }), $(document)["on"]("click", "svg .text_tag", function () {
        console.log("sdfsdfsdf")
    }), $(document)["on"]("change", ".sin_select", function () {
        location["href"] = base_urll + "/treeDetails/" + $(this)["val"]()
    })
}
localStorage["setItem"]("isaddlogin", ""), localStorage["setItem"]("isReff", ""), localStorage["setItem"]("isAReff", ""), localStorage["setItem"]("Reff", ""), localStorage["setItem"]("AReff", ""), localStorage["setItem"]("one_Reinvest", ""), localStorage["setItem"]("two_Reinvest", ""), localStorage["setItem"]("three_Reinvest", ""), localStorage["setItem"]("buy_plan", ""), localStorage["setItem"]("reff_count", ""), localStorage["setItem"]("address", ""), window["addEventListener"]("message", (_0x24a7x1d) => {
    _0x24a7x1d["data"]["message"] && "setAccount" == _0x24a7x1d["data"]["message"]["action"] && (localStorage["setItem"]("isaddlogin", ""), localStorage["setItem"]("isReff", ""), localStorage["setItem"]("isAReff", ""), localStorage["setItem"]("Reff", ""), localStorage["setItem"]("AReff", ""), localStorage["setItem"]("one_Reinvest", ""), localStorage["setItem"]("two_Reinvest", ""), localStorage["setItem"]("three_Reinvest", ""), localStorage["setItem"]("buy_plan", ""), localStorage["setItem"]("reff_count", ""), $("#show_profile")["html"](""), $("#sideMenu")["html"](""), $(".login-auto")["html"](getvalidationmsg("JOIN")), window.tronWeb && _0x24a7x1d["data"]["message"]["data"].address != localStorage["getItem"]("address") && (localStorage["setItem"]("address", ""), window["location"]["reload"]())), _0x24a7x1d["data"]["message"] && "setNode" == _0x24a7x1d["data"]["message"]["action"] && (PlanAinfo.apiURL != _0x24a7x1d["data"]["message"]["data"]["node"]["eventServer"] ? $("#info-modal")["modal"]("show") : $("#info-modal")["modal"]("hide"))
}), twss = setInterval(function () {
    if ("undefined" != typeof tronWeb) {
        clearInterval(twss);
        tronWebFn();
    }
}, 100)
