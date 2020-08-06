function equipe_icon() {
    /*
        Il est impossible de mettre des icons dans les boutons d'action
        Pour palier à cela, on utilise des bouttons avec la class icon_submit dans le même formulaire
        En cliquant sur l'icon_submit, le boutton submit sera cliqué
    */
    $(".icon_submit").each(function () {
        // On masque les input submit
        $(this).parent().children("[type='submit']").attr('style', 'display:none');
        // On équipe les icon_submit
        $(this).attr('onclick', " $(this).parent().children(\"[type='submit']\").click();");
    });
}


function equipe_icon_alert() {
    /*
        Semmblable à equipe_icon sauf qu'on affiche un message d'alerte avant.
        La classe doit être icon_alert_submit et le message d'alerte doit être contenu dans l'attribut data-alert
     */
    $(".icon_alert_submit").each(function () {
        // On masque les input submit
        $(this).parent().children("[type='submit']").attr('style', 'display:none');
        // On équipe les icon_alert_submit
        $(this).attr('onclick', "alert_submit(this);");
    });
}


function alert_submit(appelant) {
    $(appelant).attr('id', 'will_submit');

    var node = $("<div></div>").attr({
        'id': 'alert',
        'style': "position: fixed;top: 0; left:auto; width:100%; min-height:100vh;z-index:4; margin:0;padding:0;display:flex;"
    });
    var tampon = "<div class='echape' style='background-color: rgba(0,0,0,0.5);flex: 1;'></div>";
    var html = tampon;
    html += "<div style='display: flex;flex-direction:column!important'>";
    html += tampon;
    html += "<div style='background-color: rgba(0,0,0,0.5);flex: 1;'>";
    html += "<div style='background:white;border-radius:10px; padding:20px;min-width:150px;text-align: center'>";
    html += $(appelant).data('alert'); // Le message
    html += "<div style='margin-top:20px;display: flex;justify-content:space-around!important'>";
    html += "<button type='button' class ='btn btn-success' >Oui</button>";
    html += "<button type='button' class ='btn btn-danger echape'>Non</button>";
    html += "</div>";
    html += "</div>";
    html += "</div>";
    html += tampon;
    html += "</div>";
    html += tampon;

    node.html(html);

    node.find('.btn-success').attr('onclick', "lunch_button();");
    node.find('.echape').attr('onclick', "$('#will_submit').removeAttr('id');$('#alert').remove();");

    $("body").append(node);
}


function lunch_button() {
    $("#will_submit").parent().children("[type='submit']").click();
    $('#alert').remove();
}


$(document).ready(function () {
    equipe_icon();
    equipe_icon_alert();
});

function hide_box() {
    /* Fonction pour les show_box quand on les cache */
    $('[id$="hide_box_input"]').click();
    $('#show_box').remove();
}