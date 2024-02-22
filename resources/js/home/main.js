$(document).ready(function () {
    const $navMenuBx = $(".navMenuBx");

    $(document).mouseup((ev) => {
        if ($(".navMenuBx").hasClass("open")) {
            if (!$navMenuBx.is(ev.target) && $navMenuBx.has(ev.target).length === 0) {
                $(".navMenuBx").removeClass("open");
                $("body").removeClass("noScroll");
            }
        }
    });

    $(".opnSideMnu").click(function () {
        $(".navMenuBx").addClass("open");
        $("body").addClass("noScroll");
    });
    $(".closSidMnu").click(function () {
        $(".navMenuBx").removeClass("open");
        $("body").removeClass("noScroll");
    });

    if ($(".shopPgFltr").length) {
        $(".shopPgFltr .openFiltrLst").click(function () {
            if ($(".shopPgFltr .shopFltrBdy").hasClass("opened")) {
                $(".shopPgFltr .shopFltrBdy").removeClass("opened , animate__animated , animate__fadeIn");
            } else {
                $(".shopPgFltr .shopFltrBdy").addClass("opened , animate__animated , animate__fadeIn");
            }
        });
    }

    /*********opnUserMnu**********/
    if ($(".opnUserMnu").length) {
        $(".opnUserMnu").click(function () {
            $(".dashMenu").toggleClass("open , animate__animated , animate__fadeIn");
        });
    }

    /************showFactrLnk***********/
    if ($(".showFactrLnk").length) {
        $(".showFactrLnk").click(function () {
            $(".dshfactorLst").hide();
            $(".goToFactrLst").show().addClass("show");
            $(".factrDtailBx").show();
        });

        $(".goToFactrLst").click(function () {
            $(".goToFactrLst").hide().removeClass("show");
            $(".dshfactorLst").show();
            $(".factrDtailBx").hide();
        });

        $(".dashLeft .tablinks").click(function () {
            if ($(".goToFactrLst").hasClass("show")) {
                $(".goToFactrLst").hide().removeClass("show");
                $(".dshfactorLst").show();
                $(".factrDtailBx").hide();
            }
        });
    }

    /******************count-down*********************/
    if ($(".countdown").length) {
        $(".countdown").each(function () {
            var thisTimer = $(this);
            $(function () {
                jQuery.fn.extend({
                    countdown: function () {
                        let hour = 12,
                            min = 23,
                            sec = 41;
                        render(min, sec, hour);

                        const timer = setInterval(() => {
                            if (min == 0 && sec == 0 && hour == 0) {
                                clearInterval(timer);
                                return;
                            }

                            sec = dealSec(sec);
                            min = dealMin(min, sec);
                            hour = dealHour(hour, min);
                            render(hour, min, sec);
                        }, 1000);
                    },
                });

                thisTimer.countdown();
            });

            function dealSec(sec) {
                const timeRange = [...Array(60).keys()].reverse();
                const idxNow = timeRange.indexOf(sec);
                const idxNext = (idxNow + 1) % timeRange.length;
                return timeRange[idxNext];
            }

            function dealMin(min, sec) {
                const timeRange = [...Array(60).keys()].reverse();
                if (sec === 59) {
                    const idxNow = timeRange.indexOf(min);
                    const idxNext = (idxNow + 1) % timeRange.length;
                    return timeRange[idxNext];
                }
                return min;
            }

            function dealHour(hour, min) {
                const timeRange = [...Array(60).keys()].reverse();
                if (min === 59) {
                    const idxNow = timeRange.indexOf(hour);
                    const idxNext = (idxNow + 1) % timeRange.length;
                    return timeRange[idxNext];
                }
                return hour;
            }

            function render(hour, min, sec) {
                hour = ("00" + hour).slice(-2);
                min = ("00" + min).slice(-2);
                sec = ("00" + sec).slice(-2);

                thisTimer.text(`${hour}:${min}:${sec}`);
            }
        });
    }
    /******************count-down*********************/
    if ($(".count_down").length) {
        $(".count_down").each(function () {
            var count_down = $(this);
            $(function () {
                setInterval(function () {
                    var currentDate = new Date().getTime();
                    var giveDate = count_down.attr("giveDate");
                    var eventDate = new Date(giveDate).getTime();

                    var dateDifference = eventDate - currentDate;
                    var seconds = parseInt(dateDifference / 1000);
                    var minutes = parseInt(seconds / 60);
                    var hours = parseInt(minutes / 60);
                    var days = parseInt(hours / 24);
                    var months = parseInt(days / 30);
                    seconds = seconds - minutes * 60;
                    minutes = minutes - hours * 60;
                    hours = hours - days * 24;
                    days = days - months * 30;

                    var showSec = ("00" + seconds).slice(-2);
                    var showMin = ("00" + minutes).slice(-2);
                    var showHour = ("00" + hours).slice(-2);

                    count_down.find(".one").html(days + "روز ");
                    count_down
                        .find(".two")
                        .html(showHour + ":" + showMin + ":" + showSec);
                });
            }, 1000);
        });
    }
    /******************Rating*********************/
    if ($(".rating-stars").length) {
        $(".rating-stars").each(function () {
            var thisRating = $(this);

            thisRating.find(".starsLst li").hover(
                function () {
                    var onStar = parseInt($(this).data("value"), 10);
                    $(this)
                        .parent()
                        .children("li.star")
                        .each(function (e) {
                            if (e < onStar) {
                                $(this).addClass("hoverStar");
                            } else {
                                $(this).removeClass("hoverStar");
                            }
                        });
                },
                function () {
                    $(this)
                        .parent()
                        .children("li.star")
                        .each(function (e) {
                            $(this).removeClass("hoverStar");
                        });
                }
            );

            thisRating.find(".starsLst li").on("click", function () {
                var onStar = parseInt($(this).data("value"), 10);
                var stars = $(this).parent().children("li.star");

                for (i = 0; i < stars.length; i++) {
                    $(stars[i]).removeClass("selected");
                    $(stars[i])
                        .find("span")
                        .removeClass("icon-Vector2")
                        .addClass("icon-Group-2273");
                }

                for (i = 0; i < onStar; i++) {
                    $(stars[i]).addClass("selected");
                    $(".selected")
                        .find("span")
                        .addClass("icon-Vector2")
                        .removeClass("icon-Group-2273");
                }

                var ratingValue = parseInt(
                    $(".starsLst li.selected").last().data("value"),
                    10
                );
                var msg = "";
                msg = "<i>" + ratingValue + "</i>" + " / 5";

                thisRating.find("p").html(msg);
            });
        });
    }

    /*****************date picker*********************/
    if ($("#datepicker1").length) {
        // window.pd = $("#datepicker1").persianDatepicker({
        //     altFormat: "LLLL",
        //     initialValue: false,
        //     observer: true,
        //     format: "YYYY/MM/DD",
        //     timePicker: {
        //         enabled: false,
        //     },
        // });
    }

    if ($(".datepicker-plot-area").length) {
        $(".datepicker-plot-area").click(function () {
            $("#datepicker1").focus();
            $("#datepicker1").parent().addClass("clicked");
        });
    }

    /*****************upload image*********************/
    if ($("#fileInput").length) {
        $("#fileInput").on("change", function () {
            if (this.files[0]) {
                var picture = new FileReader();
                picture.readAsDataURL(this.files[0]);
                picture.addEventListener("load", function (event) {
                    document.getElementById("uploadedImage").setAttribute("src", event.target.result);
                });
            }
        });
    }

    /*rate stars*/
    if ($(".rate").length) {
        var rates = $(".rate");
        for (var i = 0; i < rates.length; i++) {
            var el = $(rates[i]);
            var stars = el.find(".stars");
            var value = el.data("rate");
            var cls = "five";
            if (value < 5) cls = "four";
            if (value < 4) cls = "three";
            if (value < 3) cls = "tow";
            if (value < 2) cls = "one";
            if (value < 1) cls = "";
            stars.addClass(cls);
            if (stars.hasClass(cls)) {
                for (var j = 0; j < value; j++) {
                    var starInput = el.find("span");
                    var starClass = $(starInput[j]);
                    $(starClass).addClass("icon-Vector2").removeClass("icon-Group-2273");
                    el.find("p").find("i").text(value);
                }
            }
        }
    }

    /************revwCostBox*********/
    if ($(".exprtPointBx").length) {
        var $slider = $("#slider");
        var $max_value = $slider.attr("max-value");
        var scale = [0, 20, 40, 60, 80];
        var range = {
            0: "خیلی بد",
            20: "بد",
            40: "متوسط",
            60: "خوب",
            80: "خیلی خوب",
        };

        $.each(range, function (index, val) {
            $(".scale").append("<span>" + val + "</span>");
        });
        $(".scale span:nth-child(1)").addClass("veryGood");
        $(".scale span:nth-child(2)").addClass("good");
        $(".scale span:nth-child(3)").addClass("normal");
        $(".scale span:nth-child(4)").addClass("bad");
        $(".scale span:nth-child(5)").addClass("veryBad");

        $slider.after('<div class="range-slider"><div class="slider-path"></div><div class="slider-fill"></div></div>');

        $(document).on("input", "#slider", function () {
            var $slider_width = $slider.width();
            var $slider_val = $slider.val();
            var $slider_Tag = $slider.val();
            if ($slider_Tag >= 0 && $slider_Tag <= 20) {
                $slider_Tag = "خیلی بد";
            }
            if ($slider_Tag > 20 && $slider_Tag <= 40) {
                $slider_Tag = "بد";
            }
            if ($slider_Tag > 40 && $slider_Tag <= 60) {
                $slider_Tag = "متوسط";
            }
            if ($slider_Tag > 60 && $slider_Tag <= 80) {
                $slider_Tag = "خوب";
            }
            if ($slider_Tag > 80) {
                $slider_Tag = "خیلی خوب";
            }
            $(".scale span").each(function () {
                var thisItem = $(this);
                var $scale_val = thisItem.text();
                if ($scale_val === $slider_Tag) {
                    thisItem.addClass("active");
                    thisItem.siblings().removeClass("active");
                }
            });
            var $slider_fill = ($slider_val / $max_value) * 100;
            $(".slider-fill").css("width", $slider_fill + "%");
        });
    }

    /***************item_Num_box**************/
    $(".item_Num_box").each(function () {
        var thisItem = $(this);
        thisItem.find(".inpuSetZero").click(function () {
            thisItem.parent().parent().remove();
        });
        thisItem.find("span").on("click", function () {
            if (thisItem.find("input").val() === "1") {
                thisItem.find(".minus").hide();
                thisItem.find("button").show();
            } else {
                thisItem.find(".minus").show();
                thisItem.find("button").hide();
            }
        });
    });

    /* element transfer */
    let tagName = "transfer";
    let separator = "@";
    $("*[" + tagName + "]").each(function () {
        let element = $(this);
        let prev = element.prev();
        let parent = element.parent();
        let value = element.attr(tagName);
        $(window)
            .resize(function () {
                var size = $(window).width();
                if (value.indexOf(separator) > 0) {
                    var slice = value.split(separator);
                    var max = parseInt(slice[1]);
                    if (size <= max) {
                        $(slice[0]).append(element);
                    } else {
                        if (prev.length > 0) {
                            element.insertAfter(prev);
                        } else {
                            parent.prepend(element);
                        }
                    }
                } else {
                    $(value).append(element);
                }
            })
            .resize();
    });

    /************************frmInputBx********************/
    if ($(".frmInputBx").length) {
        $(".frmInputBx").each(function () {
            var thisBox = $(this);
            var thisIput = thisBox.find("div");
            var input = thisIput.find("input");
            thisIput.click(function () {
                thisIput.addClass("clicked");
                input.focus();
            });
            // input.blur(function () {
            //     if (input.val().length === 0) {
            //         thisIput.removeClass("clicked");
            //     }
            // });
        });
    }

    function test() {

    }

    /*********************accordion***********************/
    if ($(".accordion").length) {
        $(".accordion-item").each(function () {
            var thisItem = $(this);
            thisItem.click(function () {
                var collapsItem = thisItem.find(".accordion-header");
                if (!collapsItem.find("button").hasClass("collapsed")) {
                    thisItem.addClass("open");
                } else {
                    thisItem.removeClass("open");
                }
            });
        });
    }

    /************swiper***********/
    if ($(".lndTopSldr").length) {
        var swiper = new Swiper(".lndTopSldr .swiper-container", {
            slidesPerView: "auto",
            centeredSlides: true,
            spaceBetween: 10,
            grabCursor: true,
            loop: true,
            autoplay: true,
            autoplayTimeout: 7000,
            navigation: {
                nextEl: ".lndTopSldr .swiper-button-next",
                prevEl: ".lndTopSldr .swiper-button-prev",
            },
        });
        $(".lndTopSldr .swiper-container").hover(
            function () {
                this.swiper.autoplay.stop();
            },
            function () {
                this.swiper.autoplay.start();
            }
        );
    }

    if ($(".newCatSldr").length) {
        var swiper = new Swiper(".newCatSldr .swiper-container", {
            slidesPerView: "auto",
            centeredSlides: true,
            spaceBetween: 1,
            grabCursor: true,
            loop: true,
            autoplay: true,
            autoplayTimeout: 6000,
        });
        $(".newCatSldr .swiper-container").hover(
            function () {
                this.swiper.autoplay.stop();
            },
            function () {
                this.swiper.autoplay.start();
            }
        );
    }

    if ($(".topRanchrLst").length) {
        var swiper = new Swiper(".topRanchrLst .swiper-container", {
            slidesPerView: "auto",
            centeredSlides: true,
            spaceBetween: 20,
            grabCursor: true,
            loop: true,
            autoplay: true,
            autoplayTimeout: 5000,
            navigation: {
                nextEl: ".topRanchrLst .ranchrSldrRght",
                prevEl: ".topRanchrLst .ranchrSldrLft",
            },
        });
        $(".topRanchrLst .swiper-container").hover(
            function () {
                this.swiper.autoplay.stop();
            },
            function () {
                this.swiper.autoplay.start();
            }
        );
    }

    if ($(".aboutSlider").length) {
        var swiper = new Swiper(".aboutSlider .swiper-container", {
            slidesPerView: "auto",
            centeredSlides: true,
            spaceBetween: 1,
            grabCursor: true,
            loop: true,
            autoplay: true,
            autoplayTimeout: 7000,
            navigation: {
                nextEl: ".aboutSlider .swiper-button-next",
                prevEl: ".aboutSlider .swiper-button-prev",
            },
        });
        $(".aboutSlider .swiper-container").hover(
            function () {
                this.swiper.autoplay.stop();
            },
            function () {
                this.swiper.autoplay.start();
            }
        );
    }

    if ($(".prdctPgSldr").length) {
        var swiper = new Swiper(".AdSwiper1", {
            spaceBetween: 10,
            slidesPerView: "auto",
            freeMode: true,
            grabCursor: true,
            watchSlidesProgress: true,
        });
        var swiper2 = new Swiper(".AdSwiper2", {
            spaceBetween: 10,
            slidesPerView: 1,
            grabCursor: true,
            thumbs: {
                swiper: swiper,
            },
        });
    }

    if ($(".dshCrdSldr").length) {
        const AdSwiper1 = document.querySelectorAll(".AdSwiper1");
        const AdSwiper2 = document.querySelectorAll(".AdSwiper2");
        for (i = 0; i < AdSwiper1.length; i++) {
            AdSwiper1[i].classList.add("AdSwiper1-" + i);
            AdSwiper2[i].classList.add("AdSwiper2-" + i);
            var swiperThumbs = new Swiper(".AdSwiper1-" + i, {
                spaceBetween: 10,
                slidesPerView: "auto",
                direction: getDirection(),
                // direction: "vertical",
                on: {
                    resize: function () {
                        swiper.changeDirection(getDirection());
                    },
                },
                freeMode: true,
                grabCursor: true,
                watchSlidesVisibility: true,
                watchSlidesProgress: true,
                observer: true,
                observeParents: true,
            });
            var swiper = new Swiper(".AdSwiper2-" + i, {
                spaceBetween: 10,
                slidesPerView: 1,
                grabCursor: true,
                watchSlidesVisibility: true,
                watchSlidesProgress: true,
                observer: true,
                observeParents: true,
                thumbs: {
                    swiper: swiperThumbs,
                },
            });
        }
    }

    function getDirection() {
        var windowWidth = window.innerWidth;
        var direction = windowWidth <= 575 ? "horizontal" : "vertical";
        console.log(direction);
        return direction;
    }

    /************range-slider*************/
    /* price range*/
    if (document.querySelector(".priceRange")) {
        let priceRange = document.querySelectorAll(".priceRange");
        for (var i = 0; i < priceRange.length; i++) {
            let inputLeft = priceRange[i].querySelector("#input-left");
            let inputRight = priceRange[i].querySelector("#input-right");
            let range = priceRange[i].querySelector(".slider .range");
            let priceFrom = priceRange[i].querySelector(".price-from");
            let priceTo = priceRange[i].querySelector(".price-to");

            function setLeftValue() {
                let _this = inputLeft,
                    min = parseInt(_this.min),
                    max = parseInt(_this.max);

                _this.value = Math.min(parseInt(_this.value), parseInt(inputRight.value) - 50);

                let inptMin = `${_this.value}`;
                priceFrom.textContent = delimitNumbers(inptMin);

                let percent = ((_this.value - min) / (max - min)) * 100;

                range.style.left = percent + "%";
            }

            setLeftValue();

            function setRightValue() {
                let _this = inputRight,
                    min = parseInt(_this.min),
                    max = parseInt(_this.max);

                _this.value = Math.max(parseInt(_this.value), parseInt(inputLeft.value) + 50);

                let inptMax = `${_this.value}`;
                priceTo.textContent = delimitNumbers(inptMax);

                let percent = ((_this.value - min) / (max - min)) * 100;

                range.style.right = 100 - percent + "%";
            }

            function delimitNumbers(str) {
                return (str + "").replace(/\b(\d+)((\.\d+)*)\b/g, function (a, b, c) {
                    return (b.charAt(0) > 0 && !(c || ".").lastIndexOf(".") ? b.replace(/(\d)(?=(\d{3})+$)/g, "$1,") : b) + c;
                });
            }

            setRightValue();
            inputLeft.addEventListener("input", setLeftValue);
            inputRight.addEventListener("input", setRightValue);
            inputLeft.addEventListener("mousedown", (e) => {
                inputLeft.classList.add("active");
            });
            inputLeft.addEventListener("mouseup", (e) => {
                inputLeft.classList.remove("active");
            });

            inputRight.addEventListener("mousedown", (e) => {
                inputRight.classList.add("active");
            });
            inputRight.addEventListener("mouseup", (e) => {
                inputRight.classList.remove("active");
            });
        }
    }

    /*weight range*/
    if (document.querySelector(".weightRng")) {
        let weightRng = document.querySelectorAll(".weightRng");
        for (var i = 0; i < weightRng.length; i++) {
            let inputLeft = weightRng[i].querySelector("#input-left");
            let inputRight = weightRng[i].querySelector("#input-right");
            let range = weightRng[i].querySelector(".slider .range");
            let priceFrom = weightRng[i].querySelector(".price-from");
            let priceTo = weightRng[i].querySelector(".price-to");

            function setLeftValue() {
                let _this = inputLeft,
                    min = parseInt(_this.min),
                    max = parseInt(_this.max);

                _this.value = Math.min(parseInt(_this.value), parseInt(inputRight.value));
                priceFrom.textContent = `${_this.value} KG`;

                let percent = ((_this.value - min) / (max - min)) * 100;

                range.style.left = percent + "%";
            }

            setLeftValue();

            function setRightValue() {
                let _this = inputRight,
                    min = parseInt(_this.min),
                    max = parseInt(_this.max);

                _this.value = Math.max(parseInt(_this.value), parseInt(inputLeft.value));

                priceTo.textContent = `${_this.value} KG`;

                let percent = ((_this.value - min) / (max - min)) * 100;

                range.style.right = 100 - percent + "%";
            }

            setRightValue();
            inputLeft.addEventListener("input", setLeftValue);
            inputRight.addEventListener("input", setRightValue);
            inputLeft.addEventListener("mousedown", (e) => {
                inputLeft.classList.add("active");
            });
            inputLeft.addEventListener("mouseup", (e) => {
                inputLeft.classList.remove("active");
            });

            inputRight.addEventListener("mousedown", (e) => {
                inputRight.classList.add("active");
            });
            inputRight.addEventListener("mouseup", (e) => {
                inputRight.classList.remove("active");
            });
        }
    }

    /*year range*/
    if (document.querySelector(".yearRange")) {
        let yearRange = document.querySelectorAll(".yearRange");
        for (var i = 0; i < yearRange.length; i++) {
            let inputLeft = yearRange[i].querySelector("#input-left");
            let inputRight = yearRange[i].querySelector("#input-right");
            let range = yearRange[i].querySelector(".slider .range");
            let priceFrom = yearRange[i].querySelector(".price-from");
            let priceTo = yearRange[i].querySelector(".price-to");

            function setLeftValue() {
                let _this = inputLeft,
                    min = parseInt(_this.min),
                    max = parseInt(_this.max);

                _this.value = Math.min(parseInt(_this.value), parseInt(inputRight.value));
                priceFrom.textContent = `${_this.value} سال`;

                let percent = ((_this.value - min) / (max - min)) * 100;

                range.style.left = percent + "%";
            }

            setLeftValue();

            function setRightValue() {
                let _this = inputRight,
                    min = parseInt(_this.min),
                    max = parseInt(_this.max);

                _this.value = Math.max(parseInt(_this.value), parseInt(inputLeft.value));

                priceTo.textContent = `${_this.value} سال`;

                let percent = ((_this.value - min) / (max - min)) * 100;

                range.style.right = 100 - percent + "%";
            }

            setRightValue();
            inputLeft.addEventListener("input", setLeftValue);
            inputRight.addEventListener("input", setRightValue);
            inputLeft.addEventListener("mousedown", (e) => {
                inputLeft.classList.add("active");
            });
            inputLeft.addEventListener("mouseup", (e) => {
                inputLeft.classList.remove("active");
            });

            inputRight.addEventListener("mousedown", (e) => {
                inputRight.classList.add("active");
            });
            inputRight.addEventListener("mouseup", (e) => {
                inputRight.classList.remove("active");
            });
        }
    }

    /*milk range*/
    if (document.querySelector(".milkRange")) {
        let milkRange = document.querySelectorAll(".milkRange");
        for (var i = 0; i < milkRange.length; i++) {
            let inputLeft = milkRange[i].querySelector("#input-left");
            let inputRight = milkRange[i].querySelector("#input-right");
            let range = milkRange[i].querySelector(".slider .range");
            let priceFrom = milkRange[i].querySelector(".price-from");
            let priceTo = milkRange[i].querySelector(".price-to");

            function setLeftValue() {
                let _this = inputLeft,
                    min = parseInt(_this.min),
                    max = parseInt(_this.max);

                _this.value = Math.min(parseInt(_this.value), parseInt(inputRight.value));
                priceFrom.textContent = `${_this.value} KG`;

                let percent = ((_this.value - min) / (max - min)) * 100;

                range.style.left = percent + "%";
            }

            setLeftValue();

            function setRightValue() {
                let _this = inputRight,
                    min = parseInt(_this.min),
                    max = parseInt(_this.max);

                _this.value = Math.max(parseInt(_this.value), parseInt(inputLeft.value));

                priceTo.textContent = `${_this.value} KG`;

                let percent = ((_this.value - min) / (max - min)) * 100;

                range.style.right = 100 - percent + "%";
            }

            setRightValue();
            inputLeft.addEventListener("input", setLeftValue);
            inputRight.addEventListener("input", setRightValue);
            inputLeft.addEventListener("mousedown", (e) => {
                inputLeft.classList.add("active");
            });
            inputLeft.addEventListener("mouseup", (e) => {
                inputLeft.classList.remove("active");
            });

            inputRight.addEventListener("mousedown", (e) => {
                inputRight.classList.add("active");
            });
            inputRight.addEventListener("mouseup", (e) => {
                inputRight.classList.remove("active");
            });
        }
    }

    /***************chart**************/
    if ($("#pricLstChrt1").length) {
        new Chart(document.getElementById("pricLstChrt1"), {
            type: "line",
            data: {
                labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10"],
                datasets: [
                    {
                        label: "Series 1", // Name the series
                        data: [10, 100, 105, 105, 105, 135, 100, 100, 100000000, 45, 45], // Specify the data values array
                        fill: false,
                        borderColor: "#EA1237", // Add custom color border (Line)
                        backgroundColor: "#EA1237", // Add custom color background (Points and Fill)
                        borderWidth: 2, // Specify bar border width
                        pointBorderWidth: 3,
                    },
                    // {
                    //     label: "Series 2",
                    //     data: [, , 75, 75, 25, 30, 10, 14, 15],
                    //     fill: false,
                    //     borderColor: "#FF4504",
                    //     backgroundColor: "#FF4504",
                    //     borderWidth: 2,
                    //     pointBorderWidth: 3,
                    // },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                    title: {
                        text: "chart-title",
                        lineHeight: 0,
                        display: false,
                    },
                    tooltip: {
                        bodyColor: "#000",
                        backgroundColor: "#f8f9fa",
                        titleColor: "#380E94",
                        bodySpacing: 5,
                        padding: 15,
                        trigger: "axis",
                    },
                },
                layout: {
                    padding: {
                        top: 25,
                        right: 0,
                    },
                },
                yAxis: {
                    type: "value",
                },
            },
        });
    }

    if ($(".dashBdyChrt").length) {
        const dashBdyChrt = document.querySelectorAll(".dashBdyChrt");

        for (i = 0; i < dashBdyChrt.length; i++) {
            dashBdyChrt[i].classList.add("dashBdyChrt-" + i);
            var itmClsName = "dashBdyChrt-" + i;
            new Chart(document.getElementsByClassName(itmClsName), {
                type: "line",
                data: {
                    labels: ["1", "2", "3", "4", "5", "6", "7", "8", "9", "10"],
                    datasets: [
                        {
                            label: "Series 1", // Name the series
                            data: [, 100, 105, 200, 105, 135, 250, 250, 125], // Specify the data values array
                            fill: false,
                            borderColor: "#0ae977", // Add custom color border (Line)
                            backgroundColor: "#0ae977", // Add custom color background (Points and Fill)
                            borderWidth: 2, // Specify bar border width
                            pointBorderWidth: 3,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false,
                        },
                        title: {
                            text: "chart-title",
                            lineHeight: 0,
                            display: false,
                        },
                        tooltip: {
                            bodyColor: "#000",
                            backgroundColor: "#f8f9fa",
                            titleColor: "#380E94",
                            bodySpacing: 5,
                            padding: 15,
                            trigger: "axis",
                        },
                    },
                    layout: {
                        padding: {
                            top: 25,
                            right: 0,
                        },
                    },
                    yAxis: {
                        type: "value",
                    },
                },
            });
        }
    }

    /*********creditCrd_inpt********/

    const iranianBanks = [
        {
            prefix: "603799",
            name: "بانک ملی ایران",
            image: "http://[::1]:5173/public/img/bank/meli.png",
        },
        {
            prefix: "610433",
            name: "بانک ملت",
            image: "http://[::1]:5173/public/img/bank/mellat.png",
        },
        {
            prefix: "622106",
            name: "بانک پارسیان",
            image: "http://[::1]:5173/public/img/bank/parsian.png",
        },
        {
            prefix: "627353",
            name: "بانک تجارت",
            image: "http://[::1]:5173/public/img/bank/tejarat.png",
        },
        {
            prefix: "589210",
            name: "بانک سپه",
            image: "http://[::1]:5173/public/img/bank/sepah.png",
        },
        {
            prefix: "621986",
            name: "بانک سامان",
            image: "http://[::1]:5173/public/img/bank/saman.png",
        },
        {
            prefix: "639346",
            name: "بانک سینا",
            image: "http://[::1]:5173/public/img/bank/sina.png",
        },
        {
            prefix: "502229",
            name: "بانک پاسارگاد",
            image: "http://[::1]:5173/public/img/bank/pasargad.png",
        },
        {
            prefix: "502908",
            name: "بانک توسعه و تعاون",
            image: "http://[::1]:5173/public/img/bank/tosee.png",
        },
        {
            prefix: "603770",
            name: "بانک کشاورزی",
            image: "http://[::1]:5173/public/img/bank/keshavarzi.png",
        },
        {
            prefix: "589463",
            name: "بانک رفاه",
            image: "http://[::1]:5173/public/img/bank/refah.png",
        },
        {
            prefix: "627381",
            name: "بانک انصار",
            image: "http://[::1]:5173/public/img/bank/ansar.png",
        },
        {
            prefix: "639607",
            name: "بانک سرمایه",
            image: "http://[::1]:5173/public/img/bank/sarmaye.png",
        },
        {
            prefix: "627760",
            name: "پست بانک",
            image: "http://[::1]:5173/public/img/bank/post.png",
        },
        {
            prefix: "606737",
            name: "بانک مهر ایران",
            image: "http://[::1]:5173/public/img/bank/mehr.png",
        },
        {
            prefix: "639599",
            name: "بانک قوامین",
            image: "http://[::1]:5173/public/img/bank/ghavamin.png",
        },
        {
            prefix: "627412",
            name: "بانک اقتصاد نوین",
            image: "http://[::1]:5173/public/img/bank/eghtesad.png",
        },
        {
            prefix: "627488",
            name: "بانک کارآفرین",
            image: "http://[::1]:5173/public/img/bank/karafarin.png",
        },
        {
            prefix: "502806",
            name: "بانک شهر",
            image: "http://[::1]:5173/public/img/bank/shahr.png",
        },
        {
            prefix: "636214",
            name: "بانک آینده",
            image: "http://[::1]:5173/public/img/bank/ayande.png",
        },
        {
            prefix: "639347",
            name: "بانک پاسارگاد",
            image: "http://[::1]:5173/public/img/bank/pasargad.png",
        },
        {
            prefix: "502938",
            name: "بانک دی",
            image: "http://[::1]:5173/public/img/bank/dey.png",
        },
        {
            prefix: "603769",
            name: "بانک صادرات",
            image: "http://[::1]:5173/public/img/bank/saderat.png",
        },
        {
            prefix: "628023",
            name: "بانک مسکن",
            image: "http://[::1]:5173/public/img/bank/maskan.png",
        },
        {
            prefix: "627648",
            name: "بانک توسعه و صادرات",
            image: "http://[::1]:5173/public/img/bank/tosee_saderat.png",
        },
        {
            // image
            prefix: "627961",
            name: "بانک صنعت و معدن",
            image: "http://[::1]:5173/public/img/bank/tosee_saderat.png",
        },
        {
            // image
            prefix: "636214",
            name: "بانک تات",
            image: "http://[::1]:5173/public/img/bank/tosee_saderat.png",
        },
        {
            // image
            prefix: "639370",
            name: "بانک مهر اقتصاد",
            image: "http://[::1]:5173/public/img/bank/tosee_saderat.png",
        },
        {
            // image
            prefix: "606256",
            name: "بانک ملل",
            image: "http://[::1]:5173/public/img/bank/melal.png",
        },
    ];

    if ($(".creditCrd_inpt").length) {
        const ccNumberInput = document.querySelector(".creditCrd_inpt");
        const cardNumberDisplay = document.querySelector(".bankNumber");

        ccNumberInput.addEventListener("keyup", (event) => {
            let maxNum = 16;
            if (event.target.value.length > maxNum) {
                event.target.value = event.target.value.slice(0, maxNum);
            }
            var fourNum = event.target.value.substr(0, 6);

            console.log(fourNum);

            const bank = iranianBanks.find((bank) => bank.prefix === fourNum);

            if (bank) {
                $(".bankName p ").text(bank.name);
                $(".bankName img").attr("src", bank.image);
            } else {
                $(".bankName p ").text("بانک ");
                $(".bankName img").attr("src", "asset/img/bank/shaparak.png");
            }

            ccNumberInput.setAttribute("value", event.target.value);
            cardNumberDisplay.classList.add("filled");
            cardNumberDisplay.innerHTML = event.target.value
                .trim()
                .split("")
                .map((num) => `<span>${num}</span>`)
                .join("");
        });
    }
    (() => {
        // check for dark mode

        // let logo = document.getElementById('logo')
        // let logo_footer = document.getElementById('logo_footer')
        const theme = localStorage.getItem("theme");

        if (!theme) return;
        document.documentElement.setAttribute("data-theme", theme);
        if (theme === "dark") {
            const toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
            toggleSwitch.checked = true;
            // logo.src = 'http://localhost:8000/img/logo/logo_light.svg'
            // logo_footer.src = 'http://localhost:8000/img/logo/logo_light.svg'
        }

    })();
    /*********show-factor-list*********/
    if ($(".showFactr").length) {
        $(".showFactr").click(function () {
            $(".fctrTabBx").find(".tabFactrLnk").addClass("active");
            $(".fctrTabBx")
                .find(".tabFactrLnk")
                .parent()
                .siblings()
                .find("a")
                .removeClass("active")
            $(".fctrTabBx").find(".tabcontent").hide();
            $(".fctrTabBx").find(".factorTab").show();

        })
    }


    /*********switch-mood*********/
    if ($(".theme-switch-wrapper").length) {
        const toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');

        function switchTheme(e) {
            // let logo = document.getElementById('logo')
            // let logo_footer = document.getElementById('logo_footer')
            if (e.target.checked) {
                document.documentElement.setAttribute("data-theme", "dark");
                localStorage.setItem("theme", "dark");
                // logo.src = 'http://localhost:8000/img/logo/logo_light.svg'
                // logo_footer.src = 'http://localhost:8000/img/logo/logo_light.svg'
            } else {
                document.documentElement.setAttribute("data-theme", "light");
                localStorage.setItem("theme", "light");
                // logo.src = 'http://localhost:8000/img/logo/logo_dark.svg'
                // logo_footer.src = 'http://localhost:8000/img/logo/logo_dark.svg'
            }
        }

        toggleSwitch.addEventListener("change", switchTheme, false);
    }
});

$(window).scroll(function () {
    if ($(window).scrollTop() >= 300 && $(window).scrollTop() + $(window).height() != $(document).height() + 20) {
        $(".headerSec")
            .css({
                position: "fixed",
                left: 0,
                top: 0,
            })
            .addClass("fixed , animate__animated , animate__fadeInDown");
    } else {
        $(".headerSec")
            .css({
                position: "relative",
                top: "auto",
                left: "auto",
            })
            .removeClass("fixed , animate__animated , animate__fadeInDown");
    }
});
