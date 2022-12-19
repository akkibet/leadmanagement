<?php
                if(isset($_SESSION['message']))
                {
                    echo "<h4>".$_SESSION['message']."</h4>";
                    unset($_SESSION['message']);
                }
    ?>
	
<div class="card card-outline card-primary rounded-0 shadow">
	<div class="card-header">
		<h3 class="card-title">Upload Lead</h3>
	</div>

	<div class="card-body">

		<form action="../admin/leads/code.php" method="POST" enctype="multipart/form-data">

				<input type="file" name="import_file" class="form-control"/>
				<button type="submit" name="save_excel_data" class="btn btn-sm btn-primary mrgn-tp">Import</button>
		</form>
	</div>
</div>

<style>
        .mrgn-tp{
            margin-top: 30px;
            margin-left: 550px;
        }
    </style>