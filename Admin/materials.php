<?php
require_once("../assets/includes/admin_header.php");
require_once("../assets/CLass/course.class.php");
require_once("../assets/CLass/year.class.php");
require_once("../assets/CLass/sems.class.php");
require_once("../assets/CLass/subject.class.php");
require_once("../assets/CLass/category.class.php");
require_once("../assets/CLass/material.class.php");
require_once("../assets/CLass/elements.class.php");

use Courses\Course;
use Years\Year;
use Sems\Sem;
use Subjects\Subject;
use Elements\Element;
use Categories\Category;
use Materials\Material;

$element = new Element();

$course = new Course();
$courses = json_decode($course->select(), true);
?>
<div class="main-content">
    <div class="page-content">
        <div class="row">
            <?php
            echo $element->form("course", "course_id");
            echo $element->form("year", "year_id");
            echo $element->form("sem", "sem_id");
            echo $element->form("subject", "subject_id");
            echo $element->form("category", "category_id");
            if (@$_POST["course_id"]) {
                $year = new Year();
                $years = $year->getyear($_POST["course_id"]);
                foreach ($years as $year) {
                    echo $element->button("year_name", $year["id"], $year["name"]);
                }
                echo $element->addbutton("add_year", "Add Year");
            } else if (@$_POST["year_id"]) {
                $sem = new Sem();
                $sems = $sem->getsems($_POST["year_id"]);
                foreach ($sems as $sem) {
                    echo $element->button("sem_name", $sem["id"], $sem["name"]);
                }
                echo $element->addbutton("add_sem", "Add Semester");
            } else if (@$_POST["sem_id"]) {
                $subject = new Subject();
                $subjects = $subject->getsubjects($_POST["sem_id"]);
                foreach ($subjects as $subject) {
                    echo $element->button("subject_name", $subject["id"], $subject["name"]);
                }
                echo $element->addbutton("add_subject", "Add Subject");
            } else if (@$_POST["subject_id"]) {
                $category = new Category();
                $categories = $category->getcategory($_POST["subject_id"]);
                foreach ($categories as $category) {
                    echo $element->button("category_name", $category["id"], $category["name"]);
                }
                echo $element->addbutton("add_category", "Add Category");
            } else if (@$_POST["category_id"]) {
                $material = new Material();
                $materials = $material->getmaterial($_POST["category_id"]);
                foreach ($materials as $material) {
                    ?>
                    <div class="col-sm-4">
                        <a href="<?php echo $material["file"] ?>" target="_blank">
                            <div class="card card-body text-center bg-primary"><h4 class="card-title text-light"><?php echo $material["name"]; ?></h4></div>
                        </a>
                    </div>

                <?php }
                echo $element->addbutton("add_material", "Add Materials");
            } else if ($courses["status"] == 1) {
                foreach ($courses["message"] as $course) {
                    echo $element->button("course_name", $course["id"], $course["name"]);
                }
                echo $element->addbutton("add_course", "Add Course");
            } else {
                ?>
                <div class="col">
                    <div class="card card-body text-center bg-danger">
                        <h4 class="card-title text-light">Something went wrong</h4>
                    </div>
                </div>
                <?php
            } ?>
        </div>
    </div>
