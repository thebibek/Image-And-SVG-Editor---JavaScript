<?php 
    require_once("includes/db.php");
    // If Category Set
    if(!isset($_GET['id'])){
        redirectTo("categories");
    }
    $original_id = ($_GET['id']);
    $category_id = $db->validNum($_GET['id']);
    $category = $db->selectSingle("categories", array("id" => $category_id));
    if(!$category) redirectTo("categories");


    $page_name = "Add ". $category['name'] . " | Categories";
    $breadcrumbs = "Categories > " . $category['name'] . " > Add";
    $deleteData = false;
    if(isset($_GET['delete'])){
        $categories = $db->selectSingle("categories", array("id"=>$_GET['delete']));
        if($categories){
            $delete = $db->delete("categories",array("id"=>$_GET['delete']));
            if($delete){
                $deleteData = true;
            }
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
                <div class="card-header">
                    <div class="pull-away">
                        <span><a href="categories">Categories</a> > <a href="category?id=category-<?php echo $category['id']; ?>"><?php echo $category['name']; ?></a> > Add</span>
                        <a href="category?id=<?php echo $original_id; ?>">View <?php echo $category['name']; ?></a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="add-media?id=<?php echo $original_id; ?>" method="POST" class="submit_form" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span class="label">Name</span>
                                    <input type="text" class="form-control" name="name" placeholder="Enter background name here....." required data-length="[1,250]">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <span class="label">Select Image</span>
                                    <div class="input-group">
                                        <label class="input-group-text file-upload-label"><i class="fas fa-folder-open"></i>
                                            <input type="file" name="file[]" class="d-none file-input required" id="background-image-file" accept=".svg, image/*" multiple="multiple">
                                        </label>
                                        <input type="text" class="form-control file-name" placeholder="Please Select a file" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <input type="hidden" name="uploadMedia" value="<?php echo $category_id; ?>">
                                <button type="submit" class="submit-btn"><span class="text"><i class="fas fa-plus"></i> Add</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php require_once("includes/footer.php"); ?>
    <script>
        <?php if($deleteData){ ?>
        sAlert("Item has been deleted.", "Deleted", "success");
        <?php } ?>
    </script>
</body>

</html>