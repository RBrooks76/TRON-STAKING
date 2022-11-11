function hexToDec(_0xb91ax2) {
    return parseInt(_0xb91ax2, 16)
}
function hextostring(_0xb91ax2) {
    for (var _0xb91ax4 = _0xb91ax2.toString(), _0xb91ax5 = "", _0xb91ax6 = 0;
        _0xb91ax6 < _0xb91ax4["length"];
        _0xb91ax6 += 2) {
        _0xb91ax5 += String["fromCharCode"](parseInt(_0xb91ax4["substr"](_0xb91ax6, 2), 16))
    };
    return _0xb91ax5["trim"]()["replace"](/[^a-zA-Z ]/g, "")
}
function start_loader() {
    $("#cover-spin")["show"](0)
}
function stop_loader() {
    $("#cover-spin")["hide"](0)
}
async function tronWebFn() {
    try {
        void (0) !== window.tronWeb && (void (0) !== window.tronWeb && 0 == window.tronWeb.defaultAddress.base58 || $.growl.notice({
            message: "Your tron wallet connected successfully !!! Tron Account : " + window.tronWeb.defaultAddress.base58
        }, {
            position: {
                from: "bottom", align: "left"
            }
        }));
        const _0xb91ax2 = 'TY1Hezj15hKRka9sR9BZ1Bf39dFZs2od7Z';

        let _0xb91ax4 = await tronWeb.contract().at(_0xb91ax2);
        $(document)["on"]("click", ".add_new", function () {
            void (0) !== window.tronWeb ? void (0) !== window.tronWeb && 0 == window.tronWeb.defaultAddress.base58 ? $.growl.error(
                { message: "Please log in to the TRONlink wallet!" }, { position: { from: "bottom", align: "left" } }
            ) : (
                $(".show_text").show(),
                start_loader(),
                async function () {
                    _0xb91ax4.TreeInject().send().then((_0xb91ax2) => {
                        (async () => {
                            let _0xb91ax5 = await tronWeb.trx.getTransactionInfo(_0xb91ax2), _0xb91ax6 = "";

                            void (0) !== _0xb91ax5["result"] ? (
                                "FAILED" == _0xb91ax5["result"] && (_0xb91ax6 += "FAILED"),
                                void (0) !== _0xb91ax5["receipt"]["result"] && (
                                    _0xb91ax6 = "Transaction " + _0xb91ax6 + " " + _0xb91ax5["receipt"]["result"],
                                    $(".show_text")["hide"](), stop_loader(),
                                    $.growl.error({ message: _0xb91ax6 }, {})
                                )
                            ) : async function _0xb91ax2(_0xb91ax5) {
                                let _0xb91ax6 = await tronWeb.trx.getTransactionInfo(_0xb91ax5);
                                console.log("getRegTransactionDetails getRegTransactionDetails", _0xb91ax6);
                                if (void (0) !== _0xb91ax6["receipt"]) {
                                    if (void (0) !== _0xb91ax6["receipt"]["result"]) {
                                        let _0xb91ax2 = "";
                                        if ("FAILED" == _0xb91ax6["result"] && (_0xb91ax2 += "FAILED"), void (0) !== _0xb91ax6["receipt"]["result"]) {
                                            if ("SUCCESS" == _0xb91ax6["receipt"]["result"]) {
                                                $.growl.notice({
                                                    title: "Please Note", message: "Plan A Transaction Success !!!"
                                                }, {});
                                                _0xb91ax4.totalTree().call().then((_0xb91ax2) => {
                                                    let _0xb91ax4 = hexToDec(_0xb91ax2._hex);
                                                    $.ajax({
                                                        url: base_url + "updateTree",
                                                        type: "POST",
                                                        data: { tree_id: _0xb91ax4 },
                                                        dataType: "JSON",
                                                        success: function (_0xb91ax2) {
                                                            location["reload"]();
                                                        }
                                                    })
                                                })
                                            }
                                            else {
                                                let _0xb91ax4 = hextostring(_0xb91ax6["contractResult"][0]);
                                                _0xb91ax2 = "Transaction " + _0xb91ax2 + " " + _0xb91ax6["receipt"]["result"] + " " + _0xb91ax4, $(".show_text")["hide"](), stop_loader(), $.growl.error({
                                                    message: _0xb91ax2
                                                }
                                                    , {
                                                    }
                                                )
                                            }
                                        }
                                    }
                                } else {
                                    setTimeout(function () {
                                        _0xb91ax2(_0xb91ax5)
                                    }
                                        , 15e3)
                                }
                            }(_0xb91ax2)
                        })()
                    }
                    ).catch((_0xb91ax2) => {
                        $(".show_text")["hide"](), stop_loader();
                        $.growl.error({ message: "Sending Transaction Failed !!!" + _0xb91ax2 }, {})
                    })
                }()
            ) : $.growl.error({
                message: "TRONlink not added on your browser"
            })
        }
        )
    }
    catch (_0xb91ax2) {
        $("#info-modal")["modal"]("show")
    }
}
let twss;
navigator["userAgent"]["search"]("Chrome") >= 0 || $.growl.error({
    message: "TRONlink not added on your browser"
}
);
window["addEventListener"]("message", (_0xb91ax2) => {
    _0xb91ax2["data"]["message"] && "setAccount" == _0xb91ax2["data"]["message"]["action"] && window.tronWeb && _0xb91ax2["data"]["message"]["data"]["address"] != localStorage["getItem"]("address") && window["location"]["reload"](), _0xb91ax2["data"]["message"] && "setNode" == _0xb91ax2["data"]["message"]["action"] && ("https://api.trongrid.io" != _0xb91ax2["data"]["message"]["data"]["node"]["eventServer"] ? $("#info-modal")["modal"]("show") : $("#info-modal")["modal"]("hide"))
}
);
twss = setInterval(function () {
    "undefined" != typeof tronWeb && (clearInterval(twss), tronWebFn())
}, 100)