function refreshParking() {
    var eID = "jwparkingGetParkings";
    var occupied = "";
    var ajaxRefresh = 0;
    var $jwGetParking = jQuery("#jwGetParking");
    var $jwGetFreeParking = jQuery("#jwGetFreeParking");
    if (!$jwGetParking.length) {
        eID = "jwparkingGetFreeParking";
        ajaxRefresh = $jwGetFreeParking.data("ajaxRefresh");
    } else {
        occupied = $jwGetParking.data("occupied");
        ajaxRefresh = $jwGetParking.data("ajaxRefresh");
    }

    jQuery.ajax({
        type: "GET",
        url: "/index.php",
        dataType: "json",
        data: {
            eID: eID
        }
    }).done(function(data) {
        if ($jwGetParking.length) {
            var $freeParkingRow;
            for (var i = 0; i < data.length; i++) {
                $freeParkingRow = jQuery(".jwGetFreeParking-" + data[i].uid);
                if ($freeParkingRow.length) {
                    if (data[i].free) {
                        $freeParkingRow.text(data[i].free);
                    } else {
                        $freeParkingRow.text(occupied);
                    }
                }
            }
        } else {
            $jwGetFreeParking.text(data);
        }
    }).fail(function(xhr, error) {
        console.log(error);
    });
    setTimeout(function() {
        refreshParking()
    }, ajaxRefresh);
}
refreshParking();
