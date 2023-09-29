<?php
$dir = "uploads/archive/";

if(isset($_GET['text'])){
  $text = $_GET['text'];
  $dir = "uploads/".$text;

}

$files = scandir($dir);

if(count($files) > 0){
  $a = 2;
  while($a < count($files)){
    echo '<tr>';
    if(pathinfo($files[$a], PATHINFO_EXTENSION)){
      echo '<td id="clickme"><i class="fa-solid fa-file pe-1"></i><a href="'.$dir.'/'.$files[$a].'" target="_blank">'.$files[$a].'</a></td>';
      echo '<td class="text-center"><button class="btn btn-outline-danger" value="'.$files[$a].'" id="delete"><i class="fa-solid fa-trash"></i> Delete</button></td>';
      if($a+2 < count($files)){
        echo '<td id="clickme"><i class="fa-solid fa-file pe-1"></i><a href="'.$dir.'/'.$files[$a + 1].'" target="_blank">'.$files[$a].'</a></td>';
        echo '<td class="text-center"><button class="btn btn-outline-danger" value="'.$files[$a + 1].'" id="delete"><i class="fa-solid fa-trash"></i> Delete</button></td>';
      }
      //echo '<td id="clickme"><i class="fa-regular fa-folder pe-1"></i>'.$files[$b].'</td>';
      //echo '<td class="text-center"><button class="btn btn-outline-danger" value="'.$files[$b].'" id="delete"><i class="fa-solid fa-trash"></i> Delete</button></td>';
      
       //echo '<a href="uploads/'.$files[$a].'"><i class="fa-regular fa-folder"></i>'.$files[$a].'</a><br>';
     }
    echo '</tr>'; 
    if($a+2 < count($files)){
      $a+=2;
    }
    else{
      $a+=1;
    }
  }
}
else{
  echo '<tr><td><h1>No File Found</h1></td></tr>';
}

echo '<script>

$("button#delete").on("click",function(){
  var fileName = $(this).val();
  $.ajax({
    data: {fileName:fileName},
    url: "testing.php",
    type: "POST",
    success: function(data){
      alert(data)
    }
  })
})

 
  })
</script>';
?>
