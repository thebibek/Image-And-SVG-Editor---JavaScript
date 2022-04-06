// Initialize Canvas
const editorContainer = $(".editing-area .editor-container");

function initializeCanvas() {
    let width = editorContainer.width(),
        height = editorContainer.height();
    canvas = new fabric.Canvas("editor", {
        isDrawingMode: false,
        preserveObjectStacking: true
    });
    canvas.setDimensions({
        width: width,
        height: height
    });
    canvas.backgroundColor = null;
    canvas.requestRenderAll();
    //canvas.setBackgroundImage("./images/editor-background.png", canvas.renderAll.bind(canvas), {});
    // Selection
    fabric.Object.prototype.transparentCorners = false;
    fabric.Object.prototype.cornerColor = '#fe6f02';
    fabric.Object.prototype.cornerStyle = 'square';
    return canvas;
}
const editor = initializeCanvas(),
    editingOptions = $(".editing-area .options");
editor.on("mouse:down", removeActiveTabs);
let fileSaved = false;
// Media Type
function getMediaType(src) {
    let ext = src.split(".").pop().toLowerCase();
    if (ext != "svg") {
        ext = "image";
    }
    return ext;
}
// Add Icons to canvas
let mediaContainer = $(".sidebar .nav .nav-item .panel");
mediaContainer.on("click", ".single-media .add-btn", function() {
    let media = $(this).parent(),
        src = media.find("img").attr("src"),
        width = media.find("img").naturalWidth,
        height = media.find("img").naturalHeight,
        item = {
            src: src,
            type: media.attr("data-type").toLowerCase(),
            fileType: getMediaType(src)
        }
    addItemToEditor(item);
});
// Add Item to canvas
function addItemToEditor(item) {
    let shape = 0,
        type = item.fileType,
        source = item.src,
        scaleToHeight = (editor.height) / 2,
        scaleToWidth = (editor.width) / 2,
        index = 2;
    if (item.type.indexOf("background") != -1) {
        scaleToWidth = editor.width,
            scaleToHeight = editor.height;
        scaleToWidth = editor.width;
        index = 1;
    }
    let shapeProperties = {
        left: ($("#editor").width() / 2) - (scaleToWidth / 2),
        top: ($("#editor").height() / 2) - (scaleToHeight / 2),
        stroke: "#fff",
        strokeWidth: 0,
        opacity: 1,
        strokeUniform: false,
        fontWeight: 'normal',
        fontStyle: 'normal',
        shadow: {
            color: "#fff",
            offsetX: 0,
            offsetY: 0,
            blur: 0,
            opacity: 1
        }
    };

    if (type == "svg") {
        fabric.loadSVGFromURL(source, function(objects, options) {
            obj = fabric.util.groupSVGElements(objects, options);
            obj.scaleToHeight(scaleToHeight)
                .set(shapeProperties)
                .setCoords();
            editor.add(obj);
            editor.setActiveObject(obj);
            saveHistory();
        });
    } else if (type == "text") {
        shape = new fabric.Text(source, shapeProperties);
        saveHistory();
    } else {
        if (false) {
            editor.setBackgroundImage(source, editor.renderAll.bind(editor), {});
        } else {
            fabric.Image.fromURL(source, function(img) {
                img.set(shapeProperties);
                img.scaleToWidth(scaleToWidth);
                editor.add(img);
                editor.setActiveObject(img);
                saveHistory();
            });
        }
    }
    // Render Canvas
    if (shape == 0) return false;
    editor.add(shape);
    editor.setActiveObject(shape);
}
const editingPanel = $(".sidebar .editingPanel");
// On Object Selected
editor.on("selection:created", function(e) {
    let obj = e.target;
    objectSelected(obj);
});
editor.on("object:selected", function(e) {
    let obj = e.target;
    objectSelected(obj);
});
// On Cleared Selection
editor.on("selection:cleared", function() {
    disableActionsButtons();
    hideEditingPanel();
});
// Show Editing Panel
function showEditingPanel(type = 0, hide = false) {
    if(windowWidth > 992){
        $(".sidebar .wrapper").hide();
    }
    $(".sidebar .nav-item .tab.active").removeClass("active");
    $(".sidebar .nav-item .panel.active").removeClass("active");
    if(windowWidth > 992){
        editingPanel.addClass("active");
    }
    if (hide == true) {
        if (type != 0) {
            editingPanel.find(".editing-box").show();
            type.forEach(function(item) {
                editingPanel.find(".editing-box." + item).hide();
            });
        } else {
            editingPanel.find(".editing-box").hide();
        }
    } else {
        if (type != 0) {
            editingPanel.find(".editing-box").hide();
            type.forEach(function(item) {
                editingPanel.find(".editing-box." + item).show();
            });
        } else {
            editingPanel.find(".editing-box").show();
        }
    }
}
// Hide Editing Panel
function hideEditingPanel() {
    $(".sidebar .wrapper").show();
    editingPanel.removeClass("active");
}
// Enable Action Buttons
function enableActionsButtons() {
    $(".active-shapes-button").removeClass("disabled");
    $(".active-shapes-button").prop("disabled", false);
    if(windowWidth <= 992){
        $(".show-editing-panel").show();
    }
}
// Disable Action Buttons
function disableActionsButtons() {
    $(".active-shapes-button").addClass("disabled");
    $(".active-shapes-button").prop("disabled", true);
    $(".show-editing-panel").hide();
}
// Delete Object
$(".delete-shape").on("click", deleteEditorObject);

