window.Application = {
    Components: {},
    /**
     * Front controller application, init all plugin
     * and event handler
     */

    addComponent: function (name, object) {
        this.Components[name] = object;
        object.run();
        if (object.resizeFunctions != null && typeof(object.resizeFunctions) == "function") {
            $(window).on("resize", function () {
                object.resizeFunctions();
            });
        }
        if (object.scrollFunctions != null && typeof(object.scrollFunctions) == "function") {
            $(window).on("scroll", function () {
                object.scrollFunctions();
            });
        }
    }
};

Date.prototype.getWeek = function () {
    var target  = new Date(this.valueOf());
    var dayNr   = (this.getDay() + 6) % 7;
    target.setDate(target.getDate() - dayNr + 3);
    var firstThursday = target.valueOf();
    target.setMonth(0, 1);
    if (target.getDay() != 4) {
        target.setMonth(0, 1 + ((4 - target.getDay()) + 7) % 7);
    }
    return 1 + Math.ceil((firstThursday - target) / 604800000);
}

