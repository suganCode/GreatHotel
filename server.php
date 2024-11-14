<?php 


if(isset($_GET['reg'])){

    $servername = "localhost"; 
    $username = "root";
    $password = ""; 
    $dbname = "database1";
    
    try {
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
    
    $val = $_GET['val'];
    
    $sql = "SELECT * FROM orders WHERE seatnum LIKE :startWith";
    
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindValue(':startWith', $val . '%', PDO::PARAM_STR);
    
    $stmt->execute();  
    
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
  if($result){

    if(count($result)>0){
        
      foreach($result as $row){
      
         $mode=$row['mode'];
         $waiter=$row['waiter'];
         $index=$row['seatnum'];
    
         echo json_encode(array(
             
             'mode'=>$mode,
             'waiter'=>$waiter,
             'index'=>$index
            ));
     
            echo "#";  
      }
     
         }
         else{
     
             echo json_encode(array(
     
                 'msg'=>'No items', 
                 'status'=>509
                  )
             );        
        
         }
     
        }
        else{
  
          echo json_encode(array(
  
            "status"=>502
      
          ));  
  
        }    

        $pdo=null;

      }
  

if(isset($_GET['check'])){
   
 try {
  
$conn = mysqli_connect("localhost","root", "","database1");

$column = "seatnum";   
        
$sql = "SELECT $column FROM orders ";

$result = mysqli_query($conn,$sql);


$numbers = array();


while ($row=mysqli_fetch_assoc($result)) { 
    echo "Column Value: " . $row[$column] . "<br>";   
    $numbers[] = $row[$column];   

}
      

 echo json_encode($numbers);

        
    } catch (exception $e) {
        die("Error: " . $e->getMessage());
    }


}




if(isset($_GET['indexvalue'])){


$servername = "localhost";  
$username = "root";
$password = "";
$dbname = "database1";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$indexv = $_GET['indexvalue'];
$waiter = $_GET['waiterName'];
$food = $_GET['food'];
$qty = $_GET['qtyvalue']; 
$code = $_GET['codevalue'];
$rate = $_GET['ratevalue'];
$mode = $_GET['modevalue'];
$rowCount=$_GET['Rowcount'];


if($rowCount>0){


    $sql = "UPDATE orders 
        SET waiter = :waiter, 
            food = :food, 
            qty = :qty, 
            code = :code, 
            rate = :rate, 
            mode = :mode 
        WHERE seatnum = :indexv";

}else{

    $sql = "INSERT INTO orders (seatnum, waiter, food, qty, code, rate, mode) 
        VALUES (:indexv, :waiter, :food, :qty, :code, :rate, :mode)";

}


try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':indexv' => $indexv,
        ':waiter' => $waiter,
        ':food' => $food, 
        ':qty' => $qty,
        ':code' => $code,
        ':rate' => $rate,
        ':mode' => $mode,
    ]);

    echo json_encode([
        'msg' => 'successfully added',
        'status' => 202,
    ]);

} catch (PDOException $except) {
    echo json_encode([
        'msg' => $except->getMessage(),
        'status' => 404,
    ]);

  
    }finally {
        $pdo= null;
    }


}


if(isset($_GET['keyword'])){ 

    $keyword =$_GET['keyword'];

$servername = "localhost"; 
$username = "root";
$password = "";
$dbname = "database1";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$sql = "SELECT * FROM items WHERE name LIKE :endWith OR name LIKE :startWith OR name = :exactMatch";
$stmt = $pdo->prepare($sql);

$stmt->bindValue(':endWith', '%' . $keyword, PDO::PARAM_STR);
$stmt->bindValue(':startWith', $keyword . '%', PDO::PARAM_STR);
$stmt->bindValue(':exactMatch', $keyword, PDO::PARAM_STR);

$stmt->execute();

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

   
    if($result){

    if(count($result)>0){
    
        
      foreach($result as $row){
      
         $code=$row['code'];
         $name=$row['name'];
         $rate=$row['rate'];
     
         echo json_encode(array(
             
             'avail'=>true,
             'code'=>$code,
             'name'=>$name,
              'rate'=>$rate
            ));
     
            echo "#";  
      }
     
         }
         else{
     
             echo json_encode(array(
     
                 'avail'=>false,
                 'msg'=>'No items', 
                 'status'=>509
                  )
             );        
        
         }
     
        }
        else{
  
          echo json_encode(array(
  
            'avail'=>false,
            "status"=>502
      
          ));  
  
        }    

        $pdo=null;

      }  


if (isset($_GET['table'])) {

 try {    

$servername = "localhost"; 
$username = "root";
$password = ""; 
$dbname = "database1";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$index = $_GET['index'];

$sql = "SELECT * FROM orders WHERE seatnum = :indexv";
$stmt = $pdo->prepare($sql);

$stmt->bindParam(':indexv', $index, PDO::PARAM_STR);

$stmt->execute();  

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        
        if ($result) {
            if (count($result) > 0) {
                $response = array();
                foreach ($result as $row) {
                    $code = $row['code'];
                    $food = $row['food'];
                    $rate = $row['rate'];
                    $qty = $row['qty'];
                    
                      echo json_encode(array(
                        'code' => $code,
                        'food' => $food,
                        'rate' => $rate,
                        'qty' => $qty,
                    ));
                    echo "#";  


                } 

            } else {
                echo json_encode(array(
                    'msg' => 'No items',
                    'status' => 509
                ));
            }
        } else {
            echo json_encode(array(
                'msg' => 'No results found',
                'status' => 502
            ));
        }
        
        $pdo = null; 
    } catch (PDOException $e) {
        echo json_encode(array(
            'error' => 'Database error: ' . $e->getMessage(),
            'status' => 500
        ));
    }
} else {
    echo json_encode(array(
        'error' => 'Parameter "table" is missing',
        'status' => 400
    ));
}


?>