function deleteEditorObject() {
    let obj = editor.getActiveObject();
    if (!obj) return;
    if (obj.get('type') == "activeSelection") {
        obj.forEachObject(function(object) {
            editor.remove(object);
        });
    } else {
        editor.remove(obj);
    }
    deselectShapes();
    saveHistory();
}
// Copy Object
$(".copy-shape").on("click", copyEditorObject);

function copyEditorObject() {
    var activeObject = editor.getActiveObject();
    activeObject.clone(function(cloned) {
        editor.discardActiveObject();
        cloned.set({
            top: cloned.top + 20,
            evented: true
        });
        if (cloned.type === 'activeSelection') {
            cloned.canvas = editor;
            cloned.forEachObject(function(obj) {
                editor.add(obj);
            });
            cloned.setCoords();
        } else {
            editor.add(cloned);
        }
        editor.setActiveObject(cloned);
        editor.requestRenderAll();
    });
    saveHistory();
}
// Object Select
function objectSelected(shape) {
    shape = editor.getActiveObject();
    if (!shape) return;
    // Enable Action Buttons
    enableActionsButtons();
    if (shape.get('type') == "activeSelection") return;
    showEditingPanel(["drawing-editing"], true);
    if (shape.get('type') != "text") {
        editingPanel.find(".text-editing").hide();
    } else {
        editingPanel.find(".text-editing").show();
    }
    // Set Active Shape Editing
    let fillColor = shape.fill,
        strokeColor = shape.stroke,
        strokeWidth = shape.strokeWidth,
        opacity = shape.opacity * 10,
        fontSize = shape.fontSize,
        fontFamily = shape.fontFamily,
        fontWeight = shape.fontWeight,
        fontStyle = shape.fontStyle,
        shadowColor = shape.shadow.color || "white",
        shadowOffsetX = shape.shadow.offsetX || 0,
        shadowOffsetY = shape.shadow.offsetY || 0,
        shadowBlur = shape.shadow.blur || 0,
        shadowOpacity = shape.shadow.opacity * 10;
    setEditingPanelColor(fillColor, "fill-color");
    setEditingPanelColor(strokeColor, "stroke-color");
    setEditingPanelVal(strokeWidth, "stroke-width");
    setEditingPanelVal(opacity, "opacity");
    setEditingPanelVal(fontSize, "font-size");
    setEditingPanelVal(fontFamily, "font-family");
    setEditingPanelVal(fontWeight, "font-weight");
    setEditingPanelVal(fontStyle, "font-style");
    setEditingPanelVal(shadowColor, "shadow-color");
    setEditingPanelVal(shadowOffsetX, "shadow-x");
    setEditingPanelVal(shadowOffsetY, "shadow-y");
    setEditingPanelVal(shadowBlur, "shadow-blur");
    setEditingPanelVal(shadowOpacity, "shadow-opacity");
    // If Text
    if (shape.get('type') == "text") {
        setEditingPanelVal(shape.text, "text");
    }

}
// Set Object Property
function setObjectProperty(property, value) {
    let obj = editor.getActiveObject();
    if (!obj) return;
    if (obj.get('type') == "activeSelection") {
        editor.forEachObject(function(object) {
            object.set(property, value);
        });
    } else {
        obj.set(property, value);
    }
    editor.renderAll();
    saveHistory();
}
// Set Flip
function setObjectFlip(direction) {
    let obj = editor.getActiveObject();
    if (!obj) return;
    setObjectProperty("flip" + direction, !obj.get("flip" + direction));
}
// Flip Object X
editingOptions.find(".flip-x-shape").on("click", function() {
    setObjectFlip("X");
});
// Flip Object Y
editingOptions.find(".flip-y-shape").on("click", function() {
    setObjectFlip("Y");
});
// ON Drawing Mode
editingOptions.find(".drawing-mode").on("click", function() {
    startDrawingMode();
});

