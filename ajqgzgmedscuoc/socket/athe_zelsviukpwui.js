let createError = require("http-errors");
let express = require("express");
let path = require("path");
let cookieParser = require("cookie-parser");
let app = express();
let fs = require("fs");
let bodyParser = require("body-parser");
let request = require("request");
let cron = require("node-cron");
let whitelist = require("./16S6B1FFF");
const TronWeb = require("tronweb");

// const App_info = {
//     admin_address: 'TAgEWnmQG5pAano7Kjb2Lft2U9Ybzngtsg',
//     // plana_addr: 'TRyxuRb1RpAFgsjiGvxeRQyF3QKjeviTgQ',
//     plana_addr: 'TY1Hezj15hKRka9sR9BZ1Bf39dFZs2od7Z',
//     // tree_addr: 'THahAUmCkHeiFrFm9etHN8obrC9BL58HpU',
//     tree_addr: 'TEEXnjyMN34Nzap3okpwpinreefEQ1XxfK',
//     admin_key: '9bc03424a6c9ca52b74a71338bd2722ba2fa2573373e082325a8d878f40b7851',
//     // Api_Url: 'https://api.shasta.trongrid.io',
//     Api_Url: 'https://api.trongrid.io',
//     Base_Url1: '127.0.0.1/trongoogol',
//     Base_Url2: 'http://127.0.0.1/trongoogol',
//     port: '2053',
// }

const App_info = {
    admin_address: 'TEe543qxXh5GwhKNd3QSbvuwiT1MeA3oTj',
    plana_addr: 'TY1Hezj15hKRka9sR9BZ1Bf39dFZs2od7Z',
    tree_addr: 'TEEXnjyMN34Nzap3okpwpinreefEQ1XxfK',
    admin_key: '9bc03424a6c9ca52b74a71338bd2722ba2fa2573373e082325a8d878f40b7851',
    Api_Url: 'https://api.trongrid.io',
    Base_Url1: 'www.trongoogol.io',
    Base_Url2: 'https://www.trongoogol.io',
    port: '2053',
}

app.use(bodyParser.json({ limit: "500mb" }));
app.use(bodyParser.urlencoded({ extended: !0, limit: "500mb" }));

let options = { key: fs.readFileSync("G9xtkC.key"), cert: fs.readFileSync("FkQK.crt") };
let http = require("https").Server(options, app);

const HttpProvider = TronWeb.providers["HttpProvider"];
const fullNode = new HttpProvider(App_info.Api_Url);
const solidityNode = new HttpProvider(App_info.Api_Url);
const eventServer = new HttpProvider(App_info.Api_Url);
const tronWeb_new = new TronWeb(fullNode, solidityNode, eventServer, App_info.admin_key);

app.use(function (_0xd50exd, _0xd50exe, _0xd50exf) {
    let _0xd50ex10 = !0;
    if (void (0) !== _0xd50exd["headers"]["origin"] ? (
        -1 !== whitelist.indexOf(_0xd50exd["headers"]["origin"]) ? (
            _0xd50ex10 = !0,
            _0xd50exe["header"]("Access-Control-Allow-Origin", _0xd50exd["headers"]["origin"])
        ) : (
            _0xd50ex10 = !1, _0xd50exe["header"]("Access-Control-Allow-Origin", "http-errors")
        ),
        "" == _0xd50exd["headers"]["origin"] && (_0xd50ex10 = !1)
    ) : _0xd50ex10 = App_info.Base_Url1 == _0xd50exd["headers"]["host"] || (App_info.Base_Url1 + ":" + App_info.port) == _0xd50exd["headers"]["host"],
        _0xd50exe["header"]("Access-Control-Allow-Methods", "GET, OPTIONS"),
        _0xd50exe["header"]("Access-Control-Allow-Headers", "Content-Type"), _0xd50ex10
    ) { return _0xd50exf() };
    _0xd50exe.send(403)
});
app.get('*', () => {
    return 'get';
})

