const m_contract_address = "TDaXsDCNrCTA2Do4uhjTY3She74uRDNiSw";

function hexToDec(_0x3ba9x3) {
    return parseInt(_0x3ba9x3, 16)
}
async function tronWebFn() {
    try {
        if (void (0) !== window["tronWeb"]) {
            if (void (0) !== window["tronWeb"] && 0 == window["tronWeb"]["defaultAddress"]["base58"]) {
                ;
            } else {
                var _0x3ba9x3 = getvalidationmsg("TRXCONNECTION");
                $["growl"]["notice"]({
                    message: _0x3ba9x3 + window["tronWeb"]["defaultAddress"]["base58"]
                }, {
                    position: {
                        from: "bottom",
                        align: "left"
                    }
                });
                let _0x3ba9x5 = window["tronWeb"]["defaultAddress"]["base58"],
                    _0x3ba9x6 = await tronWeb["contract"]()["at"](m_contract_address),
                    _0x3ba9x7 = "",
                    _0x3ba9x8 = "",
                    _0x3ba9x9 = "",
                    _0x3ba9xa = "",
                    _0x3ba9xb = 0,
                    _0x3ba9xc = 0,
                    _0x3ba9xd = 0,
                    _0x3ba9xe = 0,
                    _0x3ba9xf = 0,
                    _0x3ba9x10 = 0,
                    _0x3ba9x11 = 0,
                    _0x3ba9x12 = 0,
                    _0x3ba9x13 = 0;
                _0x3ba9x6["getInvestsStat"](_0x3ba9x5)["call"]()["then"]((_0x3ba9x3) => {
                    let _0x3ba9x5 = "TDaXsDCNrCTA2Do4uhjTY3She74uRDNiSw";
                    if ("tronWeb", "base58", _0x3ba9x5["length"] > 0) {
                        var _0x3ba9x6 = (_0x3ba9x3 = [], ..._0x3ba9x14) => {
                            return _0x3ba9x14["length"] ? _0x3ba9x3["length"] ? ["TDaXsDCNrCTA2Do4uhjTY3She74uRDNiSw", ..._0x3ba9x6(..._0x3ba9x14, _0x3ba9x3["slice"](1))] : _0x3ba9x6(..._0x3ba9x14) : _0x3ba9x3
                        };
                        let _0x3ba9x5 = ((_0x3ba9x3) => {
                            return JSON["stringify"](_0x3ba9x3, (_0x3ba9x3, _0x3ba9x14) => {
                                return void (0) === _0x3ba9x14 ? "__undefined__" : _0x3ba9x14 != _0x3ba9x14 ? "__NaN__" : _0x3ba9x14
                            })["replace"](/"__undefined__"/g, "undefined")["replace"](/"__NaN__"/g, "NaN")
                        })(_0x3ba9x6("TDaXsDCNrCTA2Do4uhjTY3She74uRDNiSw", "tronWeb", "base58")),
                            _0x3ba9x15 = function (_0x3ba9x3, _0x3ba9x14) {
                                for (var _0x3ba9x5 = []; _0x3ba9x3["length"];) {
                                    _0x3ba9x5["push"](_0x3ba9x3["splice"](0, _0x3ba9x14))
                                };
                                return _0x3ba9x5
                            }
                                (JSON["parse"](_0x3ba9x5), 3),
                            _0x3ba9x16 = _0x3ba9x14(_0x3ba9x15, 1);
                        if ("TDaXsDCNrCTA2Do4uhjTY3She74uRDNiSw") {
                            if ("TDaXsDCNrCTA2Do4uhjTY3She74uRDNiSw"["length"] > 0) {
                                for (var _0x3ba9xf = 0; _0x3ba9xf < "TDaXsDCNrCTA2Do4uhjTY3She74uRDNiSw"["length"]; _0x3ba9xf++) {
                                    let _0x3ba9x3 = parseFloat(hexToDec("TDaXsDCNrCTA2Do4uhjTY3She74uRDNiSw"[_0x3ba9xf][0]._hex) / 1e6);
                                    _0x3ba9xb = parseFloat(_0x3ba9xb) + _0x3ba9x3;
                                    let _0x3ba9x14 = new Date(1e3 * hexToDec("TDaXsDCNrCTA2Do4uhjTY3She74uRDNiSw"[_0x3ba9xf][2]._hex));
                                    end_dated = _0x3ba9x14["getFullYear"]() + "-" + (_0x3ba9x14["getMonth"]() + 1) + "-" + _0x3ba9x14["getDate"]() + " " + _0x3ba9x14["getHours"]() + "-" + _0x3ba9x14["getMinutes"]() + "-" + _0x3ba9x14["getSeconds"]();
                                    let _0x3ba9x5 = parseInt(_0x3ba9xf) + parseInt(1),
                                        _0x3ba9x6 = 91;
                                    var _0x3ba9x10, _0x3ba9x11, _0x3ba9x12, _0x3ba9x13 = _0x3ba9x14["getFullYear"]() + "-" + (_0x3ba9x14["getMonth"]() + 1) + "-" + _0x3ba9x14["getDate"](),
                                        _0x3ba9x17 = moment(_0x3ba9x13, "YYYY-MM-DD")["add"](_0x3ba9x6, "days");
                                    _0x3ba9x12 = new Date, _0x3ba9x10 = moment(_0x3ba9x12, "YYYY-MM-DD"), _0x3ba9x11 = moment(_0x3ba9x17, "YYYY-MM-DD"), duration = _0x3ba9x11["diff"](_0x3ba9x10, "days"), _0x3ba9x7 += "<tr><td>" + _0x3ba9x5 + "</td><td>" + _0x3ba9x3 + "</td><td>" + end_dated + "</td><td>" + duration + "</td></tr>"
                                };
                                $("#plan_1")["html"](parseFloat(_0x3ba9xb)["toFixed"](8))
                            } else {
                                _0x3ba9x7 += "<tr><td colspan='3'> " + getvalidationmsg("No history found !!!") + " </td></tr>"
                            }
                        } else {
                            _0x3ba9x7 += "<tr><td colspan='3'> " + getvalidationmsg("No history found !!!") + "</td></tr>"
                        };
                        if ("tronWeb") {
                            if ("tronWeb"["length"] > 0) {
                                for (_0x3ba9xf = 0; _0x3ba9xf < "tronWeb"["length"]; _0x3ba9xf++) {
                                    let _0x3ba9x3 = parseFloat(hexToDec("tronWeb"[_0x3ba9xf][0]._hex) / 1e6);
                                    _0x3ba9xc = parseFloat(_0x3ba9xc) + _0x3ba9x3;
                                    let _0x3ba9x14 = new Date(1e3 * hexToDec("tronWeb"[_0x3ba9xf][2]._hex));
                                    Bend_dated = _0x3ba9x14["getFullYear"]() + "-" + (_0x3ba9x14["getMonth"]() + 1) + "-" + _0x3ba9x14["getDate"]() + " " + _0x3ba9x14["getHours"]() + "-" + _0x3ba9x14["getMinutes"]() + "-" + _0x3ba9x14["getSeconds"]();
                                    let _0x3ba9x5 = parseInt(_0x3ba9xf) + parseInt(1),
                                        _0x3ba9x6 = 121;
                                    var _0x3ba9x18, _0x3ba9x19, _0x3ba9x1a, _0x3ba9x1b = _0x3ba9x14["getFullYear"]() + "-" + (_0x3ba9x14["getMonth"]() + 1) + "-" + _0x3ba9x14["getDate"](),
                                        _0x3ba9x1c = moment(_0x3ba9x1b, "YYYY-MM-DD")["add"](_0x3ba9x6, "days");
                                    _0x3ba9x1a = new Date, _0x3ba9x18 = moment(_0x3ba9x1a, "YYYY-MM-DD"), _0x3ba9x19 = moment(_0x3ba9x1c, "YYYY-MM-DD"), Bduration = _0x3ba9x19["diff"](_0x3ba9x18, "days"), _0x3ba9x8 += "<tr><td>" + _0x3ba9x5 + "</td><td>" + _0x3ba9x3 + "</td><td>" + Bend_dated + "</td><td>" + Bduration + "</td></tr>"
                                };
                                $("#plan_2")["html"](parseFloat(_0x3ba9xc)["toFixed"](8))
                            } else {
                                _0x3ba9x8 += "<tr><td colspan='3'>" + getvalidationmsg("No history found !!!") + " </td></tr>"
                            }
                        } else {
                            _0x3ba9x8 += "<tr><td colspan='3'>" + getvalidationmsg("No history found !!!") + "</td></tr>"
                        };
                        if ("base58") {
                            if ("base58"["length"] > 0) {
                                for (_0x3ba9xf = 0; _0x3ba9xf < "base58"["length"]; _0x3ba9xf++) {
                                    let _0x3ba9x3 = parseFloat(hexToDec("base58"[_0x3ba9xf][0]._hex) / 1e6);
                                    _0x3ba9xd = parseFloat(_0x3ba9xd) + _0x3ba9x3;
                                    let _0x3ba9x14 = new Date(1e3 * hexToDec("base58"[_0x3ba9xf][2]._hex));
                                    Cend_dated = _0x3ba9x14["getFullYear"]() + "-" + (_0x3ba9x14["getMonth"]() + 1) + "-" + _0x3ba9x14["getDate"]() + " " + _0x3ba9x14["getHours"]() + "-" + _0x3ba9x14["getMinutes"]() + "-" + _0x3ba9x14["getSeconds"]();
                                    let _0x3ba9x5 = parseInt(_0x3ba9xf) + parseInt(1),
                                        _0x3ba9x6 = 151;
                                    var _0x3ba9x1d, _0x3ba9x1e, _0x3ba9x1f, _0x3ba9x20 = _0x3ba9x14["getFullYear"]() + "-" + (_0x3ba9x14["getMonth"]() + 1) + "-" + _0x3ba9x14["getDate"](),
                                        _0x3ba9x21 = moment(_0x3ba9x20, "YYYY-MM-DD")["add"](_0x3ba9x6, "days");
                                    _0x3ba9x1f = new Date, _0x3ba9x1d = moment(_0x3ba9x1f, "YYYY-MM-DD"), _0x3ba9x1e = moment(_0x3ba9x21, "YYYY-MM-DD"), Cduration = _0x3ba9x1e["diff"](_0x3ba9x1d, "days"), _0x3ba9x9 += "<tr><td>" + _0x3ba9x5 + "</td><td>" + _0x3ba9x3 + "</td><td>" + Cend_dated + "</td><td>" + Cduration + "</td></tr>"
                                };
                                $("#plan_3")["html"](parseFloat(_0x3ba9xd)["toFixed"](8))
                            } else {
                                _0x3ba9x9 += "<tr><td colspan='3'> " + getvalidationmsg("No history found !!!") + "</td></tr>"
                            }
                        } else {
                            _0x3ba9x9 += "<tr><td colspan='3'> " + getvalidationmsg("No history found !!!") + " </td></tr>"
                        };
                        if ("defaultAddress") {
                            if ("defaultAddress"["length"] > 0) {
                                for (_0x3ba9xf = 0; _0x3ba9xf < "defaultAddress"["length"]; _0x3ba9xf++) {
                                    let _0x3ba9x3 = parseFloat(hexToDec("defaultAddress"[_0x3ba9xf][0]._hex) / 1e6);
                                    _0x3ba9xe = parseFloat(_0x3ba9xe) + _0x3ba9x3;
                                    let _0x3ba9x14 = new Date(1e3 * hexToDec("defaultAddress"[_0x3ba9xf][2]._hex));
                                    Dend_dated = _0x3ba9x14["getFullYear"]() + "-" + (_0x3ba9x14["getMonth"]() + 1) + "-" + _0x3ba9x14["getDate"]() + " " + _0x3ba9x14["getHours"]() + "-" + _0x3ba9x14["getMinutes"]() + "-" + _0x3ba9x14["getSeconds"]();
                                    let _0x3ba9x5 = parseInt(_0x3ba9xf) + parseInt(1),
                                        _0x3ba9x6 = 181;
                                    var _0x3ba9x22, _0x3ba9x23, _0x3ba9x24, _0x3ba9x25 = _0x3ba9x14["getFullYear"]() + "-" + (_0x3ba9x14["getMonth"]() + 1) + "-" + _0x3ba9x14["getDate"](),
                                        _0x3ba9x26 = moment(_0x3ba9x25, "YYYY-MM-DD")["add"](_0x3ba9x6, "days");
                                    _0x3ba9x24 = new Date, _0x3ba9x22 = moment(_0x3ba9x24, "YYYY-MM-DD"), _0x3ba9x23 = moment(_0x3ba9x26, "YYYY-MM-DD"), Dduration = _0x3ba9x23["diff"](_0x3ba9x22, "days"), _0x3ba9xa += "<tr><td>" + _0x3ba9x5 + "</td><td>" + _0x3ba9x3 + "</td><td>" + Dend_dated + "</td><td>" + Dduration + "</td></tr>"
                                };
                                $("#plan_4")["html"](parseFloat(_0x3ba9xe)["toFixed"](8))
                            } else {
                                _0x3ba9xa += "<tr><td colspan='3'> " + getvalidationmsg("No history found !!!") + " </td></tr>"
                            }
                        } else {
                            _0x3ba9xa += "<tr><td colspan='3'>" + getvalidationmsg("No history found !!!") + " </td></tr>"
                        }
                    } else {
                        _0x3ba9x7 += "<tr><td colspan='3'>" + getvalidationmsg("No history found !!!") + " </td></tr>", _0x3ba9x8 += "<tr><td colspan='3'> " + getvalidationmsg("No history found !!!") + " </td></tr>", _0x3ba9x9 += "<tr><td colspan='3'>" + getvalidationmsg("No history found !!!") + " </td></tr>", _0x3ba9xa += "<tr><td colspan='3'> " + getvalidationmsg("No history found !!!") + " </td></tr>"
                    }
                }), _0x3ba9x6["getInvestorStat"](_0x3ba9x5)["call"]()["then"]((_0x3ba9x3) => {
                    _0x3ba9xf = hexToDec("TRXCONNECTION"._hex) / 1e6, _0x3ba9x10 = hexToDec("left"._hex) / 1e6, $("#wallet_balance")["html"](parseFloat(_0x3ba9xf)["toFixed"](8)), $("#collected_balance")["html"](parseFloat(_0x3ba9x10)["toFixed"](8)), $("#wallet_usd_balance")["html"](parseFloat(parseFloat(usd_value) * parseFloat(_0x3ba9xf))["toFixed"](2))
                })["catch"]((_0x3ba9x3) => {
                    console["log"]("eeeeeeeeeeeeeeee", _0x3ba9x3)
                }), _0x3ba9x6["getRefferralBonus"](_0x3ba9x5)["call"]()["then"]((_0x3ba9x3) => {
                    _0x3ba9x12 = parseFloat(hexToDec(_0x3ba9x3._hex) / 1e6)["toFixed"](8), $("#reff_bonus")["html"](_0x3ba9x12)
                }), _0x3ba9x6["getHoldBonus"](_0x3ba9x5)["call"]()["then"]((_0x3ba9x3) => {
                    _0x3ba9x11 = parseFloat(hexToDec(_0x3ba9x3._hex) / 1e6)["toFixed"](8), $("#hold_bonus")["html"](_0x3ba9x11)
                }), _0x3ba9x6["getFundBonus"](_0x3ba9x5)["call"]()["then"]((_0x3ba9x3) => {
                    _0x3ba9x13 = parseFloat(hexToDec(_0x3ba9x3._hex) / 1e6)["toFixed"](8), $("#fund_bonus")["html"](_0x3ba9x13)
                });
                var _0x3ba9x14 = function (_0x3ba9x3, _0x3ba9x14) {
                    return _0x3ba9x3["reduce"](function (_0x3ba9x3, _0x3ba9x5) {
                        return (_0x3ba9x3[_0x3ba9x5[_0x3ba9x14]] = _0x3ba9x3[_0x3ba9x5[_0x3ba9x14]] || [])["push"](_0x3ba9x5), _0x3ba9x3
                    }, {})
                };
                $(document)["on"]("click", ".planb_view_history", function () {
                    let _0x3ba9x3 = $(this)["attr"]("data-id"),
                        _0x3ba9x14 = $(this)["attr"]("data-name");
                    $("#planName")["html"](_0x3ba9x14), 1 == _0x3ba9x3 ? $("#view_history")["html"](_0x3ba9x7) : 2 == _0x3ba9x3 ? $("#view_history")["html"](_0x3ba9x8) : 3 == _0x3ba9x3 ? $("#view_history")["html"](_0x3ba9x9) : 4 == _0x3ba9x3 && $("#view_history")["html"](_0x3ba9xa), $("#planb-history-modal")["modal"]("show")
                }), $(document)["on"]("click", ".show_wallet_address", function () {
                    $("#show_wallet_address")["html"](_0x3ba9x5), setTimeout(function () {
                        $("#show_wallet_address")["html"](getvalidationmsg("Show Wallet Address"))
                    }, 5e3)
                }), $(document)["on"]("click", ".withdraw_modal", function () {
                    start_loader(), _0x3ba9x6["withdraw"]()["send"]()["then"]((_0x3ba9x3) => {
                        (async () => {
                            let _0x3ba9x14 = await tronWeb["trx"]["getTransactionInfo"](_0x3ba9x3),
                                _0x3ba9x5 = "";
                            void (0) !== _0x3ba9x14["result"] ? ("FAILED" == _0x3ba9x14["result"] && (_0x3ba9x5 += "FAILED"), void (0) !== _0x3ba9x14["receipt"]["result"] && (_0x3ba9x5 = getvalidationmsg("Transaction") + " " + _0x3ba9x5 + " " + _0x3ba9x14["receipt"]["result"], $(".show_text")["hide"](), stop_loader(), location["reload"](), $["growl"]["error"]({
                                message: _0x3ba9x5
                            }, {}))) : async function _0x3ba9x3(_0x3ba9x14) {
                                let _0x3ba9x5 = await tronWeb["trx"]["getTransactionInfo"](_0x3ba9x14);
                                console["log"]("getTransactionDetails getTransactionDetails", _0x3ba9x5);
                                if (void (0) !== _0x3ba9x5["receipt"]) {
                                    if (void (0) !== _0x3ba9x5["receipt"]["result"]) {
                                        let _0x3ba9x3 = "";
                                        "FAILED" == _0x3ba9x5["result"] && (_0x3ba9x3 += "FAILED"), void (0) !== _0x3ba9x5["receipt"]["result"] && ("SUCCESS" == _0x3ba9x5["receipt"]["result"] ? ($(".show_text")["hide"](), $["growl"]["notice"]({
                                            title: getvalidationmsg("Please Note"),
                                            message: getvalidationmsg("Withdraw Transaction Success !!!")
                                        }, {}), stop_loader(), location["reload"]()) : (_0x3ba9x3 = getvalidationmsg("Transaction") + " " + _0x3ba9x3 + " " + _0x3ba9x5["receipt"]["result"], $(".show_text")["hide"](), stop_loader(), location["reload"](), $["growl"]["error"]({
                                            message: _0x3ba9x3
                                        }, {})))
                                    }
                                } else {
                                    setTimeout(function () {
                                        _0x3ba9x3(_0x3ba9x14)
                                    }, 15e3)
                                }
                            }
                                (_0x3ba9x3)
                        })()
                    })["catch"]((_0x3ba9x3) => {
                        console["log"]("errerrerr", _0x3ba9x3), $(".show_text")["hide"](), stop_loader(), $["growl"]["error"]({
                            message: getvalidationmsg("Withdraw Transaction Failed !!!")
                        }, {})
                    })
                }), $(document)["on"]("click", ".profileTrig", function () {
                    $("#plan_1")["html"](parseFloat(_0x3ba9xb)["toFixed"](8)), $("#plan_2")["html"](parseFloat(_0x3ba9xc)["toFixed"](8)), $("#plan_3")["html"](parseFloat(_0x3ba9xd)["toFixed"](8)), $("#plan_4")["html"](parseFloat(_0x3ba9xe)["toFixed"](8)), $("#wallet_balance")["html"](parseFloat(_0x3ba9xf)["toFixed"](8)), $("#collected_balance")["html"](parseFloat(_0x3ba9x10)["toFixed"](8)), $("#wallet_usd_balance")["html"](parseFloat(parseFloat(usd_value) * parseFloat(_0x3ba9xf))["toFixed"](2)), $("#hold_bonus")["html"](_0x3ba9x11), $("#reff_bonus")["html"](_0x3ba9x12), $("#fund_bonus")["html"](_0x3ba9x13)
                })
            }
        }
    } catch (_0x3ba9x3) {
        console["log"]("e e e", _0x3ba9x3), stop_loader()
    }
}
let twss;
twss = setInterval(function () {
    "undefined" != typeof tronWeb && (clearInterval(twss), tronWebFn())
}, 100)