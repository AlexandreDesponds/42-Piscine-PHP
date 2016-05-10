var ship = null;
var active = null;
var player = 1;

$(document).ready(function () {
    addEventShip();
    addEvent();
    refreshGame();
    $('#player').change(function () {
        player = $("#player option:selected").val();
        alert("Bonjour player " + player);
    });
});

function addEventShip() {
    $('.ship').each(function () {
        $(this).click(function () {
            aj('ship/info/' + $(this).data('id'), "GET", null, shipShowInfo)
        });
    });
};

function addEventControle() {
    $('#turnLeft').click(function () {
        aj('ship/turn/' + ship + '/-1', "GET", null, refreshGame)
    });
    $('#turnRight').click(function () {
        aj('ship/turn/' + ship + '/1', "GET", null, refreshGame)
    });
    $('.move').each(function () {
        $(this).click(function () {
            aj('ship/move/' + ship + '/' + $(this).data('case'), "GET", null, refreshGame)
        });
    });
    $('#stopMove').click(function () {
        aj('ship/stopMove/' + ship, "GET", null, refreshGame)
    });
    $('#ppShield').click(function () {
        aj('ship/ppShield/' + ship, "GET", null, refreshGame)
    });
    $('#ppSpeed').click(function () {
        aj('ship/ppSpeed/' + ship, "GET", null, refreshGame)
    });
    $('#ppStop').click(function () {
        aj('ship/ppStop/' + ship, "GET", null, refreshGame)
    });
    $('#fireStop').click(function () {
        removeWeaponMap()
        aj('ship/fireStop/' + ship, "GET", null, refreshGame)
    });
    $('.weapon').each(function () {
        $(this).mouseover(function () {
            $(this).mouseout(removeWeaponMap);
            aj('ship/' + ship + '/weapon/' + $(this).data('id') + '/show', "GET", null, addWeaponMap)
        });
        $(this).click(function (){
            aj('ship/' + ship + '/weapon/' + $(this).data('id') + '/fire', "GET", null, refreshGame)
        })
    });
    $('.addCharge').each(function () {
        $(this).click(function (){
            aj('ship/' + ship + '/weapon/' + $(this).data('id') + '/addCharge', "GET", null, refreshGame)
        })
    });
}

function addWeaponMap(data) {
    removeWeaponMap()
    $('.mapCadre').append(data);
}

function removeWeaponMap(data) {
    $('.fire').each(function () {
        $(this).remove();
    });
}

function addEvent() {
    $('#active').click(function () {
        aj('ship/active/' + ship + '/' + player, "GET", null, function(){
            active = ship;
            refreshGame(null);
        })
    });
}

function refreshGame(data){
    aj('ship/html', "GET", null, function (data){
        $('.ship').each(function () {
            $(this).off();
            $(this).remove();
        });
        $('.mapCadre').append(data);
        addEventShip();
    })
    aj('control/' + active + '/' + player, "GET", null, function (data){
        $('#control').empty();
        $('#control').append(data);
        addEventControle();
    })
}


function aj(url, method, data, success) {
    $.ajax({
            method: method,
            url: url,
            data: data
        })
        .done(function (data) {
            success(data);
        })
        .error(function (msg) {
            alert("error ajax : " + msg);
        });
}

function shipShowInfo(data){
    data = jQuery.parseJSON(data);
    $('#info #title').text(data._name);
    $('#info #x').text(data._x);
    $('#info #y').text(data._y);
    $('#info #rotation').text(data._currentRotation);
    ship = data._id;
}