function startDrawingMode() {
    let drawingIcon = editingOptions.find(".drawing-mode");
    if (editor.isDrawingMode) {
        stopDrawingMode();
        return false;
    }
    deselectShapes();
    editor.freeDrawingBrush.color = editingPanel.find(".brush-color").val();
    editor.freeDrawingBrush.width = parseInt(editingPanel.find(".brush-size").val()) || 1;
    showEditingPanel(["drawing-editing", "shadow-editing"]);
    editor.isDrawingMode = true;
    changeShapeShadow();
    drawingIcon.addClass("active");
    editor.renderAll();
}

function stopDrawingMode() {
    let drawingIcon = editingOptions.find(".drawing-mode");
    editor.isDrawingMode = false;
    drawingIcon.removeClass("active");
    hideEditingPanel();
    editor.renderAll();
}
// Save Drawing
editor.on("mouse:up", function() {
    if (editor.isDrawingMode) {
        saveHistory();
    }
});
// Set Editing Panel Color
function setEditingPanelColor(color, elementClass) {
    if (!color) return;
    editingPanel.find("." + elementClass).spectrum({
        color: color
    });
}
// Set Editing Panel Values
function setEditingPanelVal(val, elementClass) {
    let element = editingPanel.find("." + elementClass);
    if (element.attr("type") == "range") val = toNumber(val);
    element.val(val);
    if (element.attr("type") == "checkbox") {
        if (val == 'normal') {
            element.prop("checked", false);
        } else {
            element.prop("checked", true);
        }
    }
}
// Clear Selected Shape
$(".all-content").on("mousedown", function(e) {
    let target = $(e.target);
    if (!(target.hasClass("options") || target.parents(".options").length > 0 || target.hasClass("editor") || target.parents(".editor").length > 0)) {
        deselectShapes();
        stopDrawingMode();
    }
});
// Deselect Objects
function deselectShapes() {
    editor.discardActiveObject();
    editor.requestRenderAll();
}
// Add Text
$(".sidebar .nav .panel").on("click", ".add-text", function() {
    let parent = $(this).parents(".panel"),
        text = parent.find(".text");
    if (text.val().length < 1) {
        text.focus();
        return false;
    }

    let item = {
        src: text.val(),
        fileType: "text",
        type: "text"
    }
    text.val("");
    addItemToEditor(item);
});
// Upload Image / Svg
$(".file-upload").on("change", function() {
    let files = $(this).get(0).files;
    if (files.length < 1) return;

    let file = files[0],
        ext = file.name.split(".").pop().toLowerCase(),
        allowedFiles = ["jpg", "jpeg", "png", "gif", "svg"];
    if (!allowedFiles.includes(ext)) {
        sAlert("Allowed file types are " + allowedFiles.join(" , "), "Invalid File Type");
        return false;
    }
    src = URL.createObjectURL(file)
    if (ext == "svg") {
        item = {
            src: src,
            type: ext,
            fileType: ext
        }
        addItemToEditor(item);
    } else {
        let tmp_canvas = document.createElement("canvas");

        let image = new Image();
        image.src = src;
        image.onload = function() {
            tmp_canvas.width = image.width;
            tmp_canvas.height = image.height;
            let ctx = tmp_canvas.getContext('2d');
            ctx.drawImage(image, 0, 0);
            src = tmp_canvas.toDataURL();
            item = {
                src: src,
                type: ext,
                fileType: ext
            }
            addItemToEditor(item);
        }
    }
});
// Color Pickers
$('.color-picker').each(function() {
    let color = $(this).attr("data-default");
    $(this).spectrum({
        type: "component",
        color: "#fff"
    });
});
$('body').on("click", ".sp-colorize", function() {
    $(this).parents(".sp-original-input-container").find(".color-picker").click();
    return false;
});
// Change Drawing Brush Size
editingPanel.find(".brush-size").on("input", function() {
    editor.freeDrawingBrush.width = parseInt($(this).val()) || 1;
    editor.renderAll();
});
// Change Drawing Brush Color
editingPanel.find(".brush-color").on("move.spectrum", function() {
    editor.freeDrawingBrush.color = $(this).val();
    editor.renderAll();
});
//  Change Fill Color
$(".color-picker.fill-color").on("move.spectrum", fillShapeColor);
$(".color-picker.fill-color").on("change.spectrum", saveHistoryIfActiveShpae);