var customHeaderRequest = request.defaults({ headers: { "User-Agent": "OP" } });
cron.schedule("* * * * *", async () => {
    customHeaderRequest.get(App_info.Base_Url2 + "/en/coinmarketcap/",
        async (err, response, body) => {
            let result = JSON.parse(body);
            console.log("coinmarketcap ==> ", result.state);
        })

    // const planA_con = await tronWeb_new.contract().at(App_info.plana_addr);
    // const planTree_con = await tronWeb_new.contract().at(App_info.tree_addr);
    // // Tree ID CREATE Start
    // planA_con.totalTree().call().then((result1) => {
    //     let total_1 = parseInt(result1._hex, 16);
    //     if (total_1 && Number(total_1)) {

    //         planTree_con.totalTree().call().then((result2) => {
    //             let total_2 = parseInt(result2._hex, 16);
    //             if (total_2 && Number(total_2)) {
    //                 if (total_2 < total_1) {
    //                     planTree_con.TreeInject().send({ feeLimit: 80 * 1e6 }).then((res) => {
    //                         console.log('tree add success', res, ' ==> ', total_1, total_2);
    //                     }).catch((e) => { console.log('error3') })
    //                 }
    //             }
    //         }).catch((e) => { console.log('error2') });
    //     }
    // }).catch((e) => { console.log('error1') });
    // // Tree ID CREATE End
});

cron.schedule("* * * * *", () => {
    customHeaderRequest(App_info.Base_Url2 + "/en/getCurrentMissingId/",
        function (_0xd50exd, _0xd50exe, _0xd50exf) {
            if (!_0xd50exd && 0 != _0xd50exf) {
                let _0xd50exd = JSON.parse(_0xd50exf);
                let _0xd50exe = Object.keys(_0xd50exd).map(function (_0xd50exe) {
                    return _0xd50exd[_0xd50exe];
                });
                io.emit("CurrentMissingId", _0xd50exe)
            }
        });
    customHeaderRequest(App_info.Base_Url2 + "/en/getNewCurrentMissingId/",
        function (_0xd50exd, _0xd50exe, _0xd50exf) {
            if (!_0xd50exd && _0xd50exf != 0) {
                let _0xd50exd = JSON.parse(_0xd50exf);
                let _0xd50exe = Object.keys(_0xd50exd).map(function (_0xd50exe) {
                    return _0xd50exd[_0xd50exe];
                });
                io.emit("NewCurrentMissingId", _0xd50exe)
            }
        })
});

