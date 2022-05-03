function isBi(n) {
    return (n % 4 == 0) && ((n % 100 != 0) || (n % 400 == 0));
}

function JoursFeries(a, m, c, p) {
    while (m - 11 > 0) {
        m = m - 12;
        a = a + 1;
    }
    var Jouran = new Date(a, "00", "01");
    var FeteTravail = new Date(a, "04", "01");
    var Victoire1945 = new Date(a, "04", "08");
    var FeteNationale = new Date(a, "06", "14");
    var Assomption = new Date(a, "07", "15");
    var Toussaint = new Date(a, "10", "01");
    var Armistice = new Date(a, "10", "11");
    var Noel = new Date(a, "11", "25");
    var G = a % 19;
    var C = Math.floor(a / 100);
    var H = (C - Math.floor(C / 4) - Math.floor((8 * C + 13) / 25) + 19 * G + 15) % 30;
    var I = H - Math.floor(H / 28) * (1 - Math.floor(H / 28) * Math.floor(29 / (H + 1)) * Math.floor((21 - G) / 11));
    var J = (a * 1 + Math.floor(a / 4) + I + 2 - C + Math.floor(C / 4)) % 7;
    var L = I - J;
    var MoisPaques = 3 + Math.floor((L + 40) / 44);
    var JourPaques = L + 28 - 31 * Math.floor(MoisPaques / 4);
    var LundiPaques = new Date(a, MoisPaques - 1, JourPaques + 1);
    var Ascension = new Date(a, MoisPaques - 1, JourPaques + 39);
    var LundiPentecote = new Date(a, MoisPaques - 1, JourPaques + 50);
    var jours = new Array(Jouran, LundiPaques, FeteTravail, Victoire1945, Ascension, LundiPentecote, FeteNationale, Assomption, Toussaint, Armistice, Noel);
    var d = new Date(a, m);
    for (var x = 0; x <= 10; ++x) {
        var test = jours[x];
        if (m == test.getMonth()) {
            var offset = d.getDay();
            if (offset == 0) { offset = 7; }
            var day_of_week = test.getDay();
            if (day_of_week == 4) {
                document.getElementById('day-' + (offset + test.getDate())).style.backgroundColor = p;
            }
            if (day_of_week == 2) {
                document.getElementById('day-' + (offset - 2 + test.getDate())).style.backgroundColor = p;
            }
            document.getElementById('day-' + ((offset - 1) + test.getDate())).style.backgroundColor = c;
        }
    }
}

function customize(sam, dim, a, m) {
    var d = new Date(a, m);
    var day = d.getDay();
    if (day == 0) { day = 7; }
    var offset = day - 1;
    var nblignes = Math.ceil((nbJours(m, a) + offset) / 7);
    var x = 6;
    var y = 7;
    for (var i = 0; i < nblignes; i++) {
        document.getElementById('day-' + x).style.backgroundColor = sam;
        document.getElementById('day-' + y).style.backgroundColor = dim;
        x = x + 7;
        y = y + 7;
        document.getElementById('sam').style.backgroundColor = sam;
        document.getElementById('dim').style.backgroundColor = dim;
    }
}

function colorize(id, color) {
    document.getElementById('day-' + id).style.backgroundColor = color;
}

function nbJours(m, y) {
    var nbday;
    if ((m == 3) || (m == 5) || (m == 8) || (m == 10)) {
        nbday = 30;
    } else {
        nbday = 31;
        if (m == 1) {
            if (y / 4 - parseInt(y / 4) != 0) {
                nbday = 28
            } else {
                nbday = 29
            }
        }
    }
    return nbday;
}


function set_default(n) {
    $(function() {
        var temp = n.getMonth();
        $("#month").val(temp);
    });
}

function getlastsunday(y, m) {
    var d = new Date(y, m + 1, -1);
    d.setDate(d.getDate() - d.getDay());
    return d;
}

function affiche_monthyear(m, a) {
    let month = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    document.getElementById('monthyear').innerHTML = month[m % 12] + " " + a;
}

function build_calendar(m, a) {
    document.getElementById('calendar').innerHTML = "<thead><th>Lun</th><th>Mar</th><th>Mer</th><th>Jeu</th><th>Ven</th><th id='sam'>Sam</th><th id='dim'>Dim</th</thead>";
    var d = new Date(a, m);
    var day = d.getDay();
    if (day == 0) { day = 7; }
    var offset = day - 1;
    var k = 1;
    var nblignes = Math.ceil((nbJours(m, a) + offset) / 7);
    for (var i = 0; i < nblignes; ++i) {
        $("#calendar").append("<tr>");
        for (var x = 0; x < 7; ++x) {
            $("#calendar").append("<td id='day-" + k + "'></td>");

            ++k;
        }
        $("#calendrier").append("</tr>");

    }
    calendar(m, a);
}

function build_calendar_connect(m, a) {
    document.getElementById('calendar').innerHTML = "<thead><th>Lun</th><th>Mar</th><th>Mer</th><th>Jeu</th><th>Ven</th><th id='sam'>Sam</th><th id='dim'>Dim</th</thead>";
    var d = new Date(a, m);
    var day = d.getDay();
    if (day == 0) { day = 7; }
    var offset = day - 1;
    var k = 1;
    var nblignes = Math.ceil((nbJours(m, a) + offset) / 7);
    for (var i = 0; i < nblignes; ++i) {
        $("#calendar").append("<tr>");
        for (var x = 0; x < 7; ++x) {
            $("#calendar").append("<td id='day-" + k + "' onclick ='clickEvent(" + k + ")'></td>");

            ++k;
        }
        $("#calendrier").append("</tr>");

    }
    calendar(m, a);
}

function calendar(m, a) {
    while (m - 11 > 0) {
        m = m - 12;
        a = a + 1;
    }
    var j = 1;;
    var today = new Date;
    var d = new Date(a, m);
    affiche_monthyear(m, a);
    set_default(d);
    var day = d.getDay();
    if (day == 0) { day = 7; }
    var offset = day - 1;
    var nblignes = Math.ceil((nbJours(m, a) + offset) / 7);
    //bordure externe aujourd'hui
    if (m == today.getMonth() && a == today.getFullYear()) {
        document.getElementById('day-' + (offset + today.getDate())).style.border = '5px solid black';
    }
    //remplissage du tableau (calendrier)

    while (j <= nbJours(m, a)) {
        document.getElementById('day-' + day).innerHTML = j;
        ++j;
        ++day;
    }
}