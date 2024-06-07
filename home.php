<?php
require_once("assets/includes/header.php");
require_once("assets/Class/subject.class.php");
require_once("assets/Class/sems.class.php");
require_once("assets/Class/category.class.php");
require_once("assets/Class/material.class.php");

use Subjects\Subject;
use Sems\Sem;
use Categories\Category;
use Materials\Material;

?>
<script>
    window.addEventListener("focus", () => {
        document.title = "Study Hub";
    })
    window.addEventListener("blur", () => {
        document.title = "Learn Together";
    })
</script>
<!--Home Page-->
<div id="Semesters" class="container mt-3">
    <?php
    $sem = new Sem();
    $sems = $sem->getsems($_SESSION["year"]);
    if (!empty($sems)) {
        foreach ($sems as $sem) {
            $subject = new Subject();
            $subjects = $subject->getsubjects($sem["id"]);
            if (!empty($subjects)) {
                ?>
                <h3 class="header"><?php echo($sem["name"]) ?></h3><br>
                <?php
                foreach ($subjects as $subject) {
                    $category = new Category();
                    $categories = $category->getcategory($subject["id"]);
                    if (!empty($categories)) {
                        ?>
                        <div class="container mt-3">
                            <button type="button" class="btn btn-subject" data-bs-toggle="collapse"
                                    data-bs-target="#<?php echo $subject["name"] . $subject["id"] ?>">
                                <?php echo $subject["name"] ?>
                            </button>
                            <br>
                            <?php
                            if (!empty($categories)) {
                                foreach ($categories as $category) {
                                    $material = new Material();
                                    $materials = $material->getmaterial($category["id"]);
                                    if (!empty($materials)) {
                                        ?>
                                    <div id="<?php echo $subject["name"] . $subject["id"] ?>" class="collapse">
                                        <button type="button" class="btn btn-color" data-bs-toggle="collapse"
                                                data-bs-target="#<?php echo $category["name"] . $subject['id']; ?>">
                                            <font class="fa fa-toolbox"></font><?php echo $category["name"]; ?>
                                        </button>
                                        <br>
                                            <div id="<?php echo $category["name"] . $subject['id']; ?>"
                                                 class="collapse">
                                                <?php foreach ($materials as $material) { ?>
                                                    <a href="<?php echo $material["file"]; ?>" target="_blank">
                                                        <button type="button" class="btn study"><?php echo $material["name"] ?></button>
                                                    </a><br>
                                                <?php } ?>
                                            </div>
                                            </div>
                                            <?php
                                    }
                                }
                            }
                            ?>
                        </div>
                    <?php }
                }
            }
        }
    } ?>
</div>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script>
    $(document).ready(function () {
        var token = sessionStorage.getItem("token");
        if (!token) {
            window.location.href = 'login';
        } else {
            var headers = {
                'Authorization': 'Bearer ' + token
            };
            $.ajax({
                type: 'post',
                url: "assets/Exec/loginCheck.php",
                headers: headers,
                data: null,
                dataType: 'JSON',
                contentType: false,
                processData: false,
                async: true,
                cache: false,
                beforeSend: function () {
                    $(".loaderClass").css("display", "flex");
                },
                success: function (data) {
                    $(".loaderClass").css("display", "none");
                    console.log(data.status);
                    if (data.status != 1) {
                        window.location.href = 'login';
                    }
                }
            });
        }
    });
</script>