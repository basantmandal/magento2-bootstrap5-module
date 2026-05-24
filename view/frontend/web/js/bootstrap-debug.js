define([], function () {
    "use strict";

    return function (config) {
        console.group("HK2 AddBootstrap5 Module");
        console.log("Bootstrap Version:", config.version);
        console.log("CDN Provider:", config.cdn);
        console.groupEnd();
    };
});
