<?php 
    require_once("includes/db.php");
    $page_name = "Add Category";
    $editCategory = array(
        "name" => "",
        "icon" => "",
        "id" => 0
    );
    $update = false;
    if(isset($_GET['edit'])){
        $category = $db->selectSingle("categories", array("id"=>$_GET['edit']));
        if($category){
            $update = true;
            $editCategory['name'] = addslashes($category['name']);
            $editCategory['icon'] = $category['icon'];
            $editCategory['id'] = $category['id'];
        }
    }
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once("includes/head.php"); ?>
</head>

<body>
    <?php require_once("includes/sidemenu.php") ?>
    <div class="all-content">
        <div class="wrapper">
            <div class="card">
                <div class="card-header"><a href="categories">Categories</a> > Add</div>
                <div class="card-body">
                    <form action="add-background" method="POST" class="submit_form" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span class="label">Category Name</span>
                                    <input type="text" class="form-control" name="name" placeholder="Enter background name here....." required data-length="[1,250]" value="<?php echo $editCategory['name']; ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span class="label">Category Icon <span class="muted" style="font-size: 12px;">( Select or Enter Font Awesome Icon )</span></span>
                                    <div class="dropdown ms-list">
                                        <div class="input-group dropdown-toogle" data-toggle="dropdown">
                                            <div  class="form-control options-target" name="icon" contenteditable="true" autocomplete="off"><?php echo $editCategory['icon']; ?></div>
                                            <span class="input-group-text"><i class="fas fa-angle-down"></i></span>
                                        </div>
                                        <input type="hidden" name="icon" class="hidden-input" value='<?php echo $editCategory['icon']; ?>'>
                                        <div class="dropdown-menu">
                                            <?php 
                                                $icons = array(
                                                    '<i class="fas fa-images"></i>',
                                                    '<i class="fas fa-icons"></i>',
                                                    '<i class="fas fa-atom"></i>',
                                                    '<i class="fas fa-shapes"></i>',
                                                );
                                                foreach($icons as $icon){
                                             ?>
                                            <div class="dropdown-item" data-value='<?php echo $icon; ?>' ><?php echo $icon; ?></div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <input type="hidden" name="addCategory" value="1">
                                <?php if($editCategory['id'] != 0){ ?>
                                <input type="hidden" name="updateCategory" value="<?php echo $editCategory['id']; ?>">
                                <?php } ?>
                                <button type="submit" class="submit-btn"><span class="text">
                                    <?php if($update){ echo "Update"; } else {
                                        echo '<i class="fas fa-plus"></i> Add';
                                    } ?>
                                </span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php require_once("includes/footer.php"); ?>
</body>

</html>