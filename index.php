<?php
    include("connect.php");
    $db = new dataObj();
    $connection = $db->getConnstring();
    $request_method = $_SERVER["REQUEST_METHOD"];

    switch ($request_method) {
        case 'GET':
            if(!empty($_GET['id'])) {
                $id = intval($_GET['id']);
                getEmployee($id);
            } else {
                getEmployee();
            }
            break;

        case 'POST':
            insertEmployee();
            break;

        case 'PUT':
            $id = intval($_GET['id']);
            updateEmployee($id);
            break;
    
        case 'DELETE':
            $id = intval($_GET['id']);
            deleEmployee($id);
            break;

        default:
            header("");
            break;
    }

    function getEmployee() {
        global $connection;
        $query = "SELECT * FROM `employeee` ";
        $resp = array();
        $res = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_array($res)) {
            $resp[]=$row;
        }
        header('Content-type:application/json');
        echo json_encode($resp);
    }

    function get_pegawaid($id=0) {
        global $connection;
        $query = "SELECT * FROM `employeee` ";
        if ($id != 0) {
            $query.= "WHERE id = '$id' LIMIT 1";
        }
        $resp = array();
        $res =  mysqli_query($connection, $query);
        while ($row = mysqli_fetch_array($res)) {
            $resp[] = $row;
        }
        header('Content-type:application/json');
        echo json_encode($resp);
    }

    function insertEmployee() {
        global $connection;
        $data = json_decode(file_get_contents('php://input'), TRUE);
        $nama = $data["nama"];
        $email = $data["email"];
        $role_employee = $data["role_employee"];
        echo $query = "INSERT INTO `employee` SET
        `id` = null,
        `nama`='$nama',
        `email`='$email',
        `role_employee`='$role_employee'";
        if (mysqli_query($connection, $query)) {
            $resp = array(
                'status'=> 1,
                'status_message'=>'Employee Added Successfully.'
            );
        } else {
            $resp = array(
                'status'=> 0,
                'status_message'=> 'Employee Addition Failed'
            );
        }
        header('Content-Type: application/json');
        echo json_encode($resp);
    } 

    function updateEmployee($id) {
        global $connection;
        $data = json_decode(file_get_contents('php://input'), TRUE);
        $nama = $data["nama"];
        $email = $data["email"];
        $role_employee = $data["role_empolyee"];
        echo $query = "UPDATE `employee` SET
        `nama` = '$nama',
        `email` = '$email',
        `role_employe` = '$role_employe' WHERE `id` = '$id'";
        if (mysqli_query($connection, $query)) {
            $resp = array(
                'status' => 1,
                'status_message' => 'Employee Updated Successfully.'
            );
        } else {
            $resp = array(
                'status' => 0,
                'status_message' => 'Employee Update Failed'
            );
        }
        header('Content-Type: application/json');
        echo json_encode($resp);
    }

    function delemployee($id) {
        global $connection;
        $query = "DELETE FROM `employee` WHERE `id`='$id'";
        if (mysqli_query($connection, $query)) {
            $resp = array(
                'status' => 1,
                'status_message' => 'Employee Deleted Successfully.'
            );
        } else {
            $resp = array(
                'status' => 0,
                'status_message' => 'Employee Delete Failed'
            );
        }
        header('Content-Type: application/json');
        echo json_encode($resp);
    }
?>