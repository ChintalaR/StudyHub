<?php
require_once("../assets/includes/admin_header.php");
require_once("../assets/CLass/User.class.php");

use Users\User;

$user = new User();
$users = $user->select();
$response = json_decode($users, true);
?>
<div class="main-content">
    <div class="page-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="example"
                                           class="table table-bordered dt-responsive nowrap table-striped align-middle dataTable no-footer dtr-inline collapsed"
                                           style="width: 100%;" aria-describedby="example_info">
                                        <thead>
                                        <tr>
                                            <th data-ordering="false" class="sort" tabindex="0" aria-controls="srno"
                                                style="width: 40.6px;"
                                                aria-label="SR No.: activate to sort column ascending">Sr No.
                                            </th>
                                            <th data-ordering="false" class="sort" tabindex="1"
                                                aria-controls="email" style="width: 32.6px;"
                                                aria-label="ID: activate to sort column ascending">Email
                                            </th>
                                            <th data-ordering="false" class="sort" tabindex="2"
                                                aria-controls="course" style="width: 32.6px;"
                                                aria-label="Course: activate to sort column ascending">Course
                                            </th>
                                            <th data-ordering="false" class="sort" tabindex="3" aria-controls="year"
                                                style="width: 32.6px;"
                                                aria-label="Year: activate to sort column ascending">Year
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $i = 0;
                                        foreach ($response["data"] as $user) { ?>
                                            <tr>
                                                <td><?php echo ++$i ?></td>
                                                <td><?php echo $user["email"] ?></td>
                                                <td><?php echo $user["course"] ?></td>
                                                <td><?php echo $user["year"] ?></td>
                                            </tr>
                                        <?php }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end col-->
        </div>
        <!-- container-fluid -->
    </div>
    <?php
    include("../assets/includes/admin_footer.php");

    if (@$_SESSION['flash']) {
        ?>
        <script>
            toastr.success('<?php echo $_SESSION['flash'] ?>')
        </script>
        <?php
        unset($_SESSION['flash']);
    }
    ?>