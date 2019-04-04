var blobObject = null;



function createDownloadLink(anchorSelector, str, fileName){

    

    if(window.navigator.msSaveOrOpenBlob) {

        var fileData = [str];

        blobObject = new Blob(fileData);

        $(anchorSelector).click(function(){

            window.navigator.msSaveOrOpenBlob(blobObject, fileName);

        });

    } else {

        var url = "data:text/plain;charset=utf-8," + encodeURIComponent(str);

        $(anchorSelector).attr("href", url);

    }

}



(function (e) {

    jQuery.validator.addMethod("alphanumeric", function(value, element) {

            return this.optional(element) || /^[a-zA-Z0-9 ]+$/.test(value);

    });

    e(document).ready(function () {

        $("[data-toggle=tooltip]").tooltip();

        if(e("#datatable-myaccounts").length) {
            e(".checkall, input[type=checkbox]").change(function() {

                setTimeout(function() {

                    var c = e("tbody [type=checkbox]:checked");



                    if(c.length > 0) {

                        e("#delete").removeAttr('disabled');

                    } else

                        e("#delete").attr('disabled', 'disabled');

                }, 200);

            });



            e("#delete").click(function() {

                var c = e("tbody [type=checkbox]:checked");



                if(c.length === 0) {

                    return false;

                }



                var ids = [];



                for(var i = 0; i < c.length; i++)

                    ids.push($(c[i]).attr('id'));

                $.post('index.php/seller/delete', {ids: ids}, function(res) {

                    window.location = window.location;

                });

            });

        }

        if(e("#datatable-accounts").length) {
            e(".checkall, input[type=checkbox]").change(function() {

                setTimeout(function() {

                    var c = e("tbody [type=checkbox]:checked");



                    if(c.length > 0) {

                        e("#delete").removeAttr('disabled');

                    } else

                        e("#delete").attr('disabled', 'disabled');

                }, 200);

            });



            e("#delete").click(function() {

                var c = e("tbody [type=checkbox]:checked");



                if(c.length === 0) {

                    return false;

                }



                var ids = [];



                for(var i = 0; i < c.length; i++)

                    ids.push($(c[i]).attr('id'));

                $.post('index.php/user/delete', {ids: ids}, function(res) {

                    window.location = window.location;

                });

            });

        }

        if(e("#checker-format").length) {

            $("#startChecker").click(function() {

                $('.alert-danger').addClass('hide');

                var val = e("#cc-checker textarea").val();



                if(val.length === 0) {

                    $(".alert-danger strong").text('The list cannot be empty.');

                    $('.alert-danger').removeClass('hide');

                    e("#cc-checker textarea").focus();

                    return;

                }



                var lines = val.split(/\r*\n/);

                var total = 0;



                for(idx in lines) {

                    lines[idx] = lines[idx].trim();



                    if(lines[idx].length === 0) {

                        continue;

                    }



                    var format = $("#checker-format input").not(":eq(0)");

                    var fields = lines[idx].split($('[name=delim]').val());



                    var row = '<tr id="c' + total + '">';

                    row+='<td></td>';

                    for(j in format) {

                        var v = format[j].value || null;



                        if(v == null) continue;



                        var name = $(format[j]).attr('name');

                        var lv = v > fields.length ? '' : (fields[v] || '');

                        

                        row += '<td data-for="' + name + '">' + lv + '</td>';

                    }



                    row += '</tr>';

                    e("#cc-checker table tbody").append(row);

                    total++;

                }



                e("#cc-checker .goaway").slideUp();

                e("#cc-checker table").slideDown();

                e("#checker-format").parent().remove();

                e("#cc-checker").parent().addClass('col-md-12').removeClass('col-md-9');

                

                var idx = 0;

                var start = function() {



                    $("#c" + idx + " td:first").html('<i class="fa fa-spinner fa-spin"></i>');

                    var td = $("#c" + idx + " td").not(":eq(0)");

                    var data = {};



                    for(var i = 0; i < td.length; i++) {

                        data[$(td[i]).data('for')] = $(td[i]).text();

                    }



                    $.post('checker/checkCC', data, function(res) {

                        if(typeof res.error !== 'undefined') {

                            $("#c" + idx).addClass('danger');

                            $("#c" + idx + " td:first").html('<i class="fa fa-times-circle"></i>');

                        } else if(typeof res.success) {

                            $("#c" + idx).addClass('success');

                            $("#c" + idx + " td:first").html('<i class="fa fa-check-circle"></i>');

                        }



                        idx++;



                        if(idx >= total) {

                            var success = $("#cc-checker .success").length;

                            var bad = $("#cc-checker .danger").length;

                            $("#cc-checker .alert-success span").text(success + " working and " + bad + " failed out of " + total + " credit cards");

                            $("#cc-checker .alert-success").show();



                            var results = "Accounts Zone CC Checker Results\r\n";

                            results+= "Success: " + success + "\r\n";

                            results+= "Bad: " + bad + "\r\n\r\n[Working]\r\n";



                            var success = $("#cc-checker .success");



                            for(var i = 0; i < success.length; i++) {

                                var td = $(success[i]).find('td').not(':first');



                                for(var j = 0; j < td.length; j++) {

                                    var v = $(td[j]).text().trim();



                                    if(v.length == 0)

                                        v = 'N/A';





                                    results += v;



                                    if(j != td.length - 1)

                                        results += " | ";

                                }



                                results +="\r\n";

                            }



                            results += "\r\n[Bad]\r\n";

                            var bad = $("#cc-checker .danger");



                            for(var i = 0; i < bad.length; i++) {

                                var td = $(bad[i]).find('td').not(':first');



                                for(var j = 0; j < td.length; j++) {

                                    var v = $(td[j]).text().trim();

                                    

                                    if(v.length == 0)

                                        v = 'N/A';





                                    results += v;



                                    if(j != td.length - 1)

                                        results += " | ";

                                }



                                results +="\r\n";

                            }



                            createDownloadLink("#cc-checker .alert-success a", results,"results.txt");



                        } else {

                            start();

                        }

                    }, 'json');

                }



                start();



            });

        }


        if(e('#form-usersettings').length) {

            e('#form-usersettings').validate({

                rules: {

                    password: {

                        required: true

                    }

                },

                messages: {

                    password: {

                        required: "Enter your current password to apply any changes"

                    }

                }

            });

            e("[name=password]").focus();

        }

        if(e('.chat-messages').length) {

            setTimeout(function() {

                $(".nano").nanoScroller({ scroll: 'bottom' });

                e('[name=message]').focus();

            }, 400);

            

        }

        function c() {

            if(e("#form-ticketmessage").length) {

                e("#form-ticketmessage").validate({

                    rules: {

                        message: {

                            required: true

                        }

                    }

                });

            }

            if(e("#changeType").length) {

                e("#changeType").change(function() {

                    window.location = $(this).val();

                });

            }

            if(e('#add-account-list').length) {

                e("#form-addaccount").submit(function() {

                    var elems = $('#form-addaccount input, #form-addaccount textarea');



                    for(idx in elems) {

                        if(typeof elems[idx].value !== 'undefined' && elems[idx].value.length === 0) {

                            $(elems[idx]).focus();

                            return false;

                        }

                    }

                });

                e("#reset").click(function() {

                    e("#add-account-list").val('');

                    e("input").each(function(idx, el) {

                        if(idx == 0) return;

                        e(el).val(idx - 1);

                    });

                    e("#add-account-list").focus();

                   return false;

                });

                e('#add-account-list').focus();

            }

            if (e("#placeholder").length) {

                e.plot("#placeholder", [n, s, o], {

                    colors: ["#5bc0de", "#82b964", "#f4cc13"],

                    grid: {

                        hoverable: true,

                        clickable: false,

                        borderWidth: 0,

                        backgroundColor: "transparent"

                    },

                    yaxis: {

                        font: {

                            color: "#555",

                            family: "Open Sans, sans-serif",

                            size: 11

                        },

                        tickColor: "transparent"

                    },

                    xaxis: {

                        font: {

                            color: "#555",

                            family: "Open Sans, sans-serif",

                            size: 11

                        },

                        tickColor: "rgba(0,0,0,0.1)"

                    },

                    series: {

                        lines: {

                            show: f,

                            lineWidth: 0,

                            color: "#fff",

                            fill: 1,

                            steps: l

                        },

                        bars: {

                            show: a,

                            barWidth: .5,

                            fill: 1,

                            lineWidth: 0

                        }

                    }

                })

            }

        }



        function d(e) {

            var t = [],

                n = new Date(e.xaxis.min);

            n.setUTCDate(n.getUTCDate() - (n.getUTCDay() + 1) % 7);

            n.setUTCSeconds(0);

            n.setUTCMinutes(0);

            n.setUTCHours(0);

            var r = n.getTime();

            do {

                t.push({

                    xaxis: {

                        from: r,

                        to: r + 2 * 24 * 60 * 60 * 1e3

                    }

                });

                r += 7 * 24 * 60 * 60 * 1e3

            } while (r < e.xaxis.max);

            return t

        }



        function b() {

            if (g.length) {

                g = g.slice(1)

            }

            while (g.length < E) {

                var e = g.length ? g[g.length - 1] : 70;

                var t = e + Math.random() * 10 - 5;

                g.push(t < 0 ? 0 : t > 100 ? 100 : t)

            }

            var n = [];

            for (var r = 1; r < g.length; ++r) {

                n.push([r, g[r]])

            }

            return n

        }



        function T() {

            var e = [];

            if (g.length > 0) g = g.slice(1);

            while (g.length < N) {

                var t = g.length ? g[g.length - 1] : 50;

                var n = t + Math.random() * 10 - 5;

                g.push(n < 0 ? 0 : n > 100 ? 100 : n)

            }

            for (var r = 0; r < g.length; ++r) {

                e.push([r, g[r]])

            }

            return e

        }



        function I() {

            function n(e) {

                var n = t.text(e).width();

                t.show();

                var r = (t.parent().width() - n) / 2;

                t.css("left", r);

                setTimeout(function () {

                    t.fadeOut()

                }, 1e3)

            }



            function i(cb) {

                r.show();

                setTimeout(function () {

                    r.hide();

                    

                    if(cb)

                        cb();

                }, 1e3)

            }

            e(".checkall").click(function () {

                var t = e(this).parents("table");

                var n = t.find("[type=checkbox]");

                var r = e(this).is(":checked");

                n.prop("checked", r).parent().toggleClass("checked", r);

                t.find("tbody:first tr").toggleClass("selected", r)

            });

            e(".mailinbox .fa-flag").click(function () {

                var t = e(this).is(".flagged-yellow");

                e(this).toggleClass("flagged-yellow", !t).toggleClass("flagged-grey", t)

            });

            e(".mailinbox tbody:first input:checkbox").click(function () {

                e(this).parents("tr").toggleClass("selected", e(this).prop("checked"))

            });

            if(e("#openTicket").length) {

                $("#openTicket").validate({

                    rules: {

                        topic: {

                            required: true,

                            minlength: 3

                        },

                        content: {

                            required: true,

                            minlength: 40

                        }

                    },

                    submitHandler: function(form) {

                        $.post('/index.php/user/openTicket', $("#openTicket").serialize(), function(res) {

                            

                            if(typeof res.success !== 'undefined') {

                                location.hash = '#';

                                location.hash = '#mytickets';

                                $('#openTicket input, #openTicket textarea').val('');

                                $('.refresh').click();

                                n("Ticket submitted!");

                            }



                            

                        }, 'json');

                    }

                })

            }

            var tm = $('.page-header h1').text() == 'Ticket Manager';

            e(".delete").click(function (t) {

                t.preventDefault();

                var r = e(".mailinbox tbody:first [type=checkbox]:checked");

                var i = r.length;

                if (i === 0) {

                    n("No selected tickets");

                    return

                }

                r.parents("tr").remove();

                var s = r.length > 1 ? "messages" : "message";

                var o = r.length + " " + s + " deleted";

                n(o);



                var ids = [];

                for(var j = 0; j < i; j++) {

                    var id = $(r[j]).attr('id');

                    ids.push(id);

                }



                $.post('/index.php/user/deleteTickets', {tickets: ids, tm: tm}, function(res) {

                    $('.refresh').click();

                });



                $(".checkall").prop('checked', false);

            });

            e(".mark_read, .mark_unread").click(function (t) {

                t.preventDefault();

                var r = e(".mailinbox .checkbox:checked");

                var i = r.length;

                if (i === 0) {

                    n("No selected message");

                    return

                }

                r.parents("tr").toggleClass("unread", !e(this).is(".mark_read"));

                var s = r.length > 1 ? "messages were" : "message was";

                var o = e(this).is(".mark_read") ? " read" : " unread";

                var u = r.length + " " + s + " marked as " + o;

                n(u)

            });

            var page = 1;

            var open = 1;

            var next = 2;

            var back = 1;

            e("#opened").click(function(e2) {

                e2.preventDefault();

                open = 1;

                e("#opened").toggleClass("active", open == 1);

                e("#closed").toggleClass("active", open == 0);

                e(".refresh").click();

            });

            e("#closed").click(function(e2) {

                e2.preventDefault();

                open = 0;

                e("#opened").toggleClass("active", open == 1);

                e("#closed").toggleClass("active", open == 0);

                e(".refresh").click();

            });

            e(".next").click(function(e2) {

                e2.preventDefault();



                if($(this).hasClass('disabled')) return;



                page = next;

                e(".refresh").click();

                location.hash = '#';

                location.hash = '#mytickets';

            });

            e("#pagination li:first a").click(function(e2) {

                e2.preventDefault();



                if($(this).hasClass('disabled')) return;

                

                page = back;

                e(".refresh").click();

                location.hash = '#';

                location.hash = '#mytickets';

            });

            e(".refresh").click(function (e) {

                e.preventDefault();

                $("#tickets tbody:last tr td").text('');

                r.show()

                $.get('/index.php/user/getTickets', {page: page, open: open, tm:tm}, function(res) {

                    $("#opened span").text(res.open);

                    $("#closed span").text(res.closed);

                    $("#pagination span:first").text((res.page.start + 1) + ' to ' + (res.page.start + res.data.length) + ' of ' + res.total + ' entries');

                    $("#tickets tbody:first tr").remove();

                    $("#pagination .active a").text(res.page.current);



                    next = res.page.next;

                    back = res.page.back;



                    if(next === res.page.current)

                        $(".next").addClass('disabled');

                    else

                        $('.next').removeClass('disabled');



                    if(1 == res.page.current)

                        $(".prev").addClass('disabled');

                    else

                        $('.prev').removeClass('disabled');



                    if(res.data.length === 0) {

                        $("#tickets tbody:last tr td").text('Nothing to display');

                    } else

                        for(idx in res.data) {

                            $("#tickets tbody:first")

                                .append('<tr class="' + (tm ? (res.data[idx].unread2 == 0 ? '' : 'unread') : (res.data[idx].unread == 0 ? '' : 'unread')) + '">' +

                                    '<td align="center"><input id="' + res.data[idx].id + '" style="display:block" type="checkbox" /></td>' +

                                    '<td><a href="' + res.data[idx].link + '">' + res.data[idx].topic + ' <small>' + res.data[idx].short_content + '</small></a></td>' +

                                    '<td>' + res.data[idx].date_text + ' <small><a href="' + res.data[idx].link + '">' + res.data[idx].ago + ' <i class="fa fa-caret-right"></i></a></small></td>' +

                                    "</tr>");

                        }



                    r.hide();

                }, 'json');

            });

            var t = e('<div class="alert alert-danger alert-inbox">').css({

                display: "none",

                position: "absolute",

                top: "40%"

            }).appendTo(".table-relative");

            var r = e('<div class="loader-darkener">').appendTo(".table-relative");

            e('<div class="fa-spin dummy-loader">').appendTo(r)

        }



        function R() {

            W.forEach(function (e, t) {

                e.addEventListener("click", function (e) {

                    e.preventDefault();

                    U(this)

                }, false)

            })

        }



        function U(e) {

            W.forEach(function (e) {

                classie.remove(z, e.getAttribute("data-view"));

                classie.remove(e, "items-selected")

            });

            classie.add(z, e.getAttribute("data-view"));

            classie.add(e, "items-selected")

        }



        function V(e) {

            var t = X.text(e).width();

            X.show();

            var n = (X.parent().width() - t) / 2;

            X.css("left", n);

            setTimeout(function () {

                X.fadeOut()

            }, 1e3)

        }



        function K() {

            J.show();

            setTimeout(function () {

                J.hide()

            }, 1e3)

        }

        I();

        e(".left-toggler").click(function (t) {

            e(".responsive-admin-menu").toggleClass("sidebar-toggle");

            e(".content-wrapper").toggleClass("main-content-toggle-left");

            t.preventDefault()

        });

        e(".right-toggler").click(function (t) {

            e(".main-wrap").toggleClass("userbar-toggle");

            t.preventDefault()

        });

        e(".chat-toggler").click(function (t) {

            e(".chat-users-menu").toggleClass("chatbar-toggle");

            t.preventDefault()

        });

        e(".btn-close").click(function (t) {

            t.preventDefault();

            e(this).parent().parent().parent().fadeOut()

        });

        e(".btn-minmax").click(function (t) {

            t.preventDefault();

            var n = e(this).parent().parent().next(".panel-body");

            if (n.is(":visible")) e("i", e(this)).removeClass("fa fa-chevron-circle-up").addClass("fa fa-chevron-circle-down");

            else e("i", e(this)).removeClass("fa-chevron-circle-down").addClass("fa fa-chevron-circle-up");

            n.slideToggle()

        });

        e(".btn-question").click(function (t) {

            t.preventDefault();

            e("#myModal").modal("show")

        });

        if (e(".vidz").length) {

            e(".vidz").fitVids()

        }

        e(function () {

            e(".tree li:has(ul)").addClass("parent_li").find(" > span").attr("title", "Collapse this branch");

            e(".tree li.parent_li > span").on("click", function (t) {

                var n = e(this).parent("li.parent_li").find(" > ul > li");

                if (n.is(":visible")) {

                    n.hide("fast");

                    e(this).attr("title", "Expand this branch").find(" > i").addClass("fa-plus-circle").removeClass("fa-minus-circle")

                } else {

                    n.show("fast");

                    e(this).attr("title", "Collapse this branch").find(" > i").addClass("fa-minus-circle").removeClass("fa-plus-circle")

                }

                t.stopPropagation()

            })

        });

        if (e("#nestable").length) {

            e("#nestable").nestable({

                group: 1

            })

        }

        if (e("#nestable2").length) {

            e("#nestable2").nestable({

                group: 1

            })

        }

        if (e("#nestable-menu").length) {

            e("#nestable-menu").on("click", function (t) {

                var n = e(t.target),

                    r = n.data("action");

                if (r === "expand-all") {

                    e(".dd").nestable("expandAll")

                }

                if (r === "collapse-all") {

                    e(".dd").nestable("collapseAll")

                }

            })

        }

        if (e("#nestable3").length) {

            e("#nestable3").nestable()

        }

        if (e("#nestable4").length) {

            e("#nestable4").nestable()

        }

        if (e(".knob").length) {

            e(".knob").knob({

                height: "130"

            })

        }

        if (e(".knob2").length) {

            e(".knob2").knob({

                height: "130",

                font: "Open Sans, sans-serif"

            })

        }

        if (e(".knob3").length) {

            e(".knob3").knob({

                height: "130",

                font: "Open Sans, sans-serif"

            })

        }

        if (e(".knob4").length) {

            e(".knob4").knob({

                height: "130",

                font: "Open Sans, sans-serif"

            })

        }

        if (e(".knob5").length) {

            e(".knob5").knob({

                height: "130",

                font: "Open Sans, sans-serif"

            })

        }

        if (e(".knob6").length) {

            e(".knob6").knob({

                height: "130",

                font: "Open Sans, sans-serif"

            })

        }

        if (e("#ui-slider1").length) {

            e("#ui-slider1").slider({

                min: 0,

                max: 500,

                slide: function (t, n) {

                    e("#ui-slider1-value").text(n.value)

                }

            })

        }

        if (e("#ui-slider2").length) {

            e("#ui-slider2").slider({

                min: 0,

                max: 500,

                range: true,

                values: [75, 300],

                slide: function (t, n) {

                    e("#ui-slider2-value1").text(n.values[0]);

                    e("#ui-slider2-value2").text(n.values[1])

                }

            })

        }

        if (e("#ui-slider3").length) {

            e("#ui-slider3").slider({

                min: 0,

                max: 500,

                step: 100,

                slide: function (t, n) {

                    e("#ui-slider3-value").text(n.value)

                }

            })

        }

        if (e("#vmap").length) {

            e("#vmap").vectorMap({

                map: "world_en",

                backgroundColor: "#fff",

                color: "#5bc0de",

                borderColor: "#5bc0de",

                hoverOpacity: .7,

                selectedColor: "#82b964",

                enableZoom: true,

                showTooltip: true,

                values: sample_data,

                scaleColors: ["#5bc0de", "#006491"],

                normalizeFunction: "polynomial"

            })

        }

        if (e("#vmap-usa").length) {

            e("#vmap-usa").vectorMap({

                map: "usa_en",

                backgroundColor: "#5bc0de",

                color: "#fff",

                hoverOpacity: 0,

                hoverColor: "#f4cc13",

                selectedColor: "#ccd600",

                enableZoom: true,

                showTooltip: true,

                selectedRegion: "MO"

            })

        }

        if (e("#vmap-europe").length) {

            e("#vmap-europe").vectorMap({

                map: "europe_en",

                backgroundColor: "#c4c5c5",

                hoverColor: "#f87aa0",

                selectedColor: "#5bc0de",

                enableZoom: true,

                showTooltip: true

            })

        }

        if (e("#vmap-russia").length) {

            e("#vmap-russia").vectorMap({

                map: "russia_en",

                backgroundColor: "#f1f1f1",

                color: "#d24d33",

                hoverOpacity: .7,

                selectedColor: "#999999",

                enableZoom: true,

                borderColor: "#d24d33",

                showTooltip: true,

                values: sample_data,

                scaleColors: ["#f0ad4e", "#d24d33"],

                normalizeFunction: "polynomial"

            })

        }

        if (e("#ionrange_1").length) {

            e("#ionrange_1").ionRangeSlider({

                min: 0,

                max: 5e3,

                from: 1e3,

                to: 4e3,

                type: "double",

                step: 1,

                prefix: "$ ",

                prettify: true,

                hasGrid: true

            })

        }

        if (e("#ionrange_2").length) {

            e("#ionrange_2").ionRangeSlider({

                min: 1e3,

                max: 1e5,

                from: 3e4,

                to: 9e4,

                type: "double",

                step: 500,

                postfix: " €",

                hasGrid: true

            })

        }

        if (e("#ionrange_3").length) {

            e("#ionrange_3").ionRangeSlider({

                min: 0,

                max: 10,

                type: "single",

                step: .1,

                postfix: " carats",

                prettify: false,

                hasGrid: true

            })

        }

        if (e("#ionrange_4").length) {

            e("#ionrange_4").ionRangeSlider({

                min: -50,

                max: 50,

                from: 0,

                postfix: "°",

                prettify: false,

                hasGrid: true

            })

        }

        if (e("#ionrange_5").length) {

            e("#ionrange_5").ionRangeSlider({

                values: ["Jan", "Fef", "Mar", "Apr", "May", "Jan", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],

                type: "single",

                hasGrid: true

            })

        }

        if (e("#ionrange_6").length) {

            e("#ionrange_6").ionRangeSlider({

                min: 1e4,

                max: 1e5,

                step: 1e3,

                postfix: " miles",

                from: 55e3,

                hideMinMax: false,

                hideFromTo: true

            })

        }

        if (e("#ionrange_7").length) {

            e("#ionrange_7").ionRangeSlider({

                min: 1e4,

                max: 1e5,

                step: 100,

                postfix: " kilometres",

                from: 55e3,

                hideMinMax: true,

                hideFromTo: false

            })

        }

        if (e("#powerwidgets").length) {

            e("#powerwidgets").powerWidgets({

                grid: ".bootstrap-grid",

                widgets: ".powerwidget",

                localStorage: true,

                deleteSettingsKey: "#deletesettingskey-options",

                settingsKeyLabel: "Reset settings?",

                deletePositionKey: "#deletepositionkey-options",

                positionKeyLabel: "Reset position?",

                sortable: true,

                buttonsHidden: false,

                toggleButton: true,

                toggleClass: "fa fa-chevron-circle-up | fa fa-chevron-circle-down",

                toggleSpeed: 200,

                onToggle: function () {},

                deleteButton: true,

                deleteClass: "fa fa-times-circle",

                onDelete: function (t) {

                    e("#delete-widget").modal();

                    e(t).addClass("deletethiswidget")

                },

                editButton: true,

                editPlaceholder: ".powerwidget-editbox",

                editClass: "fa fa-cog | fa fa-cog",

                editSpeed: 200,

                onEdit: function () {},

                fullscreenButton: true,

                fullscreenClass: "fa fa-arrows-alt | fa fa-arrows-alt",

                fullscreenDiff: 3,

                onFullscreen: function () {},

                buttonOrder: "%refresh% %delete% %edit% %fullscreen% %toggle%",

                opacity: 1,

                dragHandle: "> header",

                placeholderClass: "powerwidget-placeholder",

                indicator: true,

                indicatorTime: 600,

                ajax: true,

                timestampPlaceholder: ".powerwidget-timestamp",

                timestampFormat: "Last update: %m%/%d%/%y% %h%:%i%:%s%",

                refreshButton: true,

                refreshButtonClass: "fa fa-refresh",

                labelError: "Sorry but there was a error:",

                labelUpdated: "Last Update:",

                labelRefresh: "Refresh",

                labelDelete: "Delete widget:",

                afterLoad: function () {},

                rtl: false,

                onChange: function () {},

                onSave: function () {}

            })

        }

        e("#trigger-deletewidget").click(function (t) {

            e(".deletethiswidget").remove();

            e("#delete-widget").modal("hide")

        });

        e("#trigger-deletewidget-reset").click(function (t) {

            e("body").find(".deletethiswidget").removeClass("deletethiswidget")

        });

        e(".empty-local-storage").click(function (t) {

            var n = e("#confirm_replacer");

            if (n.length && typeof e.fn.modal === "function") {

                e("#bootconfirm_confirm", n).off(clickEvent).on(clickEvent, function (e) {

                    localStorage.clear();

                    location.reload();

                    n.modal().hide()

                });

                e(".modal-title", n).text("Clear all localStorage");

                n.modal()

            } else {

                var r = confirm("Clear all localStorage?");

                if (r && localStorage) {

                    localStorage.clear();

                    location.reload()

                }

            }

            t.preventDefault()

        });

        if (document.getElementById("morris-area")) {

            Morris.Area({

                element: "morris-area",

                data: [{

                    period: "2012 Q1",

                    iphone: 2666,

                    ipad: 6e3,

                    ipadmini: 2647,

                    itouch: 2647,

                    imac: 2647

                }, {

                    period: "2012 Q2",

                    iphone: 2778,

                    ipad: 2294,

                    ipadmini: 1333,

                    itouch: 2441,

                    imac: 200

                }, {

                    period: "2012 Q3",

                    iphone: 4912,

                    ipad: 1969,

                    ipadmini: 1267,

                    itouch: 2501,

                    imac: 4234

                }, {

                    period: "2012 Q4",

                    iphone: 3767,

                    ipad: 3597,

                    ipadmini: 2001,

                    itouch: 5689,

                    imac: 7585

                }, {

                    period: "2013 Q1",

                    iphone: 6810,

                    ipad: 1914,

                    ipadmini: 6421,

                    itouch: 2293,

                    imac: 1290

                }, {

                    period: "2013 Q2",

                    iphone: 5670,

                    ipad: 4293,

                    ipadmini: 5692,

                    itouch: 6881,

                    imac: 3987

                }, {

                    period: "2013 Q3",

                    iphone: 4820,

                    ipad: 3795,

                    ipadmini: 2647,

                    itouch: 1588,

                    imac: 5690

                }, {

                    period: "2013 Q4",

                    iphone: 15073,

                    ipad: 5967,

                    ipadmini: 2100,

                    itouch: 5175,

                    imac: 6890

                }, {

                    period: "2014 Q1",

                    iphone: 10687,

                    ipad: 4460,

                    ipadmini: 1902,

                    itouch: 2028,

                    imac: 4523

                }, {

                    period: "2014 Q2",

                    iphone: 8432,

                    ipad: 5713,

                    ipadmini: 2647,

                    itouch: 1791,

                    imac: 907

                }],

                fillOpacity: "0.8",

                lineWidth: "6",

                gridTextSize: 11,

                pointStrokeWidth: "3",

                gridTextFamily: "Open Sans, sans-serif",

                lineColors: ["#82b964", "#858689", "#993838", "#f87aa0", "f4b66d"],

                xkey: "period",

                ykeys: ["iphone", "ipad", "ipadmini", "itouch", "imac"],

                labels: ["iPhone", "iPad", "iPad Mini", "iPod Touch", "IMac"]

            }).on("click", function (e, t) {

                console.log(e, t)

            })

        }

        if (document.getElementById("morris-area-lines")) {

            Morris.Area({

                element: "morris-area-lines",

                behaveLikeLine: true,

                data: [{

                    period: "2012 Q1",

                    iphone: 2666,

                    ipad: 6e3,

                    ipadmini: 2647

                }, {

                    period: "2012 Q2",

                    iphone: 2778,

                    ipad: 2294,

                    ipadmini: 1333

                }, {

                    period: "2012 Q3",

                    iphone: 4912,

                    ipad: 1969,

                    ipadmini: 1267

                }, {

                    period: "2012 Q4",

                    iphone: 3767,

                    ipad: 3597,

                    ipadmini: 2001

                }, {

                    period: "2013 Q1",

                    iphone: 6810,

                    ipad: 1914,

                    ipadmini: 6421

                }, {

                    period: "2013 Q2",

                    iphone: 5670,

                    ipad: 4293,

                    ipadmini: 5692

                }, {

                    period: "2013 Q3",

                    iphone: 4820,

                    ipad: 3795,

                    ipadmini: 2647

                }, {

                    period: "2013 Q4",

                    iphone: 15073,

                    ipad: 5967,

                    ipadmini: 2100

                }, {

                    period: "2014 Q1",

                    iphone: 10687,

                    ipad: 4460,

                    ipadmini: 1902

                }, {

                    period: "2014 Q2",

                    iphone: 8432,

                    ipad: 5713,

                    ipadmini: 2647

                }],

                lineWidth: "6",

                pointStrokeWidth: "3",

                gridTextFamily: "Open Sans, sans-serif",

                lineColors: ["#82b964", "#8960a7", "#993838", "#f87aa0", "f4b66d"],

                xkey: "period",

                gridTextSize: 11,

                ykeys: ["iphone", "ipad", "ipadmini"],

                labels: ["iPhone", "iPad", "iPad Mini"]

            })

        }

        if (document.getElementById("morris-line")) {

            var t = [{

                period: "2011 W27",

                licensed: 3407,

                sorned: 660,

                leaked: 123

            }, {

                period: "2011 W26",

                licensed: 3351,

                sorned: 629,

                leaked: 2660

            }, {

                period: "2011 W25",

                licensed: 3269,

                sorned: 618,

                leaked: 1660

            }, {

                period: "2011 W24",

                licensed: 3246,

                sorned: 661,

                leaked: 3456

            }, {

                period: "2011 W23",

                licensed: 3257,

                sorned: 667,

                leaked: 873

            }, {

                period: "2011 W22",

                licensed: 3248,

                sorned: 627,

                leaked: 660

            }, {

                period: "2011 W21",

                licensed: 3171,

                sorned: 660,

                leaked: 839

            }, {

                period: "2011 W20",

                licensed: 3171,

                sorned: 676,

                leaked: 2999

            }, {

                period: "2011 W19",

                licensed: 666,

                sorned: 656,

                leaked: 660

            }, {

                period: "2011 W18",

                licensed: 3215,

                sorned: 622,

                leaked: 2650

            }, {

                period: "2011 W17",

                licensed: 3148,

                sorned: 632,

                leaked: 1890

            }, {

                period: "2011 W16",

                licensed: 3155,

                sorned: 300,

                leaked: 660

            }, {

                period: "2011 W15",

                licensed: 491,

                sorned: 667,

                leaked: 660

            }, {

                period: "2011 W14",

                licensed: 3226,

                sorned: 620,

                leaked: 781

            }, {

                period: "2011 W13",

                licensed: 3245,

                sorned: 200,

                leaked: 660

            }, {

                period: "2011 W12",

                licensed: 999,

                sorned: 300,

                leaked: 660

            }, {

                period: "2011 W11",

                licensed: 3263,

                sorned: null,

                leaked: 660

            }, {

                period: "2011 W10",

                licensed: 1250,

                sorned: 3987,

                leaked: 660

            }, {

                period: "2011 W09",

                licensed: 121,

                sorned: 555,

                leaked: 660

            }, {

                period: "2011 W08",

                licensed: 3085,

                sorned: 234,

                leaked: 532

            }, {

                period: "2011 W07",

                licensed: 3055,

                sorned: 342,

                leaked: 789

            }, {

                period: "2011 W06",

                licensed: 590,

                sorned: 546,

                leaked: 334

            }, {

                period: "2011 W05",

                licensed: 2943,

                sorned: 2573,

                leaked: 454

            }, {

                period: "2011 W04",

                licensed: 2806,

                sorned: 489,

                leaked: 2343

            }, {

                period: "2011 W03",

                licensed: 953,

                sorned: 490,

                leaked: 345

            }, {

                period: "2011 W02",

                licensed: 1702,

                sorned: 23,

                leaked: 660

            }, {

                period: "2011 W01",

                licensed: 1732,

                sorned: 2342,

                leaked: 660

            }];

            Morris.Line({

                element: "morris-line",

                lineWidth: "6",

                gridTextColor: "#fff",

                pointStrokeWidth: "3",

                gridTextFamily: "Open Sans, sans-serif",

                lineColors: ["#f4cc13", "#5bc0de", "#993838", "#ccd600", "f4b66d"],

                data: t,

                xkey: "period",

                gridTextSize: 11,

                ykeys: ["licensed", "sorned", "leaked"],

                labels: ["Licensed", "SORN", "Pirates"]

            })

        }

        if (document.getElementById("morris-stacked")) {

            Morris.Bar({

                element: "morris-stacked",

                data: [{

                    x: "2013 Q1",

                    y: 3,

                    z: 2,

                    a: 3,

                    b: 6

                }, {

                    x: "2013 Q2",

                    y: 2,

                    z: null,

                    a: 1,

                    b: 3

                }, {

                    x: "2013 Q3",

                    y: 0,

                    z: 2,

                    a: 4,

                    b: 2

                }, {

                    x: "2013 Q4",

                    y: 2,

                    z: 4,

                    a: 3,

                    b: 1

                }],

                gridTextFamily: "Open Sans, sans-serif",

                barColors: ["#82b964", "#858689", "#993838", "#f87aa0", "f4b66d"],

                xkey: "x",

                gridTextSize: 11,

                ykeys: ["y", "z", "a", "b"],

                labels: ["Y", "Z", "A", "B"],

                stacked: true

            })

        }

        var n = [];

        var r;

        var i;

        for (r = 0; r <= 10; r += 1) {

            n.push([r, parseInt(Math.random() * 30)])

        }

        var s = [];

        for (r = 0; r <= 10; r += 1) {

            s.push([r, parseInt(Math.random() * 30)])

        }

        var o = [];

        for (r = 0; r <= 10; r += 1) {

            o.push([r, parseInt(Math.random() * 30)])

        }

        var u, a, f, l;

        u = 0;

        a = false;

        f = true;

        l = false;

        c();

        e(".btn-group button").click(function (t) {

            t.preventDefault();

            a = e(this).text().indexOf("Bars") != -1;

            f = e(this).text().indexOf("Lines") != -1;

            l = e(this).text().indexOf("steps") != -1;

            c()

        });

        if (e("#placeholder2").length) {

            var h = [

                ["Jan", 56],

                ["Feb", 67],

                ["Mar", 42],

                ["Apr", 87],

                ["May", 53],

                ["June", 38],

                ["July", 49],

                ["Aug", 32],

                ["Sep", 33],

                ["Oct", 34],

                ["Nov", 41],

                ["Dec", 14]

            ];

            var p = [

                ["Jan", 189],

                ["Feb", 244],

                ["Mar", 293],

                ["Apr", 192],

                ["May", 265],

                ["June", 167],

                ["July", 231],

                ["Aug", 169],

                ["Sep", 163],

                ["Oct", 168],

                ["Nov", 152],

                ["Dec", 52]

            ];

            e.plot("#placeholder2", [{

                data: p,

                label: "Earnings"

            }, {

                data: h,

                label: "Buys"

            }], {

                colors: ["#5bc0de", "#f87aa0"],

                grid: {

                    hoverable: true,

                    clickable: false,

                    borderWidth: 0,

                    backgroundColor: "transparent"

                },

                legend: {

                    labelBoxBorderColor: false

                },

                series: {

                    bars: {

                        show: true,

                        barWidth: .9,

                        fill: 1,

                        lineWidth: 0,

                        align: "center"

                    }

                },

                xaxis: {

                    font: {

                        color: "#555",

                        family: "Open Sans, sans-serif",

                        size: 11

                    },

                    mode: "categories",

                    tickLength: 0

                },

                yaxis: {

                    font: {

                        color: "#333",

                        family: "Open Sans, sans-serif",

                        size: 11

                    }

                }

            })

        }

        if (e("#placeholder3").length) {

            var v = [

                [11964636e5, 0],

                [119655e7, 0],

                [11966364e5, 0],

                [11967228e5, 77],

                [11968092e5, 3636],

                [11968956e5, 3575],

                [1196982e6, 2736],

                [11970684e5, 1086],

                [11971548e5, 676],

                [11972412e5, 1205],

                [11973276e5, 906],

                [1197414e6, 710],

                [11975004e5, 639],

                [11975868e5, 540],

                [11976732e5, 435],

                [11977596e5, 301],

                [1197846e6, 575],

                [11979324e5, 481],

                [11980188e5, 591],

                [11981052e5, 608],

                [11981916e5, 459],

                [1198278e6, 234],

                [11983644e5, 1352],

                [11984508e5, 686],

                [11985372e5, 279],

                [11986236e5, 449],

                [119871e7, 468],

                [11987964e5, 392],

                [11988828e5, 282],

                [11989692e5, 208],

                [11990556e5, 229],

                [1199142e6, 177],

                [11992284e5, 374],

                [11993148e5, 436],

                [11994012e5, 404],

                [11994876e5, 253],

                [1199574e6, 218],

                [11996604e5, 476],

                [11997468e5, 462],

                [11998332e5, 448],

                [11999196e5, 442],

                [1200006e6, 403],

                [12000924e5, 204],

                [12001788e5, 194],

                [12002652e5, 327],

                [12003516e5, 374],

                [1200438e6, 507],

                [12005244e5, 546],

                [12006108e5, 482],

                [12006972e5, 283],

                [12007836e5, 221],

                [120087e7, 483],

                [12009564e5, 523],

                [12010428e5, 528],

                [12011292e5, 483],

                [12012156e5, 452],

                [1201302e6, 270],

                [12013884e5, 1222],

                [12014748e5, 1439],

                [12015612e5, 2559],

                [12016476e5, 2521],

                [1201734e6, 2477],

                [12018204e5, 442],

                [12019068e5, 252],

                [12019932e5, 236],

                [12020796e5, 525],

                [1202166e6, 477],

                [12022524e5, 386],

                [12023388e5, 409],

                [12024252e5, 408],

                [12025116e5, 237],

                [1202598e6, 193],

                [12026844e5, 357],

                [12027708e5, 414],

                [12028572e5, 393],

                [12029436e5, 353],

                [120303e7, 364],

                [12031164e5, 215],

                [12032028e5, 214],

                [12032892e5, 356],

                [12033756e5, 1399],

                [1203462e6, 334],

                [12035484e5, 348],

                [12036348e5, 243],

                [12037212e5, 126],

                [12038076e5, 157],

                [1203894e6, 288]

            ];

            for (r = 0; r < v.length; ++r) {

                v[r][0] += 60 * 60 * 1e3

            }

            var m = {

                grid: {

                    hoverable: true,

                    markingsColor: "rgba(0,0,0,0.1)",

                    clickable: true,

                    autoHighlight: true,

                    borderWidth: 0,

                    backgroundColor: "transparent",

                    markings: d

                },

                xaxis: {

                    mode: "time",

                    tickLength: 5,

                    font: {

                        color: "#555",

                        family: "Open Sans, sans-serif",

                        size: 11

                    }

                },

                yaxis: {

                    font: {

                        color: "#555",

                        family: "Open Sans, sans-serif",

                        size: 11

                    },

                    tickColor: "rgba(0,0,0,0.1)"

                },

                points: {

                    radius: 3,

                    show: true,

                    symbol: "circle"

                },

                shadowSize: 0,

                lines: {

                    show: true,

                    fill: true,

                    lineWidth: 7

                },

                colors: ["#8960a7"],

                tooltip: true,

                tooltipOpts: {

                    content: "$%y.2",

                    shifts: {

                        x: -10,

                        y: 25

                    }

                }

            };

            i = e.plot("#placeholder3", [v], m)

        }

        var g = [],

            y;

        if (e("#placeholder4").length) {

            var w = e("#placeholder4");

            var E = 11;

            g = [];

            var S;

            S = [{

                data: b(),

                bars: {

                    show: true,

                    fill: 1,

                    barWidth: .8,

                    align: "center",

                    horizontal: false

                }

            }];

            var x = e.plot(w, S, {

                colors: ["#fff"],

                axisLabelUseCanvas: false,

                grid: {

                    borderWidth: 0,

                    color: "#fff",

                    backgroundColor: "#6a6f76",

                    hoverable: true,

                    mouseActiveRadius: 50,

                    markings: function (e) {

                        var t = [];

                        var n = e.xaxis;

                        for (var r = Math.floor(n.min); r < n.max; r += n.tickSize * 2) {

                            t.push({

                                xaxis: {

                                    from: r,

                                    to: r + n.tickSize

                                },

                                color: "#6a6f76"

                            })

                        }

                        return t

                    }

                },

                xaxis: {

                    color: "#797e83",

                    font: {

                        color: "#fff",

                        family: "Open Sans, sans-serif",

                        size: 11

                    },

                    tickDecimals: 0

                },

                yaxis: {

                    color: "#797e83",

                    font: {

                        color: "#fff",

                        family: "Open Sans, sans-serif",

                        size: 11

                    },

                    min: 0,

                    max: 110

                },

                tooltip: true,

                tooltipOpts: {

                    content: "Core #%x | Loaded %y.2%"

                }

            });

            setInterval(function () {

                S[0].data = b();

                x.setData(S);

                x.draw()

            }, 1e3)

        }

        window.initFloatchartDemo = function () {

            y = Math.floor(Math.random() * 6) + 3;

            for (r = 0; r < y; r++) {

                g[r] = {

                    label: "Series" + (r + 1),

                    data: Math.floor(Math.random() * 100) + 1

                }

            }

            e.plot("#placeholder5", g, {

                colors: ["#333", "#f87aa0", "#5bc0de", "#82b964", "#ccd600", "#f4cc13", "#8960a7", "#454b52", "#d24d33", "#f0ad4e"],

                series: {

                    pie: {

                        show: true,

                        innerRadius: .4,

                        stroke: {

                            width: 0

                        }

                    }

                },

                grid: {

                    hoverable: true,

                    clickable: true

                }

            })

        };

        if (e("#placeholder5").length) {

            window.initFloatchartDemo()

        }

        window.initFloatchartDemo2 = function () {

            series6 = Math.floor(Math.random() * 6) + 3;

            for (r = 0; r < series6; r++) {

                g[r] = {

                    label: "Series" + (r + 1),

                    data: Math.floor(Math.random() * 100) + 1

                }

            }

            e.plot("#placeholder6", g, {

                colors: ["#333", "#f87aa0", "#5bc0de", "#82b964", "#ccd600", "#f4cc13", "#8960a7", "#454b52", "#d24d33", "#f0ad4e"],

                series: {

                    pie: {

                        show: true,

                        stroke: {

                            width: 0

                        }

                    }

                },

                grid: {

                    hoverable: true,

                    clickable: true

                },

                legend: {

                    show: true,

                    backgroundColor: "rgb(255, 255, 255)",

                    backgroundOpacity: .85

                }

            })

        };

        if (e("#placeholder6").length) {

            window.initFloatchartDemo2()

        }

        if (e("#placeholder7").length) {

            g = [];

            var N = 40;

            var C = 200;

            var k = e("#placeholder7");

            var L = e.plot(k, [T()], {

                grid: {

                    borderWidth: 0,

                    hoverable: true,

                    clickable: false,

                    markingsColor: "rgba(255,255,255,0.1)",

                    backgroundColor: "transparent",

                    markings: function (e) {

                        var t = [];

                        var n = e.xaxis;

                        for (var r = Math.floor(n.min); r < n.max; r += n.tickSize * 2) {

                            t.push({

                                xaxis: {

                                    from: r,

                                    to: r + n.tickSize

                                },

                                color: "rgba(255,255,255, 0.2)"

                            })

                        }

                        return t

                    }

                },

                series: {

                    points: {

                        radius: 3,

                        show: true,

                        symbol: "circle"

                    },

                    lines: {

                        show: true,

                        fill: true,

                        lineWidth: 7

                    },

                    tickFormatter: function () {

                        return ""

                    },

                    shadowSize: 0

                },

                yaxis: {

                    font: {

                        color: "#fff",

                        family: "Open Sans, sans-serif",

                        size: 11

                    },

                    min: 0,

                    max: 110

                },

                xaxis: {

                    show: false

                },

                colors: ["#333"]

            });

            e("#start7").change(function () {

                if (e(this).is(":checked")) {

                    e(this).attr("checked", true);

                    timerId = setInterval(function () {

                        L.setData([T()]);

                        L.draw()

                    }, C)

                } else {

                    e(this).attr("checked", true);

                    clearInterval(timerId)

                }

            })

        }

        if (e("#placeholder8").length) {

            var A = [

                [1, 4302],

                [2, 3516],

                [3, 4925],

                [4, 3134],

                [5, 4545],

                [6, 5434],

                [7, 5241],

                [8, 6211],

                [9, 5900],

                [10, 6601],

                [11, 4822],

                [12, 4233]

            ];

            var O = [

                [1, 1802],

                [2, 2344],

                [3, 1543],

                [4, 2016],

                [5, 1900],

                [6, 3511],

                [7, 4144],

                [8, 4655],

                [9, 3442],

                [10, 3445],

                [11, 3132],

                [12, 2598]

            ];

            e.plot(e("#placeholder8"), [{

                data: A,

                label: "Facebook"

            }, {

                data: O,

                label: "Twitter"

            }], {

                series: {

                    lines: {

                        show: true,

                        lineWidth: 7,

                        fill: true,

                        fillColor: "rgba(255,255,255, 0.2)"

                    },

                    points: {

                        show: true,

                        fillColor: "#5bc0de",

                        lineWidth: 3,

                        radius: 5

                    },

                    shadowSize: 0,

                    stack: true

                },

                tooltip: true,

                tooltipOpts: {

                    content: "%y"

                },

                grid: {

                    hoverable: true,

                    clickable: true,

                    color: "#fff",

                    borderWidth: 0

                },

                legend: {

                    color: "#fff"

                },

                colors: ["#fff", "#fff"],

                xaxis: {

                    color: "rgba(255,255,255,0.4)",

                    ticks: [

                        [1, "JAN"],

                        [2, "FEB"],

                        [3, "MAR"],

                        [4, "APR"],

                        [5, "MAY"],

                        [6, "JUN"],

                        [7, "JUL"],

                        [8, "AUG"],

                        [9, "SEP"],

                        [10, "OCT"],

                        [11, "NOV"],

                        [12, "DEC"]

                    ],

                    font: {

                        color: "#fff",

                        size: 11,

                        family: "Open Sans, sans-serif"

                    }

                },

                yaxis: {

                    color: "rgba(255,255,255,0.4)",

                    ticks: 5,

                    show: false,

                    tickDecimals: 0,

                    font: {

                        color: "#fff",

                        size: 11

                    }

                }

            })

        }

        if (e("#external-events div.external-event").length) {

            e("#external-events div.external-event").each(function () {

                var t = {

                    title: e.trim(e(this).text())

                };

                e(this).data("eventObject", t);

                e(this).draggable({

                    zIndex: 999,

                    revert: true,

                    revertDuration: 0

                })

            });

            var M = new Date;

            var _ = M.getDate();

            var D = M.getMonth();

            var P = M.getFullYear();

            e("#calendar").fullCalendar({

                header: {

                    left: "prev,next today,title",

                    right: "month,agendaWeek,agendaDay"

                },

                events: [{

                    title: "All Day Event",

                    start: new Date(P, D, 1),

                    className: ["event", "greenEvent"]

                }, {

                    title: "Long Event",

                    start: new Date(P, D, _ - 5),

                    end: new Date(P, D, _ - 2)

                }, {

                    id: 999,

                    title: "Repeating Event",

                    start: new Date(P, D, _ - 3, 16, 0),

                    allDay: false

                }, {

                    id: 999,

                    title: "Repeating Event",

                    start: new Date(P, D, _ + 4, 16, 0),

                    allDay: false

                }, {

                    title: "Meeting",

                    start: new Date(P, D, _, 10, 30),

                    allDay: false

                }, {

                    title: "Lunch",

                    start: new Date(P, D, _, 12, 0),

                    end: new Date(P, D, _, 14, 0),

                    allDay: false

                }, {

                    title: "Click for Google",

                    start: new Date(P, D, 28),

                    end: new Date(P, D, 29),

                    url: "http://google.com/",

                    className: [".greenEvent"]

                }],

                editable: true,

                droppable: true,

                drop: function (t, n) {

                    var r = e(this).data("eventObject");

                    var i = e.extend({}, r);

                    i.start = t;

                    i.allDay = n;

                    e("#calendar").fullCalendar("renderEvent", i, true);

                    if (e("#drop-remove").is(":checked")) {

                        e(this).remove()

                    }

                }

            })

        }

        var H = new Date;

        var B = H.getDate();

        var j = H.getMonth();

        var F = H.getFullYear();

        if (e("#calendar2").length) {

            e("#calendar2").fullCalendar({

                header: {

                    left: "prev,next today",

                    center: "title",

                    right: "month,basicWeek,basicDay"

                },

                editable: true,

                events: [{

                    title: "All Day Event",

                    start: new Date(F, j, 1)

                }, {

                    title: "Long Event",

                    start: new Date(F, j, B - 5),

                    end: new Date(F, j, B - 2)

                }, {

                    id: 999,

                    title: "Repeating Event",

                    start: new Date(F, j, B - 3, 16, 0),

                    allDay: false

                }, {

                    id: 999,

                    title: "Repeating Event",

                    start: new Date(F, j, B + 4, 16, 0),

                    allDay: false

                }, {

                    title: "Meeting",

                    start: new Date(F, j, B, 10, 30),

                    allDay: false

                }, {

                    title: "Lunch",

                    start: new Date(F, j, B, 12, 0),

                    end: new Date(F, j, B, 14, 0),

                    allDay: false

                }, {

                    title: "Birthday Party",

                    start: new Date(F, j, B + 1, 19, 0),

                    end: new Date(F, j, B + 1, 22, 30),

                    allDay: false

                }, {

                    title: "Click for Google",

                    start: new Date(F, j, 28),

                    end: new Date(F, j, 29),

                    url: "http://google.com/"

                }]

            })

        }

        if (e(".tooltiped").length) {

            e(".tooltiped").tooltip()

        }

        if (e(".tooltiped").length) {

            e(".popovered").popover({

                html: "true"

            })

        }

        if (e(".popover-hovered").length) {

            e(".popover-hovered").popover({

                trigger: "hover",

                html: "true",

                placement: "top"

            })

        }

        if (e(".v-default-animated .progress-bar").length) {

            e(".v-default-animated .progress-bar").progressbar()

        }

        if (e(".h-default-basic .progress-bar").length) {

            e(".h-default-basic .progress-bar").progressbar({

                display_text: "fill",

                use_percentage: false

            })

        }

        if (e(".v-bottom-animated .progress-bar").length) {

            e(".v-bottom-animated .progress-bar").progressbar({

                display_text: "fill"

            })

        }

        e("#toggle-fullscreen").click(function () {

            screenfull.request()

        });

        e(".keep_open").click(function (e) {

            e.stopPropagation()

        });

        if (e(".nano").length) {

            e(".nano").nanoScroller()

        }

        e(".inlinebar2").sparkline("html", {

            type: "bar",

            barWidth: "10px",

            height: "40px",

            enableTagOptions: "true",

            barColor: "#de5546"

        });

        e(".inlinebar").sparkline("html", {

            type: "bar",

            barWidth: "7px",

            height: "40px",

            enableTagOptions: "true",

            barColor: "#969fa1"

        });

        e(".stackedbar").sparkline("html", {

            type: "bar",

            barWidth: "7px",

            height: "40px",

            enableTagOptions: "true",

            stackedBarColor: ["#fff", "#c4c5c5"]

        });

        e(".piechart").sparkline("html", {

            type: "pie",

            width: "40",

            height: "40",

            sliceColors: ["#fff", "#82b964", "#f87aa0", "#109618", "#a4b7bf", "#506066", "#667880", "#8ca0a8"]

        });

        e(".linechart").sparkline("html", {

            type: "line",

            width: "100",

            height: "40",

            lineColor: "#fff",

            fillColor: "#81c1d9",

            lineWidth: 3,

            spotColor: "#ffffff",

            minSpotColor: "#33383d",

            maxSpotColor: "#33383d",

            highlightSpotColor: "#a6c172",

            spotRadius: 3,

            drawNormalOnTop: false

        });

        e(".simpleline").sparkline("html", {

            type: "line",

            width: "100",

            height: "40",

            lineColor: "#82b964",

            fillColor: false,

            lineWidth: 3,

            spotColor: "#ffffff",

            minSpotColor: "#52646c",

            maxSpotColor: "#fff",

            highlightSpotColor: "#a6c172",

            spotRadius: 3,

            drawNormalOnTop: false

        });

        e(".table-sparkline-pie").sparkline("html", {

            type: "pie",

            width: "30",

            height: "30",

            sliceColors: ["#f4b66d", "#993838", "#fff", "#82b964", "#66aa00", "#dd4477", "#0099c6", "#990099 "]

        });

        e(".table-sparkline-pie2").sparkline("html", {

            type: "pie",

            width: "30",

            height: "30",

            sliceColors: ["#5bc0de", "#f0ad4e", "#f87aa0", "#58b868", "#454b52", "#dd4477", "#0099c6", "#990099 "]

        });

        e(".table-sparkline-lines").sparkline("html", {

            type: "line",

            lineColor: "#858689",

            width: "100",

            height: "30",

            fillColor: "#8b8c8d",

            lineWidth: 3,

            spotRadius: 3,

            spotColor: "#f4b66d",

            minSpotColor: "#fff",

            maxSpotColor: "#fff",

            highlightSpotColor: "#a6c172"

        });

        e(".piechart-search").sparkline("html", {

            type: "pie",

            width: "60",

            height: "60",

            sliceColors: ["#f87aa0", "#5bc0de", "#82b964", "#f4cc13", "#454b52", "#d24d33", "#f0ad4e"]

        });

        e("#portlet-compositeline").sparkline("html", {

            fillColor: "rgba(167,96,154,.5)",

            spotRadius: "3",

            width: "310",

            height: "100",

            lineColor: "#a7609a",

            highlightSpotColor: "#a7609a",

            spotColor: "#a7609a",

            minSpotColor: "#a7609a",

            maxSpotColor: "#a7609a",

            lineWidth: 4,

            highlightLineColor: "#a7609a",

            changeRangeMin: 0,

            chartRangeMax: 10

        });

        e("#portlet-compositeline").sparkline([4, 1, 5, 7, 9, 9, 8, 7, 2, 6, 4, 7, 8, 4, 3, 2, 2, 5, 6, 7], {

            composite: true,

            fillColor: "rgba(91,192,222,.7)",

            spotRadius: "3",

            lineColor: "rgba(91,192,222,,1)",

            highlightSpotColor: "#5bc0de",

            spotColor: "#5bc0de",

            minSpotColor: "#5bc0de",

            maxSpotColor: "#5bc0de",

            lineWidth: 4,

            highlightLineColor: "rgba(255,255,255,.2)",

            changeRangeMin: 0,

            chartRangeMax: 10

        });

        e("#portlet-compositebar").sparkline("html", {

            type: "bar",

            barWidth: "20",

            barSpacing: "5",

            width: "310",

            height: "100",

            barColor: "#5bc0de"

        });

        e("#portlet-compositebar").sparkline([4, 1, 5, 7, 9, 9, 8, 7, 6, 6, 4, 7, 8, 4, 3, 2, 2, 5, 6, 7], {

            composite: true,

            fillColor: false,

            spotRadius: "3",

            width: "310",

            height: "100",

            lineColor: "#a7609a",

            highlightSpotColor: "#a7609a",

            spotColor: "#a7609a",

            minSpotColor: "#a7609a",

            maxSpotColor: "#a7609a",

            lineWidth: 4,

            highlightLineColor: "#a7609a",

            changeRangeMin: 0,

            chartRangeMax: 10

        });

        e(".demo-sparkline").sparkline("html", {

            fillColor: false,

            lineColor: "#858689",

            spotColor: "#f4b66d"

        });

        e(".demo-sparkbar").sparkline("html", {

            type: "bar",

            barColor: "#5bc0de",

            negBarColor: "#d24d33",

            stackedBarColor: ["#5bc0de", "#d24d33"]

        });

        e("#demo-compositeline").sparkline("html", {

            fillColor: false,

            lineColor: "#858689",

            spotColor: "#f4b66d",

            changeRangeMin: 0,

            chartRangeMax: 10

        });

        e("#demo-compositeline").sparkline([4, 1, 5, 7, 9, 9, 8, 7, 6, 6, 4, 7, 8, 4, 3, 2, 2, 5, 6, 7], {

            composite: true,

            fillColor: false,

            lineColor: "#d24d33",

            changeRangeMin: 0,

            chartRangeMax: 10

        });

        e("#demo-normalline").sparkline("html", {

            fillColor: false,

            normalRangeMin: -1,

            normalRangeMax: 8

        });

        e("#demo-normalExample").sparkline("html", {

            fillColor: false,

            normalRangeMin: 80,

            normalRangeMax: 95,

            normalRangeColor: "#5bc0de"

        });

        e("#demo-compositebar").sparkline("html", {

            type: "bar",

            barColor: "#5bc0de"

        });

        e("#demo-compositebar").sparkline([4, 1, 5, 7, 9, 9, 8, 7, 6, 6, 4, 7, 8, 4, 3, 2, 2, 5, 6, 7], {

            composite: true,

            fillColor: false,

            lineColor: "#f87aa0"

        });

        e(".demo-discrete1").sparkline("html", {

            type: "discrete",

            lineColor: "#58b868",

            xwidth: 18

        });

        e("#demo-discrete2").sparkline("html", {

            type: "discrete",

            lineColor: "#58b868",

            thresholdColor: "#d24d33",

            thresholdValue: 4

        });

        e(".demo-sparktristatecols").sparkline("html", {

            type: "tristate",

            colorMap: {

                "-2": "#5bc0de",

                2: "#d24d33"

            },

            posBarColor: "#5bc0de",

            negBarColor: "#d24d33"

        });

        e(".demo-sparkboxplot").sparkline("html", {

            type: "box",

            boxLineColor: "#222",

            boxFillColor: "#c4c5c5",

            whiskerColor: "#222",

            outlierLineColor: "#222",

            medianColor: "#333",

            outlierFillColor: "#888"

        });

        e(".demo-boxfieldorder").sparkline("html", {

            type: "box",

            boxLineColor: "#222",

            boxFillColor: "#c4c5c5",

            whiskerColor: "#222",

            outlierLineColor: "#222",

            medianColor: "#333",

            outlierFillColor: "#888",

            tooltipFormatFieldlist: ["med", "lq", "uq"],

            tooltipFormatFieldlistKey: "field"

        });

        e(".demo-sparkbullet").sparkline("html", {

            type: "bullet",

            targetColor: "#d24d33",

            performanceColor: "#969fa1",

            rangeColors: ["#f4cc13", "#8960a7", "#5bc0de", "#82b964"]

        });

        e(".demo-sparkpie").sparkline("html", {

            type: "pie",

            height: "14px",

            sliceColors: ["#f87aa0", "#5bc0de", "#82b964"]

        });

        e(document).ready(function () {

            e(".responsive-menu").click(function () {

                e(".responsive-admin-menu #menu").slideToggle()

            });

            e(window).resize(function () {

                e(".responsive-admin-menu #menu").removeAttr("style")

            });

            (function (n) {

                var r = e(".accordion", n).add(n);

                r.each(function () {

                    var t = e(this);

                    var n = e("> li > a.submenu.active", t);

                    n.next("ul").css("display", "block");

                    n.addClass("downarrow");

                    var r = n.attr("data-id") || "";

                    var i = t.children("li").children("a.submenu");

                    i.click(function (t) {

                        if (r !== "") {

                            e("#" + r).prev("a").removeClass("downarrow");

                            e("#" + r).slideUp("fast")

                        }

                        if (r == e(this).attr("data-id")) {

                            e("#" + e(this).attr("data-id")).slideUp("fast");

                            e(this).removeClass("downarrow");

                            r = ""

                        } else {

                            e("#" + e(this).attr("data-id")).slideDown("fast");

                            r = e(this).attr("data-id");

                            e(this).addClass("downarrow")

                        }

                        t.preventDefault()

                    })

                })

            })(e("#menu"));

            e(".responsive-admin-menu #menu li").hover(function () {

                e(this).addClass("opened").siblings("li").removeClass("opened")

            }, function () {

                e(this).removeClass("opened")

            });

            if (e("#table-1").length) {

                e("#table-1").dataTable()

            }

            if (e("#datatable-accounts").length) {

                e("#accounts a").click(function() {

                    var anchor = $(this);

                    alertify.confirm('Are you sure you want to purchase this account for ' + anchor.text() + '?', function(e) {

                        if(e)

                            window.location = anchor.attr('href');

                    });

                    return false;

                });

            }

            $('.disabled a').click(function() {

                return false;

            });

            var t = [];

            if (e("#table-3").length) {

                e("#table-3").dataTable({

                    bPaginate: false,

                    sDom: 'C<"clear">lfrtip',

                    colVis: {

                        order: "alfa"

                    }

                })

            }

            if (e("#table-2").length) {

                var n = e("#table-2").dataTable({

                    oLanguage: {

                        sSearch: "Search all columns:"

                    }

                });

                e("tfoot input").keyup(function () {

                    n.fnFilter(this.value, e("tfoot input").index(this))

                });

                e("tfoot input").each(function (e) {

                    t[e] = this.value

                });

                e("tfoot input").focus(function () {

                    if (this.className == "search_init") {

                        this.className = "";

                        this.value = ""

                    }

                });

                e("tfoot input").blur(function (n) {

                    if (this.value === "") {

                        this.className = "search_init";

                        this.value = t[e("tfoot input").index(this)]

                    }

                })

            }

            if (typeof google !== "undefined") {

                var r = {

                    zoom: 11,

                    disableDefaultUI: true,

                    center: new google.maps.LatLng(40.67, -73.94),

                    styles: [{

                        featureType: "water",

                        stylers: [{

                            visibility: "on"

                        }, {

                            color: "#638897"

                        }]

                    }, {

                        featureType: "landscape",

                        stylers: [{

                            color: "#f2e5d4"

                        }]

                    }, {

                        featureType: "road.highway",

                        elementType: "geometry",

                        stylers: [{

                            color: "#82b964"

                        }]

                    }, {

                        featureType: "road.arterial",

                        elementType: "geometry",

                        stylers: [{

                            color: "#e4d7c6"

                        }]

                    }, {

                        featureType: "road.local",

                        elementType: "geometry",

                        stylers: [{

                            color: "#fbfaf7"

                        }]

                    }, {

                        featureType: "poi.park",

                        elementType: "geometry",

                        stylers: [{

                            color: "#82b964"

                        }]

                    }, {

                        featureType: "administrative",

                        stylers: [{

                            visibility: "on"

                        }, {

                            lightness: 33

                        }]

                    }, {

                        featureType: "road"

                    }, {

                        featureType: "poi.park",

                        elementType: "labels",

                        stylers: [{

                            visibility: "on"

                        }, {

                            lightness: 20

                        }]

                    }, {}, {

                        featureType: "road",

                        stylers: [{

                            lightness: 20

                        }]

                    }]

                };

                var i = {

                    zoom: 11,

                    disableDefaultUI: true,

                    center: new google.maps.LatLng(40.67, -73.94),

                    styles: [{

                        stylers: [{

                            saturation: -100

                        }, {

                            gamma: 1

                        }]

                    }, {

                        elementType: "labels.text.stroke",

                        stylers: [{

                            visibility: "off"

                        }]

                    }, {

                        featureType: "poi.business",

                        elementType: "labels.text",

                        stylers: [{

                            visibility: "off"

                        }]

                    }, {

                        featureType: "poi.business",

                        elementType: "labels.icon",

                        stylers: [{

                            visibility: "off"

                        }]

                    }, {

                        featureType: "poi.place_of_worship",

                        elementType: "labels.text",

                        stylers: [{

                            visibility: "off"

                        }]

                    }, {

                        featureType: "poi.place_of_worship",

                        elementType: "labels.icon",

                        stylers: [{

                            visibility: "off"

                        }]

                    }, {

                        featureType: "road",

                        elementType: "geometry",

                        stylers: [{

                            visibility: "simplified"

                        }]

                    }, {

                        featureType: "water",

                        stylers: [{

                            visibility: "on"

                        }, {

                            saturation: 50

                        }, {

                            gamma: 0

                        }, {

                            hue: "#50a5d1"

                        }]

                    }, {

                        featureType: "administrative.neighborhood",

                        elementType: "labels.text.fill",

                        stylers: [{

                            color: "#333333"

                        }]

                    }, {

                        featureType: "road.local",

                        elementType: "labels.text",

                        stylers: [{

                            weight: .5

                        }, {

                            color: "#333333"

                        }]

                    }, {

                        featureType: "transit.station",

                        elementType: "labels.icon",

                        stylers: [{

                            gamma: 1

                        }, {

                            saturation: 10

                        }]

                    }]

                };

                var s = {

                    zoom: 11,

                    disableDefaultUI: true,

                    center: new google.maps.LatLng(40.67, -73.94),

                    styles: [{

                        featureType: "water",

                        elementType: "geometry",

                        stylers: [{

                            color: "#81c1d9"

                        }]

                    }, {

                        featureType: "landscape",

                        elementType: "geometry",

                        stylers: [{

                            color: "#f0f0ed"

                        }]

                    }, {

                        featureType: "road",

                        elementType: "geometry",

                        stylers: [{

                            color: "#c4c5c5"

                        }]

                    }, {

                        featureType: "poi",

                        elementType: "geometry",

                        stylers: [{

                            color: "#e2e8e7"

                        }]

                    }, {

                        featureType: "transit",

                        elementType: "geometry",

                        stylers: [{

                            color: "#e2e8e7"

                        }]

                    }, {

                        elementType: "labels.text.stroke",

                        stylers: [{

                            visibility: "on"

                        }, {

                            color: "#81c1d9"

                        }, {

                            weight: 6

                        }]

                    }, {

                        elementType: "labels.text.fill",

                        stylers: [{

                            color: "#ffffff"

                        }]

                    }, {

                        featureType: "administrative",

                        elementType: "geometry",

                        stylers: [{

                            weight: .2

                        }, {

                            color: "#1a3541"

                        }]

                    }, {

                        elementType: "labels.icon",

                        stylers: [{

                            visibility: "off"

                        }]

                    }, {

                        featureType: "poi.park",

                        elementType: "geometry",

                        stylers: [{

                            color: "#e2e8e7"

                        }]

                    }]

                };

                var o = document.getElementById("map_canvas");

                var u = document.getElementById("map_canvas2");

                var a = document.getElementById("map_canvas3");

                var f = new google.maps.Map(o, r);

                var l = new google.maps.Map(u, i);

                var c = new google.maps.Map(a, s)

            }

        });

        if (e("#date, #date2").length) {

            e("#date, #date2").mask("99/99/9999", {

                placeholder: "X"

            })

        }

        if (e("#phone").length) {

            e("#phone").mask("(999) 999-9999", {

                placeholder: "X"

            })

        }

        if (e("#card").length) {

            e("#card").mask("9999-9999-9999-9999", {

                placeholder: "X"

            })

        }

        if (e("#serial").length) {

            e("#serial").mask("***-***-***-***-***-***", {

                placeholder: "_"

            })

        }

        if (e("#tax").length) {

            e("#tax").mask("99-9999999", {

                placeholder: "X"

            })

        }

        if (e("#cvv").length) {

            e("#cvv").mask("999", {

                placeholder: "X"

            })

        }

        if (e("#year").length) {

            e("#year").mask("2099", {

                placeholder: "X"

            })

        }

        if (e("#date").length) {

            e("#date").datepicker({

                dateFormat: "dd.mm.yy",

                prevText: '<i class="fa fa-chevron-left"></i>',

                nextText: '<i class="fa fa-chevron-right"></i>'

            })

        }

        if (e("#start").length) {

            e("#start").datepicker({

                dateFormat: "dd.mm.yy",

                prevText: '<i class="fa fa-chevron-left"></i>',

                nextText: '<i class="fa fa-chevron-right"></i>',

                onSelect: function (t) {

                    e("#finish").datepicker("option", "minDate", t)

                }

            })

        }

        if (e("#finish").length) {

            e("#finish").datepicker({

                dateFormat: "dd.mm.yy",

                prevText: '<i class="fa fa-chevron-left"></i>',

                nextText: '<i class="fa fa-chevron-right"></i>',

                onSelect: function (t) {

                    e("#start").datepicker("option", "maxDate", t)

                }

            })

        }

        if (e("#inline").length) {

            e("#inline").datepicker({

                dateFormat: "dd.mm.yy",

                prevText: '<i class="fa fa-chevron-left"></i>',

                nextText: '<i class="fa fa-chevron-right"></i>'

            })

        }

        if (e("#inline-start").length) {

            e("#inline-start").datepicker({

                dateFormat: "dd.mm.yy",

                prevText: '<i class="fa fa-chevron-left"></i>',

                nextText: '<i class="fa fa-chevron-right"></i>',

                onSelect: function (t) {

                    e("#inline-finish").datepicker("option", "minDate", t)

                }

            })

        }

        if (e("#inline-finish").length) {

            e("#inline-finish").datepicker({

                dateFormat: "dd.mm.yy",

                prevText: '<i class="fa fa-chevron-left"></i>',

                nextText: '<i class="fa fa-chevron-right"></i>',

                onSelect: function (t) {

                    e("#inline-start").datepicker("option", "maxDate", t)

                }

            })

        }

        if (e("#available-validations").length) {

            e("#available-validations").validate({

                rules: {

                    required: {

                        required: true

                    },

                    email: {

                        required: true,

                        email: true

                    },

                    url: {

                        required: true,

                        url: true

                    },

                    date3: {

                        required: true,

                        date: true

                    },

                    min: {

                        required: true,

                        minlength: 5

                    },

                    max: {

                        required: true,

                        maxlength: 5

                    },

                    range: {

                        required: true,

                        rangelength: [5, 10]

                    },

                    digits: {

                        required: true,

                        digits: true

                    },

                    number: {

                        required: true,

                        number: true

                    },

                    minVal: {

                        required: true,

                        min: 5

                    },

                    maxVal: {

                        required: true,

                        max: 100

                    },

                    rangeVal: {

                        required: true,

                        range: [5, 100]

                    }

                },

                messages: {

                    required: {

                        required: "Please enter something"

                    },

                    email: {

                        required: "Please enter your email address"

                    },

                    url: {

                        required: "Please enter your URL"

                    },

                    date3: {

                        required: "Please enter some date in mm/dd/yyyy format"

                    },

                    min: {

                        required: "Please enter some text"

                    },

                    max: {

                        required: "Please enter some text"

                    },

                    range: {

                        required: "Please enter some text"

                    },

                    digits: {

                        required: "Please enter some digits"

                    },

                    number: {

                        required: "Please enter some number"

                    },

                    minVal: {

                        required: "Please enter some value"

                    },

                    maxVal: {

                        required: "Please enter some value"

                    },

                    rangeVal: {

                        required: "Please enter some value"

                    }

                },

                errorPlacement: function (e, t) {

                    e.insertAfter(t.parent())

                }

            })

        }

        if (e("#form-login").length) {

            e("#form-login").validate({

                rules: {

                    username: {

                        required: true,

                        alphanumeric: true

                    },

                    password: {

                        required: true,

                        minlength: 6,

                        maxlength: 32

                    }

                },

                messages: {

                    username: {

                        required: "Please enter your username",

                        alphanumeric: "Please enter a VALID username"

                    },

                    password: {

                        required: "Please enter your password"

                    }

                },

                errorPlacement: function (e, t) {

                    e.insertAfter(t.parent())

                }

            });



            $("input").each(function() {

                if($(this).val().length === 0) {

                    $(this).focus();

                    return false;

                }

            });

        }

        if (e("#form-register").length) {

            e("#form-register").validate({

                rules: {

                    username: {

                        required: true,

                        minlength: 1,

                        maxlength: 15,

                        alphanumeric: true

                    },

                    password: {

                        required: true,

                        minlength: 6

                    },

                    confirm_password: {

                        required: true,

                        equalTo: "#password",

                        maxlength: 32

                    },

                    email: {

                        required: true,

                        email: true,

                        maxlength: 40

                    }

                },

                messages: {

                    username: {

                        required: "Please enter your username",

                        minlength: "Please enter a VALID username",

                        maxlength: "Your username must be between 1-15 characters",

                        alphanumeric: "Please enter an alphanumeric username only (including space)"

                    },

                    password: {

                        required: "Please enter your password"

                    },

                    email: {

                        required: "Pleaase enter your e-mail",

                        maxlength: "Please enter a VALID e-mail"

                    }

                },

                errorPlacement: function (e, t) {

                    e.insertAfter(t.parent())

                }

            });



            $("input").each(function() {

                if($(this).val().length === 0) {

                    $(this).focus();

                    return false;

                }

            });

        }

        if (e("#checkout-form").length) {

            e("#checkout-form").validate({

                rules: {

                    fname: {

                        required: true

                    },

                    lname: {

                        required: true

                    },

                    email: {

                        required: true,

                        email: true

                    },

                    phone: {

                        required: true

                    },

                    country: {

                        required: true

                    },

                    city: {

                        required: true

                    },

                    code: {

                        required: true,

                        digits: true

                    },

                    address: {

                        required: true

                    },

                    name: {

                        required: true

                    },

                    card: {

                        required: true

                    },

                    cvv: {

                        required: true,

                        digits: true

                    },

                    month: {

                        required: true

                    },

                    year: {

                        required: true,

                        digits: true

                    }

                },

                messages: {

                    fname: {

                        required: "Please enter your first name"

                    },

                    lname: {

                        required: "Please enter your last name"

                    },

                    email: {

                        required: "Please enter your email address",

                        email: "Please enter a VALID email address"

                    },

                    phone: {

                        required: "Please enter your phone number"

                    },

                    country: {

                        required: "Please select your country"

                    },

                    city: {

                        required: "Please enter your city"

                    },

                    code: {

                        required: "Please enter code",

                        digits: "Digits only please"

                    },

                    address: {

                        required: "Please enter your full address"

                    },

                    name: {

                        required: "Please enter name on your card"

                    },

                    card: {

                        required: "Please enter your card number"

                    },

                    cvv: {

                        required: "Enter CVV2",

                        digits: "Digits only"

                    },

                    month: {

                        required: "Select month"

                    },

                    year: {

                        required: "Enter year",

                        digits: "Digits only please"

                    }

                },

                errorPlacement: function (e, t) {

                    e.insertAfter(t.parent())

                }

            })

        }

        if (e("#order-form").length) {

            e("#order-form").validate({

                rules: {

                    name: {

                        required: true

                    },

                    email: {

                        required: true,

                        email: true

                    },

                    phone: {

                        required: true

                    },

                    interested: {

                        required: true

                    },

                    budget: {

                        required: true

                    }

                },

                messages: {

                    name: {

                        required: "Please enter your name"

                    },

                    email: {

                        required: "Please enter your email address",

                        email: "Please enter a VALID email address"

                    },

                    phone: {

                        required: "Please enter your phone number"

                    },

                    interested: {

                        required: "Please select interested service"

                    },

                    budget: {

                        required: "Please select your budget"

                    }

                },

                submitHandler: function (t) {

                    e(t).ajaxSubmit({

                        beforeSend: function () {

                            e('#order-form button[type="submit"]').addClass("button-uploading").attr("disabled", true)

                        },

                        uploadProgress: function (t, n, r, i) {

                            e("#order-form .progress").text(i + "%")

                        },

                        success: function () {

                            e("#order-form").addClass("submited");

                            e('#order-form button[type="submit"]').removeClass("button-uploading").attr("disabled", false)

                        }

                    })

                },

                errorPlacement: function (e, t) {

                    e.insertAfter(t.parent())

                }

            })

        }

        if (e("#registration-form").length) {

            e("#registration-form").validate({

                rules: {

                    username: {

                        required: true

                    },

                    email: {

                        required: true,

                        email: true

                    },

                    password: {

                        required: true,

                        minlength: 3,

                        maxlength: 20

                    },

                    passwordConfirm: {

                        required: true,

                        minlength: 3,

                        maxlength: 20,

                        equalTo: "#password"

                    },

                    firstname: {

                        required: true

                    },

                    lastname: {

                        required: true

                    },

                    gender: {

                        required: true

                    },

                    terms: {

                        required: true

                    }

                },

                messages: {

                    login: {

                        required: "Please enter your login"

                    },

                    email: {

                        required: "Please enter your email address",

                        email: "Please enter a VALID email address"

                    },

                    password: {

                        required: "Please enter your password"

                    },

                    passwordConfirm: {

                        required: "Please enter your password one more time",

                        equalTo: "Please enter the same password as above"

                    },

                    firstname: {

                        required: "Please select your first name"

                    },

                    lastname: {

                        required: "Please select your last name"

                    },

                    gender: {

                        required: "Please select your gender"

                    },

                    terms: {

                        required: "You must agree with Terms and Conditions"

                    }

                },

                errorPlacement: function (e, t) {

                    e.insertAfter(t.parent())

                }

            })

        }

        if (e("#review-form").length) {

            e("#review-form").validate({

                rules: {

                    name: {

                        required: true

                    },

                    email: {

                        required: true,

                        email: true

                    },

                    review: {

                        required: true,

                        minlength: 20

                    },

                    quality: {

                        required: true

                    },

                    reliability: {

                        required: true

                    },

                    overall: {

                        required: true

                    }

                },

                messages: {

                    name: {

                        required: "Please enter your name"

                    },

                    email: {

                        required: "Please enter your email address",

                        email: "Please enter a VALID email address"

                    },

                    review: {

                        required: "Please enter your review"

                    },

                    quality: {

                        required: "Please rate quality of the product"

                    },

                    reliability: {

                        required: "Please rate reliability of the product"

                    },

                    overall: {

                        required: "Please rate the product"

                    }

                },

                submitHandler: function (t) {

                    e(t).ajaxSubmit({

                        beforeSend: function () {

                            e('#review-form button[type="submit"]').attr("disabled", true)

                        },

                        success: function () {

                            e("#review-form").addClass("submited")

                        }

                    })

                },

                errorPlacement: function (e, t) {

                    e.insertAfter(t.parent())

                }

            })

        }

        if (e("#wizard").length) {

            e("#wizard").steps({

                bodyTag: "fieldset",

                autoFocus: true,

                transitionEffect: "slideLeft",

                finish: "Continue",

                onStepChanging: function (t, n, r) {

                    e("#steps-wizard").validate().settings.ignore = ":disabled,:hidden";

                    return e("#steps-wizard").valid()

                },

                onFinishing: function () {

                    e("#steps-wizard").validate().settings.ignore = ":disabled";

                    return e("#steps-wizard").valid()

                },

                onFinished: function () {

                    e("#steps-wizard").submit()

                }

            })

        }

        if (e("#steps-wizard").length) {

            e("#steps-wizard").validate({

                rules: {

                    fname: {

                        required: true

                    },

                    lname: {

                        required: true

                    },

                    email: {

                        required: true,

                        email: true

                    },

                    phone: {

                        required: true

                    },

                    country: {

                        required: true

                    },

                    city: {

                        required: true

                    },

                    code: {

                        required: true,

                        digits: true

                    },

                    address: {

                        required: true

                    },

                    name: {

                        required: true

                    },

                    card: {

                        required: true

                    },

                    cvv: {

                        required: true,

                        digits: true

                    },

                    month: {

                        required: true

                    },

                    year: {

                        required: true,

                        digits: true

                    }

                },

                messages: {

                    fname: {

                        required: "Please enter your first name"

                    },

                    lname: {

                        required: "Please enter your last name"

                    },

                    email: {

                        required: "Please enter your email address",

                        email: "Please enter a VALID email address"

                    },

                    phone: {

                        required: "Please enter your phone number"

                    },

                    country: {

                        required: "Please select your country"

                    },

                    city: {

                        required: "Please enter your city"

                    },

                    code: {

                        required: "Please enter code",

                        digits: "Digits only please"

                    },

                    address: {

                        required: "Please enter your full address"

                    },

                    name: {

                        required: "Please enter name on your card"

                    },

                    card: {

                        required: "Please enter your card number"

                    },

                    cvv: {

                        required: "Enter CVV2",

                        digits: "Digits only"

                    },

                    month: {

                        required: "Select month"

                    },

                    year: {

                        required: "Enter year",

                        digits: "Digits only please"

                    }

                },

                errorPlacement: function (e, t) {

                    e.insertAfter(t.parent())

                }

            })

        }

        if (e("#easy1").length) {

            e("#easy1").easyPieChart({

                easing: "easeOutBounce",

                lineWidth: "10",

                size: 50,

                trackColor: "#f1f1f1",

                lineCap: "butt",

                barColor: "#5bc0de",

                scaleColor: false,

                onStep: function (t, n, r) {

                    e(this.el).find(".percent").text(Math.round(r))

                }

            })

        }

        if (e("#easy2").length) {

            e("#easy2").easyPieChart({

                easing: "easeOutBounce",

                lineWidth: "10",

                size: 50,

                trackColor: "#fff",

                lineCap: "butt",

                barColor: "#82b964",

                scaleColor: false,

                onStep: function (t, n, r) {

                    e(this.el).find(".percent").text(Math.round(r))

                }

            })

        }

        if (e("#easy3").length) {

            e("#easy3").easyPieChart({

                easing: "easeOutBounce",

                lineWidth: "10",

                size: 50,

                trackColor: "#993838",

                lineCap: "butt",

                barColor: "#cc6699",

                scaleColor: false,

                onStep: function (t, n, r) {

                    e(this.el).find(".percent").text(Math.round(r))

                }

            })

        }

        if (e("#easy4").length) {

            e("#easy4").easyPieChart({

                easing: "easeOutBounce",

                lineWidth: "10",

                size: 50,

                trackColor: "#33383d",

                lineCap: "butt",

                barColor: "#638897",

                scaleColor: false,

                onStep: function (t, n, r) {

                    e(this.el).find(".percent").text(Math.round(r))

                }

            })

        }

        if (e("#easy5").length) {

            e("#easy5").easyPieChart({

                easing: "easeOutBounce",

                lineWidth: "10",

                size: 50,

                trackColor: "#5d6371",

                lineCap: "butt",

                barColor: "#dodoce",

                scaleColor: false,

                onStep: function (t, n, r) {

                    e(this.el).find(".percent").text(Math.round(r))

                }

            })

        }

        if (e("#easy6").length) {

            e("#easy6").easyPieChart({

                easing: "easeOutBounce",

                lineWidth: "23",

                trackColor: false,

                lineCap: "butt",

                barColor: "#f4b66d",

                scaleColor: false,

                onStep: function (t, n, r) {

                    e(this.el).find(".percent").text(Math.round(r))

                }

            })

        }

        if (e("#easy7").length) {

            e("#easy7").easyPieChart({

                easing: "easeOutBounce",

                lineWidth: "23",

                trackColor: "#999",

                lineCap: "butt",

                barColor: "#fff",

                scaleColor: false,

                onStep: function (t, n, r) {

                    e(this.el).find(".percent").text(Math.round(r))

                }

            })

        }

        if (e("#easy8").length) {

            e("#easy8").easyPieChart({

                easing: "easeOutBounce",

                lineWidth: "23",

                trackColor: "#cacac8",

                lineCap: "butt",

                barColor: "#949fb2",

                scaleColor: false,

                onStep: function (t, n, r) {

                    e(this.el).find(".percent").text(Math.round(r))

                }

            })

        }

        //var q = new cbpHorizontalSlideOutMenu(document.getElementById("cbp-hsmenu-wrapper"));

        if (e("#summernote").length) {

            e("#summernote").summernote({

                

                height: e("#summernote").data('height'),

                focus: false

            });

            e(".goaway").click(function (t) {

                t.preventDefault();

                e("#signout").modal();

                e("#yesigo").click(function () {

                    window.open("admin-login.html", "_self");

                    e("#signout").modal("hide")

                })

            })

        }

        if (e("#form-createpost").length) {

            e("#form-createpost").validate({

                rules: {

                    title: {

                        required: true,

                        maxlength: 128

                    },

                    color: {

                        required: true

                    },

                    icon: {

                        required: true

                    },

                    content: {

                        required: true

                    }

                },

                errorPlacement: function (e, t) {

                }

            });

            $("input, textarea").each(function() {

                if($(this).val().length === 0) {

                    $(this).focus();

                    return false;

                }

            });

        }



        e(".lockme").click(function (t) {

            t.preventDefault();

            e("#lockscreen").modal();

            e("#yesilock").click(function () {

                window.open("admin-lock.html", "_self");

                e("#lockscreen").modal("hide")

            })

        });

        if (document.getElementById("items")) {

            var z, W;

            z = document.getElementById("items");

            W = Array.prototype.slice.call(z.querySelectorAll("div.items-options > a"));

            R()

        }

        e(".checkall").click(function () {

            var t = e(this).parents("table");

            var n = t.find(".checkbox");

            var r = e(this).is(":checked");

            n.prop("checked", r).parent().toggleClass("checked", r);

            t.find("tbody:first tr").toggleClass("selected", r)

        });

        e(".fa-star").click(function () {

            var t = e(this).is(".star-yellow");

            e(this).toggleClass("star-yellow", !t).toggleClass("star-grey", t)

        });

        e(".mailinbox tbody input:checkbox").click(function () {

            e(this).parents("tr").toggleClass("selected", e(this).prop("checked"))

        });

        e(".delete").click(function (t) {

            t.preventDefault();

            var n = e(".mailinbox .checkbox:checked");

            var r = n.length;

            if (r === 0) {

                V("No selected message");

                return

            }

            n.parents("tr").remove();

            var i = n.length > 1 ? "messages" : "message";

            var s = n.length + " " + i + " deleted";

            V(s)

        });

        e(".mark_read, .mark_unread").click(function (t) {

            t.preventDefault();

            var n = e(".mailinbox .checkbox:checked");

            var r = n.length;

            if (r === 0) {

                V("No selected message");

                return

            }

            n.parents("tr").toggleClass("unread", !e(this).is(".mark_read"));

            var i = n.length > 1 ? "messages were" : "message was";

            var s = e(this).is(".mark_read") ? " read" : " unread";

            var o = n.length + " " + i + " marked as " + s;

            V(o)

        });

        e(".refresh").click(function (e) {

            e.preventDefault();

            K()

        });

        var X = e('<div class="alert alert-danger alert-inbox">').css({

            display: "none",

            position: "absolute",

            top: "40%"

        }).appendTo(".table-ctn");

        var J = e('<div class="loader-cnt">').appendTo(".table-ctn");

        e('<div class="fa fa-refresh fa-spin loader">').appendTo(J);

        var Q = [{

            value: 30,

            color: "#82b964"

        }, {

            value: 50,

            color: "#58b868"

        }, {

            value: 100,

            color: "#009485"

        }, {

            value: 40,

            color: "#ccd600"

        }, {

            value: 120,

            color: "#f4cc13"

        }];

        var G = {

            segmentShowStroke: false,

            percentageInnerCutout: 40

        };

        var Y = [{

            value: 30,

            color: "#595f66"

        }, {

            value: 50,

            color: "#f4cc13"

        }, {

            value: 100,

            color: "#fff"

        }, {

            value: 40,

            color: "#454b52"

        }];

        var Z = {

            segmentShowStroke: false,

            percentageInnerCutout: 40

        };

        var et = [{

            value: 15,

            color: "#a7609a"

        }, {

            value: 35,

            color: "#d24d33"

        }, {

            value: 10,

            color: "#f87aa0"

        }, {

            value: 40,

            color: "#f0ad4e"

        }];

        var tt = {

            segmentShowStroke: false,

            percentageInnerCutout: 40

        };

        var nt = [{

            value: 40,

            color: "#454b52"

        }, {

            value: 20,

            color: "#fff"

        }, {

            value: 20,

            color: "#5bc0de"

        }, {

            value: 20,

            color: "#993838"

        }];

        var rt = {

            segmentShowStroke: false,

            percentageInnerCutout: 40

        };

        var it = {

            labels: ["", "", "", "", "", "", ""],

            datasets: [{

                fillColor: "rgba(150,159,161,0.5)",

                strokeColor: "rgba(150,159,161,1)",

                pointColor: "rgba(150,159,161,1)",

                pointStrokeColor: "#fff",

                data: [65, 59, 90, 81, 56, 55, 40]

            }, {

                fillColor: "rgba(91,192,222,0.5)",

                strokeColor: "rgba(91,192,222,1)",

                pointColor: "rgba(91,192,222,1)",

                pointStrokeColor: "#fff",

                data: [28, 48, 40, 19, 96, 27, 100]

            }]

        };

        var st = {

            scaleFontFamily: "'Open Sans'",

            scaleFontSize: 11

        };

        var ot = {

            labels: ["", "", "", "", "", "", ""],

            datasets: [{

                fillColor: "rgba(244,204,19,0.5)",

                strokeColor: "#f4cc13",

                data: [65, 59, 99, 81, 56, 55, 40]

            }, {

                fillColor: "rgba(91,192,222,0.5)",

                strokeColor: "rgba(91,192,222,1)",

                data: [28, 48, 88, 56, 72, 65, 100]

            }, {

                fillColor: "rgba(255,255,255,0.5)",

                strokeColor: "#fff",

                data: [12, 32, 42, 13, 33, 27, 59]

            }]

        };

        var ut = {

            pointDot: false,

            datasetStrokeWidth: 4,

            scaleShowGridLines: true,

            scaleShowLabels: false

        };

        var at = {

            labels: ["", "", "", "", "", "", ""],

            datasets: [{

                fillColor: "rgba(51,56,61,0.8)",

                strokeColor: "#33383d",

                data: [88, 71, 99, 83, 99, 66, 71]

            }, {

                fillColor: "rgba(153,56,56,0.8)",

                strokeColor: "#993838",

                data: [65, 59, 99, 81, 56, 55, 0]

            }, {

                fillColor: "rgba(210,77,51,0.8)",

                strokeColor: "#d24d33",

                data: [28, 48, 88, 56, 72, 10, 0]

            }, {

                fillColor: "rgba(240,173,78,0.8)",

                strokeColor: "#f0ad4e",

                data: [12, 32, 42, 13, 33, 27, 0]

            }]

        };

        var ft = {

            pointDot: false,

            datasetStrokeWidth: 4,

            scaleShowGridLines: true,

            scaleShowLabels: false

        };

        var lt = [{

            value: 30,

            color: "#f87aa0"

        }, {

            value: 50,

            color: "#a7609a"

        }, {

            value: 20,

            color: "#d24d33"

        }, {

            value: 10,

            color: "#454b52"

        }, {

            value: 20,

            color: "#993838"

        }];

        var ct = {

            segmentShowStroke: false

        };

        var ht = {

            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],

            datasets: [{

                fillColor: "rgba(150,159,161,0.5)",

                strokeColor: "rgba(150,159,161,1)",

                data: [65, 59, 90, 81, 56, 55, 40]

            }, {

                fillColor: "rgba(210,77,51,0.5)",

                strokeColor: "rgba(210,77,51,1)",

                data: [28, 48, 40, 19, 96, 27, 100]

            }]

        };

        var pt = {

            scaleFontFamily: "'Open Sans'",

            scaleFontSize: 11

        };

        var dt = [{

            value: Math.random(),

            color: "#a7609a"

        }, {

            value: Math.random(),

            color: "#d24d33"

        }, {

            value: Math.random(),

            color: "#21323D"

        }, {

            value: Math.random(),

            color: "#9D9B7F"

        }, {

            value: Math.random(),

            color: "#7D4F6D"

        }, {

            value: Math.random(),

            color: "#82b964"

        }];

        var vt = {

            scaleFontFamily: "'Open Sans'",

            scaleFontSize: 10,

            scaleBackdropColor: "rgba(0,0,0,0.75)",

            scaleBackdropPaddingY: 4,

            scaleBackdropPaddingX: 4,

            scaleFontColor: "#fff",

            segmentShowStroke: false

        };

        var mt = {

            labels: ["", "", "", "", "", "", ""],

            datasets: [{

                fillColor: "rgba(150,159,161,0.5)",

                strokeColor: "rgba(150,159,161,1)",

                pointColor: "rgba(150,159,161,1)",

                pointStrokeColor: "#fff",

                data: [65, 59, 90, 81, 56, 55, 40]

            }, {

                fillColor: "rgba(88,184,104,0.5)",

                strokeColor: "rgba(88,184,104,1)",

                pointColor: "rgba(88,184,104,1)",

                pointStrokeColor: "#fff",

                data: [28, 48, 40, 19, 96, 27, 100]

            }]

        };

        if (e("#chartjs-doughnut").length > 0) {

            (new Chart(document.getElementById("chartjs-doughnut").getContext("2d"))).Doughnut(Q, G)

        }

        if (e("#chartjs-doughnut2").length > 0) {

            (new Chart(document.getElementById("chartjs-doughnut2").getContext("2d"))).Doughnut(Y, Z)

        }

        if (e("#chartjs-doughnut3").length > 0) {

            (new Chart(document.getElementById("chartjs-doughnut3").getContext("2d"))).Doughnut(et, tt)

        }

        if (e("#chartjs-doughnut4").length > 0) {

            (new Chart(document.getElementById("chartjs-doughnut4").getContext("2d"))).Doughnut(nt, rt)

        }

        if (e("#chartjs-line").length > 0) {

            (new Chart(document.getElementById("chartjs-line").getContext("2d"))).Line(it, st)

        }

        if (e("#chartjs-line-portlet").length > 0) {

            (new Chart(document.getElementById("chartjs-line-portlet").getContext("2d"))).Line(ot, ut)

        }

        if (e("#chartjs-line-portlet2").length > 0) {

            (new Chart(document.getElementById("chartjs-line-portlet2").getContext("2d"))).Line(at, ft)

        }

        if (e("#chartjs-radar").length > 0) {

            (new Chart(document.getElementById("chartjs-radar").getContext("2d"))).Radar(mt)

        }

        if (e("#chartjs-polarArea").length > 0) {

            (new Chart(document.getElementById("chartjs-polarArea").getContext("2d"))).PolarArea(dt, vt)

        }

        if (e("#chartjs-bar").length > 0) {

            (new Chart(document.getElementById("chartjs-bar").getContext("2d"))).Bar(ht, pt)

        }

        if (e("#chartjs-pie").length > 0) {

            (new Chart(document.getElementById("chartjs-pie").getContext("2d"))).Pie(lt, ct)

        }

    })

})(jQuery)