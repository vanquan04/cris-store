$(document).ready(function () {
    $(".title1").click(function () {
        $(".collapse1").toggleClass("show");
        $(".title1 i").toggleClass("fa-rotate-180");
    });

    $(".title2").click(function () {
        $(".collapse2").toggleClass("show");
        $(".title2 i").toggleClass("fa-rotate-180");
    });

    $(".title3").click(function () {
        $(".collapse3").toggleClass("show");
        $(".title3 i").toggleClass("fa-rotate-180");
    });

    $("#category-product-wp .list-item > li")
        .find(".sub-menu")
        .after('<i class="fa-solid fa-angle-right arrow"></i>');

    $(window).scroll(function () {
        if ($(this).scrollTop() != 0) {
            $("#btn-top").stop().fadeIn();
        } else {
            $("#btn-top").stop().fadeOut();
        }
    });
    $("#btn-top").click(function () {
        $("body,html").stop().animate({ scrollTop: 0 }, 800);
    });

    var discountEndTime = new Date("2024-08-31T23:59:59").getTime();

    var countdown = setInterval(function () {
        var now = new Date().getTime();
        var timeLeft = discountEndTime - now;

        var hours = Math.floor(
            (timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
        );
        var minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

        // Sử dụng getElementsByClassName thay thế cho getElementById
        var hourBoxes = document.getElementsByClassName("hour-box");
        var minuteBoxes = document.getElementsByClassName("minute-box");
        var secondBoxes = document.getElementsByClassName("second-box");

        // Lặp qua các phần tử có class tương ứng và cập nhật giá trị
        for (var i = 0; i < hourBoxes.length; i++) {
            hourBoxes[i].innerText = hours < 10 ? "0" + hours : hours;
        }

        for (var i = 0; i < minuteBoxes.length; i++) {
            minuteBoxes[i].innerText = minutes < 10 ? "0" + minutes : minutes;
        }

        for (var i = 0; i < secondBoxes.length; i++) {
            secondBoxes[i].innerText = seconds < 10 ? "0" + seconds : seconds;
        }

        if (timeLeft < 0) {
            clearInterval(countdown);
            // Để tránh hiển thị giá trị âm, bạn có thể đặt giá trị là "00" hoặc xử lý theo ý muốn
            for (var i = 0; i < hourBoxes.length; i++) {
                hourBoxes[i].innerText = "00";
            }
            for (var i = 0; i < minuteBoxes.length; i++) {
                minuteBoxes[i].innerText = "00";
            }
            for (var i = 0; i < secondBoxes.length; i++) {
                secondBoxes[i].innerText = "00";
            }
        }
    }, 1000);
    $(document).ready(function () {
        $(".show-product .owl-carousel").owlCarousel({
            loop: false,
            margin: 10,
            dots: false,
            nav: true,
            responsive: {
                0: {
                    items: 4,
                    nav: true,
                },
                600: {
                    items: 3,
                    nav: false,
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: false,
                },
            },
        });
    });
    $(document).ready(function () {
        $(".wp-same-category .same-category.owl-carousel").owlCarousel({
            loop: false,
            margin: 10,
            dots: false,
            nav: true,
            responsive: {
                0: {
                    items: 1,
                    nav: true,
                },
                600: {
                    items: 3,
                    nav: false,
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: false,
                },
            },
        });
    });

    $(".list_thumb .item img").on("click", function () {
        var detailImageSrc = $(this).attr("src");
        var thumbMainImage = $(".thumb_main img");
        thumbMainImage.css("opacity", 0);
        setTimeout(function () {
            thumbMainImage.attr("src", detailImageSrc);
            thumbMainImage.css("opacity", 1);
        }, 100);
    });
});

var value = 1;
if ($("#num-order").length) {
    var tmpVal = parseInt($("#num-order").attr("value"));
    value = isNaN(tmpVal) ? 1 : tmpVal;
    $("#plus").on("click", function () {
        value++;
        $("#num-order").attr("value", value);
        if (typeof update_href === 'function') update_href(value);
    });
    $("#minus").on("click", function () {
        if (value > 1) {
            value--;
            $("#num-order").attr("value", value);
        }
        if (typeof update_href === 'function') update_href(value);
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const minusButton = document.getElementById("minus");
    const plusButton = document.getElementById("plus");
    const numOrderInput = document.querySelector(".num-order");

    if (minusButton && plusButton && numOrderInput) {
        let currentQty = parseInt(numOrderInput.value) || 1;

        minusButton.addEventListener("click", function () {
            if (currentQty > 1) {
                currentQty--;
                numOrderInput.value = currentQty;
            }
        });

        plusButton.addEventListener("click", function () {
            currentQty++;
            numOrderInput.value = currentQty;
        });

        numOrderInput.addEventListener("change", function () {
            currentQty = Math.max(1, parseInt(numOrderInput.value) || 1);
            numOrderInput.value = currentQty;
        });
    }
});

function selectOption(event, optionId) {
    var buttons = document.getElementsByClassName("option-button");
    event.preventDefault();

    var selInput = document.getElementById("selected_option_id");
    if (selInput) selInput.value = optionId;
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].classList.remove("selected");
    }

    var selectedButton = event.target;
    selectedButton.classList.add("selected");
}

