<div class="card card-outline card-primary rounded-0 shadow">
	<div class="card-header">
		<h3 class="card-title">Export Data</h3>
	</div>

	<div class="card-body">

		<form action="../admin/leads/code.php" method="POST">

				<select name="export_file_type" id="" class="form-control">
                    <option value="xlsx">XLSX</option>
                    <option value="xls">XLS</option>
                    <option value="csv">CSV</option>
                </select>

				<button type="submit" name="export_excel_btn" class="btn btn-sm btn-primary mrgn-tp">Export</button>
		</form>
	</div>
</div>

<style>
        .mrgn-tp{
            margin-top: 30px;
            margin-left: 550px;
        }
    </style>