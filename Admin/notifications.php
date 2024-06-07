<?php
require_once("../assets/includes/admin_header.php");
require_once("../assets/includes/admin_footer.php");
require_once("../assets/Class/year.class.php");
require_once("../assets/Class/notification.class.php");
use Years\Year;
use Notifications\Notification;
$year=new Year();
$years=$year->select();
$notification=new Notification();
$notifications=$notification->select();
?>
<style>
    #notification {
        height: 300px;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="row mt-2">
            <div class="col-lg-12"><h5>Notifications <label for="eye" class="ri-eye-line"  data-bs-toggle="modal" data-bs-target="#show_notifications"></label></h5></div>
        </div>
        <div class="row mt-2">
            <div class="col-lg-12">
                <div id="notification"></div>
            </div>
        </div>
        <div class="row mt-2 text-center">
            <div class="col-lg-12">
                <button class="btn btn-primary" id="next">Next</button>
            </div>
        </div>
    </div>
</div>
<div id="notification_modal" class="modal fade flip" tabindex="-1" aria-labelledby="flipModalLabel" aria-hidden="true"
     style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="flipModalLabel">Send Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="send_notification">
                <div class="modal-body">
                    <div class="col-lg-12">
                        <input type="hidden" name="content" id="content">
                        <select id="years" name="years[]" multiple placeholder="Select Year" autocomplete="off">
                                <?php
                                foreach ($years as $year) {
                                    echo "<option value='".$year['id']."'>".$year['course']." - ".$year['name']."</option>";
                                }
                                ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div id="show_notifications" class="modal fade exampleModalFullscreen" tabindex="-1" aria-labelledby="exampleModalFullscreenLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalFullscreenLabel">Notifications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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
                                            aria-label="SR No.: activate to sort column ascending">Date Time
                                        </th>
                                        <th data-ordering="false" class="sort" tabindex="1"
                                            aria-controls="email" style="width: 32.6px;"
                                            aria-label="ID: activate to sort column ascending">Course
                                        </th>
                                        <th data-ordering="false" class="sort" tabindex="1"
                                            aria-controls="email" style="width: 32.6px;"
                                            aria-label="ID: activate to sort column ascending">Year
                                        </th>
                                        <th data-ordering="false" class="sort" tabindex="2"
                                            aria-controls="course" style="width: 32.6px;"
                                            aria-label="Course: activate to sort column ascending">Notificaion
                                        </th>
                                        <th data-ordering="false" class="sort" tabindex="3" aria-controls="year"
                                            style="width: 32.6px;"
                                            aria-label="Year: activate to sort column ascending">Delete
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if(!empty($notifications)){
                                    foreach($notifications as $notification){
                                    ?>
                                    <tr>
                                        <td><?php echo $notification["updated_at"] ?></td>
                                        <td><?php echo $notification["course"] ?></td>
                                        <td><?php echo $notification["year"] ?></td>
                                        <td><?php echo $notification["content"] ?></td>
                                        <td><button id="<?php echo $notification["id"] ?>" class="ri-delete-bin-line btn btn-danger text-center delete"></button></td>
                                    </tr>
                                    <?php
                                    }}
                                    else{
                                        echo "<tr class='text-center'><td colspan='4'>No Notifications Yet</td></tr>";
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn btn-link link-success fw-medium material-shadow-none" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<script>
    $(document).ready(function () {
        const quill = new Quill('#notification', {
            theme: 'snow',
        });
        new TomSelect("#years",true);
        $(document).on("click", "#next", function () {
            $("#content").val(quill.root.innerHTML);
            $("#notification_modal").modal("show");
        });
        $("#send_notification").validate({
            rules:{
                content:{
                    required:true,
                },
                years:{
                    required:true,
                },
            },
            messages:{
                content:{
                    required:"Content is required",
                },
                years:{
                    required:"Select Years",
                },
            },
            errorClass: "text-danger",
            errorElement: "p",
            submitHandler: function (form, event) {
                event.preventDefault();
                let data = new FormData(form);
                $.ajax({
                    type: 'post',
                    url: "../assets/Exec/send_notification.php",
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
                            $("#notification_modal").modal("hide");
                            toastr.success(data.message);
                            setTimeout(function (){
                                location.reload();
                            },3000);
                        } else {
                            toastr.error(data.message);
                        }
                    }
                });
            }
        });

        $(document).on("click",".delete",function (){
            var id=$(this).attr("id");
            $.ajax({
                type: 'post',
                url: "../assets/Exec/delete_notification.php",
                data: {id:id},
                dataType: 'JSON',
                beforeSend: function () {
                    $(".loaderClass").css("display", "flex");
                },
                success: function (data) {
                    $(".loaderClass").css("display", "none");
                    if (data.status == 1) {
                        toastr.success(data.message);
                        setTimeout(function (){
                            location.reload();
                        },3000);
                    } else {
                        toastr.error(data.message);
                    }
                }
            });
        });
    });
</script>