function fillShapeColor(e, color) {
    color = color.toRgbString();
    let shape = editor.getActiveObject();
    if (!shape) return;
    let type = shape.get('type');
    shape.set("fill", color);
    // Fill Object
    if (type == "path") {
        if (shape.paths) {
            for (var i = 0; i < shape.paths.length; i++) {
                shape.paths[i].set("fill", color);
            }
        }
    } else if (type == "group") {
        Array.from(shape._objects).forEach((object) => {
            object.set('fill', color);
        })
    } else if (type == "activeSelection") {
        Array.from(shape._objects).forEach((object) => {
            object.set("fill", color);
            if (object.paths) {
                for (var i = 0; i < object.paths.length; i++) {
                    object.paths[i].set("fill", color);
                }
            }
        })
    }
    // Render Canvas
    editor.renderAll();
}
// Change Stroke Color
$(".color-picker.stroke-color").on("move.spectrum", changeShapeStrokeColor);
$(".color-picker.stroke-color").on("change.spectrum", saveHistoryIfActiveShpae);

function changeShapeStrokeColor(e, color) {
    color = color.toRgbString();
    let shape = editor.getActiveObject();
    if (!shape) return;
    let type = shape.get('type');
    shape.set("stroke", color);
    // Fill Object
    if (type == "path") {
        if (shape.paths) {
            for (var i = 0; i < shape.paths.length; i++) {
                shape.paths[i].set("stroke", color);
            }
        }
    } else if (type == "group") {
        Array.from(shape._objects).forEach((object) => {
            object.set('stroke', color);
        })
    } else if (type == "activeSelection") {
        Array.from(shape._objects).forEach((object) => {
            object.set("stroke", color);
            if (object.paths) {
                for (var i = 0; i < object.paths.length; i++) {
                    object.paths[i].set("stroke", color);
                }
            }
        })
    }
    // Render Canvas
    editor.renderAll();
}
// Change Stroke Width
$(".stroke-width").on("input", function() {
    changeShapeStrokeWdith(this);
});
$(".stroke-width").on("change", function() {
    saveHistoryIfActiveShpae();
});

function changeShapeStrokeWdith(input) {
    let strokeWidth = Number($(input).val());
    let shape = editor.getActiveObject();
    if (!shape) return;
    let type = shape.get('type');
    shape.set("strokeWidth", strokeWidth);
    if (type == "path") {
        if (shape.paths) {
            for (var i = 0; i < shape.paths.length; i++) {
                shape.paths[i].set("strokeWidth", strokeWidth);
            }
        }
    } else if (type == "group") {
        Array.from(shape._objects).forEach((object) => {
            object.set('strokeWidth', strokeWidth);
        })
    }
    // Render Canvas
    editor.renderAll();
}
// Change Stroke Width
editingPanel.find(".opacity").on("input", function() {
    changeShapeOpacity(this);
});
// Change Stroke Width
editingPanel.find(".opacity").on("change", function() {
    saveHistoryIfActiveShpae();
});

function changeShapeOpacity(input) {
    let opacity = Number($(input).val()) / 10;
    let shape = editor.getActiveObject();
    if (!shape) return;
    let type = shape.get('type');
    shape.set("opacity", opacity);
    if (type == "path") {
        if (shape.paths) {
            for (var i = 0; i < shape.paths.length; i++) {
                shape.paths[i].set("opacity", opacity);
            }
        }
    } else if (type == "group") {
        Array.from(shape._objects).forEach((object) => {
            object.set('opacity', opacity);
        })
    }
    // Render Canvas
    editor.renderAll();
}
// Change Text
editingPanel.find(".text").on("keyup", function() {
    changeShapeText(this);
});
editingPanel.find(".text").on("blur", function() {
    saveHistoryIfActiveShpae();
});

