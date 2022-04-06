    function l(args) { console.log(args); }
    setTimeout(function(){
        $(".full-screen-loader").fadeOut(500);
    },500);
    const windowWidth = window.innerWidth;

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
    function genereateSvgLinkArrow() {
        let width = $(".nav-btn").first().width() + 10,
            height = $(".nav-btn").first().height() + 10,
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
    if (windowWidth > 992) {
        $(".nav-btn").each(function() {
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
            svg = genereateSvgLinkArrow();

            $(svg).insertAfter($(this));

        });
    } else {
        let navItemsWdith = 0;
        $(".sidebar .nav-item").each(function() {
            navItemsWdith += $(this).width();
        });
        let singleItemWidth = $(".sidebar .nav-item").first().width();
        navItemsWdith += singleItemWidth * 2;
        $(".sidebar .nav-item .panel").css("width", navItemsWdith + "px");
        $(".sidebar .nav-item .panel").css("top", $(".sidebar .nav").height() + "px");
        $(".sidebar .editingPanel").css("width", navItemsWdith + "px");
        $(".sidebar .editingPanel").css("top", $(".sidebar .nav").height() + "px");
    }

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
    // Alert Fuction
    function sAlert(text, heading) {
        Swal.fire({
            title: heading,
            text: text,
        });
    }
    // Error
    function makeError() {
        Swal.fire({
            title: 'Oops...',
            text: 'Something went wrong! Please try again',
        });
    }
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
    $(function() {
        $('[title]').tooltip({
            trigger: 'hover'
        });
        $('[title]').on("click", function() {
            $(".tooltip").remove();
        });
    })
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
    const loader = getLoader(false),
        controllers = {
            mediaController: "controllers/mediaController.php"
        };
    // Tab And Panel
    $(".nav .nav-item .tab").on("click", function() {
        $(".sidebar .editingPanel").removeClass("active");
        // Show Editing
        if ($(this).hasClass("show-editing-panel")) {
            $(".sidebar .editingPanel").addClass("active");
        }
        if ($(this).hasClass("upload-file")) {
            $(".file-upload").trigger("click");
            return false;
        }
        let parent = $(this).parents(".sidebar");
        if ($(this).hasClass("active")) {
            $(this).removeClass("active");
            $(this).parent().find(".panel").removeClass("active");
            return false;
        }
        // Remove Other 
        parent.find(".nav .nav-item .tab").removeClass("active");
        parent.find(".nav .nav-item .panel").removeClass("active");
        $(this).addClass("active");
        // Active Target Panel
        let targetPanel = $(this).parent().find(".panel"),
            targetPanelHtml = targetPanel.html();
        targetPanel.addClass("active");
        if (targetPanel.find(".loader").length > 0) return;
        /*targetPanel.html(getLoader(true));
        setTimeout(function() {
            targetPanel.html(targetPanelHtml);
        }, 500);*/
    });
    // Hide panels on mobile
    $(".clearSideBar").on("click", function(e) {
        let target = $(e.target);
        l(target.get(0));
        if (windowWidth <= 992) {
            $(this).hide();
            $(".sidebar .editingPanel").removeClass("active");
            $(".sidebar .nav .nav-item .tab").removeClass("active");
            $(".sidebar .nav .nav-item .panel").removeClass("active");
        }
    });
    $(document).ready(function() {
        // Get Media
        $(".nav .nav-item .tab").each(function() {
            let btn = $(this),
                target = $(this).attr("data-target"),
                parent = $(this).parents(".nav-item"),
                panel = parent.find(".panel").find(".paginationData");
            if (!this.hasAttribute("data-target")) return;
            $.ajax({
                url: "controllers/mediaController.php",
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
                    panel.html('<p class="msg">No data found!</p>');
                }
            })
        });
        // Append Media
        function appendMedia(response, panel) {
            panel = $(panel);
            panel.find(".loader,.loader-container").remove();
            let target = response.type;
            // Append Media
            let html = '';
            if (response.data.length > 0) {
                Array.from(response.data).forEach(function(item) {
                    html += `<div class="col-6 p-2">
                                <div class="single-media background-img" data-id="${item.id}" data-type="${response.type}">
                                    <img src="${item.src}" alt="background-img" class="img-fluid">
                                    <button class="add-btn action-btn"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>`;
                });
            } else {
                html = '<p class="msg">No ' + target + ' found!</p>';
            }
            panel.html(html);
            // Creat Pagination
            if (toNumber(response.total) > 0) {
                let pagination = getPagination(response, "category-" + response.typeId);
                panel.append(pagination);
            }
        }
        // Create Pagenination
        function getPagination(response, target) {
            let pages_no = response.total / 10;
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
                panel = $(this).parents(".panel").first().find(".paginationData"),
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
                url: controllers.mediaController,
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
                url: controllers.mediaController,
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
    });
    // Remove Active Tabs and Panel On mobile Device
    $(".all-content").on("click", removeActiveTabs);

    function removeActiveTabs() {
        if (windowWidth <= 992) {
            $(".sidebar .nav .tab.active").removeClass("active");
            $(".sidebar .nav .panel.active").removeClass("active");
            $(".sidebar .editingPanel").removeClass("active");
        }
    }