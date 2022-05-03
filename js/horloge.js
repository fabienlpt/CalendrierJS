class Horloge {
    constructor(date_str) {
        this.update(date_str);
    }

    update(date_str) {
        const date_str_split = date_str.split(":");

        this.h = parseInt(date_str_split[0], 10);
        this.m = parseInt(date_str_split[1], 10);
        this.s = parseInt(date_str_split[2], 10);

        this.regulate();
    }

    inc() {
        ++this.s;

        this.regulate();
    }

    regulate() {
        if (this.s == 60) {
            this.s = 0;
            ++this.m;
        }

        if (this.m == 60) {
            this.m = 0;
            ++this.h;
        }

        if (this.h == 24) {
            this.h = 0;
        }
    }
    getlastsunday() {
        var today = new Date();
        var last_sunday_of_march = new Date(2022, 4, -1);
        last_sunday_of_march.setDate(last_sunday_of_march.getDate() - last_sunday_of_march.getDay());
        var last_sunday_of_october = new Date(2022, 10, -1);
        last_sunday_of_october.setDate(last_sunday_of_october.getDate() - last_sunday_of_october.getDay());
        if (today > last_sunday_of_march && today < last_sunday_of_october) {
            return "(heure d'été)";
        } else {
            console.log(today);
            return "(heure d'hiver)";
        }
    }

    insertHorlogeDsDiv(id) {
        document.getElementById(id).innerHTML =
            "il est : " + this.h + ":" + this.m + ":" + this.s + " " + this.getlastsunday();
    }
}

var currentTime = new Date();
let local = new Horloge(currentTime.toLocaleTimeString());

setInterval(function() {
    local.inc();
    local.insertHorlogeDsDiv("HL");
}, 1000);