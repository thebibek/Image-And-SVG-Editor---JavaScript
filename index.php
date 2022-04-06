<?php require_once("./includes/db.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $site_name; ?></title>
    <link rel="icon" href="./images/favicon.png" type="image/png" />
    <link rel="stylesheet" href="css/fonts.css">
    <link rel="stylesheet" href="css/spectrum.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="sidebar scrollbar">
        <div class="wrapper">
            <ul class="nav hide-scrollbar">
                <?php $categories = $db->select("categories");
                if($categories){
                    foreach($categories as $category){
                ?>
                <li class="nav-item">
                    <div class="tab" data-target="category-<?php echo $category['id']; ?>">
                        <button class="nav-btn">
                            <span class="text">
                                <?php echo $category['icon'] . " <span class='item-text'>" . $category['name'] . "</span>"; ?></span>
                        </button>
                    </div>
                    <div class="panel">
                        <h4 class="heading panel-name"><?php echo $category['name']; ?></h4>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" placeholder="Search...." class="form-control search-query" data-action="fetchUserMedia" data-target="category-<?= $category['id']; ?>">
                            </div>
                        </div>
                        <div class="row paginationData">
                            <div class="loader-container">
                                <div class="loader">
                                    <span class="load load1"></span>
                                    <span class="load load2"></span>
                                    <span class="text">Loading</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <?php
                    }
                }
                ?>
                <li class="nav-item">
                    <div class="tab">
                        <button class="nav-btn">
                            <span class="text"><i class="fas fa-font"></i> <span class="item-text">Text</span></span>
                        </button>
                    </div>
                    <div class="panel">
                        <h4 class="heading panel-name mb-3">Text</h4>
                        <div class="form-group">
                            <span class="label">Enter Text</span>
                            <textarea type="text" class="form-control text" placeholder="Enter text here..."></textarea>
                        </div>
                        <div class="form-group">
                            <button class="submit-btn bg_orange add-text"><i class="fas fa-plus"></i> Add</button>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="tab upload-file">
                        <button class="nav-btn">
                            <span class="text"><i class="fas fa-cloud-upload-alt"></i> <span class="item-text">Import <span style="font-size: 10px;">Image/Svg</span></span></span>
                        </button>
                    </div>
                    <input type="file" class="file-upload d-none" accept="svg,image/*">
                </li>
                <li class="nav-item">
                    <div class="tab show-editing-panel">
                        <button class="nav-btn">
                            <span class="text"><i class="far fa-edit"></i> <span class="item-text">Editing Panel</span></span>
                        </button>
                    </div>
                </li>
            </ul>
        </div>
        <div class="editingPanel scrollbar">
            <div class="object-editing editing-box">
                <h4 class="heading mb-3">Editing:</h4>
                <div class="form-group">
                    <span class="label">Fill Color:</span>
                    <input type="text" class="form-control color-picker fill-color">
                </div>
                <div class="form-group">
                    <span class="label">Stroke Color:</span>
                    <input type="text" class="form-control color-picker stroke-color">
                </div>
                <div class="form-group">
                    <span class="label">Stroke Width:</span>
                    <input type="range" class="rangeSlider stroke-width" min="0" max="20" value="0">
                </div>
                <div class="form-group">
                    <span class="label">Opacity:</span>
                    <input type="range" class="opacity rangeSlider" min="0" max="10" value="0">
                </div>
            </div>
            <div class="text-editing editing-box">
                <h4 class="heading mb-3">Text:</h4>
                <div class="form-group">
                    <span class="label">Text:</span>
                    <textarea type="text" class="form-control text"></textarea>
                </div>
                <div class="form-group">
                    <span class="label">Font Size:</span>
                    <input type="range" class="font-size rangeSlider" min="6" max="150" value="40">
                </div>
                <div class="form-group">
                    <span class="label">Font Family:</span>
                    <select class="form-control font-family">
                        <option value="Sans Serif">Sans Serif</option>
                        <option value="monospace">Monospace</option>
                        <option value="'Raleway', sans-serif">Raleway</option>
                        <option value="'Rowdies', cursive">Rowdies</option>
                    </select>
                </div>
                <div class="form-group pull-away">
                    <label class="checkbox">
                        <input type="checkbox" class="check font-weight">
                        <span class="box"><i class="fa fa-check"></i></span>
                        <b>Bold</b>
                    </label>
                    <label class="checkbox">
                        <input type="checkbox" class="check font-style">
                        <span class="box"><i class="fa fa-check"></i></span>
                        <i>Italic</i>
                    </label>
                </div>
            </div>
            <div class="shadow-editing editing-box">
                <h4 class="heading mb-3">Shadow:</h4>
                <div class="form-group">
                    <span class="label">Color:</span>
                    <input type="text" class="form-control color-picker shadow-color">
                </div>
                <div class="form-group pull-away">
                    <div>
                        <div class="flex">
                            <span class="label">X:</span>
                            <input type="number" class="form-control number shadow-x short">
                        </div>
                    </div>
                    <div>
                        <div class="flex">
                            <span class="label">Y:</span>
                            <input type="number" class="form-control number shadow-y short">
                        </div>
                    </div>
                    <div>
                        <div class="flex">
                            <span class="label">Width:</span>
                            <input type="number" class="form-control number shadow-blur short">
                        </div>
                    </div>
                </div>
            </div>
            <div class="drawing-editing editing-box">
                <h4 class="heading mb-3">Brush:</h4>
                <div class="form-group">
                    <span class="label">Color:</span>
                    <input type="text" class="form-control color-picker brush-color">
                </div>
                <div class="form-group">
                    <span class="label">Size:</span>
                    <input type="range" class="rangeSlider brush-size" min="1" max="100" value="5">
                </div>
            </div>
        </div>
    </div>
    <div class="all-content">
        <div class="editing-wrapper">
            <div class="editing-target">
                <div class="area-border border1"><span></span><span></span></div>
                <div class="area-border border2"><span></span><span></span></div>
                <div class="area-border border3"><span></span><span></span></div>
                <div class="area-border border4"><span></span><span></span></div>
                <div class="editing-area">
                    <div class="editor-wrapper">
                        <div class="editor-container">
                            <canvas id="editor" class="editor"></canvas>
                            <div class="bg-img"></div>
                        </div>
                    </div>
                    <div class="options hide-scrollbar">
                        <button class="submit-btn bg_dark drawing-mode" title="Drawing"><i class="fas fa-pencil-alt"></i></button>
                        <button class="submit-btn bg_dark flip-y-shape active-shapes-button disabled" title="Flip Y"><i class="fas fa-exchange-alt rotate-90"></i></button>
                        <button class="submit-btn bg_dark flip-x-shape active-shapes-button disabled" title="Flip X"><i class="fas fa-exchange-alt"></i></button>
                        <button class="submit-btn bg_dark delete-shape active-shapes-button disabled" title="Delete"><i class="far fa-trash-alt"></i></button>
                        <button class="submit-btn bg_dark copy-shape active-shapes-button disabled" title="Copy"><i class="far fa-copy"></i></button>
                        <button class="submit-btn bg_dark undo-btn disabled" title="Undo" id="undo"><i class="fas fa-undo"></i></button>
                        <button class="submit-btn bg_dark redo-btn disabled" title="Redo" id="redo"><i class="fas fa-redo"></i></button>
                        <input type="text" class="form-control zoom-value d-none" value="100%">
                        <button class="submit-btn bg_dark zoom-in" title="Zoom In"><i class="fas fa-search-plus"></i></button>
                        <button class="submit-btn bg_dark zoom-out" title="Zoom Out"><i class="fas fa-search-minus"></i></button>
                        <button class="submit-btn bg_dark resize-editor" title="Resize"><i class="fas fa-expand-arrows-alt"></i></button>
                        <button class="submit-btn bg_dark new-file" title="New File"><i class="fas fa-plus"></i></button>
                        <div class="dropdown save-img-dropdown">
                            <button class="submit-btn bg_info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Download">
                                <i class="fas fa-download"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item save-img" data-type="png" href="#">PNG</a>
                                <a class="dropdown-item save-img" data-type="jpg" href="#">JPG</a>
                                <a class="dropdown-item save-img" data-type="svg" href="#">SVG</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="full-screen-loader">
        <div class="loader-container">
            <div class="loader">
                <span class="load load1"></span>
                <span class="load load2"></span>
                <span class="text">Loading</span>
            </div>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/fabric.min.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/spectrum.min.js"></script>
    <script src="js/pagination.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/app.js"></script>
</body>

</html>