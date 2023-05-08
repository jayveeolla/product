const path = require('path');

module.exports = {
    resolve: {
        alias: {
            '@': path.resolve('resources/js/Client'),
            '@admin': path.resolve('resources/js/Admin'),
        },
    },
};