
<h2 class="text-center">Insert Categories</h2>
<form action="" method="post" class="mb-2">
    <div class="input-group w-90 mb-2">
        <span class="input-group-text bg-info" id="basic-addon1"><i class="fa-solid fa-receipt"></i></span>
        <input type="text" class="form-control" name="cat_title" placeholder="Insert categories" aria-label="Username" aria-describedby="basic-addon1">
    </div>
    
<input type="submit" name="insert_Categories" value="Insert Categories" class="bg-info" my-3 px-3 border-0>
</form>

<?php  
@$ins_cate = $_POST['cat_title'];
    
?>


