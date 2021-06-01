function getRefine(name, where, token, callback) {
    $.ajax({
        url: "/api/absoulute/refine/" + name,
        type: "GET",
        dataType: "json",
        data: {where: where},
        beforeSend: function (xhr) {
            xhr.setRequestHeader("Content-type", "application/json");
            xhr.setRequestHeader("Authorization", "bearer " + token);
        }
    }).success(function(data){
        callback(data);
    }).fail(function (res, status, error) {
        console.log("getRefine fail...");
        console.log("status: " + res.status);
        console.log("message: " + res.responseText);
    });
}