</div>
<div id="add_course" class="modal fade flip" tabindex="-1" aria-labelledby="flipModalLabel" aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="flipModalLabel">Add Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add_courses">
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="form-floating">
                            <input type="text" class="form-control" name="course"
                                   placeholder="Enter Course Name" autocomplete="off">
                            <label for="course">Course Name</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="add_year" class="modal fade flip" tabindex="-1" aria-labelledby="flipModalLabel" aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="flipModalLabel">Add Year</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add_years">
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="form-floating form-group">
                            <input type="hidden" class="form-control" name="course"
                                   value="<?php echo @$_POST["course_id"]; ?>">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-floating form-group">
                            <input type="text" class="form-control" name="year"
                                   placeholder="Enter Year Name">
                            <label for="course">Year Name</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="add_sem" class="modal fade flip" tabindex="-1" aria-labelledby="flipModalLabel" aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="flipModalLabel">Add Semester</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add_sems">
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="form-floating form-group">
                            <input type="hidden" class="form-control" name="year"
                                   value="<?php echo @$_POST["year_id"]; ?>">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-floating form-group">
                            <input type="text" class="form-control" name="sem"
                                   placeholder="Enter Sem Name">
                            <label for="course">Sem Name</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="add_subject" class="modal fade flip" tabindex="-1" aria-labelledby="flipModalLabel" aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="flipModalLabel">Add Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add_subjects">
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="form-floating form-group">
                            <input type="hidden" class="form-control" name="sem"
                                   value="<?php echo @$_POST["sem_id"]; ?>">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-floating form-group">
                            <input type="text" class="form-control" name="subject"
                                   placeholder="Enter Subject Name">
                            <label for="course">Subject Name</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="add_category" class="modal fade flip" tabindex="-1" aria-labelledby="flipModalLabel" aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="flipModalLabel">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add_categories">
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="form-floating form-group">
                            <input type="hidden" class="form-control" name="subject"
                                   value="<?php echo @$_POST["subject_id"]; ?>">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-floating form-group">
                            <input type="text" class="form-control" name="category"
                                   placeholder="Enter Category Name">
                            <label for="course">Category Name</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="add_material" class="modal fade flip" tabindex="-1" aria-labelledby="flipModalLabel" aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="flipModalLabel">Add Materials</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="add_materials" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="form-floating form-group">
                            <input type="hidden" class="form-control" name="category"
                                   value="<?php echo @$_POST["category_id"]; ?>">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-floating form-group">
                            <input type="text" class="form-control" name="material"
                                   placeholder="Enter Material Name">
                            <label for="course">Material Name</label>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-floating form-group">
                            <input class="form-control" type="file" id="file" name="file">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php include("../assets/includes/admin_footer.php"); ?>
