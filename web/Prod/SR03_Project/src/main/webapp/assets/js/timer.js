var start;

function aff(elt) {
    if (elt < 10) {
        return "0" + elt;
    } else {
        return elt;
    }
}

function chrono() {
    var end = new Date();
    var diff = end - start;
    diff = new Date(diff);
    var sec = diff.getSeconds();
    var min = diff.getMinutes();
    var hr = diff.getHours() - 1;
    var result = aff(hr) + ":" + aff(min) + ":" + aff(sec);
    $("#chrono").html(result);
    $("[id$='input_chrono']").val(sec + 60 * min + 3600 * hr);
}

$(document).ready(function () {
    start = new Date();
    chrono();
    setInterval(chrono, 800);
});

console.log("chargé !")