var io = require("socket.io")(http);
io.sockets.on("connection", async function (_0xd50exd) {
    console.log("socket connected");

    _0xd50exd.on("regUser", function (_0xd50exd, _0xd50exe) {
        customHeaderRequest.post(_0xd50exd + "/register/", { formData: _0xd50exe },
            function (_0xd50exd, _0xd50exe, _0xd50exf) {
                console.log("body body ", _0xd50exf);
                !_0xd50exd && _0xd50exe["statusCode"];
            }
        )
    });
    _0xd50exd.on("manualregUser", function (_0xd50exd, _0xd50exe) {
        customHeaderRequest.post(_0xd50exd + "/manual/", { formData: _0xd50exe },
            function (_0xd50exd, _0xd50exe, _0xd50exf) {
                console.log("body body", _0xd50exf);
                !_0xd50exd && _0xd50exe["statusCode"];
            }
        )
    });
    app.post("/socket", function (_0xd50exd, _0xd50exe) {
        console.log("triggersocket connect");
        _0xd50exe.end();
    });
    app.post("/userLogin", function (_0xd50exd, _0xd50exe) {
        var _0xd50exf = _0xd50exd["body"];
        io.emit("regUser", _0xd50exf);
        _0xd50exe.end();
    });
    app.post("/ManualuserLogin", function (_0xd50exd, _0xd50exe) {
        var _0xd50exf = _0xd50exd["body"];
        io.emit("ManualregUser", _0xd50exf);
        _0xd50exe.end();
    });
    _0xd50exd.on("checkUser", function (_0xd50exd, _0xd50exe) {
        var _0xd50exf = { address: _0xd50exe };
        customHeaderRequest.post(_0xd50exd + "/checkUser/", { formData: _0xd50exf },
            function (_0xd50exd, _0xd50exe, _0xd50exf) {
            }
        )
    });
    app.post("/checkUser", function (_0xd50exd, _0xd50exe) {
        var _0xd50exf = _0xd50exd["body"];
        io.emit("checkUser", _0xd50exf);
        _0xd50exe.end();
    });
    _0xd50exd.on("LinkRequest", function (_0xd50exe, _0xd50exf) {
        var _0xd50ex10 = { user_data: JSON.stringify(_0xd50exf) };
        customHeaderRequest.post(_0xd50exe + "/LinkRequest/", { formData: _0xd50ex10 },
            function (_0xd50exe, _0xd50exf, _0xd50ex10) {
                _0xd50exe || 200 != _0xd50exf["statusCode"] || _0xd50exd.emit("LinkRequest")
            }
        )
    });
    _0xd50exd.on("planUpdate", function (_0xd50exd, _0xd50exe) {
        var _0xd50exf = { user_data: JSON["stringify"](_0xd50exe) };
        customHeaderRequest.post(_0xd50exd + "/planUpdate/", { formData: _0xd50exf },
            function (_0xd50exd, _0xd50exe, _0xd50exf) {
                !_0xd50exd && _0xd50exe["statusCode"];
            }
        )
    });
    _0xd50exd.on("updateid", function (_0xd50exd, _0xd50exe, _0xd50exf) {
        let _0xd50ex10 = { user_address: _0xd50exd, con_u_id: _0xd50exf };
        customHeaderRequest.post(_0xd50exe + "/updateid/", { formData: _0xd50ex10 },
            function (_0xd50exd, _0xd50exe, _0xd50exf) {
                !_0xd50exd && _0xd50exe["statusCode"]
            }
        )
    });
    _0xd50exd.on("updatetime", function (_0xd50exd, _0xd50exe, _0xd50exf, _0xd50ex10) {
        let _0xd50ex1c = { user_address: _0xd50exd, plan_id: _0xd50exf, con_u_id: _0xd50ex10 };
        customHeaderRequest.post(_0xd50exe + "/updatetime/", { formData: _0xd50ex1c },
            function (_0xd50exd, _0xd50exe, _0xd50exf) {
                !_0xd50exd && _0xd50exe["statusCode"]
            }
        )
    });
    _0xd50exd.on("reInvestUpdate", function (_0xd50exd, _0xd50exe) {
        customHeaderRequest.post(_0xd50exd + "/reInvestUpdate/", { formData: _0xd50exe },
            function (_0xd50exd, _0xd50exe, _0xd50exf) {
                console.log("body body reInvestUpdate", _0xd50exf), !_0xd50exd && _0xd50exe["statusCode"]
            }
        )
    });
    _0xd50exd.on("count_update", function (_0xd50exd, _0xd50exf) {
        _0xd50exe["partnersCountUpdate"](_0xd50exd, 2, _0xd50exf, 2, 2).send().then((_0xd50exd) => {
            console.log("2s")
        }).catch((_0xd50exd) => {
            console.log("2e", _0xd50exd)
        })
    });
    app.post("/countupdate", function (_0xd50exd, _0xd50exf) {
        var _0xd50ex10 = _0xd50exd["body"];
        _0xd50exe["partnersCountUpdate"](_0xd50ex10.address, 2, _0xd50ex10["tree_id"], 2, 2).send().then((_0xd50exd) => {
            console.log("2s")
        }).catch((_0xd50exd) => {
            console.log("2e", _0xd50exd)
        }), _0xd50exf.end()
    })
});

http.listen(App_info.port, () => {
    return console.log("backend server running on port " + App_info.port)
})