<script>
    $(document).ready(function () {
        $('.modal').on('hidden.bs.modal', function () {
            $(".form-control").val("");
        });

        $("#add_courses").validate({
            rules: {
                course: {
                    required: true,
                },
            },
            messages: {
                course: {
                    required: "Add Course Name"
                },
            },
            errorClass: "text-danger",
            errorElement: "p",
            submitHandler: function (form, event) {
                event.preventDefault();
                let data = new FormData(form);
                $.ajax({
                    type: 'post',
                    url: "../assets/Exec/add_course.php",
                    data: data,
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
                        if (data.status == 1) {
                            $("#add_course").modal("hide");
                            toastr.success(data.message);
                            setTimeout(function () {
                                location.reload();
                            }, 3500);
                        } else {
                            toastr.error(data.message);
                        }
                    }
                });
            }
        });

        $("#add_years").validate({
            rules: {
                course: {
                    required: true,
                },
                year: {
                    required: true,
                }
            },
            messages: {
                course: {
                    required: "Add Course Name"
                },
                year: {
                    required: "Add Year Name"
                }
            },
            errorClass: "text-danger",
            errorElement: "p",
            submitHandler: function (form, event) {
                event.preventDefault();
                let data = new FormData(form);
                $.ajax({
                    type: 'post',
                    url: "../assets/Exec/add_year.php",
                    data: data,
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
                        if (data.status == 1) {
                            $("#add_year").modal("hide");
                            toastr.success(data.message);
                            setTimeout(function () {
                                $("#course").submit();
                            }, 3500);
                        } else {
                            toastr.error(data.message);
                        }
                    }
                });
            }
        });

        $("#add_sems").validate({
            rules: {
                year: {
                    required: true,
                },
                sem: {
                    required: true,
                }
            },
            messages: {
                year: {
                    required: "Add Year"
                },
                sem: {
                    required: "Add Sem Name"
                }
            },
            errorClass: "text-danger",
            errorElement: "p",
            submitHandler: function (form, event) {
                event.preventDefault();
                let data = new FormData(form);
                $.ajax({
                    type: 'post',
                    url: "../assets/Exec/add_sem.php",
                    data: data,
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
                        if (data.status == 1) {
                            $("#add_sem").modal("hide");
                            toastr.success(data.message);
                            setTimeout(function () {
                                $("#year").submit();
                            }, 3500);
                        } else {
                            toastr.error(data.message);
                        }
                    }
                });
            }
        });

        $("#add_subjects").validate({
            rules: {
                sem: {
                    required: true,
                },
                subject: {
                    required: true,
                }
            },
            messages: {
                sem: {
                    required: "Add Semester"
                },
                subject: {
                    required: "Add Subject Name"
                }
            },
            errorClass: "text-danger",
            errorElement: "p",
            submitHandler: function (form, event) {
                event.preventDefault();
                let data = new FormData(form);
                $.ajax({
                    type: 'post',
                    url: "../assets/Exec/add_subject.php",
                    data: data,
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
                        if (data.status == 1) {
                            $("#add_subject").modal("hide");
                            toastr.success(data.message);
                            setTimeout(function () {
                                $("#sem").submit();
                            }, 3500);
                        } else {
                            toastr.error(data.message);
                        }
                    }
                });
            }
        });

        $("#add_categories").validate({
            rules: {
                subject: {
                    required: true,
                },
                category: {
                    required: true,
                }
            },
            messages: {
                subject: {
                    required: "Add Subject"
                },
                category: {
                    required: "Add Category Name"
                }
            },
            errorClass: "text-danger",
            errorElement: "p",
            submitHandler: function (form, event) {
                event.preventDefault();
                let data = new FormData(form);
                $.ajax({
                    type: 'post',
                    url: "../assets/Exec/add_category.php",
                    data: data,
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
                        if (data.status == 1) {
                            $("#add_category").modal("hide");
                            toastr.success(data.message);
                            setTimeout(function () {
                                $("#subject").submit();
                            }, 3500);
                        } else {
                            toastr.error(data.message);
                        }
                    }
                });
            }
        });

        $("#add_materials").validate({
            rules: {
                category: {
                    required: true,
                },
                material: {
                    required: true,
                },
                file: {
                    required: true,
                }
            },
            messages: {
                category: {
                    required: "Add Category"
                },
                material: {
                    required: "Add Material Name"
                },
                file: {
                    required: "Add File"
                }
            },
            errorClass: "text-danger",
            errorElement: "p",
            submitHandler: function (form, event) {
                event.preventDefault();
                let data = new FormData(form);
                $.ajax({
                    type: 'post',
                    url: "../assets/Exec/add_material.php",
                    data: data,
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
                        if (data.status == 1) {
                            $("#add_material").modal("hide");
                            toastr.success(data.message);
                            setTimeout(function () {
                                $("#category").submit();
                            }, 3500);
                        } else {
                            toastr.error(data.message);
                        }
                    }
                });
            }
        });

        $(document).on("click", ".course_name", function () {
            var course = $(this).attr("id");
            $("#course_id").val(course);
            $("#course").submit();
        });

        $(document).on("click", ".year_name", function () {
            var year = $(this).attr("id");
            $("#year_id").val(year);
            $("#year").submit();
        });

        $(document).on("click", ".sem_name", function () {
            var sem = $(this).attr("id");
            $("#sem_id").val(sem);
            $("#sem").submit();
        });

        $(document).on("click", ".subject_name", function () {
            var subject = $(this).attr("id");
            $("#subject_id").val(subject);
            $("#subject").submit();
        });

        $(document).on("click", ".category_name", function () {
            var category = $(this).attr("id");
            $("#category_id").val(category);
            $("#category").submit();
        });
    });
</script>
