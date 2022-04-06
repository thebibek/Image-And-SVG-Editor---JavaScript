
    <div class="sidebar">
        <div class="wrapper">
            <ul class="nav">
                <li class="nav-item">
                    <span class="label">Admin > <?php if(isset($breadcrumbs)){
                        echo $breadcrumbs;
                    } else {
                        echo $page_name;
                    } ?></span>
                </li>
                <li class="nav-item">
                    <a href="dashboard" class="btn s-btn"><span class="text"><i class="fas fa-home"></i>Dashboard</span></a>
                </li>
                <li class="nav-item">
                    <a href="categories" class="btn s-btn"><span class="text"><i class="fas fa-th-large"></i>Categories</span></a>
                </li>
                <li class="nav-item">
                    <a href="add-category" class="btn s-btn"><span class="text"><i class="fas fa-plus"></i>Add Category</span></a>
                </li>
                <li class="nav-item">
                    <a href="settings" class="btn s-btn"><span class="text"><i class="fas fa-cog"></i>Setting</span></a>
                </li>
                <li class="nav-item">
                    <a href="logout" class="btn s-btn"><span class="text"><i class="fas fa-sign-out-alt"></i>Logout</span></a>
                </li>
            </ul>
        </div>
        <span class="menu_toggler">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </div>