function changeShapeText(input) {
    let shape = editor.getActiveObject();
    if (!shape) return;
    let type = shape.get('type');
    if (type == "text") {
        shape.set("text", $(input).val());
        // Render Canvas
        editor.renderAll();
    }
}
// Change Font Size
editingPanel.find(".font-size").on("input", function() {
    changeShapeFontSize(this);
});
editingPanel.find(".font-size").on("change", function() {
    saveHistoryIfActiveShpae();
});

function changeShapeFontSize(input) {
    let shape = editor.getActiveObject();
    if (!shape) return;
    let type = shape.get('type');
    if (type == "text") {
        shape.set("fontSize", $(input).val());
        // Render Canvas
        editor.renderAll();
    }
}
// Change Font Family
editingPanel.find(".font-family").on("change", function() {
    changeShapeFontFamily(this);
});
editingPanel.find(".font-family").on("change", function() {
    saveHistoryIfActiveShpae();
});

function changeShapeFontFamily(input) {
    let shape = editor.getActiveObject();
    if (!shape) return;
    let type = shape.get('type');
    if (type == "text") {
        shape.set("fontFamily", $(input).val());
        // Render Canvas
        editor.renderAll();
    }
}
// Change Font Weight
editingPanel.find(".font-weight").on("input", function() {
    changeShapeFontWeight(this);
});
editingPanel.find(".font-weight").on("change", function() {
    saveHistoryIfActiveShpae();
});

function changeShapeFontWeight(input) {
    input = $(input);
    let shape = editor.getActiveObject();
    if (!shape) return;
    let type = shape.get('type');
    if (type == "text") {
        if (input.is(":checked"))
            shape.set("fontWeight", "bold");
        else
            shape.set("fontWeight", "normal");
        // Render Canvas
        editor.renderAll();
    }
}
// Change Font Italic
editingPanel.find(".font-style").on("input", function() {
    changeShapeFontStyle(this);
});
editingPanel.find(".font-style").on("change", function() {
    saveHistoryIfActiveShpae();
});

function changeShapeFontStyle(input) {
    input = $(input);
    let shape = editor.getActiveObject();
    if (!shape) return;
    let type = shape.get('type');
    if (type == "text") {
        if (input.is(":checked"))
            shape.set("fontStyle", "italic");
        else
            shape.set("fontStyle", "normal");
        // Render Canvas
        editor.renderAll();
    }
}

// Change Font Italic
editingPanel.find(".shadow-color").on("move.spectrum", function() {
    changeShapeShadow();
});
editingPanel.find(".shadow-x,.shadow-y,.shadow-blur").on("input", function() {
    changeShapeShadow();
});
editingPanel.find(".shadow-opacity").on("input", function() {
    changeShapeShadow();
});

function changeShapeShadow() {
    let shape = editor.getActiveObject();
    if (!shape && !editor.isDrawingMode) return;
    let offsetX = editingPanel.find(".shadow-x").val() || 0,
        offsetY = editingPanel.find(".shadow-y").val() || 0,
        blur = editingPanel.find(".shadow-blur").val() || 0,
        opacity = editingPanel.find(".shadow-opacity").val() / 10,
        color = editingPanel.find(".shadow-color").val(),
        shadow = {
            offsetY: offsetY,
            offsetX: offsetX,
            color: color,
            blur: blur
        };
    if (editor.isDrawingMode) {
        editor.freeDrawingBrush.shadow = new fabric.Shadow(shadow);
    } else {
        shape.set('shadow', new fabric.Shadow(shadow));
    }
    // Render Canvas
    editor.renderAll();
}
// Save Image
$(".all-content .editing-wrapper .editing-area .options").on("click", ".save-img", function(e) {
    e.preventDefault();
    let type = $(this).attr("data-type");
    downloadFile(type);
});

