function refreshParking() {
    let eID = "jwParkingGetParkings";
    let occupied = "";
    let ajaxRefresh = 0;
    let $jwGetParking = jQuery("#jwGetParking");
    let $jwGetFreeParking = jQuery("#jwGetFreeParking");
    if (!$jwGetParking.length) {
        eID = "jwParkingGetFreeParking";
        ajaxRefresh = parseInt($jwGetFreeParking.data("ajaxRefresh"));
    } else {
        occupied = $jwGetParking.data("occupied");
        ajaxRefresh = parseInt($jwGetParking.data("ajaxRefresh"));
    }

    if (ajaxRefresh) {
        jQuery.ajax({
            type: "GET",
            url: "/index.php",
            dataType: "json",
            data: {
                eID: eID
            }
        }).done(function(data) {
            if ($jwGetParking.length) {
                let $freeParkingRow;
                for (let i = 0; i < data.length; i++) {
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
}
refreshParking();
