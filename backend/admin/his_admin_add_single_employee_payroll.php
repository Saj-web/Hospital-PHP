<?php
session_start();
include('assets/inc/config.php');
if (isset($_POST['add_payroll'])) {
    $pay_number = $_POST['pay_number'];
    $pay_doc_name = $_POST['pay_doc_name'];
    $pay_doc_number = $_POST['pay_doc_number'];
    $pay_doc_email = $_POST['pay_doc_email'];
    $pay_emp_salary = $_POST['pay_emp_salary'];
    $pay_descr = $_POST['pay_descr'];

    $query = "INSERT INTO  his_payrolls  (pay_number, pay_doc_name, pay_doc_number, pay_doc_email, pay_emp_salary, pay_descr) VALUES(?,?,?,?,?,?)";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('ssssss', $pay_number, $pay_doc_name, $pay_doc_number, $pay_doc_email, $pay_emp_salary, $pay_descr);
    $stmt->execute();

    if ($stmt) {
        $success = "Payroll Record Added";
    } else {
        $err = "Please Try Again Or Try Later";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<!--Head-->
<?php include('assets/inc/head.php'); ?>

<body>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <?php include("assets/inc/nav.php"); ?>
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <?php include("assets/inc/sidebar.php"); ?>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <?php
        $doc_number = $_GET['doc_number'];
        $ret = "SELECT * FROM his_docs WHERE doc_number=?";
        $stmt = $mysqli->prepare($ret);
        $stmt->bind_param('s', $doc_number);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            // If doc_number is found in his_docs table
            $row = $res->fetch_object();
            $doc_fname = $row->doc_fname;
            $doc_lname = $row->doc_lname;
            $doc_email = $row->doc_email;
            $doc_number = $row->doc_number;
        } else {
            // If doc_number is not found in his_docs table, check his_nurse table
            $ret = "SELECT * FROM his_nurse WHERE nurse_number=?";
            $stmt = $mysqli->prepare($ret);
            $stmt->bind_param('s', $doc_number);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows > 0) {
                // If nurse_number is found in his_nurse table
                $row = $res->fetch_object();
                $doc_fname = $row->nurse_fname;
                $doc_lname = $row->nurse_lname;
                $doc_email = $row->nurse_email;
                $doc_number = $row->nurse_number;
            } else {
                // If nurse_number is not found in his_nurse table
                echo "Employee not found";
                exit;
            }
        }
        ?>

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="his_admin_dashboard.php">Dashboard</a></li>
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Payrolls</a></li>
                                        <li class="breadcrumb-item active">Add Payroll Record</li>
                                    </ol>
                                </div>
                                <h4 class="page-title">Add Employee Payroll Record</h4>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <!-- Form row -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">Fill all fields</h4>
                                    <!--Add Patient Form-->
                                    <form method="post">
                                        <div class="form-row">

                                            <div class="form-group col-md-4">
                                                <label for="inputEmail4" class="col-form-label">Employee Name</label>
                                                <input type="text" required="required" readonly name="pay_doc_name" value="<?php echo $doc_fname; ?> <?php echo $doc_lname
                                                                                                                                                        ?>" class="form-control" id="inputEmail4" placeholder="Patient's Name">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="input Password4" class="col-form-label">Employee Number</label>
                                                <input type="text" required="required" readonly name="pay_doc_number" value="<?php echo $doc_number; ?>" class="form-control" id="inputPassword4" placeholder="Patient's Number">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="inputPassword4" class="col-form-label">Employee Email</label>
                                                <input type="email" required="required" readonly name="pay_doc_email" value="<?php echo $doc_email; ?>" class="form-control" id="inputPassword4" placeholder="Patient's Email">
                                            </div>

                                        </div>

                                        <div class="form-row">

                                            <div class="form-group col-md-4" style="display:none">
                                                <?php
                                                $length = 5;
                                                $pay_number =  substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, $length);
                                                ?>
                                                <label for="inputEmail4" class="col-form-label">Payroll Number</label>
                                                <input type="text" required="required" name="pay_number" value="<?php echo $pay_number; ?>" class="form-control" id="inputEmail4" placeholder="Payroll Number">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="inputPassword4" class="col-form-label">Employee Salary</label>
                                                <input type="text" required="required" name="pay_emp_salary" class="form-control" id="inputPassword4" placeholder="Employee Salary">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="inputPassword4" class="col-form-label">Payroll Description</label>
                                                <input type="text" required="required" name="pay_descr" class="form-control" id="inputPassword4" placeholder="Payroll Description">
                                            </div>

                                        </div>

                                        <button type="submit" name="add_payroll" class="btn btn-primary btn-lg btn-block">Add Payroll Record</button>

                                    </form>
                                </div> <!-- end card-body -->
                            </div> <!-- end card-->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                    <?php if (isset($success)) { ?>
                        <!-- success Div -->
                        <div class="position-fixed bottom-0 right-0 p-3" style="z-index: 5; right: 0; bottom: 0; color: white">
                            <div id="successDiv" class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> <?php echo $success; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if (isset($err)) { ?>
                        <!-- error Div -->
                        <div class="position-fixed bottom-0 right-0 p-3" style="z-index: 5; right: 0; bottom: 0; color: white">
                            <div id="errDiv" class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> <?php echo $err; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    <?php } ?>

                </div> <!-- end container -->
            </div> <!-- end content -->

            <?php include('assets/inc/footer.php'); ?>
        </div>
        <!-- end content-page -->

    </div>
    <!-- end wrapper -->

    <!-- End Page content -->

    <!-- Vendor js -->
    <script src="assets/js/vendor.min.js"></script>

    <!-- App js-->
    <script src="assets/js/app.min.js"></script>

    <!-- Loading buttons js -->
    <script src="assets/libs/ladda/spin.js"></script>
    <script src="assets/libs/ladda/ladda.js"></script>

    <!-- Buttons init js-->
    <script src="assets/js/pages/loading-btn.init.js"></script>

    <!-- CKEditor js -->
    <script src="//cdn.ckeditor.com/4.6.2/basic/ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('editor')
    </script>
</body>

</html>