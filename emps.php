<?php
include "conn.php";
$pageSize=10;
?>
<body>
	<h1 align="center">员工列表</h1>
	<div style="width:100%;height:500px;">
	<table border="1" cellspacing="1" cellpadding="2" align="center">
		<tr align="center" bgcolor="silver" height="40">
			<th width="80">员工编号</th><th width="100">员工姓名</th><th width="120">联系电话</th><th width="100">职位</th><th width="100">所属领导</th><th width="100">所属部门</th><th colspan="3" width="130">操作</th>
		</tr>
		<?php 
		if (!isset($_GET['page'])) $_GET['page']=1;
	  	$offset=($_GET['page']-1)*$pageSize;
		$sql="select emp_id,emp_name,phone,job_id,manager_id,dep_id from emps limit $offset,$pageSize";
		$result=mysqli_query($conn,$sql);
		while($emp=mysqli_fetch_array($result)) {
			$job=mysqli_fetch_array(mysqli_query($conn, "select job_name from jobs where job_id={$emp[3]}"));
			$man=mysqli_fetch_array(mysqli_query($conn, "select emp_name from emps where emp_id={$emp[4]}"));
			$dep=mysqli_fetch_array(mysqli_query($conn, "select dep_name from deps where dep_id={$emp[5]}"));
			echo "<tr height='40'>";
			echo "<td>{$emp[0]}</td>";
			echo "<td>{$emp[1]}</td>";
			echo "<td>{$emp[2]}</td>";
			echo "<td>{$job[0]}</td>";
			echo "<td>{$man[0]}</td>";
			echo "<td>{$dep[0]}</td>";
			echo "<td><a href='showemp.php?id={$emp[0]}'>查看</a></td>";
			echo "<td><a href='editemp.php?id={$emp[0]}'>修改</a></td>";
			echo "<td><a href='result.php?action=delemp&id={$emp[0]}' onClick=\"if(!confirm('确定删除该员工信息吗？'))return false;else return true;\">删除</a></td>";
			echo "<tr>";
		}
		 ?>
	</table>
	</div>
	<div style="text-align:center;">
	<?php
	$row=mysqli_fetch_array(mysqli_query($conn,"select count(*) from emps"));
	$total=ceil($row[0]/$pageSize);
	echo "第".$_GET['page']."/".$total."页&nbsp;&nbsp;&nbsp;";
	echo "<a href='emps.php?page=1'>首页</a>&nbsp;";
	if ($_GET['page']>1)
		echo '<a href="emps.php?page='.($_GET['page']-1).'">上一页</a>&nbsp;';
	else
		echo '上一页&nbsp;';
	if ($_GET['page']<$total)
		echo '<a href="emps.php?page='.($_GET['page']+1).'">下一页</a>&nbsp;';
	else
		echo '下一页&nbsp;';
	echo "<a href='emps.php?page=$total'>尾页</a>&nbsp;";
	mysqli_close($conn);
	?>
	</div>
</body>
</html>
