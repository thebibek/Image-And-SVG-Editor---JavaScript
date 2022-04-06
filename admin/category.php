<?php 
    require_once("includes/db.php");
    // If Category Set
    if(!isset($_GET['id'])){
        redirectTo("categories");
    }
    $category_id = $db->validNum($_GET['id']);
    $category = $db->selectSingle("categories", array("id" => $category_id));
    if(!$category) redirectTo("categories");


    $page_name = $category['name'] . " | Categories";
    $breadcrumbs = "Categories > " . $category['name'];
    $deleteData = false;
    if(isset($_GET['delete'])){
        $media = $db->selectSingle("media", array("id"=>$_GET['delete']));
        if($media){
            unlink("../images/editor/media/" . $media['src']);
            $delete = $db->delete("media",array("id"=>$_GET['delete']));
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
                        <span><a href="categories">Categories</a> >
                            <?php echo  $category['name']; ?></span>
                        <a href="add-media?id=category-<?php echo $category['id']; ?>">Add New
                            <?php echo $category['name']; ?></a>
                    </div>
                </div>
                <div class="card-body single-category-media panel" data-target="category-<?php echo $category['id']; ?>">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" placeholder="Search...." class="form-control search-query" data-action="fetchUserMedia" data-target="category-<?= $category['id']; ?>">
                        </div>
                    </div>
                    <div class="row paginationData">
                        <?php 
                        if(false){
                        $medias = $db->select("media", array("category_id"=>$category_id), "", "id DESC");
                        if($medias){
                            foreach($medias as $media){
                        ?>
                        <div class="col-lg-4 col-md-6 my-3">
                            <div class="single-media media-img">
                                <img src="../images/editor/media/<?php echo $media['src']; ?>" alt="image" class="img-fluid full-img">
                                <a href="#" data-category="<?php echo $category_id; ?>" data-media="<?php echo $media['id']; ?>" class="deleteData action-btn text-danger bg-white tool-tip" title="Delete"><i class="fas fa-trash-alt"></i></a>
                            </div>
                        </div>
                        <?php
                            }
                        } else {
                            echo "<p class='m-3'>No Date Found!</p>";
                        }
                    }
                         ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require_once("includes/footer.php"); ?>
</body>

</html>