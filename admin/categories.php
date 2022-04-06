<?php 
    require_once("includes/db.php");
    $page_name = "Categories";
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
                        <span>Categories</span>
                        <a href="add-category">Add New Category</a>
                    </div>
                </div>
                <div class="card-body">
                    <?php 
                        $categories = $db->select("categories", "", "", "id DESC");
                        if($categories){
                    ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Icon</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 1;
                                foreach($categories as $category){ ?>
                                <tr>
                                    <td>
                                        <?php echo $count; ?>
                                    </td>
                                    <td>
                                        <a href="category?id=category-<?php echo $category['id']; ?>" class="text-white">
                                            <?php echo $category['name']; ?></a>
                                    </td>
                                    <td class="lg-font">
                                        <?php echo $category['icon']; ?>
                                    </td>
                                    <td>
                                        <a href="category?id=category-<?php echo $category['id']; ?>" class="text-white tool-tip" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="add-category?edit=<?php echo $category['id']; ?>" class="ml-2 text_success tool-tip" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="categories?delete=<?php echo $category['id']; ?>" class="ml-2 text-danger deleteData tool-tip" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php $count++; } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php } else {
                        echo '<p class="m-3">No Data Found!</p>';
                    } ?>
                </div>
            </div>
        </div>
    </div>
    <?php require_once("includes/footer.php"); ?>
</body>

</html>