function downloadFile(type) {
    let downloadLink,
        zoom = editor.getZoom();
    editor.setZoom(1);
    editor.discardActiveObject();
    editor.renderAll();
    if (type == "svg") {
        let svgStr = editor.toSVG(),
            svg64 = btoa(svgStr);
        b64Start = 'data:image/svg+xml;base64,';
        downloadLink = b64Start + svg64;
    } else if (type == "png") {
        downloadLink = $("#editor").get(0).toDataURL("image/png");
    } else {
        editor.backgroundColor = "#fff";
        editor.renderAll();
        downloadLink = $("#editor").get(0).toDataURL("image/jpeg");
        editor.backgroundColor = null;
        editor.renderAll();
    }
    editor.setZoom(zoom);

    var anchor = document.createElement('a');
    anchor.href = downloadLink;
    anchor.target = '_blank';
    anchor.download = "editor";
    anchor.click();
    fileSaved = true;
}
// Scale Of Element
function getScale(element) {
    let transform = element.css("transform");
    let values = transform.split("(")[1];
    values = values.split(")")[0];
    values = values.split(',');
    var a = values[0];
    var b = values[1];
    let scale = Math.sqrt(a * a + b * b);
    return scale;
}
// Set Trasnform Property
function setTransformProperty(property, value, element = editorContainer) {
    element.css("-webkit-" + property, value);
    element.css("-moz-" + property, value);
    element.css("-ms-" + property, value);
    element.css("-o-" + property, value);
    element.css(property, value);
}
// Zoom In
$(".editing-area").on("click", ".zoom-in", function() {
    //let zoom = editor.getZoom() * 1.1;
    let zoom = getScale(editorContainer) + 0.1;
    setZoomValue(zoom);
});
// Set Zoom Value
function setZoomValue(zoom) {

    if (editorBlank()) return;
    if (zoom >= 0.99 && zoom < 1) {
        zoom = 1;
    }
    if (zoom < 0.1) zoom = 0.1;
    if (zoom > 3) zoom = 3;
    setTransformProperty("transform", "scale(" + zoom + ")");
    // Transform Origin
    if (zoom < 1) {
        setTransformProperty("transform-origin", "center center");
    } else {
        setTransformProperty("transform-origin", "0 0");
    }
    //editor.setZoom(zoom);
    zoom = Number(zoom) * 100;
    zoom = parseInt(zoom);
    $(".editing-area .options .zoom-value").val(zoom + "%");
}
$(".editing-area .zoom-value").on("keyup", function() {
    let zoom = (parseFloat($(this).val()) / 100);
    if (isNaN(zoom)) return;
    if (editorBlank()) zoom = 1;
    if (zoom < 0.1) zoom = 0.1;
    if (zoom > 3) zoom = 3;
    setTransformProperty("transform", "scale(" + zoom + ")");
});
$(".editing-area .zoom-value").on("blur", function() {
    //let zoom = editor.getZoom();
    let zoom = getScale(editorContainer);
    $(this).val((zoom * 100) + "%");
});
// Zoom Out
$(".editing-area").on("click", ".zoom-out", function() {
    //let zoom = editor.getZoom() / 1.1;
    let zoom = getScale(editorContainer) - 0.1;
    setZoomValue(zoom);
});
$(".editing-area").on("wheel", function(e) {
    const delta = Math.sign(event.deltaY);
    var zoom = getScale(editorContainer);
    zoom += -(delta / 10);
    setZoomValue(zoom);
    e.preventDefault();
    e.stopPropagation();
});
// If Editor Blank
function editorBlank() {
    let json = editor.toJSON(),
        blank = true;
    if ("objects" in json) {
        if (json.objects.length > 0) {
            blank = false;
        }
    }
    return blank;
}

