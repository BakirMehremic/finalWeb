var OrdersService = {
     getReport: function (successCallback, errorCallback) {
        RestClient.get("/orders/report", successCallback, errorCallback);
    }
}
