define(['jquery', 'jquery/ui','mage/translate'],function($) {

    return function (config) {
        $(function() {
            $(".regionStore").change(function () {
                $(".cityStore").html("");
                $(".locationStore").html("");

                let location = config.location;

                if (Number($(".regionStore").val()) !== 0) {
                    let count = 0;
                    let city = config.city;

                    $(".cityStore").append('<option value="0">-- '+$.mage.__("All Ward")+' --</option>');
                    for (let i = 0; i < city.length; i++) {
                        if (Number(city[i]["region_id"]) === Number($(".regionStore").val())) {
                            $(".cityStore").append('<option value="'+city[i]["id"]+'">'+city[i]["label"]+'</option>');
                        }
                    }

                    for (let i = 0; i < location.length; i++) {
                        if (Number(location[i]["region_id"]) === Number($(".regionStore").val())) {
                            $(".locationStore").append(`
                            <div>
                                <span>`+location[i]["phone"]+`</span>
                                <span>`+location[i]["address"]+`</span>
                            </div>
                            `);
                            count++;
                        }
                    }

                    $(".locationCount").html(count);
                } else {
                    $(".cityStore").append('<option value="0">-- '+$.mage.__("All Ward")+' --</option>');
                    for (let i = 0; i < location.length; i++) {

                        $(".locationStore").append(`
                            <div>
                                <span>`+location[i]["phone"]+`</span>
                                <span>`+location[i]["address"]+`</span>
                            </div>
                            `);
                    }
                    $(".locationCount").html(location.length);
                }
            });

            $(".cityStore").change(function() {
                $(".locationStore").html("");

                let location = config.location;

                if (Number($(".cityStore").val()) !== 0) {
                    let count = 0;

                    for (let i = 0; i < location.length; i++) {
                        if (Number(location[i]["region_id"]) === Number($(".regionStore").val()) && Number(location[i]["city_id"]) === Number($(".cityStore").val())) {
                            $(".locationStore").append(`
                            <div>
                                <span>`+location[i]["phone"]+`</span>
                                <span>`+location[i]["address"]+`</span>
                            </div>
                            `);
                            count++;
                        }
                    }

                    $(".locationCount").html(count);
                } else {
                    if (Number($(".regionStore").val()) === 0) {
                        for (let i = 0; i < location.length; i++) {

                            $(".locationStore").append(`
                            <div>
                                <span>`+location[i]["phone"]+`</span>
                                <span>`+location[i]["address"]+`</span>
                            </div>
                            `);
                        }

                        $(".locationCount").html(location.length);
                    } else {
                        let count = 0;

                        for (let i = 0; i < location.length; i++) {
                            if (Number(location[i]["region_id"]) === Number($(".regionStore").val())) {
                                $(".locationStore").append(`
                            <div>
                                <span>`+location[i]["phone"]+`</span>
                                <span>`+location[i]["address"]+`</span>
                            </div>
                            `);
                                count++;
                            }
                        }

                        $(".locationCount").html(count);
                    }
                }
            });
        });
    };

});
