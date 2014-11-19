var mysql = require('mysql'),
    config = require('../config/app.js'),
    Q = require('q');

var pool =  mysql.createPool(config.db);

var q = function(sql, params) {
    var deferred = Q.defer();

    pool.getConnection(function(error, connection) {
        if (error) {
            deferred.reject(error);
        } else {
            connection.query(sql, params, function(error, result) {
                if (error) {
                    deferred.reject(error);
                } else {
                    deferred.resolve(result);
                }
                connection.release();
            });
        }
    });

    return deferred.promise;
};

module.exports.query = q;