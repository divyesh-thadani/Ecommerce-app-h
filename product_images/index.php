<?php 
// Start session 
session_start(); 
// Include and initialize DB class 
require_once 'DB.class.php'; 
$db = new DB(); 
// Fetch the gallery data 
$images = $db->getRows(); 
// Get session data 
$sessData = !empty($_SESSION['sessData'])?$_SESSION['sessData']:''; 
// Get status message from session 
if(!empty($sessData['status']['msg'])){ 
$statusMsg = $sessData['status']['msg']; 
$statusMsgType = $sessData['status']['type']; 
unset($_SESSION['sessData']['status']); 
} 
?>
<!-- Display status message -->
<?php if(!empty($statusMsg)){ ?>
<div class="col-xs-12">
<div class="alert alert-<?php echo $statusMsgType; ?>"><?php echo $statusMsg; ?></div>
</div>
<?php } ?>
<div class="row">
<div class="col-md-12 head">
<h5>Images</h5>
<!-- Add link -->
<div class="float-right">
<a href="addEdit.php" class="btn btn-success"><i class="plus"></i> New Gallery</a>
</div>
</div>
<!-- List the images -->
<table class="table table-striped table-bordered">
<thead class="thead-dark">
<tr>
<th width="5%">#</th>
<th width="10%"></th>
<th width="40%">Title</th>
<th width="19%">Created At</th>
<th width="8%">Status</th>
<th width="18%">Action</th>
</tr>
</thead>
<tbody>
<?php 
if(!empty($images)){ $i=0; 
foreach($images as $row){ $i++; 
$defaultImage = !empty($row['default_image'])?'<img src="uploads/images/'.$row['default_image'].'" alt="" />':''; 
$statusLink = ($row['status'] == 1)?'postAction.php?action_type=block&id='.$row['id']:'postAction.php?action_type=unblock&id='.$row['id']; 
$statusTooltip = ($row['status'] == 1)?'Click to Inactive':'Click to Active'; 
?>
<tr>
<td><?php echo $i; ?></td>
<td><?php echo $defaultImage; ?></td>
<td><?php echo $row['title']; ?></td>
<td><?php echo $row['created_at']; ?></td>
<td><a href="<?php echo $statusLink; ?>" title="<?php echo $statusTooltip; ?>"><span class="badge <?php echo ($row['status'] == 1)?'badge-success':'badge-danger'; ?>"><?php echo ($row['status'] == 1)?'Active':'Inactive'; ?></span></a></td>
<td>
<a href="view.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">view</a>
<a href="addEdit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">edit</a>
<a href="postAction.php?action_type=delete&id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure to delete data?')?true:false;">delete</a>
</td>
</tr>
<?php } }else{ ?>
<tr><td colspan="6">No gallery found...</td></tr>
<?php } ?>
</tbody>
</table>
</div>