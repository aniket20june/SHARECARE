<?php
include "connection.php";
if(empty($_SESSION))
{
    session_start();
    if(!isset($_SESSION['username']))
    header("location:login.php");
}
else if(!isset($_SESSION['username']))
    {
    header("location:login.php");
    exit;
    } 
    $id=$_SESSION['userid'];
    $local="SELECT DESTINATION FROM TRAVEL WHERE ENROLLMENT ='$id'";
    $local1=mysqli_query($con,$local);
    if(mysqli_num_rows($local1)>0)
    {
        //echo "hi";
        $en=array();
        $name=array();
        $dt=array();
        $place=array();
        while($local2=mysqli_fetch_assoc($local1))
        {
            $plan=$local2['DESTINATION'];
            $plan1="SELECT ENROLLMENT,DATE FROM TRAVEL WHERE DESTINATION='$plan' AND ENROLLMENT <> '$id'";
            $plan2=mysqli_query($con,$plan1);
            while($plan3=mysqli_fetch_assoc($plan2))
            {
                array_push($en,$plan3['ENROLLMENT']);
                array_push($dt,$plan3['DATE']);
                array_push($place,$plan);
                $temp_en=$plan3['ENROLLMENT'];
                $plan4="SELECT NAME FROM INFO WHERE ENROLLMENT='$temp_en'";
                $plan4=mysqli_query($con,$plan4);
                while($plan5=mysqli_fetch_assoc($plan4))
                {
                    array_push($name,$plan5['NAME']);
                }
            }
        }
    }
    //echo "hello";
    $length=count($en);
?>
<!DOCTYPE html>
 <html> 
 <script type=text/javascript>
function create_button()
{
    var x=document.getElementById('butarea');
    //var y="<input type='number' placeholder='enrollment'/> <br> <input type=button value='submit'/>";
    x.innerHTML+="<center><input type='number' name='to[]' placeholder='enrollment'/><input type=text placeholder='place' name=place[]/></center>";
    var z=document.getElementById('morereq');
    z.innerHTML="<center><p><input type=button value='request another' onclick='create_button()' class='but'/></p></center>";
    var y=document.getElementById('reqbut');
    y.innerHTML="<center><input type='submit' class='but' value='request' name='request'/></center>"
}
</script>
     <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>
    <body>
    <link rel="stylesheet" type="text/css" href="innerstyle.css">
<center> <img class="image" src="logo1.jpg" height=200 width=200 style="border-radius:100px; transform:scale(0.7);" > </center>
    <h1>SHARECARE SOLUTIONS INDIA</h1>
    <hr>
   <center><font size= "6"><b><span> FOLLOWING PEOPLE ARE TRAVELLING TO THE SAME PLACE   </span></font size></b></center>
   <hr>
    <table align=center border=5px>
    <tr id="head">
    <td> NAME </td>
    <td> ENROLLMENT </td>
    <td> PLACE </td>
    <td> DATE </td>
    </tr>
    <tr>
    <td> 
    <?php 
    for($x=0;$x<$length;$x++)
    {
        echo $name[$x]."<br> <hr>";
    }
    ?>
      </td>
      <td> 
    <?php 
    for($x=0;$x<$length;$x++)
    {
        echo $en[$x]."<br><hr>";
    }
    ?>
      </td>
      <td> 
    <?php 
    for($x=0;$x<$length;$x++)
    {
        echo $place[$x]."<br> <hr>";
    }
    ?>
      </td>
      <td> 
    <?php 
    for($x=0;$x<$length;$x++)
    {
        echo $dt[$x]."<br> <hr>";
    }
    ?>
      </td>
    </tr>
    </table>
    <p><center><input type="button" class="but" onclick="create_button()" value="REQUEST SOMEONE"/></center></p>
    <form action='local_request.php' method =POST>
    <div id='butarea'> </div>
    <div id='morereq'> </div> <br>
    <div id='reqbut'> </div>
    </form>
    <p><center> <a href='login_home.php'><input type='button' class='but' value='back'></a></center></p>
    </body>
</html>