function changeEditorDimensions(width, height) {
    /*    var clipPath = new fabric.Rect({
            width: width,
            height: height,
            top: 50,
            left: 50
        });
        editor.clipPath = clipPath;
        editor.setDimensions({
            top: 0,
            left: 0
        })
        editor.renderAll();*/
    width = toNumber(width);
    height = toNumber(height);
    if (!width || !height || width == 0 || height == 0) return;
    editor.setWidth(width);
    editor.setHeight(height);
    editorContainer.css("width", width + "px");
    editorContainer.css("height", height + "px");
}
// Change Editor Height And widht
$(".editor-width-input, .editor-height-input").on("keyup", function() {
    changeEditorSize();
});
// Change Editor Size
function changeEditorSize() {
    let width = toNumber($(".editor-width-input").val()),
        height = toNumber($(".editor-height-input").val());

    if (!width || !height) return;

    changeEditorDimensions(width, height);
}
// Create Input Group
function createInputGroup(label, name) {
    let group = '<div class="col-md-6 form-group text-left"><span class="label">' + label + '</span><input type="number" class="form-control ' + name + '" /></div>';

    return group;
}
// Resize Canvas
$(".resize-editor").on("click", function() {
    let inuptWidth = createInputGroup("Width (px)", "editor-width-input"),
        inputHeight = createInputGroup("Height (px)", "editor-height-input"),
        width, height;
    Swal.fire({
        title: "Resize",
        html: '<div class="row">' + inuptWidth + '' + inputHeight + '</div>',
        preConfirm: () => {
            return [
                width = $('.editor-width-input').val(),
                height = $('.editor-height-input').val()
            ]
        },
        showCancelButton: true,
        confirmButtonText: "Resize"
    }).then((result) => {
        if (result.value) {
            changeEditorDimensions(width, height);
        }
    });
});
// Disable Button
function disableButton(btn) {
    btn.addClass("disabled");
    btn.prop("disabled", true);
}

function enableButton(btn) {
    btn.removeClass("disabled");
    btn.prop("disabled", false);
}
// Undo / Redo
const undoButton = editingOptions.find(".undo-btn"),
    redoButton = editingOptions.find(".redo-btn");
editor.on({
    "object:modified": saveHistory
});
// Save History if active object / shape
function saveHistoryIfActiveShpae(){
    let shape = editor.getActiveObject();
    if (!shape) return;
    saveHistory();
}
let editorHistory = {
    state: false,
    undo: [],
    redo: []
};
// Save Editor State
function saveHistory() {
    redo = [];
    disableButton(redoButton);

    if (editorHistory.state) {
        enableButton(undoButton);
        editorHistory.undo.push(editorHistory.state);
    }

    editorHistory.state = editor.toJSON();
    fileSaved = false;
}
// Change Editor History
function changeHistory(playStack, saveStack, onButton, offButon) {
    saveStack.push(editorHistory.state);
    editorHistory.state = playStack.pop();
    // Enable Both Buttons
    disableButton(onButton);
    disableButton(offButon);
    // Add State To canvas
    editor.clear();
    editor.loadFromJSON(editorHistory.state, function() {
        editor.renderAll();
        // Enable On Button
        enableButton(onButton);
        if (playStack.length > 0) {
            enableButton(offButon);
        }
    });

}
saveHistory();
undoButton.on("click", function() {
    changeHistory(editorHistory.undo, editorHistory.redo, redoButton, $(this));
});
redoButton.on("click", function() {
    changeHistory(editorHistory.redo, editorHistory.undo, undoButton, $(this))
});
// Create New File
editingOptions.find(".new-file").on("click", function() {
    if(editorBlank()){
        createNewFile();
        return false;
    }
    if(!fileSaved){
        confirmNewFile();
    } else {
        createNewFile();
    }
});
// Confirm new file
function confirmNewFile() {
    Swal.fire({
        title: "Are you Sure?",
        text: "Do you want to continue without saving the file",
        showCancelButton: true,
        confirmButtonText: "Yes"
    }).then((result) => {
        if (result.value) {
            createNewFile();
        }
    });
}
// Clear Editor
function clearEditor(){
    editor.clear();
    editor.renderAll();
    editorHistory.redo = [];
    editorHistory.undo = [];
    editorHistory.state = false;
    saveHistory();
}
// Create New File
function createNewFile(){
    let inuptWidth = createInputGroup("Width (px)", "editor-width-input"),
        inputHeight = createInputGroup("Height (px)", "editor-height-input"),
        width, height;
    Swal.fire({
        title: "New File",
        html: '<div class="row">' + inuptWidth + '' + inputHeight + '</div>',
        preConfirm: () => {
            return [
                width = $('.editor-width-input').val(),
                height = $('.editor-height-input').val()
            ]
        },
        showCancelButton: true,
        confirmButtonText: "Resize"
    }).then((result) => {
        if (result.value) {
            clearEditor();
            changeEditorDimensions(width, height);
        }
    });
}