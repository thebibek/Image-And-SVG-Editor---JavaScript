    function l(args) { console.log(args); }
    setTimeout(function(){
        $(".full-screen-loader").fadeOut(500);
    },500);
    function generateButtonPath(start, offset, width, height) {
        let halfHeight = parseInt(height / 2)
        let path = "M" + start + " " + halfHeight + " L" + offset + " " + start + " "; // Start Points
        path += (width - offset) + " " + start + " " + width + " " + halfHeight + " "; // Top Points
        path += (width - offset) + " " + height + " " + offset + " " + height; // Bottom Points
        path += " " + start + " " + halfHeight; // End Points
        return path;
    }

    function generateSvgBorder(btn) {
        let width = $(btn).width() + 10,
            height = $(btn).height() + 10,
            halfHeight = parseInt(height / 2),
            offset = 10;
        // Gradient Color
        let gradient = '  <defs><radialGradient id="btnGradient"><stop offset="37%" stop-color="rgba(255,185,4,1)" /><stop offset="86%" stop-color="rgba(254,111,2,1)" /></radialGradient></defs>';

        // Border Path
        let path = generateButtonPath(0, offset, width, height);
        path = '<path class="path" d="' + path + '" />';
        let viewBox = "0 0 " + width + " " + height;
        let svg = '<svg ersion="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="' + viewBox + '" style="enable-background:new ' + viewBox + ';" xml:space="preserve">';
        svg += gradient;
        svg += path;
        svg += '</svg>';
        return svg;
    }
    // Genereate Down Arraw
    function genereateSvgLinkArrow(btn) {
        let width = $(btn).width() + 10,
            height = $(btn).height() + 10,
            halfHeight = parseInt(height / 2),
            offset = 10;
        // Button Line
        let line = '<line class="svgObject" x1="0" y1="' + halfHeight + '" x2="' + (offset * 5) + '" y2="' + halfHeight + '" class="path" />';
        let cx = (offset * 5) + ((offset * 3) / 2);
        let circle = '<circle class="svgObject" cx="' + cx + '" cy="' + halfHeight + '" r="' + (offset * 3) + '" />';
        cx += 2;
        let radius = offset * 2;
        let points = generatePolygon(cx, halfHeight, 6, radius),
            points2 = generatePolygon(cx - 5, halfHeight, 6, radius),
            polygon = '<polygon class="svgObject arrowBox" points="' + points + '" />',
            polygon2 = '<polygon class="svgObject arrowBox darkStroke" points="' + points2 + '" />',
            arrow = '<path class="svgObject arrow" d="M' + (cx - (radius / 2)) + ' ' + halfHeight + ' L' + cx + ' ' + (radius + (radius / 2)) + ' ' + (cx + (radius / 2)) + ' ' + halfHeight + ' "/>';

        svg = '<svg ersion="1.1" class="arrowSvg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 ' + width + ' ' + height + '" style="enable-background:new 0 0 368 368;" xml:space="preserve">';
        svg += line;
        svg += polygon2;
        svg += polygon;
        svg += arrow;
        svg += '</svg>';
        return svg;
    }
    $(".s-btn").each(function() {
        // Button Border
        let svg = generateSvgBorder($(this));
        $(this).append(svg);
        $(this).append(svg);
        let propertiest = $(this).get(0).getBoundingClientRect();
        $(this).css({
            "width": propertiest.width + "px",
            "height": propertiest.height + "px"
        });
        // Make Text Overlay
        $(this).find(".text").addClass("overlay")

        // Button Arrow
        //svg = genereateSvgLinkArrow();

        //$(svg).insertAfter($(this));

    });

    function pts(sideCount, radius) {
        const angle = 360 / sideCount;
        const vertexIndices = range(sideCount);
        const offsetDeg = 90 - ((180 - angle) / 2);
        const offset = degreesToRadians(offsetDeg);

        return vertexIndices.map((index) => {
            return {
                theta: offset + degreesToRadians(angle * index),
                r: radius,
            };
        });
    }

    function range(count) {
        return Array.from(Array(count).keys());
    }

    function degreesToRadians(angleInDegrees) {
        return (Math.PI * angleInDegrees) / 180;
    }


    function polygon([cx, cy], sideCount, radius) {
        return pts(sideCount, radius)
            .map(({ r, theta }) => [
                cx + r * Math.cos(theta),
                cy + r * Math.sin(theta),
            ])
            .join(' ');
    }

    function generatePolygon(cx, cy, sideCount, radius) {
        const s = 2 * radius + 50;

        const res = polygon([cx, cy], sideCount, radius);
        const viz = polygon([s / 2, s / 2], sideCount, radius);

        return res;
    }
    // Loader
    function getLoader(container) {
        let loader = '';
        if (container)
            loader += '<div class="loader-container">';
        loader += '<div class="loader">';
        loader += '<span class="load load1"></span>';
        loader += '<span class="load load2"></span>';
        loader += '<span class="text">Loading</span>';
        loader += '</div>';
        if (container)
            loader += '</div>';
        return loader;
    }
    const loader = getLoader(false);
    // Active page Link
    const c_location = location.href;
    let c_link = c_location.split("/").pop();
    let newAr = c_link.split("?");
    c_link = newAr[0];
    const menu_links = $(".sidebar .nav .nav-item a");
    menu_links.parent().removeClass('active');
    Array.from(menu_links).forEach((link) => {
        let href = $(link).attr("href").split("/").pop();
        if (href === c_link) {
            $(link).addClass("active");
        }
    });
    // Upload File label
    $(".file-upload-label .file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop(),
            parent = $(this).parents(".form-group");
        let files = $(this).get(0).files;
        fileName = files.length + " File";
        if (files.length != 1) {
            fileName += "s";
        }
        parent.find(".file-name").val(fileName);
    });
    // Submit form
    $(".submit_form").on("submit", function(e) {
        e.preventDefault();
        let formData = $(this).serialize(),
            submitBtn = $(this).find("[type='submit']"),
            btnText = submitBtn.html(),
            form = this;
        let valid = true;
        let inputs = $(this).find("input");
        for (let i = 0; i < inputs.length; i++) {
            if (!validInput(inputs[i])) {
                valid = false;
                break;
            }
        }
        if (valid) {
            let u_password = $(this).find(".u_password");
            if (u_password.length > 0) {
                if (u_password.get(0).value !== u_password.get(1).value) {
                    valid = false;
                    appendError($(u_password.get(1)).parents(".form-group"), "Password is not matching.", u_password.get(1));
                }
            }
        }
        // File
        let file = $(form).find('input[type="file"]');
        if (file.length > 0) {
            formData = new FormData(form);
        }
        if (valid) {
            let ajaxObject = {
                url: "controllers/controller.php",
                type: "POST",
                data: formData,
                dataType: "json",
                beforeSend: function() {
                    disableBtn(submitBtn.get(0));
                },
                success: function(response) {
                    enableBtn(submitBtn, btnText);
                    if ("redirect" in response) {
                        if (response.redirect === "refresh") {
                            location.reload();
                        } else {
                            location.assign(response.redirect);
                        }
                    } else {
                        if ("heading" in response) {
                            sAlert(response.data, response.heading, response.status)
                        } else {
                            sAlert(response.data, response.status);
                        }
                    }
                    if (response.status === "success") {
                        form.reset();
                    }
                },
                error: function() {
                    makeError();
                    enableBtn(submitBtn, btnText);
                }
            };
            if (file.length > 0) {
                ajaxObject.processData = false;
                ajaxObject.contentType = false;
            }
            $.ajax(ajaxObject);
        }
    });
    // Disaled button
    function disableBtn(btn) {
        btn = $(btn);
        btn.html(loader);
        btn.addClass('disabled');
        btn.prop('disabled', true);
    }
    // Enable button
    function enableBtn(btn, text) {
        btn = $(btn);
        btn.html(text);
        btn.removeClass('disabled');
        btn.prop('disabled', false);
    }
    // valid Inputs
    function validInput(el) {
        valid = true;
        let value = $(el).val();
        let parent = $(el).parents(".form-group");
        if ($(el).attr("name") === "email") {
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (!re.test(value)) {
                appendError(parent, "Invalid Email", el);
                valid = false;
            }
        }
        if (valid) {
            if (el.hasAttribute("required")) {
                if ($(el).val().length < 1) {
                    let error = '<p class="error">Required</p>';
                    if (parent.find(".error").length < 1) {
                        parent.append(error);
                        valid = false;
                    }
                }
            }
        }
        if (valid) {
            if (el.hasAttribute("data-length")) {
                let validLength = $(el).attr("data-length");
                if (validLength.indexOf("[") != -1) {
                    validLength = validLength.substr(1, validLength.length - 2);
                    let fullLength = validLength.split(",");
                    minLength = parseInt(fullLength[0]);
                    maxLength = parseInt(fullLength[1]);
                    if (value.length < minLength) {
                        valid = appendError(parent, "Minimum Length should be " + minLength, el);
                    }
                    if (maxLength != 0 && maxLength > minLength) {
                        if (value.length > maxLength) {
                            valid = appendError(parent, "Maximum Length should be " + maxLength, el);
                        }
                    }
                } else {
                    if ($(el).val().length != parseInt(validLength)) {
                        valid = appendError(parent, "Length should be " + maxLength, el);
                    }
                }
            }
        }
        if (valid) {
            parent.find(".error").remove();
            parent.removeClass("err");
        }
        if ($(el).hasClass("file-input")) {
            if ($(el).hasClass("required")) {
                if ($(el).val().length < 1) {
                    valid = false;
                    $(el).parents(".form-group").first().find(".file-name").val("Please Select File").focus();
                }
            }
        }
        return valid;
    }

    function isFloat(n) {
        return Number(n) === n && n % 1 !== 0;
    }
    // Get Number
    function toNumber(str) {
        if (typeof(str) == "number" || typeof(str) == "float") return str;
        if (str) {
            str = str.replace(/[^\d.]/g, "");
            if (str.length > 0) {
                str = parseFloat(str);
            }
        }
        str = parseFloat(str);
        if (isNaN(str)) {
            return false;
        } else {
            return str;
        }
    }

    function appendError(parent, err, el) {
        let error = '<p class="error">' + err + '</p>';
        parent.addClass("err");
        if (parent.find(".error").length < 1) {
            parent.append(error);
        } else {
            parent.find(".error").html(err);
        }
        el.focus();
        return false;
    }
    // Alert Fuction
    function sAlert(text, heading, type) {
        let iconType = heading.toLowerCase();
        if (type) {
            iconType = type;
        }
        Swal.fire({
            title: heading,
            text: text,
            type: iconType
        });
    }
    // Error
    function makeError() {
        Swal.fire({
            title: 'Oops...',
            text: 'Something went wrong! Please try again',
            type: "error"
        });
    }
    // Custom dropdown list
    $(".dropdown.ms-list").on("click", ".dropdown-menu .dropdown-item", function() {
        selectMSListItem($(this));
    });
    // Selected Dropdown list
    $(".dropdown.ms-list .dropdown-menu .dropdown-item").each(function() {
        let parent = $(this).parents(".dropdown");
        if ($(this).hasClass("selected")) {
            selectMSListItem($(this));
        }
    });
    // Select List Item
    function selectMSListItem(item) {
        if (!item) return;
        let dropdown = $(item).parents(".dropdown");
        dropdown.find(".dropdown-menu .dropdown-item").removeClass("selected");
        $(item).addClass("selected");
        dropdown.find(".dropdown-toogle .options-target").html($(item).attr("data-value"));
        dropdown.find(".hidden-input").val($(item).attr("data-value"));
    }
    $(".dropdown.ms-list .options-target").on("keyup", function() {
        $(this).find("i").remove();
        $(this).parents(".dropdown").find(".hidden-input").val($(this).text());
    });
    // delete Data Confirmation
    $(document).on("click", "a.deleteData", function(e) {
        e.preventDefault();
        let mediaId = $(this).attr("data-media"),
            link = $(this),
            linkText = $(this).html();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                if (link.attr("href") != "#") {
                    location.assign(link.attr("href"));
                    return false;
                }
                disableBtn($(this));
                $.post("controllers/controller.php", {
                    deleteFile: mediaId
                }).done(function(response) {
                    enableBtn(link, linkText);
                    if (response == "success") {
                        link.parents(".col-lg-4").remove();
                        $(".tooltip").remove();
                    }
                }).fail(function() {
                    enableBtn(link, linkText);
                });
            }
        });
    });
    // Load Category Media
    $(".single-category-media").each(function() {
        let btn = $(this),
            target = $(this).attr("data-target"),
            panel = $(this).find(".paginationData");
        if (!this.hasAttribute("data-target")) return;
        $.ajax({
            url: "controllers/controller.php",
            type: "POST",
            data: { getMedia: target },
            dataType: "json",
            beforeSend: function() {
                panel.html(getLoader(true));
            },
            success: function(response) {
                appendMedia(response, panel);
            },
            error: function() {
                panel.html('<p class="msg p-2">No data found!</p>');
            }
        })
    });
    // Tooltip
    if ($.isFunction($.fn.tooltip)) {
        $('body').tooltip({
            selector: '[title]',
            trigger: 'hover'
        });
        $('body').on("click", '[title]', function() {
            $(".tooltip").remove();
        });
    }
    // Append Media
    function appendMedia(response, panel) {
        panel = $(panel);
        panel.find(".loader,.loader-container").remove();
        let target = response.type;
        // Append Media
        let html = '';
        if (response.data.length > 0) {
            Array.from(response.data).forEach(function(item) {
                html += `<div class="col-lg-4 col-md-6 my-3">
                            <div class="single-media media-img">
                                <img src="${item.src}" alt="image" class="img-fluid full-img">
                                <a href="#" data-category="${response.typeId}" data-media="${item.id}" class="deleteData action-btn text-danger bg-white" title="Delete"><i class="fas fa-trash-alt"></i></a>
                                <a href="#" class="action-btn p-left edit-media-name" data-name="${item.name}" data-id="${item.id}" title="Edit Name"><i class="fas fa-edit"></i></a>

                            </div>
                        </div>`;
            });
        } else {
            html = '<p class="msg">No ' + target + ' found!</p>';
        }
        panel.html(html);

        if (toNumber(response.total) > 0) {
            // Creat Pagination
            let pagination = getPagination(response, "category-" + response.typeId);
            panel.append(pagination);
        }
    }
    // Create Pagenination
    function getPagination(response, target) {
        let pages_no = response.total / 12;
        if (isFloat(pages_no)) {
            pages_no = parseInt(pages_no) + 1;
        }
        let html = '<div class="center-content"><ul class="pagination" data-action="fetchUserMedia" data-target="' + target + '">';
        html += '<li class="page-item page-link" data-target="prev"><i class="fas fa-angle-double-left"></i></li>';
        var itemText, active = "";
        for (var i = 1; i <= pages_no; i++) {
            itemText = i;
            if (i == toNumber(response.activePage)) active = "active";
            else active = "";
            html += '<li class="page-item page-link ' + active + '"  data-target="page-' + i + '">' + itemText + '</li>';
        }
        html += '<li class="page-item page-link" data-target="next"><i class="fas fa-angle-double-right"></i></li>';
        html += '</ul></div>';
        return html;
    }
    // Pagination
    $(document).on("click", ".pagination .page-link", function(e) {
        e.preventDefault();
        let parent = $(this).parents(".pagination"),
            dataAction = parent.attr("data-action"),
            dataTarget = parent.attr("data-target"),
            btn = $(this),
            btnText = $(this).html(),
            pageNo = $(this).attr("data-target"),
            panel = $(this).parents(".paginationData"),
            search_query = $(this).parents(".panel").first().find(".search-query").val();
        if (btn.hasClass("active")) return;
        // If Previous
        let activeLink = toNumber(parent.find(".page-link.active").attr("data-target"));
        if (pageNo == "prev") {
            if (activeLink < 2) return false;
            else pageNo = activeLink - 1;
        }
        // Next
        if (pageNo == "next") {
            let lastLink = parent.find(".page-link").last();
            if (lastLink.prev().hasClass("active")) return false;
            else pageNo = activeLink + 1;
        }

        pageNo = toNumber(pageNo);
        let data = {
            paginationAction: dataAction,
            target: dataTarget,
            pageNo: pageNo,
            search_query: search_query
        }
        $.ajax({
            url: "controllers/controller.php",
            type: "POST",
            data: data,
            dataType: "json",
            beforeSend: disableBtn(btn),
            success: function(response) {
                appendMedia(response, panel);
            },
            error: makeError
        }).always(enableBtn(btn, btnText));
    });
    // Search From Media
    $(".panel .search-query").on("keyup", function() {
        let dataContainer = $(this).parents(".panel").find(".paginationData"),
            dataAction = $(this).attr("data-action"),
            dataTarget = $(this).attr("data-target"),
            search_query = $(this).val();
        let data = {
            paginationAction: dataAction,
            target: dataTarget,
            pageNo: 1,
            search_query: search_query
        }
        $.ajax({
            url: "controllers/controller.php",
            type: "POST",
            data: data,
            dataType: "json",
            beforeSend: function() {
                dataContainer.html(getLoader(true));
            },
            success: function(response) {
                appendMedia(response, dataContainer);
                dataContainer.find(".loader-container, .loader").remove();
            },
            error: function(){
                dataContainer.find(".loader-container, .loader").remove();
            }
        });
    });
    // Create Input Group
    function createInputGroup(label, name, value) {
        if (!value) value = "";
        let group = '<div class="form-group text-left"><span class="label">' + label + '</span><input type="text" class="form-control ' + name + '" value="' + value + '" /></div>';

        return group;
    }
    // Edit Media Name
    $(document).on("click", ".edit-media-name", function(e) {
        e.preventDefault();
        let media = $(this),
            mediaId = $(this).attr("data-id"),
            mediaName = $(this).attr("data-name"),
            nameInput = createInputGroup("Name", "media-name-input", mediaName);
        if (!mediaId) return;
        Swal.fire({
            title: "Change Name",
            html: nameInput,
            preConfirm: () => {
                return [
                    mediaName = $('input.media-name-input').val(),
                ]
            },
            showCancelButton: true,
            confirmButtonText: "Change"
        }).then((result) => {
            if (result.value) {
                $.post("controllers/controller.php", {
                    changeMediaName: mediaId,
                    name: mediaName
                }).done(function(data) {
                    if (data == "success") {
                        media.attr("data-name", mediaName);
                    }
                })
            }
        });
    });
    // Menu Toggler
    $(".menu_toggler").on("click", function(){
        $(".sidebar").toggleClass("active");
        $(".all-content").toggleClass("active");
    });
    // Menu Toggler
    $(".all-content").on("click", function(){
        if(window.innerWidth <= 992){
            $(".sidebar").removeClass("active");
            $(".all-content").removeClass("active");
        }
    });