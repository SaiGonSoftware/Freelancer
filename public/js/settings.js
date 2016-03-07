! function(o) {
    "use strict";
    o(window).load(function() {
        o("#loader").fadeOut("slow")
    }), o(document).ready(function() {
        function e(e) {
            o(e.target).prev(".panel-heading").find("i.indicator").toggleClass("glyphicon-chevron-down glyphicon-chevron-up")
        }
        o(window).scroll(function() {
            var e = o(window).scrollTop();
            e > 50 ? o("#header-background").slideDown(300) : o("#header-background").slideUp(300)
        }), o(".fm-button").click(function() {
            "0px" == o("header").css("left") && o("header").stop().animate({
                left: "240px"
            }, 300), "240px" == o("header").css("left") && o("header").stop().animate({
                left: "0px"
            }, 300)
        }), o(document).width() > 480 ? (o("#searchbox").css({
            opacity: "0",
            position: "relative",
            top: "0",
            width: "0"
        }), o("#search a").click(function() {
            "0" == o("#searchbox").css("opacity") && o("#searchbox").stop().animate({
                opacity: "1",
                position: "relative",
                top: "0",
                width: "200px"
            }, 300), "1" == o("#searchbox").css("opacity") && o("#searchbox").stop().animate({
                opacity: "0",
                position: "relative",
                top: "0",
                width: "0px"
            }, 300)
        })) : (o("#searchbox").css({
            opacity: "0",
            position: "absolute",
            top: "-62px",
            width: "100%"
        }), o("#search a").click(function() {
            "0" == o("#searchbox").css("opacity") && o("#searchbox").stop().animate({
                position: "absolute",
                top: "50px",
                opacity: "1",
                width: "100%"
            }, 300), "1" == o("#searchbox").css("opacity") && o("#searchbox").stop().animate({
                position: "absolute",
                top: "-62px",
                opacity: "0",
                width: "100%"
            }, 300)
        })), o(window).resize(function() {
            o(document).width() > 480 ? (o("#searchbox").css({
                opacity: "0",
                position: "relative",
                top: "0",
                width: "0"
            }), o("#search a").click(function() {
                "0" == o("#searchbox").css("opacity") && o("#searchbox").stop().animate({
                    opacity: "1",
                    position: "relative",
                    top: "0",
                    width: "200px"
                }, 300), "1" == o("#searchbox").css("opacity") && o("#searchbox").stop().animate({
                    opacity: "0",
                    position: "relative",
                    top: "0",
                    width: "0px"
                }, 300)
            })) : (o("#searchbox").css({
                opacity: "0",
                position: "absolute",
                top: "-62px",
                width: "100%"
            }), o("#search a").click(function() {
                "0" == o("#searchbox").css("opacity") && o("#searchbox").stop().animate({
                    position: "absolute",
                    top: "50px",
                    opacity: "1",
                    width: "100%"
                }, 300), "1" == o("#searchbox").css("opacity") && o("#searchbox").stop().animate({
                    position: "absolute",
                    top: "-62px",
                    opacity: "0",
                    width: "100%"
                }, 300)
            }))
        }), o("#slider").css({
            height: o(window).height() - 0 + "px"
        }), o(window).resize(function() {
            o("#slider").css({
                height: o(window).height() - 0 + "px"
            })
        });
        var i = function() {
            var e = o("#nav-arrows"),
                i = o("#nav-dots > span"),
                s = o("#slider").slitslider({
                    onBeforeChange: function(o, e) {
                        i.removeClass("nav-dot-current"), i.eq(e).addClass("nav-dot-current")
                    }
                }),
                t = function() {
                    a()
                },
                a = function() {
                    e.children(":last").on("click", function() {
                        return s.next(), !1
                    }), e.children(":first").on("click", function() {
                        return s.previous(), !1
                    }), i.each(function(e) {
                        o(this).on("click", function(t) {
                            var a = o(this);
                            return s.isActive() || (i.removeClass("nav-dot-current"), a.addClass("nav-dot-current")), s.jump(e + 1), !1
                        })
                    })
                };
            return {
                init: t
            }
        }();
        i.init(), o("#more-jobs").click(function() {
            o(this).toggleClass("on"), o(".hidden-job").toggle(0)
        }), o("#blog .owl-carousel").owlCarousel({
            margin: 20,
            loop: !0,
            dots: !1,
            nav: !0,
            navText: ['<i class="fa fa-arrow-left fa-2x"></i>', '<i class="fa fa-arrow-right fa-2x"></i>'],
            responsive: {
                0: {
                    items: 1
                },
                767: {
                    items: 2
                }
            }
        }), o("#testimonials .owl-carousel").owlCarousel({
            items: 1,
            loop: !0,
            margin: 50,
            dots: !1,
            autoplay: !0,
            autoplaySpeed: 1500,
            nav: !1
        }), o("#clients .owl-carousel").owlCarousel({
            items: 5,
            margin: 50,
            loop: !0,
            dots: !1,
            nav: !0,
            navText: ['<i class="fa fa-arrow-left fa-2x"></i>', '<i class="fa fa-arrow-right fa-2x"></i>'],
            responsive: {
                0: {
                    items: 1
                },
                481: {
                    items: 2
                },
                767: {
                    items: 3
                },
                992: {
                    items: 4
                },
                1200: {
                    items: 6
                }
            }
        }), o("#team .owl-carousel").owlCarousel({
            items: 4,
            margin: 30,
            loop: !0,
            dots: !1,
            nav: !0,
            navText: ['<i class="fa fa-arrow-left fa-2x"></i>', '<i class="fa fa-arrow-right fa-2x"></i>'],
            responsive: {
                0: {
                    items: 1
                },
                481: {
                    items: 2
                },
                767: {
                    items: 3
                },
                992: {
                    items: 4
                }
            }
        }), o(".number").counterUp({
            delay: 10,
            time: 1e3
        }), o("#years").noUiSlider({
            start: [3],
            connect: "lower",
            step: 1,
            range: {
                min: 0,
                max: 15
            },
            format: wNumb({
                decimals: 0
            })
        }), o("#years").Link("lower").to(o("#years-field")), o("#salary").noUiSlider({
            start: [4e4, 8e4],
            connect: !0,
            step: 1e3,
            range: {
                min: 0,
                max: 15e4
            },
            format: wNumb({
                decimals: 0,
                thousand: ".",
                prefix: "$"
            })
        }), o("#salary").Link("lower").to(o("#salary-field-lower")), o("#salary").Link("upper").to(o("#salary-field-upper")), o(".editor").wysiwyg(), o(".dropdown-menu input").click(function() {
            return !1
        }).change(function() {
            o(this).parent(".dropdown-menu").siblings(".dropdown-toggle").dropdown("toggle")
        }).keydown("esc", function() {
            this.value = "", o(this).change()
        }), o("#flickr").jflickrfeed({
            limit: 9,
            qstrings: {
                id: "89775615@N00"
            },
            itemTemplate: '<li><a href="{{image_b}}" class="fancybox" rel="gallery"><img src="{{image_s}}" alt="{{title}}" /></a></li>'
        }), o(".fancybox").fancybox({
            openEffect: "none"
        }), o(".link-login").click(function() {
            o("#login").fadeIn(300), o("body").addClass("no-scroll")
        }), o("#login .close").click(function() {
            o("#login").fadeOut(300), o("body").removeClass("no-scroll")
        }), o(".link-register").click(function() {
            o("#register").fadeIn(300), o("body").addClass("no-scroll")
        }), o("#register .close").click(function() {
            o("#register").fadeOut(300), o("body").removeClass("no-scroll")
        }), o("#accordion").on("hidden.bs.collapse", e), o("#accordion").on("shown.bs.collapse", e);
        var s = '<div class="row social-network"><div class="col-sm-6"><div class="form-group" id="resume-social-network-group"><label for="resume-social-network">Choose Social Network</label><select  class="form-control" id="resume-social-network"><option>Choose social network</option><option>Facebook</option><option>Twitter</option><option>Google+</option><option>LinkedIn</option><option>YouTube</option><option>Vimeo</option><option>Github</option><option>Flickr</option><option>YouTube</option><option>DeviantArt</option><option>ThemeForest</option><option>CodeCanyon</option><option>VideoHive</option><option>AudioJungle</option><option>GraphicRiver</option><option>PhotoDune</option><option>3dOcean</option><option>ActiveDen</option><option>Other</option></select></div></div><div class="col-sm-6"><div class="form-group" id="resume-social-network-url-group"><label for="resume-social-network-url">URL</label><input type="text" class="form-control" id="resume-social-network-url" placeholder="http://"></div></div></div><div class="row"><div class="col-sm-12"><hr class="dashed"></div></div>';
        o("#add-social-network").click(function() {
            o(this).parent().parent().parent().before(s)
        });
        var t = '<div class="row experience"><div class="col-sm-6"><div class="form-group" id="resume-employer-group"><label for="resume-employer">Employer</label><input type="text" class="form-control" id="resume-employer" placeholder="Company name"></div></div><div class="col-sm-6"><div class="form-group" id="resume-experience-dates-group"><label for="resume-experience-dates">Start/End Date</label><input type="text" class="form-control" id="resume-experience-dates" placeholder="e.g. April 2010 - June 2013"></div></div></div><div class="row"><div class="col-sm-6"><div class="form-group" id="resume-job-title-group"><label for="resume-job-title">Job Title</label><input type="text" class="form-control" id="resume-job-title" placeholder="e.g. Web Designer"></div></div><div class="col-sm-6"><div class="form-group" id="resume-responsibilities-group"><label for="resume-responsibilities">Responsibilities (Optional)</label><input type="text" class="form-control" id="resume-responsibilities" placeholder="e.g. Developing new websites"></div></div></div><div class="row"><div class="col-sm-12"><hr class="dashed"></div></div>';
        o("#add-experience").click(function() {
            o(this).parent().parent().parent().before(t)
        });
        var a = '<div class="row education"><div class="col-sm-6"><div class="form-group" id="resume-school-group"><label for="resume-school">School Name</label><input type="text" class="form-control" id="resume-school" placeholder="School name, city and country"></div></div><div class="col-sm-6"><div class="form-group" id="resume-education-dates-group"><label for="resume-education-dates">Start/End Date</label><input type="text" class="form-control" id="resume-education-dates" placeholder="e.g. April 2010 - June 2013"></div></div></div><div class="row"><div class="col-sm-6"><div class="form-group" id="resume-qualifications-group"><label for="resume-qualifications">Qualifications</label><input type="text" class="form-control" id="resume-qualifications" placeholder="e.g. Master Engineer"></div></div><div class="col-sm-6"><div class="form-group" id="resume-notes-group"><label for="resume-notes">Notes (Optional)</label><input type="text" class="form-control" id="resume-notes" placeholder="Any achievements"></div></div></div><div class="row"><div class="col-sm-12"><hr class="dashed"></div></div>';
        o("#add-education").click(function() {
            o(this).parent().parent().parent().before(a)
        }), window.sr = new scrollReveal({
            reset: !0,
            move: "50px",
            mobile: !1
        })
    })
}(jQuery);