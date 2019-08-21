<?php

if($_SERVER['REQUEST_METHOD']=='POST') {

   $response = array();
   //mendapatkan data

   $nim = $_POST['nim'];
   $nama = $_POST['nama'];
   $kelas = $_POST['kelas'];
   $picture = $_FILES['image']['name'];

   $target = "uploads/".basename($picture); 
   
   require_once('koneksi.php');
   //Cek nim sudah terdaftar apa belum
   $sql = "SELECT * FROM mahasiswa WHERE nim ='$nim'";

   $check = mysqli_fetch_array(mysqli_query($conn,$sql));

   if(isset($check)){
    $response["value"] = 0;
    $response["message"] = "oops! Nim sudah terdaftar!";
    echo json_encode($response);

    }else{

        $sql = "INSERT INTO mahasiswa (nim,nama,kelas,image) VALUES('$nim','$nama','$kelas','$picture')";

        if(mysqli_query($conn,$sql)){

            if(move_uploaded_file($_FILES['image']['tmp_name'], $target))
            {
                $result["value"] = true;
                $result["message"] = "Success mendaftar!";
                echo json_encode($result);
            }

        }else{
            $result["value"] = false;
            $result["message"] = "Gagal mendaftar!";
            echo json_encode($result);
        }

        mysqli_close($conn);
        
    }
    
}else{
$response["value"] = false;
$response["message"] = "oops! Coba lagi!";
echo json_encode($response);
}

?>