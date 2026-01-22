import MonaCreateModuleDefault from "./default.js";
import PopupModule from "../../../../../../../template/js/module/PopupModule.js";
import SwiperModule from "../../../../../../../template/js/module/SwiperModule.js";
// export default function filterForm() {
//   $(document).ready(function () {
//     function scrollToID(id, speed, number) {
//       const offSet = $("header").outerHeight();
//       const section = $(id).offset();
//       const targetOffset = section.top - offSet - number;
//       $("html,body").animate({ scrollTop: targetOffset }, speed);
//     }

//     function Filter(loading, formData) {
//       if (loading.hasClass("processing")) {
//         $.ajax({
//           url: mona_ajax_url.ajaxURL,
//           type: "POST",
//           data: {
//             action: "mona_filter_product",
//             formData: formData,
//           },
//           success: function (response) {
//             loading.removeClass("processing");
//             if (response.success == true) {
//               let postsList = response.data.data;
//               let postsHtml = "";
//               for (let i = 0; i < postsList.length; i++) {
//                 postsHtml += postsList[i].data;
//               }

//               $(".monaPostsList").html(postsHtml);
//             } else {
//               let postsListNone = response.data.data;

//               $(".monaPostsList").html(postsListNone);
//             }
//           },
//           error: function (e) {
//             loading.removeClass("processing");
//           },
//           beforeSend: function () {
//             loading.addClass("processing");
//           },
//         });
//       }
//     }

//     let timeout;
//     if ($(window).width() > 1070) {
//       $(document).on("input change", ".mona-input-fiter", function (e) {
//         let form = $(this).closest("#product-filter");
//         clearTimeout(timeout);
//         timeout = setTimeout(function () {
//           form.submit();
//         }, 2000);
//       });
//     }

//     $(document).on("submit", "#product-filter", function (e) {
//       e.preventDefault();
//       let loading = $(".monaPostsList").addClass("processing");
//       let formData = $(this).serialize();
//       scrollToID(".monaPostsList", 500, 200);
//       Filter(loading, formData);
//     });
//   });
// }