$(document).ready(function () {
    var originalDescOffset = 0;
    if ($(".wp-desc-detail").length) {
        var _off = $(".wp-desc-detail").offset();
        if (_off && typeof _off.top === 'number') {
            originalDescOffset = _off.top;
        }
    }
    $(".desc-detail-full").hide();

    $(".view-mode").click(function () {
        if ($(".desc-detail-full").is(":visible")) {
            $(".desc-detail-demo").show();
            $(".desc-detail-full").hide();
            $(".view-mode").text("Xem thêm");
            $("html, body").animate({ scrollTop: originalDescOffset }, "slow");
        } else {
            $("html, body").animate({ scrollTop: originalDescOffset }, "slow");
            $(".desc-detail-demo").hide();
            $(".desc-detail-full").show();
            $(".view-mode").text("Ẩn bớt");
        }
    });
});

var citis = document.getElementById("city");
var districts = document.getElementById("district");
var wards = document.getElementById("ward");
var Parameter = {
    url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
    method: "GET",
    responseType: "json",
};
if (citis) {
    axios(Parameter).then(function (result) {
        if (result && result.data) renderCity(result.data);
    }).catch(function () {
        // ignore city load failures
    });
}

function renderCity(data) {
    if (!citis) return;

    for (const x of data) {
        citis.options[citis.options.length] = new Option(x.Name, x.Id);
    }

    if (districts && wards) {
        citis.onchange = function () {
            districts.length = 1;
            wards.length = 1;
            if (this.value != "") {
                const result = data.find((n) => n.Id === this.value);
                if (result && Array.isArray(result.Districts)) {
                    for (const k of result.Districts) {
                        districts.options[districts.options.length] = new Option(
                            k.Name,
                            k.Id
                        );
                    }
                }
            }
        };

        districts.onchange = function () {
            wards.length = 1;
            const dataCity = data.find((n) => n.Id === citis.value);
            if (this.value != "" && dataCity && Array.isArray(dataCity.Districts)) {
                const district = dataCity.Districts.find((n) => n.Id === this.value);
                if (district && Array.isArray(district.Wards)) {
                    for (const w of district.Wards) {
                        wards.options[wards.options.length] = new Option(w.Name, w.Id);
                    }
                }
            }
        };
    }
}

if (citis) {
    citis.addEventListener("change", function () {
        var selectedOption = this.options[this.selectedIndex];
        var cityName = selectedOption ? selectedOption.text : '';
        var lbl = document.getElementById("city_label");
        if (lbl) lbl.value = cityName;
    });
}

if (wards) {
    wards.addEventListener("change", function () {
        var selectedOption = this.options[this.selectedIndex];
        var wardName = selectedOption ? selectedOption.text : '';
        var lbl = document.getElementById("ward_label");
        if (lbl) lbl.value = wardName;
    });
}

if (districts) {
    districts.addEventListener("change", function () {
        var selectedOption = this.options[this.selectedIndex];
        var districtName = selectedOption ? selectedOption.text : '';
        var lbl = document.getElementById("district_label");
        if (lbl) lbl.value = districtName;
    });
}

function url(link) {
    var base = typeof BASE_URL !== 'undefined' ? BASE_URL : window.location.origin;
    if (!base.endsWith('/')) {
        base += '/';
    }
    return base + link;
}