export default function filterForm() {
    const speed = 800;
    const hash = window.location.hash;
    if ($(hash).length) scrollToID(hash, speed);
    $(".btn-scroll").on("click", function(e) {
        e.preventDefault();
        const href = $(this).find("> a").attr("href") || $(this).attr("href");
        const id = href.slice(href.lastIndexOf("#"));
        if ($(id).length) {
            scrollToID(id, speed);
        } else {
            window.location.href = href;
        }
    });

    function scrollToID(id, speed, number) {
        const offSet = $("header").outerHeight();
        const section = $(id).offset();
        const targetOffset = section.top - offSet - number;
        $("html,body").animate({ scrollTop: targetOffset }, speed);
    }

    function getPostListPaged(
        flag,
        $this,
        formdata,
        processing,
        action,
        paged = 1
    ) {
        if (!processing.hasClass("processing")) {
            $.ajax({
                url: mona_ajax_url.ajaxURL,
                type: "post",
                data: {
                    action: "mona_ajax_pagination_posts",
                    formdata: formdata,
                    paged: paged,
                    action_layout: action,
                    action_flag: flag,
                    nonce: mona_ajax_url.nonce,
                },
                error: function(request) {
                    processing.removeClass("processing");
                },
                beforeSend: function(response) {
                    processing.addClass("processing");
                },
                success: function(result) {
                    if (result.success) {
                        console.log("success");
                        if (
                            result.data.action_return == "reload" &&
                            result.data.posts_html != ""
                        ) {
                            $this.find(".monaPostsList").html(result.data.posts_html);
                            scrollToID("." + result.data.scroll, 500, 200);
                        } else if (
                            result.data.action_return == "loadmore" &&
                            result.data.posts_html != ""
                        ) {
                            $this.find(".monaLoadMoreJS").remove();
                            $this.find(".monaPostsList").append(result.data.posts_html);
                        }
                    }
                    processing.removeClass("processing");
                    PopupModule();
                    SwiperModule();
                    //js page product
                    let tabPro = document.querySelectorAll(".tabJSPro");
                    if (tabPro) {
                        tabPro.forEach((t) => {
                            let tBtn = t.querySelectorAll(".tabBtnPro");
                            let tPanel = t.querySelectorAll(".tabPanelPro");

                            // for tab
                            if (tBtn.length !== 0 && tPanel.length === tBtn.length) {
                                tBtn[0].classList.add("active");
                                tPanel[0].classList.add("open");
                                $(tPanel[0]).slideDown();

                                for (let i = 0; i < tBtn.length; i++) {
                                    tBtn[i].addEventListener("click", showPanel);

                                    function showPanel(e) {
                                        e.preventDefault();
                                        for (let a = 0; a < tBtn.length; a++) {
                                            tBtn[a].classList.remove("active");
                                            tPanel[a].classList.remove("open");
                                            $(tPanel[a]).slideUp(0);
                                        }
                                        tBtn[i].classList.add("active");
                                        tPanel[i].classList.add("open");
                                        $(tPanel[i]).slideDown(0);
                                    }
                                }
                            }
                        });
                    }
                },
            });
        }
    }

    function getPostListPagedHome(
        flag,
        $this,
        formdata,
        processing,
        action,
        paged = 1
    ) {
        if (!processing.hasClass("processing")) {
            $.ajax({
                url: mona_ajax_url.ajaxURL,
                type: "post",
                data: {
                    action: "mona_ajax_pagination_home",
                    formdata: formdata,
                    paged: paged,
                    action_layout: action,
                    action_flag: flag,
                    nonce: mona_ajax_url.nonce,
                },
                error: function(request) {
                    processing.removeClass("processing");
                },
                beforeSend: function(response) {
                    processing.addClass("processing");
                },
                success: function(result) {
                    if (result.success) {
                        // console.log("success");
                        if (
                            result.data.action_return == "reload" &&
                            result.data.posts_html != ""
                        ) {
                            $this.find(".monaPostsList").html(result.data.posts_html);
                            // scrollToID("." + result.data.scroll, 500, 200);
                        } else if (
                            result.data.action_return == "loadmore" &&
                            result.data.posts_html != ""
                        ) {
                            $this.find(".monaLoadMoreJS").remove();
                            $this.find(".monaPostsList").append(result.data.posts_html);
                        }
                    }
                    processing.removeClass("processing");
                    PopupModule();
                    //swiper
                    var prodSlides = document.querySelectorAll(".pro-slider-js");
                    prodSlides.forEach(function(prodSlide) {
                        var prodSwiper = new Swiper(prodSlide.querySelector(".proSwiper"), {
                            spaceBetween: 0,
                            slidesPerView: "1",
                            pagination: {
                                el: prodSlide.querySelector(".swiper-pagination"),
                                clickable: true,
                            },
                        });
                    });
                    //js page product
                    let tabPro = document.querySelectorAll(".tabJSPro");
                    if (tabPro) {
                        tabPro.forEach((t) => {
                            let tBtn = t.querySelectorAll(".tabBtnPro");
                            let tPanel = t.querySelectorAll(".tabPanelPro");

                            // for tab
                            if (tBtn.length !== 0 && tPanel.length === tBtn.length) {
                                tBtn[0].classList.add("active");
                                tPanel[0].classList.add("open");
                                $(tPanel[0]).slideDown();

                                for (let i = 0; i < tBtn.length; i++) {
                                    tBtn[i].addEventListener("click", showPanel);

                                    function showPanel(e) {
                                        e.preventDefault();
                                        for (let a = 0; a < tBtn.length; a++) {
                                            tBtn[a].classList.remove("active");
                                            tPanel[a].classList.remove("open");
                                            $(tPanel[a]).slideUp(0);
                                        }
                                        tBtn[i].classList.add("active");
                                        tPanel[i].classList.add("open");
                                        $(tPanel[i]).slideDown(0);
                                    }
                                }
                            }
                        });
                    }
                },
            });
        }
    }
    $(document).ready(function() {
        $("#formPostAjax").keydown(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    });
    $(document).on("submit", "#formPostAjax", function(e) {
        var $this = $(this);
        var formdata = $this.serialize();
        var processing = $this.find(".monaPostsList");
        var layout = $this.data("layout");
        getPostListPaged(true, $this, formdata, processing, layout);
    });

    document.addEventListener("DOMContentLoaded", function() {
        var resetButton = document.querySelector(
            ".pcollec-fi-inner-bot button.link"
        );
        if (resetButton) {
            resetButton.addEventListener("click", function(event) {
                event.preventDefault();
                var recheckItems = document.querySelectorAll(".recheck-item");
                recheckItems.forEach(function(item) {
                    item.classList.remove("active");
                });
            });
        }
    });

    $(document).on("change", ".monaFilterJS", function(e) {
        var $this = $(this).closest("form");
        var layout = $this.data("layout");
        var formdata = $(this).closest("form").serialize();
        var processing = $(this).closest("form").find(".monaPostsList");
        getPostListPaged(false, $this, formdata, processing, layout);
    });

    $(document).on("change", ".monaFilterJS-home", function(e) {
        var $this = $(this).closest("form");
        var layout = $this.data("layout");
        var formdata = $(this).closest("form").serialize();
        var processing = $(this).closest("form").find(".monaPostsList");
        getPostListPagedHome(false, $this, formdata, processing, layout);
    });

    $(document).on("click", ".monaClickPostAjax", function(e) {
        var $this = $(this).closest("form");
        var layout = $this.data("layout");
        var formdata = $(this).closest("form").serialize();
        var processing = $(this).closest("form").find(".monaPostsList");
        getPostListPaged(false, $this, formdata, processing, layout);
    });
    $(document).on(
        "click",
        ".pagination-posts-ajax a.page-numbers",
        function(e) {
            e.preventDefault();
            var $this = $(this);
            var form = $this.closest("form");
            var pagination = $this.closest(".pagination-posts-ajax");
            var pagedText = $this.text();
            var paged = pagedText.match(/\d+/);
            if (!paged) {
                if (!$this.hasClass("next")) {
                    var pagedCurrentText = parseInt(
                        pagination.find(".page-numbers.current").text()
                    );
                    var paged = pagedCurrentText - 1;
                } else {
                    var pagedCurrentText = parseInt(
                        pagination.find(".page-numbers.current").text()
                    );
                    var paged = pagedCurrentText + 1;
                }
            } else {
                paged = paged[0];
            }
            var formdata = $this.closest("form").serialize();
            var processing = $this.closest(".monaPostsList");
            getPostListPaged(true, form, formdata, processing, "reload", paged);
        }
    );
    $(document).on("click", ".monaLoadMoreJS", function(e) {
        e.preventDefault();
        var $this = $(this);
        var paged = $this.data("paged");
        var form = $this.closest("form");
        var formdata = $this.closest("form").serialize();
        getPostListPaged(true, form, formdata, $this, "loadmore", paged);
    });
}